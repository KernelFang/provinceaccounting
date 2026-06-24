<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/system')->middleware(['auth', 'permission'])->group(function () {
    Route::get('/link-storage', [SystemController::class, 'linkStorageDefault'])->name('system.link-storage');
    Route::get('/link-storage-external', [SystemController::class, 'linkStorageExternal'])->name('system.link-storage-external');
    Route::get('/clear-cache', [SystemController::class, 'clearCache'])->name('system.clear-cache');
    Route::get('/clear-config-cache', [SystemController::class, 'clearConfigCache'])->name('system.clear-config-cache');
    Route::get('/cache-config', [SystemController::class, 'cacheConfig'])->name('system.cache-config');
    Route::get('/clear-route-cache', [SystemController::class, 'clearRouteCache'])->name('system.clear-route-cache');
    Route::get('/cache-routes', [SystemController::class, 'cacheRoutes'])->name('system.cache-routes');
    Route::get('/clear-view-cache', [SystemController::class, 'clearViewCache'])->name('system.clear-view-cache');
    Route::get('/cache-views', [SystemController::class, 'cacheViews'])->name('system.cache-views');
    Route::get('/migrate', [SystemController::class, 'migrate'])->name('system.migrate');
    Route::get('/rollback-migration', [SystemController::class, 'rollbackMigration'])->name('system.rollback-migration');
    Route::get('/seed', [SystemController::class, 'seed'])->name('system.seed');
    Route::get('/restart-queue', [SystemController::class, 'restartQueue'])->name('system.restart-queue');
    Route::get('/clear-event-cache', [SystemController::class, 'clearEventCache'])->name('system.clear-event-cache');
    Route::get('/cache-events', [SystemController::class, 'cacheEvents'])->name('system.cache-events');
    Route::get('/composer-optimize', [SystemController::class, 'composerOptimize'])->name('system.composer-optimize');
    Route::get('/composer-dump-autoload', [SystemController::class, 'composerDumpAutoload'])->name('system.composer-dump-autoload');
});
