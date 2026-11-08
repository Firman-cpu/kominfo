<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    use LogsActivity;

    protected $fillable = [
        'student_id',
        'assessment_date',
        'notes',
    ];

    protected $casts = [
        'assessment_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(AssessmentScore::class);
    }

    public function getAverageScoreAttribute(): float
    {
        if ($this->relationLoaded('scores')) {
            $count = $this->scores->count();
            return $count > 0 ? round($this->scores->avg('score'), 2) : 0.0;
        }

        return round((float) $this->scores()->avg('score'), 2);
    }

    public function getCategoryAttribute(): ?PerformanceCategory
    {
        return PerformanceCategory::forScore($this->average_score);
    }

    public function getStrongestScore(): ?AssessmentScore
    {
        return $this->scores->sortByDesc('score')->first();
    }

    public function getWeakestScore(): ?AssessmentScore
    {
        return $this->scores->sortBy('score')->first();
    }
}