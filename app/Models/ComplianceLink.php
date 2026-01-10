<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplianceLink extends Model
{
    protected $fillable = [
        'agency',
        'year',
        'title',
        'url'
    ];
}
