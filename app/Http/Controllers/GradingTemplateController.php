<?php

namespace App\Http\Controllers;

use App\Models\GradingTemplate;
use Illuminate\Http\Request;

class GradingTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = GradingTemplate::where('is_active', true)->get();
        return view('grading_templates.index', compact('templates'));
    }

    /**
     * Get all templates as JSON (Internal API)
     */
    public function list()
    {
        $templatesFromDb = GradingTemplate::where('is_active', true)->get();
        
        $formattedTemplates = [];
        $formattedTemplates = [];
        foreach ($templatesFromDb as $template) {
            $formattedTemplates[] = [ // Indexed array
                'id' => $template->id,
                'code' => $template->code, // Explicitly include code
                'name' => $template->name,
                'description' => $template->description,
                'periods' => $template->periods,
                'components' => $template->components,
            ];
        }

        return response()->json([
            'success' => true,
            'templates' => $formattedTemplates
        ]);
    }

    /**
     * Store or update the grading template.
     */
    public function update(Request $request, $id)
    {
        $template = GradingTemplate::findOrFail($id);

        $validated = $request->validate([
            'components' => 'required|array',
            'periods' => 'required|array',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $template->update($validated);

        return response()->json(['success' => true, 'message' => 'Template updated successfully']);
    }

    /**
     * Get a specific template for editing
     */
    public function show($id)
    {
        $template = GradingTemplate::findOrFail($id);
        return response()->json($template);
    }
}
