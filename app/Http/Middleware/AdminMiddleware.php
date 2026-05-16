<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isAdmin()) {
            if (Auth::user()->isFarmer()) {
                return redirect()->route('farmer.dashboard');
            }
            if (Auth::user()->isDriver()) {
                return redirect()->route('driver.dashboard');
            }
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been suspended.'
            ]);
        }

        return $next($request);
    }
}