<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use LogsActivity, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'is_primary',
        'is_active',
        'last_login_at',
        'photo_data',
        'photo_mime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'photo_data', // exclude raw blob from serialization
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    public function isAdministrator(): bool
    {
        return $this->role === 'administrator';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get the URL to display the admin's photo.
     * Serves from DB blob if available, else falls back to UI Avatar.
     *
     * Cache-busting: timestamp di-append agar browser selalu fetch ulang
     * setelah foto diperbarui. photo_mime (not in $hidden) dipakai sebagai
     * indikator agar tidak terkena masalah $hidden pada photo_data.
     */
    public function getPhotoUrlAttribute(): string
    {
        // Cek photo_mime (tidak di-$hidden) sebagai penanda foto ada di DB
        if ($this->photo_mime) {
            $v = $this->updated_at?->timestamp ?? time();

            return route('admin.profile.photo', $this->id).'?v='.$v;
        }

        $nameEncoded = urlencode($this->name ?? 'Admin');

        return "https://ui-avatars.com/api/?name={$nameEncoded}&background=1e3a8a&color=ffffff&bold=true";
    }
}
