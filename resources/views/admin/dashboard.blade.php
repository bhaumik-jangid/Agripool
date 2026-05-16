@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold text-dark">⚙️ Admin Dashboard</h3>
            <p class="text-muted">Platform overview and management</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <div class="fs-1 fw-bold text-success">{{ $totalFarmers }}</div>
                <div class="text-muted small">Total Farmers</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <div class="fs-1 fw-bold text-primary">{{ $totalDrivers }}</div>
                <div class="text-muted small">Total Drivers</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <div class="fs-1 fw-bold text-warning">{{ $totalRequests }}</div>
                <div class="text-muted small">Transport Requests</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <div class="fs-1 fw-bold text-danger">{{ $pendingDriverApprovals }}</div>
                <div class="text-muted small">Pending Approvals</div>
            </div>
        </div>

    </div>

    {{-- Pending approvals alert --}}
    @if($pendingDriverApprovals > 0)
        <div class="alert alert-warning rounded-4">
            ⚠️ <strong>{{ $pendingDriverApprovals }} driver(s)</strong> waiting for approval.
            <a href="#" class="alert-link">Review now →</a>
        </div>
    @endif

    {{-- Quick Actions --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Management</h5>
            <div class="d-flex gap-3 flex-wrap">
                <a href="#" class="btn btn-success fw-semibold">Manage Farmers</a>
                <a href="#" class="btn btn-primary fw-semibold">Manage Drivers</a>
                <a href="#" class="btn btn-warning fw-semibold">Transport Requests</a>
                <a href="#" class="btn btn-info fw-semibold text-white">Active Pools</a>
                <a href="#" class="btn btn-secondary fw-semibold">Feedback</a>
            </div>
        </div>
    </div>

</div>
@endsection