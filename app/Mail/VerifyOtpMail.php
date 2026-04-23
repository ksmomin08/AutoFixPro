<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;

    public function __construct($otp, $name)
    {
        $this->otp = $otp;
        $this->name = $name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME', 'hello@example.com')), env('MAIL_FROM_NAME', 'AutoFixPro')),
            subject: 'Your Registration OTP - AutoFixPro',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
