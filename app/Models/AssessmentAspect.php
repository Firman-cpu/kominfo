<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentAspect extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'key',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scores(): HasMany
    {
        return $this->hasMany(AssessmentScore::class, 'aspect_id');
    }

    public function canBeDeleted(): bool
    {
        return $this->scores()->count() === 0;
    }
}
