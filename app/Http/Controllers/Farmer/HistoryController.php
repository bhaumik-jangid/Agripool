<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\TransportRequest;
use App\Models\PoolMember;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $history = TransportRequest::where('user_id', Auth::id())
                       ->whereIn('status', ['delivered', 'cancelled'])
                       ->with([
                           'poolMember.pool.shipment.driver.driverProfile',
                           'poolMember.pool.driver',
                       ])
                       ->orderBy('updated_at', 'desc')
                       ->paginate(10);

        return view('farmer.history', compact('history'));
    }

    public function track(string $trackingCode)
    {
        // Find shipment by tracking code
        $shipment = Shipment::where('tracking_code', $trackingCode)
                            ->with([
                                'pool.members.farmer',
                                'pool.members.transportRequest',
                                'driver.driverProfile',
                                'driver.vehicle',
                            ])
                            ->firstOrFail();

        // Make sure this farmer is in this pool
        $isMember = PoolMember::where('pool_id', $shipment->pool_id)
                              ->where('user_id', Auth::id())
                              ->exists();

        if (!$isMember) {
            abort(403, 'You are not part of this shipment.');
        }

        // Get this farmer's specific request and cost share
        $myMember = PoolMember::where('pool_id', $shipment->pool_id)
                              ->where('user_id', Auth::id())
                              ->with('transportRequest')
                              ->first();

        // Build timeline steps with completion status
        $timeline = $this->buildTimeline($shipment);

        return view('farmer.track', compact(
            'shipment',
            'myMember',
            'timeline'
        ));
    }

    private function buildTimeline(Shipment $shipment): array
    {
        $statusOrder = [
            'pickup_pending',
            'cargo_loaded',
            'in_transit',
            'delivered',
        ];

        $currentIndex = array_search($shipment->status, $statusOrder);
        if ($currentIndex === false) $currentIndex = -1;

        return [
            [
                'key'         => 'pickup_pending',
                'label'       => 'Pool Assigned',
                'description' => 'Driver has been assigned to your pool',
                'icon'        => '📋',
                'done'        => true, // Always done if shipment exists
                'active'      => $shipment->status === 'pickup_pending',
                'time'        => $shipment->created_at,
            ],
            [
                'key'         => 'cargo_loaded',
                'label'       => 'Cargo Loaded',
                'description' => 'Driver has collected and loaded all cargo',
                'icon'        => '📦',
                'done'        => in_array($shipment->status, [
                                    'cargo_loaded',
                                    'in_transit',
                                    'delivered',
                                ]),
                'active'      => $shipment->status === 'cargo_loaded',
                'time'        => $shipment->pickup_time,
            ],
            [
                'key'         => 'in_transit',
                'label'       => 'In Transit',
                'description' => 'Your produce is on the way to the market',
                'icon'        => '🚛',
                'done'        => in_array($shipment->status, [
                                    'in_transit',
                                    'delivered',
                                ]),
                'active'      => $shipment->status === 'in_transit',
                'time'        => null,
            ],
            [
                'key'         => 'delivered',
                'label'       => 'Delivered',
                'description' => 'Successfully delivered to the market',
                'icon'        => '✅',
                'done'        => $shipment->status === 'delivered',
                'active'      => $shipment->status === 'delivered',
                'time'        => $shipment->delivery_time,
            ],
        ];
    }
}