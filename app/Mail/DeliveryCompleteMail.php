<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Shipment;
use App\Models\PoolMember;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeliveryCompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User       $farmer,
        public Shipment   $shipment,
        public PoolMember $member
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Delivery Complete — Payment Due ₹'
                     . number_format($this->member->cost_share ?? 0, 2),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.delivery-complete');
    }
}