<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\ActivityLogService;

class BiometricService
{
    /**
     * Store face descriptor for a user
     */
    public function storeFaceDescriptor(User $user, array $descriptor): bool
    {
        return $user->update([
            'face_descriptor' => $descriptor,
        ]);
    }

    /**
     * Verify if the provided descriptor matches the user's stored descriptor(s).
     *
     * Uses FaceMatcher logic: compare the login descriptor against every stored
     * reference descriptor and take the MINIMUM distance (best match).
     * This makes verification robust to lighting / angle variation.
     */
    public function verifyFace(User $user, array $providedDescriptor): bool
    {
        $storedData = $user->face_descriptor;

        if (empty($storedData)) {
            Log::warning('[Biometric] No stored face data for user', ['user_id' => $user->id]);
            return false;
        }

        // Normalise: support both a 2-D array (15 samples) and a legacy 1-D array
        $storedDescriptors = $this->normaliseDescriptors($storedData);

        if (empty($storedDescriptors)) {
            Log::warning('[Biometric] Could not parse stored descriptor(s)', ['user_id' => $user->id]);
            return false;
        }

        // Ensure the provided descriptor has the right length
        if (count($providedDescriptor) !== 128) {
            Log::warning('[Biometric] Provided descriptor has wrong length', [
                'length' => count($providedDescriptor),
            ]);
            return false;
        }

        // FaceMatcher: find minimum distance across all stored references
        $minDistance = PHP_FLOAT_MAX;

        foreach ($storedDescriptors as $ref) {
            if (count($ref) !== 128) continue;

            $sumSq = 0.0;
            for ($i = 0; $i < 128; $i++) {
                $diff  = (float) $ref[$i] - (float) $providedDescriptor[$i];
                $sumSq += $diff * $diff;
            }
            $dist = sqrt($sumSq);

            if ($dist < $minDistance) {
                $minDistance = $dist;
            }
        }

        // Threshold: 0.40 is strict — increases accuracy significantly.
        // Typical same-person distance: 0.25–0.40
        // Different-person distance:   0.50–0.90
        $threshold = 0.40;
        $matched   = $minDistance < $threshold;

        Log::info('[Biometric] Verification result', [
            'user_id'      => $user->id,
            'refs_checked' => count($storedDescriptors),
            'min_distance' => round($minDistance, 4),
            'threshold'    => $threshold,
            'matched'      => $matched,
        ]);

        return $matched;
    }

    /**
     * Normalise stored face data into a 2-D array of 128-element descriptors.
     *
     * Handles:
     *   - [[...128 floats...], [...], ...]  → multi-sample (new format)
     *   - [...128 floats...]               → single descriptor (legacy)
     */
    private function normaliseDescriptors(array $data): array
    {
        if (empty($data)) return [];

        // If first element is an array → already 2-D
        if (is_array($data[0])) {
            return $data;
        }

        // Otherwise it's a flat 128-element array → wrap in array
        return [$data];
    }

    /**
     * Finalize biometric login
     */
    public function finalizeBiometricLogin(User $user): string
    {
        Auth::login($user);
        
        // Clear pending session
        session()->forget(['pending_user_id', 'pending_user_email']);
        session()->regenerate();

        if ($user->isEmployee()) {
            ActivityLogService::logLogin($user);
            $user->updateLastActivity();
            return route('curriculum_export_tool');
        }

        return route('dashboard');
    }
}
