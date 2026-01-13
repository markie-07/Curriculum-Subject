<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MonitorDatabaseConnections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:monitor
                            {--check : Check if database is accessible}
                            {--stats : Show detailed connection statistics}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor database connections and check connectivity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Database Connection Monitor');
        $this->newLine();

        // Show current configuration
        $this->showConfiguration();

        // Check connectivity
        if ($this->option('check') || !$this->option('stats')) {
            $this->checkConnectivity();
        }

        // Show statistics if requested
        if ($this->option('stats')) {
            $this->showStatistics();
        }

        $this->newLine();
        $this->info('✅ Monitoring complete!');
    }

    /**
     * Show current database configuration
     */
    protected function showConfiguration()
    {
        $this->info('📋 Current Configuration:');
        
        $options = config('database.connections.mysql.options') ?? [];
        $persistent = isset($options[\PDO::ATTR_PERSISTENT]) && $options[\PDO::ATTR_PERSISTENT] ? 'Enabled' : 'Disabled';
        $timeout = $options[\PDO::ATTR_TIMEOUT] ?? 5;
        
        $this->table(
            ['Setting', 'Value'],
            [
                ['Connection', config('database.default')],
                ['Host', config('database.connections.mysql.host')],
                ['Database', config('database.connections.mysql.database')],
                ['Username', config('database.connections.mysql.username')],
                ['Persistent', $persistent],
                ['Sticky', config('database.connections.mysql.sticky') ? 'Enabled' : 'Disabled'],
                ['Timeout', $timeout . ' seconds'],
            ]
        );
        $this->newLine();
    }

    /**
     * Check database connectivity
     */
    protected function checkConnectivity()
    {
        $this->info('🔌 Testing Connection...');
        
        try {
            $startTime = microtime(true);
            DB::connection()->getPdo();
            $endTime = microtime(true);
            $duration = round(($endTime - $startTime) * 1000, 2);
            
            $this->info("✅ Connection successful! ({$duration}ms)");
            
            // Test a simple query
            $startTime = microtime(true);
            $result = DB::select('SELECT 1 as test');
            $endTime = microtime(true);
            $queryDuration = round(($endTime - $startTime) * 1000, 2);
            
            $this->info("✅ Query test successful! ({$queryDuration}ms)");
            
        } catch (\Exception $e) {
            $this->error('❌ Connection failed!');
            $this->error('Error: ' . $e->getMessage());
            
            if (str_contains($e->getMessage(), 'max_connections_per_hour')) {
                $this->newLine();
                $this->warn('⚠️  You have exceeded the connection limit!');
                $this->warn('📊 Limit: 500 connections per hour');
                $this->warn('🕐 Current time: ' . now()->format('Y-m-d H:i:s'));
                $this->newLine();
                $this->warn('⏰ Estimated wait time:');
                $this->warn('   • Minimum: 30 minutes');
                $this->warn('   • Typical: 45-60 minutes');
                $this->warn('   • Maximum: 90 minutes');
                $this->newLine();
                $this->warn('💡 Solutions:');
                $this->warn('   1. Wait 30-60 minutes for the limit to reset');
                $this->warn('   2. Switch to local database (see env.example)');
                $this->warn('   3. Enable persistent connections (DB_PERSISTENT=true)');
                $this->newLine();
                $this->info('💡 Tip: Run this command again in 30 minutes to check if limit has reset');
            }
            
            return 1;
        }
        
        $this->newLine();
    }

    /**
     * Show connection statistics
     */
    protected function showStatistics()
    {
        $this->info('📊 Connection Statistics:');
        
        try {
            // Get MySQL status variables
            $stats = DB::select("SHOW STATUS WHERE Variable_name IN (
                'Threads_connected',
                'Threads_running',
                'Max_used_connections',
                'Connections',
                'Aborted_connects'
            )");
            
            $data = [];
            foreach ($stats as $stat) {
                $data[] = [$stat->Variable_name, $stat->Value];
            }
            
            $this->table(['Metric', 'Value'], $data);
            
            // Show tables count
            $tablesCount = count(DB::select('SHOW TABLES'));
            $this->info("📁 Total tables: {$tablesCount}");
            
        } catch (\Exception $e) {
            $this->error('❌ Could not retrieve statistics');
            $this->error('Error: ' . $e->getMessage());
        }
        
        $this->newLine();
    }
}
