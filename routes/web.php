<?php

use Illuminate\Support\Facades\Route;

// Controllers — Public
use App\Http\Controllers\PublicController;

// Controllers — Farmer
use App\Http\Controllers\Farmer\FarmerDashboardController;
use App\Http\Controllers\Farmer\TransportRequestController;
use App\Http\Controllers\Farmer\PoolController;
use App\Http\Controllers\Farmer\NotificationController;
use App\Http\Controllers\Farmer\ProfileController;
use App\Http\Controllers\Farmer\HistoryController;

// Controllers — Driver
use App\Http\Controllers\Driver\DriverDashboardController;
use App\Http\Controllers\Driver\DriverPoolController;
use App\Http\Controllers\Driver\DeliveryController;
use App\Http\Controllers\Driver\EarningsController;
use App\Http\Controllers\Driver\VehicleController;
use App\Http\Controllers\Driver\DriverProfileController;

// Controllers — Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\FarmerManagementController;
use App\Http\Controllers\Admin\DriverManagementController;
use App\Http\Controllers\Admin\RequestManagementController;
use App\Http\Controllers\Admin\PoolManagementController;
use App\Http\Controllers\Admin\ShipmentManagementController;
use App\Http\Controllers\Admin\FeedbackManagementController;

// ============================================================
// PUBLIC ROUTES — No login required
// ============================================================

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'submitContact'])
    ->name('contact.submit');

// ============================================================
// AUTH ROUTES — Provided by Breeze
// ============================================================
require __DIR__ . '/auth.php';

// ============================================================
// FARMER ROUTES
// ============================================================
Route::prefix('farmer')
    ->middleware(['auth', 'farmer'])
    ->name('farmer.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [FarmerDashboardController::class, 'index'])
            ->name('dashboard');

        // Pool match confirmation — MUST be before resource()
        Route::get(
            '/requests/confirm',
            [TransportRequestController::class, 'confirm']
        )
            ->name('requests.confirm');
        Route::post(
            '/requests/confirm',
            [TransportRequestController::class, 'processConfirm']
        )
            ->name('requests.processConfirm');

        // Transport Requests — full CRUD resource
        Route::resource('requests', TransportRequestController::class)
            ->parameters(['requests' => 'transportRequest']);
        Route::post(
            '/requests/{transportRequest}/pay',
            [TransportRequestController::class, 'pay']
        )
            ->name('requests.pay');

        // Pools
        Route::get('/pools', [PoolController::class, 'index'])
            ->name('pools.index');
        Route::post('/pools/{pool}/join', [PoolController::class, 'join'])
            ->name('pools.join');
        Route::post('/pools/{pool}/leave', [PoolController::class, 'leave'])
            ->name('pools.leave');
        Route::post(
            '/requests/autopool',
            [TransportRequestController::class, 'autoPool']
        )
            ->name('requests.autopool');

        // Delivery History
        Route::get('/history', [HistoryController::class, 'index'])
            ->name('history');

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');
        Route::post(
            '/notifications/{id}/read',
            [NotificationController::class, 'markRead']
        )
            ->name('notifications.read');
        Route::post(
            '/notifications/read-all',
            [NotificationController::class, 'markAllRead']
        )
            ->name('notifications.readAll');

        // Profile
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

        // Deliveries
        Route::get('/deliveries', [DeliveryController::class, 'index'])
            ->name('deliveries.index');
        Route::get('/deliveries/{shipment}', [DeliveryController::class, 'show'])
            ->name('deliveries.show');
        Route::post(
            '/deliveries/{shipment}/status',
            [DeliveryController::class, 'updateStatus']
        )
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

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Farmer management
        Route::get('/farmers', [FarmerManagementController::class, 'index'])
            ->name('farmers.index');
        Route::get('/farmers/{user}', [FarmerManagementController::class, 'show'])
            ->name('farmers.show');

        // Driver management
        Route::get('/drivers', [DriverManagementController::class, 'index'])
            ->name('drivers.index');
        Route::get('/drivers/{user}', [DriverManagementController::class, 'show'])
            ->name('drivers.show');
        Route::post(
            '/drivers/{user}/approve',
            [DriverManagementController::class, 'approve']
        )
            ->name('drivers.approve');
        Route::post(
            '/drivers/{user}/reject',
            [DriverManagementController::class, 'reject']
        )
            ->name('drivers.reject');

        // Transport requests
        Route::get('/requests', [RequestManagementController::class, 'index'])
            ->name('requests.index');
        Route::get(
            '/requests/{transportRequest}',
            [RequestManagementController::class, 'show']
        )
            ->name('requests.show');

        // Pools
        Route::get('/pools', [PoolManagementController::class, 'index'])
            ->name('pools.index');
        Route::get('/pools/{pool}', [PoolManagementController::class, 'show'])
            ->name('pools.show');

        // Shipments
        Route::get('/shipments', [ShipmentManagementController::class, 'index'])
            ->name('shipments.index');
        Route::get(
            '/shipments/{shipment}',
            [ShipmentManagementController::class, 'show']
        )
            ->name('shipments.show');

        // Feedback
        Route::get('/feedback', [FeedbackManagementController::class, 'index'])
            ->name('feedback.index');
        Route::post(
            '/feedback/{feedback}/resolve',
            [FeedbackManagementController::class, 'resolve']
        )
            ->name('feedback.resolve');

        // User suspend / activate
        Route::post(
            '/users/{user}/suspend',
            [AdminDashboardController::class, 'suspend']
        )
            ->name('users.suspend');
        Route::post(
            '/users/{user}/activate',
            [AdminDashboardController::class, 'activate']
        )
            ->name('users.activate');

    });