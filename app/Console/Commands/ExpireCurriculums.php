<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Curriculum;
use Carbon\Carbon;

class ExpireCurriculums extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curriculums:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark curricula as old when they reach their expiration date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        // 1. Process Expired Curriculums
        $expiredCurriculums = Curriculum::where('version_status', 'new')
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $today)
            ->get();
        
        $expiredCount = 0;
        foreach ($expiredCurriculums as $curriculum) {
            $curriculum->update(['version_status' => 'old']);
            $expiredCount++;
            
            // Notify when expired
            $title = "Curriculum Expired";
            $message = "The curriculum '{$curriculum->program_code}' ({$curriculum->academic_year}) has expired and is now marked as old.";
            
            // Assuming we have a Notification model
            if (class_exists('App\Models\Notification')) {
                \App\Models\Notification::createForAdmins('error', $title, $message);
            }
            
            $this->info("Marked curriculum '{$curriculum->curriculum}' ({$curriculum->academic_year}) as old.");
        }
        
        if ($expiredCount > 0) {
            $this->info("Successfully marked {$expiredCount} curriculum(s) as old.");
        } else {
            $this->info('No curricula have expired today.');
        }

        // 2. Process Expiring Soon Curriculums (Notifications)
        // Check for curriculums expiring in 30, 7, or 1 days
        $futureCurriculums = Curriculum::where('version_status', 'new')
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>', $today)
            ->get();

        if ($futureCurriculums->isNotEmpty() && class_exists('App\Models\User') && class_exists('App\Models\Notification')) {
            $adminUsers = \App\Models\User::whereIn('role', ['admin', 'super_admin'])->get();
            
            foreach ($futureCurriculums as $curriculum) {
                $expirationDate = Carbon::parse($curriculum->expiration_date)->startOfDay();
                $daysUntil = $today->diffInDays($expirationDate, false);
                
                if ($daysUntil > 0 && in_array($daysUntil, [30, 7, 1])) {
                    $title = "Curriculum Expiring Soon";
                    $message = "The curriculum '{$curriculum->program_code}' ({$curriculum->academic_year}) will expire in {$daysUntil} day" . ($daysUntil > 1 ? 's' : '') . ".";
                    
                    foreach ($adminUsers as $admin) {
                        // Check if we already notified this admin about this curriculum today
                        $alreadyNotified = \App\Models\Notification::where('user_id', $admin->id)
                            ->where('title', $title)
                            ->where('created_at', '>=', Carbon::today())
                            ->whereJsonContains('data->curriculum_id', $curriculum->id)
                            ->exists();
                            
                        if (!$alreadyNotified) {
                            \App\Models\Notification::createForUser(
                                $admin->id, 
                                'warning', 
                                $title, 
                                $message, 
                                ['curriculum_id' => $curriculum->id, 'days_until' => $daysUntil]
                            );
                        }
                    }
                    
                    $this->info("Checked notifications for '{$curriculum->curriculum}' expiring in {$daysUntil} days.");
                }
            }
        }

        return 0;
    }
}
