<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\BiometricService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiometricController extends Controller
{
    protected BiometricService $biometricService;

    public function __construct(BiometricService $biometricService)
    {
        $this->biometricService = $biometricService;
    }

    /**
     * Store face descriptor for authenticated user
     */
    public function store(Request $request)
    {
        // Accept either:
        //   descriptors: [[...128 floats...], [...], ...]   ← new multi-sample
        //   descriptor:  [...128 floats...]                 ← legacy single
        $request->validate([
            'descriptors'   => 'required_without:descriptor|array|min:1',
            'descriptors.*' => 'array|size:128',
            'descriptor'    => 'required_without:descriptors|array|size:128',
        ]);

        $user = Auth::user();

        if ($request->has('descriptors')) {
            $this->biometricService->storeFaceDescriptor($user, $request->descriptors);
        } else {
            // Wrap single descriptor in array for consistent storage format
            $this->biometricService->storeFaceDescriptor($user, [$request->descriptor]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Facial recognition data saved successfully.',
        ]);
    }

    /**
     * Verify face during login (OTP stage)
     */
    public function verify(Request $request)
    {
        $userId = session('pending_user_id');
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please login again.',
            ], 401);
        }

        $user = User::find($userId);
        if (!$user || empty($user->face_descriptor)) {
            return response()->json(['success' => false, 'message' => 'Biometric data not found.'], 404);
        }

        $descriptor = $request->input('descriptor');
        if (!$this->biometricService->verifyFace($user, $descriptor)) {
            return response()->json(['success' => false, 'message' => 'Face not recognized. Please try again.'], 403);
        }

        // Finalize login using service
        $redirect = $this->biometricService->finalizeBiometricLogin($user);

        return response()->json([
            'success' => true,
            'redirect' => $redirect,
        ]);
    }

    /**
     * Check if face recognition is available for the pending user
     */
    public function check(Request $request)
    {
        $userId = session('pending_user_id');
        if (!$userId) {
            return response()->json(['available' => false]);
        }

        $user = User::find($userId);
        return response()->json([
            'available' => $user && !empty($user->face_descriptor),
        ]);
    }

    /**
     * Return stored reference descriptors for the pending login user.
     * Used by the frontend for live Euclidean distance display.
     * Safe to expose: descriptors are 128-float embeddings, not reversible to images.
     * Only works if the user has already authenticated with a valid password (session exists).
     */
    public function reference(Request $request)
    {
        $userId = session('pending_user_id');
        if (!$userId) {
            return response()->json(['descriptors' => null], 401);
        }

        $user = User::find($userId);
        if (!$user || empty($user->face_descriptor)) {
            return response()->json(['descriptors' => null]);
        }

        $data = $user->face_descriptor;

        // Normalise to 2-D array (always return array of descriptors)
        $descriptors = is_array($data[0] ?? null) ? $data : [$data];

        return response()->json([
            'descriptors' => $descriptors,
            'count'       => count($descriptors),
        ]);
    }

    /**
     * Remove face recognition data for the current user
     */
    public function destroy()
    {
        $user = Auth::user();
        $user->update(['face_descriptor' => null]);

        return back()->with('success', 'Facial recognition data has been removed.');
    }
}
