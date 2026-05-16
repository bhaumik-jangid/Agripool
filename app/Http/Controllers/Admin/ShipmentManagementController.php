<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;

class ShipmentManagementController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with('pool', 'driver')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        return view('admin.shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
    {
        $shipment->load('pool.members.farmer',
                        'pool.members.transportRequest',
                        'driver');

        return view('admin.shipments.show', compact('shipment'));
    }
}