<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public static function log(
        string $action,
        ?string $modelType = null,
        ?int $modelId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): AuditLog {
        return AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public static function logModelCreated(Model $model): AuditLog
    {
        return self::log(
            'created',
            get_class($model),
            $model->id,
            null,
            $model->toArray()
        );
    }

    public static function logModelUpdated(Model $model, array $oldValues): AuditLog
    {
        $changedValues = array_intersect_key($model->toArray(), $oldValues);
        return self::log(
            'updated',
            get_class($model),
            $model->id,
            $oldValues,
            $changedValues
        );
    }

    public static function logModelDeleted(Model $model): AuditLog
    {
        return self::log(
            'deleted',
            get_class($model),
            $model->id,
            $model->toArray(),
            null
        );
    }

    public static function logLogin(int $userId, bool $success): AuditLog
    {
        return self::log(
            $success ? 'login_success' : 'login_failed',
            'App\\Models\\User',
            $userId
        );
    }

    public static function logLoginAttempt(string $email, bool $success): AuditLog
    {
        return AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $success ? 'login_success' : 'login_failed',
            'model_type' => 'App\\Models\\User',
            'model_id' => null,
            'old_values' => null,
            'new_values' => ['email' => $email],
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public static function logLogout(): AuditLog
    {
        return self::log('logout', 'App\\Models\\User', Auth::id());
    }
}
