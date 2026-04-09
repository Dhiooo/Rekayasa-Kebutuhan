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
        'linkedin_url',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'youtube_url',
        'email',
        'phone',
        'workplace',
        'workplace_address',
        'job_position',
        'employment_type',
        'workplace_social_media',
        'social_evidence',
    ];

    protected $casts = [
        'tracked_at' => 'datetime',
        'social_evidence' => 'array',
    ];
}
