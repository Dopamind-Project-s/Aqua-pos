<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemoRequestSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly ServiceRequest $serviceRequest)
    {
    }

    public function envelope(): Envelope
    {
        $replyTo = $this->serviceRequest->email
            ? [new Address($this->serviceRequest->email, $this->serviceRequest->full_name)]
            : [];

        return new Envelope(
            replyTo: $replyTo,
            subject: 'New Demo Request - '.$this->serviceRequest->full_name,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.service-requests.demo-submitted');
    }

    public function attachments(): array
    {
        return [];
    }
}
