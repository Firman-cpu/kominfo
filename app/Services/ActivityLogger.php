<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(
        string $action,
        string $description,
        ?string $subjectType = null,
        ?int $subjectId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): ActivityLog {
        $admin = Auth::guard('admin')->user();

        return ActivityLog::create([
            'admin_id' => $admin?->id,
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
