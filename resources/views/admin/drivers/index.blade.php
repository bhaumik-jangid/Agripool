@extends('layouts.admin')
@section('title', 'Manage Drivers')
@section('page-title', 'Drivers')
@section('page-subtitle', $pendingCount . ' pending approval')

@section('content')

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        DRIVER
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        LICENSE
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        VEHICLE
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        APPROVAL
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        ACCOUNT
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        ACTIONS
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px;height:36px;border-radius:50%;
                                    background:#1d3557;color:#fff;
                                    display:flex;align-items:center;
                                    justify-content:center;font-weight:700;
                                    font-size:.85rem;">
                                    {{ strtoupper(substr($driver->name,0,2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">
                                        {{ $driver->name }}
                                    </div>
                                    <div style="font-size:.72rem;color:#888;">
                                        {{ $driver->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="small">
                            {{ $driver->driverProfile->license_number ?? '—' }}
                        </td>
                        <td class="small">
                            {{ $driver->vehicle->vehicle_number ?? 'Not added' }}
                        </td>
                        <td>
                            @php
                                $approval = $driver->driverProfile
                                    ->approval_status ?? 'pending';
                            @endphp
                            <span class="status-badge status-{{ $approval }}">
                                {{ ucfirst($approval) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $driver->is_active
                                ? 'bg-success' : 'bg-danger' }}">
                                {{ $driver->is_active ? 'Active' : 'Suspended' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('admin.drivers.show',
                                               $driver) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   style="border-radius:8px;font-size:.75rem;">
                                    View
                                </a>
                                @if($approval === 'pending')
                                    <form method="POST"
                                          action="{{ route('admin.drivers.approve',
                                                         $driver) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-success"
                                                style="border-radius:8px;
                                                       font-size:.75rem;">
                                            Approve
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
    <div class="mt-4">{{ $drivers->links() }}</div>
</div>

@endsection