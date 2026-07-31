<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use App\Models\Jadwal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JadwalCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pendaftaran $pendaftaran,
        public Jadwal $jadwal
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📅 Jadwal Wawancara Kamu Sudah Ditentukan — PPDB Nashirussunnah',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jadwal-created',
        );
    }
}