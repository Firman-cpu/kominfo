<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentScore extends Model
{
    protected $fillable = [
        'assessment_id',
        'aspect_id',
        'score',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function aspect(): BelongsTo
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }
}
