<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pool;

class PoolManagementController extends Controller
{
    public function index()
    {
        $pools = Pool::with('members.farmer', 'driver')
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);

        $counts = [
            'all'        => Pool::count(),
            'open'       => Pool::where('status', 'open')->count(),
            'in_transit' => Pool::where('status', 'in_transit')->count(),
            'completed'  => Pool::where('status', 'completed')->count(),
        ];

        return view('admin.pools.index', compact('pools', 'counts'));
    }

    public function show(Pool $pool)
    {
        $pool->load('members.farmer.farmerProfile',
                    'members.transportRequest',
                    'driver.driverProfile',
                    'shipment');

        return view('admin.pools.show', compact('pool'));
    }
}