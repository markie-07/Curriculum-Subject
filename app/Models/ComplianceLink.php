<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplianceLink extends Model
{
    protected $fillable = [
        'agency',
        'is_category',
        'year',
        'title',
        'url'
    ];

    protected $casts = [
        'is_category' => 'boolean',
    ];
}
