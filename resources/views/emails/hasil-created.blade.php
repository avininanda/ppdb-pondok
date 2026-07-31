@extends('emails.layout')

@section('content')
<h2>📢 Hasil Wawancara PPDB</h2>
<p>Assalamu'alaikum, <strong>{{ $pendaftaran->nama }}</strong>.</p>
<p>Berikut adalah hasil wawancara PPDB kamu:</p>

@if($hasil->hasil === 'lulus')
    <div class="hasil-lulus">
        <h3>🎉 Selamat! Kamu Diterima!</h3>
        <p>Kamu dinyatakan LULUS seleksi wawancara PPDB Nashirussunnah.</p>
    </div>
    <p>
        Selamat bergabung di keluarga besar Pondok Pesantren Tahfidz Nashirussunnah!
        Tim panitia akan menghubungi kamu lebih lanjut.
    </p>
@else
    <div class="hasil-gagal">
        <h3>😔 Maaf, Belum Diterima</h3>
        <p>Kamu dinyatakan belum lulus seleksi wawancara PPDB Nashirussunnah.</p>
    </div>
    <p>Jangan berkecil hati. Semoga di kesempatan berikutnya kamu bisa bergabung bersama kami.</p>
@endif

@if($hasil->keterangan)
    <div class="catatan">
        <strong>📝 Keterangan dari Panitia:</strong><br>
        {{ $hasil->keterangan }}
    </div>
@endif

<p style="color: #888; font-size: 13px;">
    Wassalamu'alaikum Warahmatullahi Wabarakatuh,<br>
    <strong>Tim Panitia PPDB Nashirussunnah</strong>
</p>
@endsection