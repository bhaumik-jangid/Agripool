<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PublicController extends Controller
{
    // Landing page
    public function index()
    {
        return view('public.home');
    }

    // Contact page
    public function contact()
    {
        return view('public.contact');
    }

    // Handle contact form submission
    public function submitContact(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        // We will connect this to email in Phase 10
        // For now, just flash a success message
        return back()->with('success',
            'Thank you, ' . $request->name . '! We received your message and will reply within 24 hours.'
        );
    }
}