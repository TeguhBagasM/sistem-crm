<?php

namespace App\Mail;

use App\Models\RiwayatEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailToPelanggan extends Mailable
{
    use Queueable, SerializesModels;

    public $riwayatEmail;
    public $pengirim;

    /**
     * Create a new message instance.
     */
    public function __construct(RiwayatEmail $riwayatEmail)
    {
        $this->riwayatEmail = $riwayatEmail;
        $this->pengirim = $riwayatEmail->pengirim;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->pengirim->email,
            replyTo: [$this->pengirim->email],
            subject: $this->riwayatEmail->subjek,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.template',
            with: [
                'riwayatEmail' => $this->riwayatEmail,
                'pengirim' => $this->pengirim,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
