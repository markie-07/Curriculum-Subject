<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Equivalency;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class EquivalencyToolController extends Controller
{
    /**
     * Display the equivalency tool view with all subjects and existing equivalencies.
     */
    public function index(): View
    {
        // Fetch all subjects to populate the dropdown with their descriptions
        $subjects = Subject::select('id', 'subject_code', 'subject_name', 'course_description')
            ->orderBy('subject_code')
            ->get();
        
        // Fetch all existing equivalencies, eager load the related subject, and order by the newest first
        $equivalencies = Equivalency::with('equivalentSubject')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('equivalency_tool', compact('subjects', 'equivalencies'));
    }

    /**
     * Get all equivalencies for API calls.
     */
    public function getEquivalencies(): JsonResponse
    {
        $equivalencies = Equivalency::with('equivalentSubject')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($equivalencies);
    }

    /**
     * Store a newly created equivalency in the database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'source_subject_name' => 'required|string|max:255',
            'source_subject_description' => 'nullable|string',
            'equivalent_subject_id' => 'required|exists:subjects,id',
        ]);

        $equivalency = Equivalency::create($validated);
        $equivalency->load('equivalentSubject');

        // Flash success message for session-based requests
        // Log activity
        if (auth()->user()) {
            \App\Services\ActivityLogService::log(
                'equivalency_create',
                'Created equivalency for ' . $validated['source_subject_name'],
                [
                    'source_subject' => $validated['source_subject_name'],
                    'equivalent_subject_id' => $validated['equivalent_subject_id']
                ]
            );
            auth()->user()->updateLastActivity();
            
            session()->flash('success', 'Equivalency for "' . $validated['source_subject_name'] . '" has been created successfully!');
        }
        
        if (request()->wantsJson()) {
            return response()->json([
                'equivalency' => $equivalency,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Equivalency Created!',
                    'message' => 'Equivalency for "' . $validated['source_subject_name'] . '" has been created successfully!'
                ]
            ], 201);
        }

        // Return the new record with its relationship loaded so the frontend can display it
        return response()->json($equivalency);
    }

    /**
     * Update the specified equivalency in the database.
     */
    public function update(Request $request, Equivalency $equivalency): JsonResponse
    {
        $validated = $request->validate([
            'source_subject_name' => 'required|string|max:255',
            'source_subject_description' => 'nullable|string',
            'equivalent_subject_id' => 'required|exists:subjects,id',
        ]);

        $equivalency->update($validated);
        $equivalency->load('equivalentSubject');

        // Flash success message for session-based requests
        // Log activity
        if (auth()->user()) {
            \App\Services\ActivityLogService::log(
                'equivalency_update',
                'Updated equivalency for ' . $validated['source_subject_name'],
                [
                    'equivalency_id' => $equivalency->id,
                    'source_subject' => $validated['source_subject_name'],
                    'equivalent_subject_id' => $validated['equivalent_subject_id']
                ]
            );
            auth()->user()->updateLastActivity();
            
            session()->flash('success', 'Equivalency for "' . $validated['source_subject_name'] . '" has been updated successfully!');
        }
        
        if (request()->wantsJson()) {
            return response()->json([
                'equivalency' => $equivalency,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Equivalency Updated!',
                    'message' => 'Equivalency for "' . $validated['source_subject_name'] . '" has been updated successfully!'
                ]
            ]);
        }

        // Return the updated record with its relationship loaded
        return response()->json($equivalency);
    }

    /**
     * Remove the specified equivalency from the database.
     */
    public function destroy(Equivalency $equivalency): JsonResponse
    {
        $sourceName = $equivalency->source_subject_name;
        $equivalency->delete();
        
        // Flash success message for session-based requests
        // Log activity
        if (auth()->user()) {
            \App\Services\ActivityLogService::log(
                'equivalency_delete',
                'Deleted equivalency for ' . $sourceName,
                [
                    'source_subject' => $sourceName,
                    'equivalency_id' => $equivalency->id
                ]
            );
            auth()->user()->updateLastActivity();
        
            session()->flash('success', 'Equivalency for "' . $sourceName . '" has been deleted successfully!');
        }
        
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Equivalency deleted successfully.',
                'notification' => [
                    'type' => 'success',
                    'title' => 'Equivalency Deleted!',
                    'message' => 'Equivalency for "' . $sourceName . '" has been deleted successfully!'
                ]
            ]);
        }
        
        // Return a success message
        return response()->json(['message' => 'Equivalency deleted successfully.']);
    }
}