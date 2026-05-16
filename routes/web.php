<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Farmer\FarmerDashboardController;
use App\Http\Controllers\Farmer\TransportRequestController;
use App\Http\Controllers\Farmer\PoolController;
use App\Http\Controllers\Farmer\NotificationController;
use App\Http\Controllers\Farmer\ProfileController;
use App\Http\Controllers\Farmer\HistoryController;
use App\Http\Controllers\Driver\DriverDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Driver\DriverPoolController;
use App\Http\Controllers\Driver\DeliveryController;
use App\Http\Controllers\Driver\EarningsController;
use App\Http\Controllers\Driver\VehicleController;
use App\Http\Controllers\Driver\DriverProfileController;

// ============================================================
// PUBLIC ROUTES
// ============================================================
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'submitContact'])->name('contact.submit');

// ============================================================
// AUTH ROUTES
// ============================================================
require __DIR__ . '/auth.php';

// ============================================================
// FARMER ROUTES
// ============================================================
Route::prefix('farmer')
    ->middleware(['auth', 'farmer'])
    ->name('farmer.')
    ->group(function () {

        Route::get('/dashboard', [FarmerDashboardController::class, 'index'])
             ->name('dashboard');

        // Custom routes BEFORE resource
        Route::get('/requests/confirm',
            [TransportRequestController::class, 'confirm'])
             ->name('requests.confirm');
        Route::post('/requests/confirm',
            [TransportRequestController::class, 'processConfirm'])
             ->name('requests.processConfirm');

        // Resource routes
        Route::resource('requests', TransportRequestController::class);

        Route::get('/pools', [PoolController::class, 'index'])
             ->name('pools.index');
        Route::post('/pools/{pool}/join', [PoolController::class, 'join'])
             ->name('pools.join');
        Route::post('/pools/{pool}/leave', [PoolController::class, 'leave'])
             ->name('pools.leave');

        Route::get('/history', [HistoryController::class, 'index'])
             ->name('history');

        Route::get('/notifications', [NotificationController::class, 'index'])
             ->name('notifications.index');
        Route::post('/notifications/{id}/read',
            [NotificationController::class, 'markRead'])
             ->name('notifications.read');
        Route::post('/notifications/read-all',
            [NotificationController::class, 'markAllRead'])
             ->name('notifications.readAll');

        Route::get('/profile', [ProfileController::class, 'index'])
             ->name('profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])
             ->name('profile.update');

    });

// ============================================================
// DRIVER ROUTES
// ============================================================
Route::prefix('driver')
    ->middleware(['auth', 'driver'])
    ->name('driver.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DriverDashboardController::class, 'index'])
            ->name('dashboard');

        // Available pools to accept
        Route::get('/pools', [DriverPoolController::class, 'index'])
            ->name('pools.index');
        Route::post('/pools/{pool}/accept', [DriverPoolController::class, 'accept'])
            ->name('pools.accept');

        // My deliveries
        Route::get('/deliveries', [DeliveryController::class, 'index'])
            ->name('deliveries.index');
        Route::get('/deliveries/{shipment}', [DeliveryController::class, 'show'])
            ->name('deliveries.show');
        Route::post('/deliveries/{shipment}/status', [DeliveryController::class, 'updateStatus'])
            ->name('deliveries.status');

        // Earnings
        Route::get('/earnings', [EarningsController::class, 'index'])
            ->name('earnings.index');

        // Vehicle
        Route::get('/vehicle', [VehicleController::class, 'index'])
            ->name('vehicle.index');
        Route::post('/vehicle', [VehicleController::class, 'store'])
            ->name('vehicle.store');
        Route::put('/vehicle/{vehicle}', [VehicleController::class, 'update'])
            ->name('vehicle.update');

        // Profile
        Route::get('/profile', [DriverProfileController::class, 'index'])
            ->name('profile.index');
        Route::put('/profile', [DriverProfileController::class, 'update'])
            ->name('profile.update');

    });


// ============================================================
// ADMIN ROUTES
// ============================================================
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
    });