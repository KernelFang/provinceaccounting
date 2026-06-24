<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    /**
     * Create storage symlink (storage:link)
     */
    public function linkStorageDefault(): JsonResponse
    {
        $storageLink = public_path('storage');

        try {
            if (File::exists($storageLink) || is_link($storageLink)) {
                // Delete existing directory or link carefully
                if (is_link($storageLink)) {
                    unlink($storageLink);
                } else {
                    File::deleteDirectory($storageLink);
                }
            }

            Artisan::call('storage:link');

            Log::info('Storage link created by user ID: '.auth()->id());

            return $this->success('Storage link created successfully.');
        } catch (\Exception $e) {
            return $this->error('Failed to create storage link: '.$e->getMessage());
        }
    }

    public function linkStorageExternal()
    {
        $link = '/home/genztravels/public_html/storage';  // public_html/storage folder
        $target = storage_path('app/public');          // /home/genztravels/project/storage/app/public

        try {
            if (file_exists($link) || is_link($link)) {
                // Delete existing symlink or directory
                if (is_dir($link) && ! is_link($link)) {
                    rmdir($link);
                } else {
                    unlink($link);
                }
            }

            symlink($target, $link);

            return response()->json(['status' => 'success', 'message' => 'Storage link created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to create storage link: '.$e->getMessage()]);
        }
    }

    /**
     * Clear application cache (cache:clear)
     */
    public function clearCache(): JsonResponse
    {
        try {
            Artisan::call('cache:clear');

            Log::info('Cache cleared by user ID: '.auth()->id());

            return $this->success('Application cache cleared.');
        } catch (\Exception $e) {
            return $this->error('Failed to clear cache: '.$e->getMessage());
        }
    }

    /**
     * Clear config cache (config:clear)
     */
    public function clearConfigCache(): JsonResponse
    {
        try {
            Artisan::call('config:clear');

            Log::info('Config cache cleared by user ID: '.auth()->id());

            return $this->success('Config cache cleared.');
        } catch (\Exception $e) {
            return $this->error('Failed to clear config cache: '.$e->getMessage());
        }
    }

    /**
     * Cache config (config:cache)
     */
    public function cacheConfig(): JsonResponse
    {
        try {
            Artisan::call('config:cache');

            Log::info('Config cached by user ID: '.auth()->id());

            return $this->success('Config cached successfully.');
        } catch (\Exception $e) {
            return $this->error('Failed to cache config: '.$e->getMessage());
        }
    }

    /**
     * Clear route cache (route:clear)
     */
    public function clearRouteCache(): JsonResponse
    {
        try {
            Artisan::call('route:clear');

            Log::info('Route cache cleared by user ID: '.auth()->id());

            return $this->success('Route cache cleared.');
        } catch (\Exception $e) {
            return $this->error('Failed to clear route cache: '.$e->getMessage());
        }
    }

    /**
     * Cache routes (route:cache)
     */
    public function cacheRoutes(): JsonResponse
    {
        try {
            Artisan::call('route:cache');

            Log::info('Routes cached by user ID: '.auth()->id());

            return $this->success('Routes cached successfully.');
        } catch (\Exception $e) {
            return $this->error('Failed to cache routes: '.$e->getMessage());
        }
    }

    /**
     * Clear compiled views (view:clear)
     */
    public function clearViewCache(): JsonResponse
    {
        try {
            Artisan::call('view:clear');

            Log::info('View cache cleared by user ID: '.auth()->id());

            return $this->success('View cache cleared.');
        } catch (\Exception $e) {
            return $this->error('Failed to clear view cache: '.$e->getMessage());
        }
    }

    /**
     * Cache compiled views (view:cache)
     */
    public function cacheViews(): JsonResponse
    {
        try {
            Artisan::call('view:cache');

            Log::info('Views cached by user ID: '.auth()->id());

            return $this->success('Views cached successfully.');
        } catch (\Exception $e) {
            return $this->error('Failed to cache views: '.$e->getMessage());
        }
    }

    /**
     * Run database migrations (migrate)
     */
    public function migrate(): JsonResponse
    {
        try {
            Artisan::call('migrate', ['--force' => true]);

            Log::info('Database migrated by user ID: '.auth()->id());

            return $this->success('Database migrated successfully.');
        } catch (\Exception $e) {
            return $this->error('Migration failed: '.$e->getMessage());
        }
    }

    /**
     * Rollback last database migration batch (migrate:rollback)
     */
    public function rollbackMigration(): JsonResponse
    {
        try {
            Artisan::call('migrate:rollback', ['--force' => true]);

            Log::info('Database rollback by user ID: '.auth()->id());

            return $this->success('Last migration batch rolled back.');
        } catch (\Exception $e) {
            return $this->error('Rollback failed: '.$e->getMessage());
        }
    }

    /**
     * Run database seeders (db:seed)
     */
    public function seed(): JsonResponse
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);

            Log::info('Database seeded by user ID: '.auth()->id());

            return $this->success('Database seeded successfully.');
        } catch (\Exception $e) {
            return $this->error('Seeding failed: '.$e->getMessage());
        }
    }

    /**
     * Restart the queue worker (queue:restart)
     */
    public function restartQueue(): JsonResponse
    {
        try {
            Artisan::call('queue:restart');

            Log::info('Queue restarted by user ID: '.auth()->id());

            return $this->success('Queue worker restarted.');
        } catch (\Exception $e) {
            return $this->error('Queue restart failed: '.$e->getMessage());
        }
    }

    /**
     * Clear event cache (event:clear)
     */
    public function clearEventCache(): JsonResponse
    {
        try {
            Artisan::call('event:clear');

            Log::info('Event cache cleared by user ID: '.auth()->id());

            return $this->success('Event cache cleared.');
        } catch (\Exception $e) {
            return $this->error('Failed to clear event cache: '.$e->getMessage());
        }
    }

    /**
     * Cache events (event:cache)
     */
    public function cacheEvents(): JsonResponse
    {
        try {
            Artisan::call('event:cache');

            Log::info('Events cached by user ID: '.auth()->id());

            return $this->success('Events cached successfully.');
        } catch (\Exception $e) {
            return $this->error('Failed to cache events: '.$e->getMessage());
        }
    }

    /*
     * Helper methods for consistent JSON responses
     */
    private function success(string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ], $code);
    }

    private function error(string $message, int $code = 500): JsonResponse
    {
        Log::error('System command error: '.$message.' User ID: '.auth()->id());

        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
