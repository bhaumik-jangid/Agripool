<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // Show login form
    public function create(): View
    {
        return view('auth.login');
    }

    // Handle login form submission
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user (checks email + password)
        $request->authenticate();

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        $user = Auth::user();

        // Check if account is suspended
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account has been suspended. Please contact support.',
            ]);
        }

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isDriver()) {
            return redirect()->route('driver.dashboard');
        }

        // Default: farmer
        return redirect()->route('farmer.dashboard');
    }

    // Handle logout
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}