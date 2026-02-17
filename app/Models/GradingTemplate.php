<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'template_key',
        'name',
        'description',
        'periods',
        'components',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'periods' => 'array',
        'components' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get all active templates formatted as an associative array keyed by template_key.
     * Use this to replace the config-based retrieval.
     */
    public static function getActiveTemplates()
    {
        return self::where('is_active', true)
            ->get()
            ->mapWithKeys(function ($template) {
                return [
                    $template->template_key => [
                        'id' => $template->id,
                        'name' => $template->name,
                        'description' => $template->description,
                        'periods' => $template->periods,
                        'components' => $template->components,
                    ]
                ];
            })
            ->toArray();
    }
}
