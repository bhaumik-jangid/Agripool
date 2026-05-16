<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverProfileController extends Controller
{
    public function index()
    {
        $user          = Auth::user();
        $driverProfile = $user->driverProfile;
        return view('driver.profile', compact('user', 'driverProfile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'phone'            => ['required', 'string', 'max:15'],
            'license_number'   => ['required', 'string', 'max:50'],
            'license_expiry'   => ['required', 'string'],
            'current_location' => ['nullable', 'string', 'max:255'],
            'district'         => ['nullable', 'string', 'max:100'],
            'state'            => ['nullable', 'string', 'max:100'],
        ]);

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        DriverProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'license_number'   => $request->license_number,
                'license_expiry'   => $request->license_expiry,
                'current_location' => $request->current_location,
                'district'         => $request->district,
                'state'            => $request->state,
            ]
        );

        return back()->with('success', 'Profile updated successfully!');
    }
}