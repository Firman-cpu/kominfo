<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'sort_order',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Dapatkan ikon representasi bidang (Lucide).
     */
    public function getIconAttribute(): string
    {
        $code = strtoupper(trim($this->code ?? ''));

        return match ($code) {
            'TI', 'IT', 'TEKNOLOGI' => 'cpu',
            'STATISTIK', 'STAT' => 'bar-chart-2',
            'INFOKOM', 'IKP', 'KOMUNIKASI' => 'megaphone',
            'SEKRETARIAT', 'SEK' => 'building-2',
            default => 'layers',
        };
    }

    /**
     * Aksesor gambar bidang untuk dukungan gambar di masa mendatang.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (isset($this->attributes['image_path']) && $this->attributes['image_path']) {
            return asset('storage/'.$this->attributes['image_path']);
        }

        if (isset($this->attributes['image']) && $this->attributes['image']) {
            return asset('storage/'.$this->attributes['image']);
        }

        return null;
    }
}
