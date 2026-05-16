<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportRequest;

class RequestManagementController extends Controller
{
    public function index()
    {
        $requests = TransportRequest::with('farmer')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);

        // Status counts for filter tabs
        $counts = [
            'all'        => TransportRequest::count(),
            'pending'    => TransportRequest::where('status','pending')->count(),
            'pooled'     => TransportRequest::where('status','pooled')->count(),
            'in_transit' => TransportRequest::where('status','in_transit')->count(),
            'delivered'  => TransportRequest::where('status','delivered')->count(),
            'cancelled'  => TransportRequest::where('status','cancelled')->count(),
        ];

        return view('admin.requests.index', compact('requests', 'counts'));
    }

    public function show(TransportRequest $transportRequest)
    {
        $transportRequest->load('farmer', 'poolMember.pool.driver');
        return view('admin.requests.show', compact('transportRequest'));
    }
}