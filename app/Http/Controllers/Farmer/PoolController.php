<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use App\Models\PoolMember;
use App\Models\TransportRequest;
use App\Services\PoolMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoolController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Show pending requests (not yet in any pool)
        $myPendingRequests = TransportRequest::where('user_id', $user->id)
                                ->where('status', 'pending')
                                ->get();

        // Show all open pools with at least one member
        $pools = Pool::where('status', 'open')
                     ->where('pickup_date', '>=', now()->toDateString())
                     ->whereHas('members')
                     ->whereNull('driver_id')
                     ->orderBy('pickup_date', 'asc')
                     ->paginate(9);

        // Pools this farmer has already joined
        $myPoolIds = PoolMember::where('user_id', $user->id)
                               ->pluck('pool_id')
                               ->toArray();

        return view('farmer.pools.index', compact(
            'pools',
            'myPendingRequests',
            'myPoolIds'
        ));
    }

    public function join(Request $request, Pool $pool)
    {
        $request->validate([
            'transport_request_id' => ['required', 'exists:transport_requests,id'],
        ]);

        $transportRequest = TransportRequest::findOrFail(
            $request->transport_request_id
        );

        if ($transportRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$pool->isOpen()) {
            return back()->with('error', 'This pool is no longer open.');
        }

        $alreadyJoined = PoolMember::where('pool_id', $pool->id)
                                   ->where('user_id', Auth::id())
                                   ->exists();
        if ($alreadyJoined) {
            return back()->with('error', 'You are already in this pool.');
        }

        if ($pool->availableCapacity() < $transportRequest->quantity_kg) {
            return back()->with('error',
                'Not enough space in this pool for your cargo ('
                . number_format($transportRequest->quantity_kg) . 'kg needed, '
                . number_format($pool->availableCapacity()) . 'kg available).');
        }

        PoolMember::create([
            'pool_id'              => $pool->id,
            'transport_request_id' => $transportRequest->id,
            'user_id'              => Auth::id(),
            'joined_at'            => now(),
        ]);

        $pool->increment('used_capacity_kg', $transportRequest->quantity_kg);
        $transportRequest->update(['status' => 'pooled']);

        if ($pool->members()->count() >= $pool->max_farmers) {
            $pool->update(['status' => 'full']);
        }

        // Recalculate cost shares
        $service = new PoolMatchingService();
        $service->recalculateCostShares($pool);

        return back()->with('success', 'Successfully joined the pool!');
    }

    public function leave(Request $request, Pool $pool)
    {
        $member = PoolMember::where('pool_id', $pool->id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $transportRequest = TransportRequest::find(
            $member->transport_request_id
        );

        $member->delete();

        if ($transportRequest) {
            $pool->decrement('used_capacity_kg', $transportRequest->quantity_kg);
            // Set back to pending so farmer can rejoin or create new pool
            $transportRequest->update(['status' => 'pending']);
        }

        if ($pool->status === 'full') {
            $pool->update(['status' => 'open']);
        }

        // Recalculate remaining members' shares
        $service = new PoolMatchingService();
        $service->recalculateCostShares($pool);

        return back()->with('success',
            'You have left the pool. Your request is now pending — '
            . 'you can rejoin a pool or create a new one.');
    }
}