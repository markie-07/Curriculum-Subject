<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingTemplate extends Model
{
    //

    protected $fillable = [
        'code',
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
}
