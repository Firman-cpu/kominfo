<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use LogsActivity;

    protected $fillable = [
        'type', // prakerin / magang
        'identity_number', // NIS / NIM
        'name',
        'major', // Jurusan / Program Studi
        'institution', // Sekolah / Kampus
        'faculty', // Fakultas (mahasiswa)
        'department_id', // Bidang
        'photo_path',
        'photo_data',
        'photo_mime',
        'class', // Kelas (siswa)
        'start_date',
        'end_date',
        'status', // active / completed
    ];

    protected $hidden = [
        'photo_data', // exclude raw blob from serialization
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::saving(function (Student $student) {
            // Otomatisasi status bila tanggal durasi pkl/magang sudah lewat hari ini
            if ($student->end_date && Carbon::parse($student->end_date)->endOfDay()->isPast()) {
                $student->status = 'completed';
            }
        });
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assessment(): HasOne
    {
        return $this->hasOne(Assessment::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'magang' ? 'Mahasiswa Magang' : 'Siswa Prakerin';
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'completed' ? 'Selesai' : 'Sedang Aktif';
    }

    public function getPhotoUrlAttribute(): string
    {
        $v = $this->updated_at?->timestamp ?? time();

        // Priority 1: DB blob — gunakan photo_mime (tidak di-$hidden) sebagai penanda
        if ($this->photo_mime) {
            return route('admin.students.photo', $this->id) . '?v=' . $v;
        }

        // Priority 2: filesystem fallback
        if ($this->photo_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($this->photo_path)) {
            return route('admin.students.photo', $this->id) . '?v=' . $v;
        }

        // Final fallback: UI Avatar
        $nameEncoded = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$nameEncoded}&background=1e3a8a&color=ffffff&bold=true";
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed' || ($this->end_date && Carbon::parse($this->end_date)->isPast());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Dapatkan daftar tahun unik dari start_date secara portabel (MySQL, MariaDB, SQLite, Postgres)
     *
     * @return array<int>
     */
    public static function getAvailableYears(): array
    {
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $expr = match ($driver) {
            'sqlite' => "DISTINCT CAST(strftime('%Y', start_date) AS INTEGER) as yr",
            'pgsql' => 'DISTINCT CAST(EXTRACT(YEAR FROM start_date) AS INTEGER) as yr',
            default => 'DISTINCT YEAR(start_date) as yr',
        };

        return static::selectRaw($expr)
            ->whereNotNull('start_date')
            ->orderByDesc('yr')
            ->pluck('yr')
            ->map(fn ($yr) => (int) $yr)
            ->filter()
            ->values()
            ->toArray();
    }
}