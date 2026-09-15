<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    protected $fillable = [
        'student_id',
        'assessment_date',
        'discipline',
        'responsibility',
        'teamwork',
        'communication',
        'initiative',
        'work_quality',
        'notes',
    ];

    protected $casts = [
        'assessment_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}