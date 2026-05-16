@extends('layouts.admin')
@section('title', 'Manage Farmers')
@section('page-title', 'Farmers')
@section('page-subtitle', 'All registered farmers')

@section('content')

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">#</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">FARMER</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">LOCATION</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">REQUESTS</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">STATUS</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">JOINED</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($farmers as $farmer)
                    <tr>
                        <td class="text-muted small">{{ $farmer->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px;height:36px;border-radius:50%;
                                    background:#2d6a4f;color:#fff;
                                    display:flex;align-items:center;
                                    justify-content:center;font-weight:700;
                                    font-size:.85rem;">
                                    {{ strtoupper(substr($farmer->name,0,2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">
                                        {{ $farmer->name }}
                                    </div>
                                    <div style="font-size:.72rem;color:#888;">
                                        {{ $farmer->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="small">
                            {{ $farmer->farmerProfile->district ?? '—' }},
                            {{ $farmer->farmerProfile->state ?? '—' }}
                        </td>
                        <td>
                            <span class="fw-bold">
                                {{ $farmer->transport_requests_count }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $farmer->is_active
                                ? 'bg-success' : 'bg-danger' }}">
                                {{ $farmer->is_active ? 'Active' : 'Suspended' }}
                            </span>
                        </td>
                        <td class="small text-muted">
                            {{ $farmer->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.farmers.show', $farmer) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   style="border-radius:8px;font-size:.75rem;">
                                    View
                                </a>
                                @if($farmer->is_active)
                                    <form method="POST"
                                          action="{{ route('admin.users.suspend',
                                                         $farmer) }}"
                                          onsubmit="return confirm(
                                              'Suspend this farmer?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger"
                                                style="border-radius:8px;
                                                       font-size:.75rem;">
                                            Suspend
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                          action="{{ route('admin.users.activate',
                                                         $farmer) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success"
                                                style="border-radius:8px;
                                                       font-size:.75rem;">
                                            Activate
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $farmers->links() }}</div>
</div>

@endsection