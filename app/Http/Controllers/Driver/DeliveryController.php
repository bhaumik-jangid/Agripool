<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Earning;
use App\Models\Notification;
use App\Models\PoolMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\DeliveryCompleteMail;
use Illuminate\Support\Facades\Mail;

class DeliveryController extends Controller
{
    // List all shipments assigned to this driver
    public function index()
    {
        $shipments = Shipment::where('driver_id', Auth::id())
            ->with('pool')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('driver.deliveries.index', compact('shipments'));
    }

    // View single shipment detail
    public function show(Shipment $shipment)
    {
        // Security: only the assigned driver can view
        if ($shipment->driver_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Load related data
        $shipment->load(
            'pool.members.farmer.farmerProfile',
            'pool.members.transportRequest'
        );

        return view('driver.deliveries.show', compact('shipment'));
    }

    // Update the shipment status
    public function updateStatus(Request $request, Shipment $shipment)
    {
        if ($shipment->driver_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:cargo_loaded,in_transit,delivered,failed'],
            'current_location' => ['nullable', 'string', 'max:255'],
            'driver_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $updateData = [
            'status' => $request->status,
            'current_location' => $request->current_location,
            'driver_notes' => $request->driver_notes,
        ];

        // Set timestamps based on status
        if ($request->status === 'cargo_loaded') {
            $updateData['pickup_time'] = now();
        }

        if ($request->status === 'in_transit') {
            // Update pool status
            $shipment->pool->update(['status' => 'in_transit']);

            // Update all transport requests
            PoolMember::where('pool_id', $shipment->pool_id)
                ->get()
                ->each(function ($member) {
                    $member->transportRequest->update(['status' => 'in_transit']);
                });
        }

        if ($request->status === 'delivered') {
            $updateData['delivery_time'] = now();

            // Update pool status
            $shipment->pool->update(['status' => 'completed']);

            // Update all requests to delivered
            $poolMembers = PoolMember::where('pool_id', $shipment->pool_id)->get();

            foreach ($poolMembers as $member) {
                $member->transportRequest->update(['status' => 'delivered']);

                // Notify each farmer
                Notification::create([
                    'user_id' => $member->user_id,
                    'title' => '🎉 Delivery Complete!',
                    'message' => 'Your produce has been successfully delivered to the market. ' .
                        'Please rate your experience.',
                    'type' => 'delivery_completed',
                    'link' => '/farmer/history',
                ]);

                // Notify each farmer — with payment reminder
                Notification::create([
                    'user_id' => $member->user_id,
                    'title' => '🎉 Delivery Complete — Payment Due!',
                    'message' => 'Your produce has been successfully delivered to '
                        . $shipment->pool->destination_market
                        . '. Please confirm your payment of ₹'
                        . number_format($member->cost_share ?? 0, 2)
                        . ' to your driver. Go to My Requests → View → Payment.',
                    'type' => 'payment_due',
                    'link' => '/farmer/requests/' . $member->transport_request_id,
                ]);
            }

            // Send delivery complete email with payment reminder
            foreach ($poolMembers as $member) {
                try {
                    $farmer = \App\Models\User::find($member->user_id);
                    if ($farmer) {
                        Mail::to($farmer->email)
                            ->send(new DeliveryCompleteMail(
                                $farmer,
                                $shipment,
                                $member
                            ));
                    }
                } catch (\Exception $e) {
                    \Log::error('Delivery complete email failed: '
                        . $e->getMessage());
                }
            }

            // Create earnings record for driver
            if ($shipment->pool->total_cost) {
                Earning::create([
                    'user_id' => Auth::id(),
                    'shipment_id' => $shipment->id,
                    'amount' => $shipment->pool->total_cost,
                    'status' => 'pending',
                ]);
            }

            // Update driver stats
            $driverProfile = Auth::user()->driverProfile;
            if ($driverProfile) {
                $driverProfile->increment('total_deliveries');
            }
        }

        $shipment->update($updateData);

        return back()->with(
            'success',
            'Shipment status updated to: ' . ucfirst(str_replace('_', ' ', $request->status))
        );
    }
}