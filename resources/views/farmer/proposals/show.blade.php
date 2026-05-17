@extends('layouts.farmer')
@section('title', 'Price Proposal')
@section('page-title', 'Driver Price Proposal')
@section('page-subtitle', 'Review and vote on the proposed transport price')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-7">

    {{-- Status banner --}}
    @if($proposal->status === 'accepted')
        <div class="alert alert-success rounded-3 mb-4">
            ✅ This proposal was <strong>accepted</strong> by the farmers.
        </div>
    @elseif($proposal->status === 'declined')
        <div class="alert alert-danger rounded-3 mb-4">
            ❌ This proposal was <strong>declined</strong> by the farmers.
        </div>
    @elseif($proposal->isExpired())
        <div class="alert alert-warning rounded-3 mb-4">
            ⏰ This proposal has <strong>expired</strong>.
        </div>
    @endif

    {{-- Proposal card --}}
    <div class="content-card mb-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <div style="width:52px;height:52px;border-radius:50%;
                background:#1d3557;color:#fff;
                display:flex;align-items:center;justify-content:center;
                font-size:1.3rem;font-weight:700;">
                {{ strtoupper(substr($proposal->driver->name,0,2)) }}
            </div>
            <div>
                <div class="fw-bold">{{ $proposal->driver->name }}</div>
                <div class="text-muted small">Proposed a new price</div>
            </div>
        </div>

        {{-- Price comparison --}}
        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="text-center p-3 rounded-3"
                     style="background:#f8f9fa;">
                    <div style="font-size:.78rem;color:#888;">
                        Original System Price
                    </div>
                    <div class="fw-bold mt-1"
                         style="font-size:1.5rem;color:#6c757d;">
                        ₹{{ number_format($proposal->original_cost, 0) }}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="text-center p-3 rounded-3"
                     style="background:#fff8e1;border:2px solid #ffe082;">
                    <div style="font-size:.78rem;color:#7a5f00;">
                        Driver's Proposed Price
                    </div>
                    <div class="fw-bold mt-1"
                         style="font-size:1.5rem;color:#e67e00;">
                        ₹{{ number_format($proposal->proposed_cost, 0) }}
                    </div>
                    <div style="font-size:.72rem;color:#e67e00;">
                        +₹{{ number_format($proposal->proposed_cost
                             - $proposal->original_cost, 0) }} more
                    </div>
                </div>
            </div>
        </div>

        {{-- What you pay --}}
        @php
            $myMember = $pool->members
                ->where('user_id', auth()->id())
                ->first();
            $myOriginalShare = $myMember
                ? ($myMember->share_percentage / 100)
                  * $proposal->original_cost
                : 0;
            $myNewShare = $myMember
                ? ($myMember->share_percentage / 100)
                  * $proposal->proposed_cost
                : 0;
        @endphp

        @if($myMember)
            <div class="p-3 rounded-3 mb-4"
                 style="background:#f0faf4;border:1px solid #c3e6cb;">
                <div class="fw-semibold small mb-2" style="color:#2d6a4f;">
                    💰 Your cost impact
                    ({{ $myMember->share_percentage }}% share)
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">You were paying</span>
                    <span class="fw-bold">
                        ₹{{ number_format($myOriginalShare, 2) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between small mt-1">
                    <span class="text-muted">You would now pay</span>
                    <span class="fw-bold" style="color:#e67e00;">
                        ₹{{ number_format($myNewShare, 2) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between small mt-1">
                    <span class="text-muted">Extra cost to you</span>
                    <span class="fw-bold text-danger">
                        +₹{{ number_format($myNewShare - $myOriginalShare, 2) }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Driver's reason --}}
        <div class="mb-4 p-3 rounded-3" style="background:#f8f9fa;">
            <div class="fw-semibold small mb-1">Driver's Reason:</div>
            <div class="text-muted small">
                "{{ $proposal->reason }}"
            </div>
        </div>

        {{-- Vote counts --}}
        @php
            $acceptCount  = $proposal->votes->where('vote','accept')->count();
            $declineCount = $proposal->votes->where('vote','decline')->count();
            $totalFarmers = $pool->members->count();
            $totalVotes   = $acceptCount + $declineCount;
            $myVote       = $proposal->getVote(auth()->id());
        @endphp

        <div class="mb-4">
            <div class="fw-semibold small mb-2">
                Farmer Votes ({{ $totalVotes }}/{{ $totalFarmers }})
            </div>
            <div class="progress mb-1" style="height:10px;border-radius:50px;">
                @if($totalVotes > 0)
                    <div class="progress-bar bg-success"
                         style="width:{{ ($acceptCount/$totalFarmers)*100 }}%;
                                border-radius:50px 0 0 50px;">
                    </div>
                    <div class="progress-bar bg-danger"
                         style="width:{{ ($declineCount/$totalFarmers)*100 }}%;
                                border-radius:0 50px 50px 0;">
                    </div>
                @endif
            </div>
            <div class="d-flex justify-content-between"
                 style="font-size:.72rem;color:#888;margin-top:4px;">
                <span>✅ {{ $acceptCount }} accepted</span>
                <span>❌ {{ $declineCount }} declined</span>
            </div>
        </div>

        {{-- Expires --}}
        <div class="text-center small text-muted mb-4">
            ⏰ Proposal expires:
            <strong>
                {{ $proposal->expires_at->format('d M Y h:i A') }}
            </strong>
            ({{ $proposal->expires_at->diffForHumans() }})
        </div>

        {{-- Vote form --}}
        @if($proposal->status === 'pending'
            && !$proposal->isExpired()
            && !$myVote)

            <form method="POST"
                  action="{{ route('farmer.proposals.vote', $proposal) }}">
                @csrf
                <div class="d-flex gap-3">
                    <button type="submit"
                            name="vote" value="accept"
                            class="btn flex-grow-1 py-3 fw-bold text-white"
                            style="background:#2d6a4f;border-radius:12px;"
                            onclick="return confirm(
                                'Accept price of ₹{{ number_format($proposal->proposed_cost,0) }}?'
                            )">
                        ✅ Accept
                        <div style="font-size:.78rem;font-weight:400;">
                            Pay ₹{{ number_format($myNewShare, 2) }}
                        </div>
                    </button>
                    <button type="submit"
                            name="vote" value="decline"
                            class="btn flex-grow-1 py-3 fw-bold btn-outline-danger"
                            style="border-radius:12px;"
                            onclick="return confirm(
                                'Decline this price proposal?'
                            )">
                        ❌ Decline
                        <div style="font-size:.78rem;font-weight:400;">
                            Keep original price
                        </div>
                    </button>
                </div>
            </form>

        @elseif($myVote)
            <div class="text-center p-3 rounded-3"
                 style="background:#f8f9fa;">
                <div class="fw-bold">
                    {{ $myVote === 'accept' ? '✅ You accepted' : '❌ You declined' }}
                </div>
                <div class="text-muted small mt-1">
                    Waiting for other farmers to vote.
                </div>
            </div>
        @endif

    </div>

    <a href="{{ route('farmer.requests.index') }}"
       class="btn btn-outline-secondary"
       style="border-radius:10px;">
        ← Back to My Requests
    </a>

</div>
</div>

@endsection