<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreContactRequest;

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
    public function submitContact(StoreContactRequest $request)
    {
        try {
            Mail::to(config('mail.from.address'))
                ->send(new ContactFormMail(
                    $request->name,
                    $request->email,
                    $request->subject,
                    $request->message
                ));
        } catch (\Exception $e) {
            \Log::error('Contact email failed: ' . $e->getMessage());
        }

        return back()->with(
            'success',
            'Thank you, ' . $request->name
            . '! We received your message and will reply within 24 hours.'
        );
    }
}