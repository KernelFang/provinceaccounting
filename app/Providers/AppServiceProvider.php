<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\Audit;

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
        View::addNamespace('errors', resource_path('views/errors'));

        // Automatically set created_by when creating records
        Event::listen('eloquent.creating: *', function ($eventName, $data) {
            $model = $data[0] ?? null;
            if (!$model) return;
            if (auth()->check() && $model->hasAttribute('created_by') && !$model->created_by) {
                $model->created_by = auth()->id();
            }
        });

        // Automatically set updated_by when updating records
        Event::listen('eloquent.updating: *', function ($eventName, $data) {
            $model = $data[0] ?? null;
            if (!$model) return;
            if (auth()->check() && $model->hasAttribute('updated_by')) {
                $model->updated_by = auth()->id();
            }
        });

        // Listen to Eloquent model events globally and create audit entries
        Event::listen('eloquent.created: *', function ($eventName, $data) {
            $model = $data[0] ?? null;
            if (!$model) return;
            if ($model instanceof Audit) return; // avoid auditing audit entries
            try {
                Audit::createAudit('create', $model, null, $model->getAttributes());
            } catch (\Throwable $e) {
                // ignore audit failures to avoid breaking primary operations
            }
        });

        Event::listen('eloquent.updated: *', function ($eventName, $data) {
            $model = $data[0] ?? null;
            if (!$model) return;
            if ($model instanceof Audit) return;
            try {
                Audit::createAudit('update', $model, $model->getOriginal(), $model->getAttributes());
            } catch (\Throwable $e) {}
        });

        Event::listen('eloquent.deleted: *', function ($eventName, $data) {
            $model = $data[0] ?? null;
            if (!$model) return;
            if ($model instanceof Audit) return;
            try {
                Audit::createAudit('delete', $model, $model->getOriginal(), null);
            } catch (\Throwable $e) {}
        });

        Event::listen('eloquent.restored: *', function ($eventName, $data) {
            $model = $data[0] ?? null;
            if (!$model) return;
            if ($model instanceof Audit) return;
            try {
                Audit::createAudit('restore', $model, null, $model->getAttributes());
            } catch (\Throwable $e) {}
        });

        Event::listen('eloquent.forceDeleted: *', function ($eventName, $data) {
            $model = $data[0] ?? null;
            if (!$model) return;
            if ($model instanceof Audit) return;
            try {
                Audit::createAudit('force_delete', $model, $model->getOriginal(), null);
            } catch (\Throwable $e) {}
        });

        // Listen for login/logout events to audit them
        Event::listen(Login::class, function (Login $event) {
            $user = $event->user ?? null;
            if ($user) {
                try {
                    Audit::create([
                        'auditable_id' => $user->getAuthIdentifier(),
                        'auditable_type' => get_class($user),
                        'action' => 'login',
                        'old_values' => null,
                        'new_values' => null,
                        'user_id' => $user->getAuthIdentifier(),
                        'ip_address' => request()->ip(),
                    ]);
                } catch (\Throwable $e) {}
            }
        });

        Event::listen(Logout::class, function (Logout $event) {
            $user = $event->user ?? null;
            if ($user) {
                try {
                    Audit::create([
                        'auditable_id' => $user->getAuthIdentifier(),
                        'auditable_type' => get_class($user),
                        'action' => 'logout',
                        'old_values' => null,
                        'new_values' => null,
                        'user_id' => $user->getAuthIdentifier(),
                        'ip_address' => request()->ip(),
                    ]);
                } catch (\Throwable $e) {}
            }
        });
    }
}
