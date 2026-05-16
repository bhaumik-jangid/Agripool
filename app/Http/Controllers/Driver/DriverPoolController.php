<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use App\Models\Shipment;
use App\Models\PoolMember;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DriverPoolController extends Controller
{
    // Show all pools available for a driver to accept
    public function index()
    {
        $pools = Pool::whereIn('status', ['open', 'full'])
                     ->whereNull('driver_id')
                     ->where('pickup_date', '>=', now()->toDateString())
                     ->with('members.farmer')
                     ->orderBy('pickup_date', 'asc')
                     ->paginate(9);

        return view('driver.pools.index', compact('pools'));
    }

    // Driver accepts a pool → creates a shipment
    public function accept(Pool $pool)
    {
        $driver = Auth::user();

        // Check driver is approved
        if (!$driver->driverProfile || !$driver->driverProfile->isApproved()) {
            return back()->with('error',
                'Your account must be approved by admin before accepting deliveries.');
        }

        // Check pool is still available
        if (!in_array($pool->status, ['open', 'full']) || $pool->driver_id) {
            return back()->with('error', 'This pool is no longer available.');
        }

        // Check driver has a verified vehicle
        if (!$driver->vehicle || !$driver->vehicle->is_verified) {
            return back()->with('error',
                'You need a verified vehicle before accepting deliveries.');
        }

        // Assign driver to pool
        $pool->update([
            'driver_id'  => $driver->id,
            'status'     => 'assigned',
            'matched_at' => now(),
        ]);

        // Create the shipment record
        $shipment = Shipment::create([
            'tracking_code'   => 'AGP-' . strtoupper(Str::random(8)),
            'pool_id'         => $pool->id,
            'driver_id'       => $driver->id,
            'status'          => 'pickup_pending',
        ]);

        // Update all transport requests in this pool to 'assigned'
        PoolMember::where('pool_id', $pool->id)
                  ->get()
                  ->each(function ($member) {
                      $member->transportRequest->update(['status' => 'assigned']);

                      // Notify each farmer
                      Notification::create([
                          'user_id' => $member->user_id,
                          'title'   => 'Driver Assigned!',
                          'message' => 'A driver has been assigned to your pool. ' .
                                       'Your shipment tracking code is ready.',
                          'type'    => 'driver_assigned',
                          'link'    => '/farmer/requests/' . $member->transport_request_id,
                      ]);
                  });

        return redirect()->route('driver.deliveries.show', $shipment)
                         ->with('success', 'Pool accepted! Shipment created successfully.');
    }
}