<?php

// removed: AirlineController
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::prefix('account')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['verified'])->name('dashboard');
        Route::get('/reports', [ReportController::class, 'index'])->middleware(['verified'])->name('reports.index');
        Route::get('/reports/export/{type}', [ReportController::class, 'export'])->middleware(['verified'])->name('reports.export');

        Route::middleware(['permission'])->group(function () {
            Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
            Route::post('upload-profile-image', [UserController::class, 'uploadProfileImage'])->name('users.imageupload');
            Route::resource('users', UserController::class);

            Route::resource('expenses', ExpenseController::class);
            Route::resource('petty-cashes', \App\Http\Controllers\PettyCashController::class);
            Route::resource('clients', \App\Http\Controllers\ClientController::class);
            Route::resource('projects', \App\Http\Controllers\ProjectController::class);
            Route::resource('flats', \App\Http\Controllers\FlatController::class);
            Route::resource('flat-pricing-histories', \App\Http\Controllers\FlatPricingHistoryController::class)->except(['edit', 'update']);
            Route::resource('expense-types', \App\Http\Controllers\ExpenseTypeController::class);
            Route::resource('payment-methods', \App\Http\Controllers\PaymentMethodController::class);
            Route::resource('incomes', \App\Http\Controllers\IncomeController::class);

            Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
            Route::get('/audit-logs/{id}', [AuditLogController::class, 'show'])->name('audit-logs.show');

            // HR modules
            Route::resource('departments', DepartmentController::class);
            Route::resource('designations', DesignationController::class);
            Route::resource('employees', EmployeeController::class);
            Route::resource('countries', CountryController::class);

            // system routes
            require __DIR__.'/system.php';
        });
    });

    require __DIR__.'/auth.php';
});
