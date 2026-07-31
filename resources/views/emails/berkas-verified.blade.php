@extends('emails.layout')

@section('content')
<h2>Update Status Berkas Pendaftaran</h2>
<p>Assalamu'alaikum, <strong>{{ $pendaftaran->nama }}</strong>.</p>
<p>Ada update terbaru mengenai status berkas pendaftaran kamu:</p>

<p>
    Status terbaru:
    @if($pendaftaran->status_verifikasi === 'diverifikasi')
        <span class="badge-info">✅ Berkas Diverifikasi</span>
    @elseif($pendaftaran->status_verifikasi === 'diterima')
        <span class="badge-success">🎉 Selamat! Kamu Diterima!</span>
    @elseif($pendaftaran->status_verifikasi === 'ditolak')
        <span class="badge-danger">❌ Maaf, Tidak Diterima</span>
    @endif
</p>

@if($pendaftaran->catatan)
    <div class="catatan">
        <strong>📝 Catatan dari Panitia:</strong><br>
        {{ $pendaftaran->catatan }}
    </div>
@endif

<p>Silakan login ke sistem PPDB untuk melihat detail lengkap.</p>
<p style="color: #888; font-size: 13px;">
    Wassalamu'alaikum Warahmatullahi Wabarakatuh,<br>
    <strong>Tim Panitia PPDB Nashirussunnah</strong>
</p>
@endsection