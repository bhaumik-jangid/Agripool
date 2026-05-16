<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TransportRequest;
use App\Models\Pool;
use App\Models\Shipment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Platform-wide statistics
        $totalFarmers  = User::where('role', 'farmer')->count();
        $totalDrivers  = User::where('role', 'driver')->count();
        $totalRequests = TransportRequest::count();
        $activePools   = Pool::whereIn('status', ['open', 'assigned', 'in_transit'])->count();
        $pendingDriverApprovals = \App\Models\DriverProfile::where('approval_status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalFarmers',
            'totalDrivers',
            'totalRequests',
            'activePools',
            'pendingDriverApprovals'
        ));
    }
}