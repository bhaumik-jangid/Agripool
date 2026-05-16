<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user          = Auth::user();
        $farmerProfile = $user->farmerProfile;

        return view('farmer.profile', compact('user', 'farmerProfile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:15'],
            'farm_name'     => ['nullable', 'string', 'max:255'],
            'farm_location' => ['required', 'string', 'max:255'],
            'district'      => ['required', 'string', 'max:100'],
            'state'         => ['required', 'string', 'max:100'],
            'pincode'       => ['nullable', 'string', 'max:10'],
            'bio'           => ['nullable', 'string', 'max:500'],
        ]);

        // Update user record
        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        // Update or create farmer profile
        FarmerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'farm_name'     => $request->farm_name,
                'farm_location' => $request->farm_location,
                'district'      => $request->district,
                'state'         => $request->state,
                'pincode'       => $request->pincode,
                'bio'           => $request->bio,
            ]
        );

        return back()->with('success', 'Profile updated successfully!');
    }
}