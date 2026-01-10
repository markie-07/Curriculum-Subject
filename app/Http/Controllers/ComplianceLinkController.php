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

        $query = ComplianceLink::query();

        if ($agency) {
            $query->where('agency', $agency);
        }

        if ($year) {
            $query->where('year', $year);
        }

        $links = $query->orderBy('id', 'asc')->get();

        return response()->json($links);
    }

    /**
     * Store a new compliance link
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agency' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'url' => 'required|url'
        ]);

        $link = ComplianceLink::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Link added successfully',
            'link' => $link
        ], 201);
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
