@extends('layouts.admin')
@section('title', 'Pools')
@section('page-title', 'Transport Pools')
@section('page-subtitle', 'All shared transport pools')

@section('content')

<div class="d-flex gap-2 mb-4 flex-wrap">
    @foreach($counts as $key => $count)
        <span class="badge px-3 py-2"
              style="background:#fff;border:1px solid #dee2e6;
                     color:#555;font-size:.82rem;border-radius:50px;">
            {{ ucfirst($key) }}: <strong>{{ $count }}</strong>
        </span>
    @endforeach
</div>

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        POOL CODE
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        DESTINATION
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        PICKUP DATE
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        FARMERS
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        CAPACITY
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        DRIVER
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        STATUS
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        ACTION
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($pools as $pool)
                    <tr>
                        <td class="fw-bold small" style="color:#1b1b2f;">
                            {{ $pool->pool_code }}
                        </td>
                        <td class="small">{{ $pool->destination_market }}</td>
                        <td class="small text-muted">
                            {{ $pool->pickup_date->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">
                                {{ $pool->members->count() }}
                            </span>
                        </td>
                        <td class="small">
                            {{ number_format($pool->used_capacity_kg) }}
                            / {{ number_format($pool->total_capacity_kg) }} kg
                        </td>
                        <td class="small">
                            {{ $pool->driver->name ?? '—' }}
                        </td>
                        <td>
                            <span class="status-badge status-{{ $pool->status }}">
                                {{ ucfirst($pool->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.pools.show', $pool) }}"
                               class="btn btn-sm btn-outline-secondary"
                               style="border-radius:8px;font-size:.75rem;">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pools->links() }}</div>
</div>

@endsection