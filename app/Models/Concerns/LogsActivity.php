<?php

namespace App\Models\Concerns;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            static::recordActivity('create', $model, null, $model->getAttributes());
        });

        static::updated(function (Model $model) {
            $changes = $model->getChanges();
            // Abaikan jika hanya updated_at yang berubah
            unset($changes['updated_at']);

            if (!empty($changes)) {
                $original = array_intersect_key($model->getOriginal(), $changes);
                static::recordActivity('update', $model, $original, $changes);
            }
        });

        static::deleted(function (Model $model) {
            static::recordActivity('delete', $model, $model->getOriginal(), null);
        });
    }

    protected static function recordActivity(string $action, Model $model, ?array $oldValues, ?array $newValues): void
    {
        $admin = Auth::guard('admin')->user();

        // Ambil nama model tanpa namespace
        $classBasename = class_basename($model);

        $description = match ($action) {
            'create' => "Menambahkan data {$classBasename} #{$model->getKey()}",
            'update' => "Memperbarui data {$classBasename} #{$model->getKey()}",
            'delete' => "Menghapus data {$classBasename} #{$model->getKey()}",
            default => "Melakukan aksi {$action} pada {$classBasename} #{$model->getKey()}",
        };

        if (isset($model->name)) {
            $description .= " ({$model->name})";
        } elseif (isset($model->username)) {
            $description .= " ({$model->username})";
        }

        ActivityLog::create([
            'admin_id' => $admin?->id,
            'action' => $action,
            'subject_type' => get_class($model),
            'subject_id' => $model->getKey(),
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
