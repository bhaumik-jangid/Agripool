<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Pool;
use App\Models\TransportRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PoolMatchedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User             $user,
        public Pool             $pool,
        public TransportRequest $transportRequest,
        public float            $costShare
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🤝 Pool Matched — Your Transport is Being Arranged',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pool-matched');
    }
}