<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $fillable = [
        'name',
        'study_program',
        'graduation_year',
        'status',
        'confidence_score',
        'best_link',
        'tracked_at',
    ];

    protected $casts = [
        'tracked_at' => 'datetime',
        'metadata' => 'array',
    ];
}
