<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FlightTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\PortalBalanceController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\SoftDeleteController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::prefix('account')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['verified'])->name('dashboard');

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

            // Finance / Sales modules
            Route::resource('sales', SaleController::class);
            Route::resource('tours', TourController::class);
            Route::resource('visas', VisaController::class);
            Route::resource('trainings', \App\Http\Controllers\TrainingController::class);
            Route::resource('training-types', \App\Http\Controllers\TrainingTypeController::class);
            Route::resource('portal-balances', PortalBalanceController::class);

            // Dropdown CRUDs
            Route::resource('portals', PortalController::class);
            Route::resource('service-types', ServiceTypeController::class);
            Route::resource('airlines', AirlineController::class);
            Route::resource('flight-types', FlightTypeController::class);
            Route::resource('trips', TripController::class);
            Route::resource('purposes', PurposeController::class);
            Route::resource('visa-purposes', \App\Http\Controllers\VisaPurposeController::class);
            Route::resource('countries', CountryController::class);
            Route::resource('infos', InfoController::class);

            // HR modules
            Route::resource('departments', DepartmentController::class);
            Route::resource('designations', DesignationController::class);
            Route::resource('employees', EmployeeController::class);

            // Register restore / force-delete routes for resources used by the app. Add all resources that have soft delete functionality here.
            $resources = [
                'users', 'expenses', 'petty-cashes', 'sales', 'tours', 'visas', 'trainings', 'training-types', 'portal-balances',
                'portals', 'service-types', 'airlines', 'flight-types', 'trips', 'purposes', 'visa-purposes',
                'expense-types', 'payment-methods', 'clients', 'projects', 'flats', 'flat-pricing-histories', 'incomes',
                'countries', 'infos', 'departments', 'designations', 'employees',
            ];

            foreach ($resources as $r) {
                Route::post("{$r}/{id}/restore", [SoftDeleteController::class, 'restore'])->name("{$r}.restore");
                Route::delete("{$r}/{id}/force-delete", [SoftDeleteController::class, 'forceDelete'])->name("{$r}.force-delete");
            }

            // system routes
            require __DIR__.'/system.php';
        });
    });

    require __DIR__.'/auth.php';
});
