<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'category',
        'key',
        'value',
        'description',
    ];

    /**
     * Get a setting value by category and key
     */
    public static function getValue(string $category, string $key, $default = null)
    {
        $setting = self::where('category', $category)
            ->where('key', $key)
            ->first();
        
        return $setting ? $setting->value : $default;
    }

    /**
     * Get all settings for a specific category
     */
    public static function getByCategory(string $category)
    {
        return self::where('category', $category)
            ->get()
            ->pluck('value', 'key');
    }
}
