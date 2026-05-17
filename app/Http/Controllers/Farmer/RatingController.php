<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\PoolMember;
use App\Models\DriverProfile;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SubmitRatingRequest;

class RatingController extends Controller
{
    // Show the rating form
    public function show(Shipment $shipment)
    {
        // Make sure this farmer is in the pool
        $myMember = PoolMember::where('pool_id', $shipment->pool_id)
                              ->where('user_id', Auth::id())
                              ->with('transportRequest')
                              ->firstOrFail();

        // Can only rate delivered shipments
        if ($shipment->status !== 'delivered') {
            return redirect()->route('farmer.history')
                             ->with('error',
                                 'You can only rate completed deliveries.');
        }

        // Already rated
        if ($myMember->has_rated) {
            return redirect()
                ->route('farmer.track', $shipment->tracking_code)
                ->with('error', 'You have already rated this delivery.');
        }

        $shipment->load('driver.driverProfile', 'pool');

        return view('farmer.rate', compact('shipment', 'myMember'));
    }

    // Submit the rating
    public function store(Request $request, Shipment $shipment)
    {
        $myMember = PoolMember::where('pool_id', $shipment->pool_id)
                              ->where('user_id', Auth::id())
                              ->firstOrFail();

        if ($shipment->status !== 'delivered') {
            return redirect()->route('farmer.history')
                             ->with('error', 'Cannot rate this delivery.');
        }

        if ($myMember->has_rated) {
            return redirect()
                ->route('farmer.track', $shipment->tracking_code)
                ->with('error', 'Already rated.');
        }

        // Save the rating on pool member record
        $myMember->update([
            'driver_rating'  => $request->rating,
            'rating_comment' => $request->comment,
            'has_rated'      => true,
        ]);

        // Recalculate driver's average rating
        $this->updateDriverRating($shipment->driver_id);

        // Notify the driver
        Notification::create([
            'user_id' => $shipment->driver_id,
            'title'   => '⭐ New Rating Received',
            'message' => Auth::user()->name
                         . ' rated your delivery '
                         . $request->rating . '/5'
                         . ($request->comment
                            ? ': "' . $request->comment . '"'
                            : '.'),
            'type'    => 'new_rating',
            'link'    => '/driver/earnings',
        ]);

        return redirect()
            ->route('farmer.track', $shipment->tracking_code)
            ->with('success',
                '⭐ Thank you for rating '
                . $shipment->driver->name . '!');
    }

    // Recalculate and update driver's average rating
    private function updateDriverRating(int $driverId): void
    {
        // Get all ratings for shipments this driver completed
        $allRatings = PoolMember::whereHas('pool', function ($q) use ($driverId) {
                          $q->where('driver_id', $driverId);
                      })
                      ->where('has_rated', true)
                      ->whereNotNull('driver_rating')
                      ->pluck('driver_rating');

        if ($allRatings->isEmpty()) return;

        $averageRating = round($allRatings->avg(), 2);

        DriverProfile::where('user_id', $driverId)
                     ->update(['rating' => $averageRating]);
    }
}