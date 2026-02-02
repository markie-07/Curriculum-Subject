<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    /**
     * Get all system settings grouped by category.
     */
    public function index()
    {
        $settings = SystemSetting::all();
        
        // Group by category for easier consumption on frontend
        $grouped = $settings->groupBy('category')->map(function ($items) {
            return $items->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            });
        });

        return response()->json($grouped);
    }

    /**
     * Get settings for a specific category.
     */
    public function getByCategory($category)
    {
        $settings = SystemSetting::where('category', $category)->get();
        
        if ($settings->isEmpty()) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $formatted = $settings->mapWithKeys(function ($item) {
            return [$item->key => $item->value];
        });

        return response()->json($formatted);
    }
}
