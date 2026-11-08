<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable, LogsActivity;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'is_primary',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
}