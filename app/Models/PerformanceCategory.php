<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PerformanceCategory extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'level_key',
        'min_score',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'min_score' => 'float',
        'sort_order' => 'integer',
    ];

    /**
     * Cache in-memory untuk request saat ini agar tidak query berulang kali pada perulangan tabel
     */
    protected static ?Collection $runtimeCache = null;

    protected static function booted(): void
    {
        static::saved(function () {
            static::$runtimeCache = null;
            Cache::forget('performance_categories');
        });

        static::deleted(function () {
            static::$runtimeCache = null;
            Cache::forget('performance_categories');
        });
    }

    /**
     * Dapatkan semua kategori performa terurut dari nilai tertinggi ke terendah
     */
    public static function getCached(): Collection
    {
        if (static::$runtimeCache !== null) {
            return static::$runtimeCache;
        }

        try {
            static::$runtimeCache = static::orderByDesc('min_score')->get();
        } catch (\Throwable) {
            static::$runtimeCache = new Collection;
        }

        return static::$runtimeCache;
    }

    /**
     * Tentukan kategori performa berdasarkan skor rata-rata
     */
    public static function forScore(float $score): ?self
    {
        $categories = static::getCached();
        if ($categories->isEmpty()) {
            return null;
        }

        foreach ($categories as $cat) {
            if ($cat instanceof self && $score >= (float) $cat->min_score) {
                return $cat;
            }
        }

        $last = $categories->last();

        return $last instanceof self ? $last : null;
    }
}
