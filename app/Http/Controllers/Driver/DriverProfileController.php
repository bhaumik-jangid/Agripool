<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateDriverProfileRequest;


class DriverProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        return view('driver.profile', compact('user', 'driverProfile'));
    }
    public function update(UpdateDriverProfileRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        DriverProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'license_number' => $request->license_number,
                'license_expiry' => $request->license_expiry,
                'current_location' => $request->current_location,
                'district' => $request->district,
                'state' => $request->state,
            ]
        );

        return back()->with('success', 'Profile updated successfully!');
    }
}