@extends('emails.layout')

@section('content')
<h2>📅 Jadwal Wawancara Sudah Ditentukan!</h2>
<p>Assalamu'alaikum, <strong>{{ $pendaftaran->nama }}</strong>.</p>
<p>Jadwal wawancara PPDB kamu sudah ditentukan. Harap hadir tepat waktu:</p>

<div class="info-box">
    <div class="info-row">
        <span class="label">Tanggal</span>
        <span class="value">
            {{ \Carbon\Carbon::parse($jadwal->tanggal_tes)->format('d M Y') }}
        </span>
    </div>
    <div class="info-row">
        <span class="label">Jam</span>
        <span class="value">{{ $jadwal->jam_tes }} WIB</span>
    </div>
    <div class="info-row">
        <span class="label">Media</span>
        <span class="value">Google Meet (Online)</span>
    </div>
</div>

<p>Klik tombol di bawah untuk bergabung ke sesi wawancara:</p>
<a href="{{ $jadwal->link_tes }}" class="btn-success">
    📹 Buka Link Google Meet
</a>

<p style="margin-top: 20px; color: #888; font-size: 13px;">
    Wassalamu'alaikum Warahmatullahi Wabarakatuh,<br>
    <strong>Tim Panitia PPDB Nashirussunnah</strong>
</p>
@endsection