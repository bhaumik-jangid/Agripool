<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use App\Models\PriceProposal;
use App\Models\Notification;
use App\Models\PoolMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceProposalController extends Controller
{
    // Driver proposes a new price for a pool
    public function propose(Request $request, Pool $pool)
    {
        $request->validate([
            'proposed_cost' => [
                'required', 'numeric',
                // Proposed price must be between original and 3x original
                'min:' . ($pool->total_cost * 1.01),
                'max:' . ($pool->total_cost * 3),
            ],
            'reason' => ['required', 'string', 'min:20', 'max:500'],
        ]);

        $driver = Auth::user();

        // Check driver is approved and has verified vehicle
        if (!$driver->driverProfile?->isApproved()) {
            return back()->with('error',
                'Your account must be approved to propose prices.');
        }

        if (!$driver->vehicle?->is_verified) {
            return back()->with('error',
                'Your vehicle must be verified before proposing prices.');
        }

        // Check pool is still open and has no driver
        if (!in_array($pool->status, ['open', 'full'])
            || $pool->driver_id) {
            return back()->with('error',
                'This pool is no longer available for proposals.');
        }

        // Check no pending proposal from this driver already
        $existing = PriceProposal::where('pool_id', $pool->id)
                                  ->where('driver_id', $driver->id)
                                  ->where('status', 'pending')
                                  ->exists();
        if ($existing) {
            return back()->with('error',
                'You already have a pending price proposal for this pool.');
        }

        // Create the proposal — expires in 24 hours
        $proposal = PriceProposal::create([
            'pool_id'       => $pool->id,
            'driver_id'     => $driver->id,
            'original_cost' => $pool->total_cost,
            'proposed_cost' => $request->proposed_cost,
            'reason'        => $request->reason,
            'status'        => 'pending',
            'expires_at'    => now()->addHours(24),
        ]);

        // Notify all farmers in this pool
        $members = PoolMember::where('pool_id', $pool->id)->get();
        foreach ($members as $member) {
            Notification::create([
                'user_id' => $member->user_id,
                'title'   => '💬 Driver Proposed a New Price',
                'message' => $driver->name
                             . ' has proposed ₹'
                             . number_format($request->proposed_cost, 0)
                             . ' for your pool (original: ₹'
                             . number_format($pool->total_cost, 0)
                             . '). Please vote to accept or decline. '
                             . 'You have 24 hours.',
                'type'    => 'price_proposal',
                'link'    => '/farmer/pools/proposals/' . $proposal->id,
            ]);
        }

        return back()->with('success',
            '✅ Price proposal sent to all farmers in this pool. '
            . 'You will be notified when they respond.');
    }

    // Farmer votes on a proposal
    public function vote(Request $request, PriceProposal $proposal)
    {
        $request->validate([
            'vote' => ['required', 'in:accept,decline'],
        ]);

        $farmer = Auth::user();

        // Make sure this farmer is in the pool
        $isMember = PoolMember::where('pool_id', $proposal->pool_id)
                              ->where('user_id', $farmer->id)
                              ->exists();
        if (!$isMember) {
            abort(403, 'You are not a member of this pool.');
        }

        if ($proposal->isExpired()) {
            return back()->with('error',
                'This proposal has expired.');
        }

        if ($proposal->hasVoted($farmer->id)) {
            return back()->with('error',
                'You have already voted on this proposal.');
        }

        // Record the vote
        \App\Models\PriceProposalVote::create([
            'price_proposal_id' => $proposal->id,
            'user_id'           => $farmer->id,
            'vote'              => $request->vote,
        ]);

        // Check if voting is now complete (all farmers voted)
        $this->checkProposalOutcome($proposal);

        $msg = $request->vote === 'accept'
            ? 'You accepted the price proposal.'
            : 'You declined the price proposal.';

        return back()->with('success', $msg);
    }

    // Check if proposal outcome is decided
    private function checkProposalOutcome(PriceProposal $proposal): void
    {
        $proposal->refresh();
        $pool         = $proposal->pool;
        $totalFarmers = $pool->members()->count();
        $totalVotes   = $proposal->votes()->count();

        // If all farmers have voted or majority reached
        if ($proposal->isMajorityAccepted()) {
            // Proposal accepted — assign driver at new price
            $proposal->update(['status' => 'accepted']);
            $pool->update([
                'total_cost' => $proposal->proposed_cost,
                'driver_id'  => $proposal->driver_id,
                'status'     => 'assigned',
                'matched_at' => now(),
            ]);

            // Create shipment
            $shipment = \App\Models\Shipment::create([
                'tracking_code' => 'AGP-' . strtoupper(\Str::random(8)),
                'pool_id'       => $pool->id,
                'driver_id'     => $proposal->driver_id,
                'status'        => 'pickup_pending',
            ]);

            // Recalculate cost shares at new price
            $service = new \App\Services\PoolMatchingService();
            $service->recalculateCostShares($pool);

            // Notify all farmers — accepted
            foreach ($pool->members as $member) {
                \App\Models\TransportRequest::find(
                    $member->transport_request_id
                )?->update(['status' => 'assigned']);

                Notification::create([
                    'user_id' => $member->user_id,
                    'title'   => '🎉 Price Accepted — Driver Assigned!',
                    'message' => 'Majority accepted the new price of ₹'
                                 . number_format($proposal->proposed_cost, 0)
                                 . '. '
                                 . $proposal->driver->name
                                 . ' is now your driver.',
                    'type'    => 'driver_assigned',
                    'link'    => '/farmer/requests',
                ]);
            }

            // Notify driver
            Notification::create([
                'user_id' => $proposal->driver_id,
                'title'   => '✅ Your Price Was Accepted!',
                'message' => 'Farmers accepted your price of ₹'
                             . number_format($proposal->proposed_cost, 0)
                             . '. Shipment created: '
                             . $shipment->tracking_code,
                'type'    => 'proposal_accepted',
                'link'    => '/driver/deliveries/' . $shipment->id,
            ]);

        } elseif ($proposal->isMajorityDeclined()) {
            // Proposal declined
            $proposal->update(['status' => 'declined']);

            // Notify driver
            Notification::create([
                'user_id' => $proposal->driver_id,
                'title'   => '❌ Price Proposal Declined',
                'message' => 'Farmers declined your proposed price of ₹'
                             . number_format($proposal->proposed_cost, 0)
                             . '. The pool is still open for other drivers.',
                'type'    => 'proposal_declined',
                'link'    => '/driver/pools',
            ]);
        }
        // If neither majority yet — wait for more votes or expiry
    }
}