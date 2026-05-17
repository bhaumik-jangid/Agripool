<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FarmerProfile;
use App\Models\DriverProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    // Show the registration form
    public function create(): View
    {
        return view('auth.register');
    }

    // Handle the registration form submission
    public function store(Request $request): RedirectResponse
    {
        // Validate all incoming fields
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'role' => ['required', 'in:farmer,driver'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Create the matching profile based on role
        if ($request->role === 'farmer') {
            FarmerProfile::create([
                'user_id' => $user->id,
                'farm_location' => $request->location ?? 'Not specified',
                'district' => $request->district ?? 'Not specified',
                'state' => $request->state ?? 'Not specified',
            ]);
        }

        if ($request->role === 'driver') {
            DriverProfile::create([
                'user_id' => $user->id,
                'license_number' => $request->license_number ?? 'PENDING',
                'license_expiry' => $request->license_expiry ?? now()->addYear()->format('Y-m-d'),
                'approval_status' => 'pending', // Driver must be approved by admin
            ]);
        }

        // Fire the Registered event (triggers email verification if enabled)
        event(new Registered($user));

        // Log the user in immediately after registration
        Auth::login($user);

        // Send welcome email
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            // Silently fail — email is not critical for registration
            \Log::error('Welcome email failed: ' . $e->getMessage());
        }

        // Redirect to the correct dashboard based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isDriver()) {
            return redirect()->route('driver.dashboard');
        }
        return redirect()->route('farmer.dashboard');
    }
}