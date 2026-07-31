@extends('emails.layout')

@section('content')
<h2>Pendaftaran Berhasil Disubmit! ✅</h2>
<p>Assalamu'alaikum, <strong>{{ $pendaftaran->nama }}</strong>.</p>
<p>
    Pendaftaran kamu di PPDB Pondok Pesantren Tahfidz Nashirussunnah
    telah berhasil disubmit. Tim panitia akan segera memverifikasi berkas kamu.
</p>

<div class="info-box">
    <div class="info-row">
        <span class="label">Nama</span>
        <span class="value">{{ $pendaftaran->nama }}</span>
    </div>
    <div class="info-row">
        <span class="label">Asal Sekolah</span>
        <span class="value">{{ $pendaftaran->asal_sekolah }}</span>
    </div>
    <div class="info-row">
        <span class="label">Tanggal Daftar</span>
        <span class="value">
            {{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d M Y') }}
        </span>
    </div>
    <div class="info-row">
        <span class="label">Status</span>
        <span class="value">
            <span class="badge-warning">⏳ Menunggu Verifikasi</span>
        </span>
    </div>
</div>

<p>Kami akan mengirimkan email kembali jika ada update.</p>
<p style="color: #888; font-size: 13px;">
    Wassalamu'alaikum Warahmatullahi Wabarakatuh,<br>
    <strong>Tim Panitia PPDB Nashirussunnah</strong>
</p>
@endsection