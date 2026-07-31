<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use App\Models\HasilTes;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HasilCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pendaftaran $pendaftaran,
        public HasilTes $hasil
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📢 Hasil Wawancara PPDB Nashirussunnah',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hasil-created',
        );
    }
}