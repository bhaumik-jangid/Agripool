@extends('layouts.admin')
@section('title', 'Feedback')
@section('page-title', 'Feedback & Complaints')
@section('page-subtitle', $counts['open'] . ' open items')

@section('content')

<div class="d-flex gap-2 mb-4">
    @foreach($counts as $key => $count)
        <span class="badge px-3 py-2"
              style="background:#fff;border:1px solid #dee2e6;
                     color:#555;font-size:.82rem;border-radius:50px;">
            {{ ucfirst($key) }}: <strong>{{ $count }}</strong>
        </span>
    @endforeach
</div>

<div class="content-card">
    @forelse($feedbacks as $fb)
        <div class="d-flex gap-3 p-3 rounded-3 mb-3"
             style="background:#fafafa;border:1px solid #f0f0f0;">
            <div style="width:40px;height:40px;border-radius:10px;
                background:{{ $fb->status === 'open'
                    ? '#fff3cd' : '#d4edda' }};
                display:flex;align-items:center;
                justify-content:center;font-size:1.1rem;flex-shrink:0;">
                {{ $fb->type === 'complaint' ? '🚨' :
                   ($fb->type === 'rating' ? '⭐' : '💡') }}
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold small">
                            {{ $fb->user->name ?? 'User' }}
                        </span>
                        <span class="text-muted small mx-2">·</span>
                        <span class="badge bg-secondary"
                              style="font-size:.7rem;">
                            {{ ucfirst($fb->type) }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge
                              status-{{ $fb->status === 'open'
                                  ? 'pending' : 'delivered' }}">
                            {{ ucfirst($fb->status) }}
                        </span>
                        <span style="font-size:.72rem;color:#aaa;">
                            {{ $fb->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @if($fb->subject)
                    <div class="fw-semibold small mt-1">
                        {{ $fb->subject }}
                    </div>
                @endif
                <div class="text-muted small mt-1">{{ $fb->message }}</div>

                @if($fb->status === 'open')
                    <form method="POST"
                          action="{{ route('admin.feedback.resolve', $fb) }}"
                          class="mt-2">
                        @csrf
                        <button class="btn btn-sm btn-outline-success"
                                style="border-radius:8px;font-size:.75rem;">
                            ✅ Mark Resolved
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <div style="font-size:3rem;">💬</div>
            <h6 class="mt-3 fw-bold">No feedback yet</h6>
        </div>
    @endforelse

    <div class="mt-3">{{ $feedbacks->links() }}</div>
</div>

@endsection