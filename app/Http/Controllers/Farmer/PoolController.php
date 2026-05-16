<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use App\Models\PoolMember;
use App\Models\TransportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoolController extends Controller
{
    // Browse available pools that this farmer can join
    public function index()
    {
        $user = Auth::user();

        // Get farmer's pending requests (only pending requests can join a pool)
        $myPendingRequests = TransportRequest::where('user_id', $user->id)
                                ->where('status', 'pending')
                                ->get();

        // Get open pools — ordered by pickup date
        $pools = Pool::where('status', 'open')
                     ->where('pickup_date', '>=', now()->toDateString())
                     ->orderBy('pickup_date', 'asc')
                     ->paginate(9);

        // Get pools the farmer has already joined
        $myPoolIds = PoolMember::where('user_id', $user->id)
                               ->pluck('pool_id')
                               ->toArray();

        return view('farmer.pools.index', compact(
            'pools',
            'myPendingRequests',
            'myPoolIds'
        ));
    }

    // Join a pool with a specific transport request
    public function join(Request $request, Pool $pool)
    {
        $request->validate([
            'transport_request_id' => ['required', 'exists:transport_requests,id'],
        ]);

        $transportRequest = TransportRequest::findOrFail($request->transport_request_id);

        // Security checks
        if ($transportRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$pool->isOpen()) {
            return back()->with('error', 'This pool is no longer accepting members.');
        }

        // Check if farmer already joined this pool
        $alreadyJoined = PoolMember::where('pool_id', $pool->id)
                                   ->where('user_id', Auth::id())
                                   ->exists();
        if ($alreadyJoined) {
            return back()->with('error', 'You have already joined this pool.');
        }

        // Check capacity
        if ($pool->availableCapacity() < $transportRequest->quantity_kg) {
            return back()->with('error', 'Not enough space in this pool for your cargo.');
        }

        // Add farmer to pool
        PoolMember::create([
            'pool_id'              => $pool->id,
            'transport_request_id' => $transportRequest->id,
            'user_id'              => Auth::id(),
            'joined_at'            => now(),
        ]);

        // Update pool used capacity
        $pool->increment('used_capacity_kg', $transportRequest->quantity_kg);

        // Update request status to pooled
        $transportRequest->update(['status' => 'pooled']);

        // Check if pool is now full
        if ($pool->members()->count() >= $pool->max_farmers) {
            $pool->update(['status' => 'full']);
        }

        return back()->with('success', 'Successfully joined the pool!');
    }

    // Leave a pool
    public function leave(Request $request, Pool $pool)
    {
        $member = PoolMember::where('pool_id', $pool->id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $transportRequest = TransportRequest::find($member->transport_request_id);

        // Remove from pool
        $member->delete();

        // Restore capacity
        if ($transportRequest) {
            $pool->decrement('used_capacity_kg', $transportRequest->quantity_kg);
            $transportRequest->update(['status' => 'pending']);
        }

        // Re-open pool if it was full
        if ($pool->status === 'full') {
            $pool->update(['status' => 'open']);
        }

        return back()->with('success', 'You have left the pool.');
    }
}