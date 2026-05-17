@extends('layouts.farmer')
@section('title', 'Notifications')
@section('page-title', 'Notifications')
@section('page-subtitle', 'Your activity alerts and updates')

@section('content')

{{-- Payment due sticky reminder --}}
@php
    $unpaidCount = Auth::user()->transportRequests()
        ->where('status', 'delivered')
        ->whereHas('poolMember', fn($q) => $q->where('cost_paid', false))
        ->count();
@endphp

@if($unpaidCount > 0)
    <div class="alert rounded-3 mb-4 d-flex align-items-center gap-3"
         style="background:#fff3cd;border:1px solid #ffc107;color:#7a5f00;">
        <span style="font-size:1.5rem;">💳</span>
        <div>
            <strong>{{ $unpaidCount }} payment(s) pending.</strong>
            You have unpaid deliveries.
            <a href="{{ route('farmer.dashboard') }}"
               style="color:#2d6a4f;font-weight:700;">
                View Dashboard →
            </a>
        </div>
    </div>
@endif

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold mb-0">All Notifications</h6>
        <form method="POST" action="{{ route('farmer.notifications.readAll') }}">
            @csrf
            <button type="submit"
                    class="btn btn-sm btn-outline-secondary"
                    style="border-radius:8px;font-size:.82rem;">
                Mark All Read
            </button>
        </form>
    </div>

    @if($notifications->count() > 0)

        @foreach($notifications as $notif)
            <div class="d-flex gap-3 p-3 rounded-3 mb-2"
                 style="background:{{ $notif->is_read ? '#fafafa' : '#f0faf4' }};
                        border:1px solid {{ $notif->is_read ? '#f0f0f0' : '#c3e6cb' }};">
                <div style="width:38px;height:38px;border-radius:10px;
                    background:{{ $notif->is_read ? '#eee' : '#d8f3dc' }};
                    display:flex;align-items:center;justify-content:center;
                    font-size:1.1rem;flex-shrink:0;">
                    🔔
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="fw-semibold small">{{ $notif->title }}</div>
                        <div style="font-size:.72rem;color:#aaa;white-space:nowrap;margin-left:12px;">
                            {{ $notif->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="text-muted small mt-1">{{ $notif->message }}</div>
                </div>
                @if(!$notif->is_read)
                    <div style="width:8px;height:8px;border-radius:50%;
                        background:#2d6a4f;flex-shrink:0;margin-top:6px;">
                    </div>
                @endif
            </div>
        @endforeach

        <div class="mt-3">{{ $notifications->links() }}</div>

    @else
        <div class="text-center py-5">
            <div style="font-size:4rem;">🔔</div>
            <h5 class="mt-3 fw-bold">No Notifications</h5>
            <p class="text-muted">You're all caught up!</p>
        </div>
    @endif

</div>

@endsection