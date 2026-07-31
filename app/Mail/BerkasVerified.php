<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BerkasVerified extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pendaftaran $pendaftaran) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Update Status Berkas — PPDB Nashirussunnah',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.berkas-verified',
        );
    }
}