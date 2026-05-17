<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreVehicleRequest;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicle = Auth::user()->vehicle;
        return view('driver.vehicle', compact('vehicle'));
    }

    public function store(StoreVehicleRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['is_verified'] = false;

        Vehicle::create($validated);

        return back()->with(
            'success',
            'Vehicle registered! Admin will verify it shortly.'
        );
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'vehicle_type' => ['required', 'string'],
            'vehicle_model' => ['nullable', 'string'],
            'capacity_tonnes' => ['required', 'numeric', 'min:0.1'],
            'manufacture_year' => ['nullable', 'integer'],
            'insurance_number' => ['nullable', 'string'],
            'insurance_expiry' => ['nullable', 'string'],
        ]);

        $vehicle->update($validated);

        return back()->with('success', 'Vehicle details updated.');
    }
}