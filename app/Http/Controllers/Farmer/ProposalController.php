<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\PriceProposal;

class ProposalController extends Controller
{
    public function show(PriceProposal $proposal)
    {
        // Make sure logged-in farmer is in this pool
        $isMember = $proposal->pool->members()
                             ->where('user_id', auth()->id())
                             ->exists();
        if (!$isMember) {
            abort(403);
        }

        $proposal->load('driver', 'pool', 'votes');
        $pool = $proposal->pool->load('members.farmer');

        return view('farmer.proposals.show',
            compact('proposal', 'pool'));
    }
}