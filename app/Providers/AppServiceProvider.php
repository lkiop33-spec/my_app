<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\SystemLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen('eloquent.*', function ($eventName, array $data) {
            $actions = ['created', 'updated', 'deleted'];
            
            $action = null;
            foreach ($actions as $a) {
                if (str_starts_with($eventName, "eloquent.{$a}:")) {
                    $action = $a;
                    break;
                }
            }
            
            if (!$action) {
                return;
            }

            $model = $data[0] ?? null;
            if (! $model instanceof Model) {
                return;
            }

            if (get_class($model) === SystemLog::class) {
                return;
            }

            if (!str_starts_with(get_class($model), 'App\\Models\\')) {
                return;
            }

            if (!$model->getKey()) {
                return;
            }

            $oldPayload = [];
            $newPayload = [];

            if ($action === 'created') {
                $newPayload = $model->getAttributes();
            } elseif ($action === 'updated') {
                $oldPayload = array_intersect_key($model->getOriginal(), $model->getDirty());
                $newPayload = $model->getDirty();
                
                if (empty($newPayload)) {
                    return;
                }
            } elseif ($action === 'deleted') {
                $oldPayload = $model->getAttributes();
            }

            $hiddenFields = ['password', 'remember_token'];
            foreach ($hiddenFields as $field) {
                if (isset($oldPayload[$field])) $oldPayload[$field] = '********';
                if (isset($newPayload[$field])) $newPayload[$field] = '********';
            }

            try {
                SystemLog::create([
                    'user_id' => auth()->id(),
                    'model_type' => class_basename($model),
                    'model_id' => $model->getKey(),
                    'action' => $action,
                    'old_payload' => empty($oldPayload) ? null : $oldPayload,
                    'new_payload' => empty($newPayload) ? null : $newPayload,
                    'ip_address' => request()->ip(),
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to log system event: ' . $e->getMessage());
            }
        });
    }
}
