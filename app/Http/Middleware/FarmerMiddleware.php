<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FarmerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // If not logged in, send to login page
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // If logged in but not a farmer, redirect to their correct dashboard
        if (!Auth::user()->isFarmer()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if (Auth::user()->isDriver()) {
                return redirect()->route('driver.dashboard');
            }
        }

        // If account is suspended
        if (!Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been suspended.'
            ]);
        }

        return $next($request);
    }
}