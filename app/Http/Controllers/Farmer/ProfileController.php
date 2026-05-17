<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateFarmerProfileRequest;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $farmerProfile = $user->farmerProfile;

        return view('farmer.profile', compact('user', 'farmerProfile'));
    }

    public function update(UpdateFarmerProfileRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        FarmerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'farm_name' => $request->farm_name,
                'farm_location' => $request->farm_location,
                'district' => $request->district,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'bio' => $request->bio,
            ]
        );

        return back()->with('success', 'Profile updated successfully!');
    }
}