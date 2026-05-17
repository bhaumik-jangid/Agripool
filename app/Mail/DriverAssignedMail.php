<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DriverAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User     $farmer,
        public Shipment $shipment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚛 Driver Assigned — Track Your Shipment',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.driver-assigned');
    }
}