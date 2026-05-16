<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use App\Models\Shipment;
use App\Models\Earning;
use Illuminate\Support\Facades\Auth;

class DriverDashboardController extends Controller
{
    public function index()
    {
        $user          = Auth::user();
        $driverProfile = $user->driverProfile;
        $vehicle       = $user->vehicle;

        // Count stats
        $totalDeliveries = Shipment::where('driver_id', $user->id)->count();

        $activeDeliveries = Shipment::where('driver_id', $user->id)
                                ->whereIn('status', ['pickup_pending','cargo_loaded','in_transit'])
                                ->count();

        $completedDeliveries = Shipment::where('driver_id', $user->id)
                                   ->where('status', 'delivered')
                                   ->count();

        $totalEarnings = Earning::where('user_id', $user->id)
                             ->where('status', 'paid')
                             ->sum('amount');

        $pendingEarnings = Earning::where('user_id', $user->id)
                               ->where('status', 'pending')
                               ->sum('amount');

        $unreadNotifications = $user->notifications()
                                    ->where('is_read', false)
                                    ->count();

        // Available pools (not yet assigned to any driver)
        $availablePools = Pool::where('status', 'open')
                              ->orWhere('status', 'full')
                              ->whereNull('driver_id')
                              ->where('pickup_date', '>=', now()->toDateString())
                              ->count();

        // Recent shipments
        $recentShipments = Shipment::where('driver_id', $user->id)
                               ->with('pool')
                               ->orderBy('created_at', 'desc')
                               ->take(5)
                               ->get();

        return view('driver.dashboard', compact(
            'user',
            'driverProfile',
            'vehicle',
            'totalDeliveries',
            'activeDeliveries',
            'completedDeliveries',
            'totalEarnings',
            'pendingEarnings',
            'unreadNotifications',
            'availablePools',
            'recentShipments'
        ));
    }
}