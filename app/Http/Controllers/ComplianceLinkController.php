<?php

namespace App\Http\Controllers;

use App\Models\ComplianceLink;
use Illuminate\Http\Request;

class ComplianceLinkController extends Controller
{
    /**
     * Get all compliance links for a specific agency and year
     */
    public function index(Request $request)
    {
        $agency = $request->query('agency');
        $year = $request->query('year');
        $isCategory = $request->query('is_category');

        $query = ComplianceLink::query();

        if ($agency) {
            $query->where('agency', $agency);
        }

        if ($year) {
            $query->where('year', $year);
        }

        if ($isCategory !== null) {
            $query->where('is_category', $isCategory === 'true' || $isCategory === '1');
        }

        $links = $query->orderBy('id', 'asc')->get();

        return response()->json($links);
    }

    /**
     * Get all categories for a specific agency
     */
    public function getCategories(Request $request)
    {
        $agency = $request->query('agency');

        $query = ComplianceLink::where('is_category', true);

        if ($agency) {
            $query->where('agency', $agency);
        }

        $categories = $query->orderBy('id', 'desc')->get();

        return response()->json($categories);
    }

    /**
     * Store a new compliance link or category
     */
    public function store(Request $request)
    {
        try {
            \Log::info('ComplianceLink store request:', $request->all());

            $validated = $request->validate([
                'agency' => 'required|string|max:255',
                'year' => 'required|string|max:255',
                'is_category' => 'nullable|boolean',
                'title' => 'nullable|string|max:500',
                'url' => 'nullable|string'
            ]);

            // Ensure is_category is set properly
            $validated['is_category'] = $request->input('is_category', false);

            \Log::info('Validated data:', $validated);

            $link = ComplianceLink::create($validated);

            \Log::info('Created ComplianceLink:', $link->toArray());

            // Log activity
            if (auth()->user()) {
                $type = $validated['is_category'] ? 'category' : 'link';
                $name = $validated['is_category'] ? $validated['year'] : ($validated['title'] ?? 'Untitled');
                \App\Services\ActivityLogService::log(
                    'compliance_' . $type . '_create',
                    'Added compliance ' . $type . ' "' . $name . '" for ' . $validated['agency'],
                    ['agency' => $validated['agency'], 'year' => $validated['year']]
                );
                auth()->user()->updateLastActivity();
            }

            return response()->json([
                'success' => true,
                'message' => ($validated['is_category'] ? 'Category' : 'Link') . ' added successfully',
                'link' => $link
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating compliance link/category:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing compliance link
     */
    public function update(Request $request, $id)
    {
        $link = ComplianceLink::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'url' => 'sometimes|required|url'
        ]);

        $link->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Link updated successfully',
            'link' => $link
        ]);
    }

    /**
     * Delete a compliance link
     */
    public function destroy($id)
    {
        $link = ComplianceLink::findOrFail($id);
        $link->delete();

        return response()->json([
            'success' => true,
            'message' => 'Link deleted successfully'
        ]);
    }
}
