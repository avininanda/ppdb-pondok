@extends('layouts.dashboard')

@section('title', 'Status Pendaftaran — PPDB Nashirussunnah')
@section('page_title', 'Status Pendaftaran')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-info-circle"></i></span>
        <div>
            <p class="eyebrow mb-1">Calon Santri</p>
            <h1 class="h3 mb-1">Status Pendaftaran</h1>
            <p class="text-muted mb-0">Detail lengkap status pendaftaran kamu.</p>
        </div>
    </div>
</div>

@if($pendaftaran)
<div class="row g-3 mt-1">

    {{-- ================================================
         STATUS BADGE — Bagian paling atas
         Menampilkan status terkini pendaftaran
    ================================================ --}}
    <div class="col-12">
        <div class="panel p-4 text-center">

            {{-- Nomor Pendaftaran --}}
            @if($pendaftaran->nomor_pendaftaran)
                <p class="text-muted small mb-1">Nomor Pendaftaran</p>
                <h4 class="fw-bold text-primary mb-3">
                    {{ $pendaftaran->nomor_pendaftaran }}
                </h4>
            @endif

            {{-- Cek status_akhir dulu (hasil wawancara)
            baru fallback ke status_verifikasi (status berkas) --}}
        @if($pendaftaran->status_akhir === 'diterima')
            <span class="badge text-bg-success fs-6 px-4 py-2">
                🎉 Selamat! Kamu Diterima!
            </span>
        @elseif($pendaftaran->status_akhir === 'ditolak')
            <span class="badge text-bg-danger fs-6 px-4 py-2">
                😔 Maaf, Belum Diterima
            </span>
        @elseif($pendaftaran->status_draft === 'draft')
            <span class="badge text-bg-warning fs-6 px-4 py-2">
                📝 Draft — Belum Disubmit
            </span>
        @elseif($pendaftaran->status_verifikasi === 'pending')
            <span class="badge text-bg-warning fs-6 px-4 py-2">
                ⏳ Menunggu Pemeriksaan Berkas
            </span>
            <p class="text-muted small mt-2 mb-0">
                Panitia sedang memeriksa berkas pendaftaran kamu.
            </p>
        @elseif($pendaftaran->status_verifikasi === 'diverifikasi' && $pendaftaran->jadwal && $pendaftaran->jadwal->sudah_dilaksanakan)
            <span class="badge text-bg-info fs-6 px-4 py-2">
                Menunggu Hasil Tes 
            </span>
            <p class="text-muted small mt-2 mb-0">
                Tes kamu sudah selesai dilaksanakan. Panitia sedang memproses keputusan.
            </p>
        @elseif($pendaftaran->status_verifikasi === 'diverifikasi' && $pendaftaran->jadwal)
            <span class="badge text-bg-info fs-6 px-4 py-2">
                📅 Jadwal Wawancara Sudah Ditetapkan
            </span>
            <p class="text-muted small mt-2 mb-0">
                Cek detail tanggal, jam, dan link wawancara di bagian "Jadwal Tes Wawancara" di bawah ini.
            </p>

        @elseif($pendaftaran->status_verifikasi === 'diverifikasi')
            {{-- Cek status pembayaran --}}
            @if($pendaftaran->status_pembayaran === 'terverifikasi')
                <span class="badge text-bg-info fs-6 px-4 py-2">
                    ✅ Berkas & Pembayaran Valid — Menunggu Jadwal Wawancara
                </span>
                <p class="text-muted small mt-2 mb-0">
                    Semua persyaratan sudah terpenuhi.
                    Tunggu jadwal wawancara dari panitia.
                </p>
            @elseif($pendaftaran->status_pembayaran === 'menunggu_verifikasi')
                <span class="badge text-bg-warning fs-6 px-4 py-2">
                    ✅ Berkas Valid — ⏳ Menunggu Verifikasi Pembayaran
                </span>
                <p class="text-muted small mt-2 mb-0">
                    Berkas kamu sudah valid. Panitia sedang
                    memverifikasi bukti pembayaran kamu.
                </p>
            @else
                <span class="badge text-bg-warning fs-6 px-4 py-2">
                    ✅ Berkas Valid — ⚠️ Bukti Pembayaran Belum Diunggah
                </span>
                <p class="text-muted small mt-2 mb-0">
                    Berkas kamu sudah valid. Silakan upload
                    bukti pembayaran untuk melanjutkan proses.
                </p>
                <a href="{{ route('pendaftaran.step3') }}"
                    class="btn btn-warning btn-sm mt-2">
                    <i class="bi bi-upload me-1"></i>
                    Upload Bukti Pembayaran
                </a>
            @endif

        @elseif($pendaftaran->status_verifikasi === 'revisi')
            <span class="badge text-bg-warning fs-6 px-4 py-2">
                ⚠️ Berkas Perlu Diperbaiki
            </span>
            @if($pendaftaran->catatan)
                <div class="alert alert-warning mt-3 text-start">
                    <strong>📝 Catatan Panitia:</strong><br>
                    {{ $pendaftaran->catatan }}
                </div>
            @endif
            <a href="{{ route('pendaftaran.step3') }}" class="btn btn-warning mt-2">
                <i class="bi bi-upload me-1"></i>Upload Ulang Dokumen
            </a>
        @elseif($pendaftaran->status_verifikasi === 'ditolak')
            <span class="badge text-bg-danger fs-6 px-4 py-2">
                ❌ Maaf, Tidak Memenuhi Syarat
            </span>
            <p class="text-muted small mt-2 mb-0">
                Pendaftaran kamu tidak dapat dilanjutkan.
                Silakan hubungi panitia untuk informasi lebih lanjut.
            </p>
        @endif
</div>
</div>
    {{-- ================================================
         DATA PENDAFTARAN
    ================================================ --}}
    <div class="col-12 col-md-6">
        <div class="panel p-4 h-100">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-person me-2 text-primary"></i>Data Pendaftaran
            </h5>
            <div class="text-muted small">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Nama Lengkap</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->nama }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Asal Sekolah</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->asal_sekolah }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>No. Telepon</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->no_telepon }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span>Tanggal Daftar</span>
                    <span class="fw-semibold text-dark">
                        {{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================
         JADWAL & HASIL
    ================================================ --}}
    <div class="col-12 col-md-6">

        {{-- Jadwal Wawancara --}}
        <div class="panel p-4 mb-3">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-calendar-check me-2 text-primary"></i>
                Jadwal Tes 
            </h5>
            @if($pendaftaran->jadwal)
                <div class="text-muted small">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Tanggal</span>
                        <span class="fw-semibold text-dark">
                            {{ \Carbon\Carbon::parse($pendaftaran->jadwal->tanggal_tes)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Jam</span>
                        <span class="fw-semibold text-dark">
                            {{ $pendaftaran->jadwal->jam_tes }}
                        </span>
                    </div>
                    <div class="pt-3">
                        <a href="{{ $pendaftaran->jadwal->link_tes }}"
                            target="_blank"
                            class="btn btn-success btn-sm w-100">
                            <i class="bi bi-camera-video me-1"></i>
                            Buka Link Tes
                        </a>
                    </div>
                </div>
            @else
                <p class="text-muted small mb-0">
                    Belum ada jadwal tes wawancara.
                    Silakan tunggu informasi dari panitia.
                </p>
            @endif
        </div>

        {{-- Hasil Wawancara --}}
        @if($pendaftaran->hasilTes)
            <div class="panel p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-clipboard-check me-2 text-primary"></i>
                    Hasil Tes Wawancara
                </h5>
                <span class="badge fs-6 {{ $pendaftaran->hasilTes->hasil === 'lulus' ? 'text-bg-success' : 'text-bg-danger' }}">
                    {{ $pendaftaran->hasilTes->hasil === 'lulus' ? 'Lulus' : 'Tidak Lulus' }}
                </span>
                @if($pendaftaran->hasilTes->keterangan)
                    <p class="text-muted small mt-2 mb-0">
                        {{ $pendaftaran->hasilTes->keterangan }}
                    </p>
                @endif
            </div>
        @endif

        {{-- Catatan Panitia --}}
        {{-- Hanya tampil kalau bukan status revisi
             (revisi sudah ditampilkan di atas) --}}
        @if($pendaftaran->catatan && $pendaftaran->status_verifikasi !== 'revisi')
            <div class="panel p-4 mt-3">
                <h5 class="fw-bold mb-2">
                    <i class="bi bi-chat-left-text me-2 text-warning"></i>
                    Catatan Panitia
                </h5>
                <p class="text-muted small mb-0">{{ $pendaftaran->catatan }}</p>
            </div>
        @endif

    </div>

    {{-- ================================================
         INFO DAFTAR ULANG
         Hanya tampil kalau hasil wawancara LULUS
         Tidak bergantung pada status_verifikasi
    ================================================ --}}
   {{-- Info Daftar Ulang —
     Bergantung pada status_akhir, BUKAN status_verifikasi --}}
@if($pendaftaran->status_akhir === 'diterima' && $infoDaftarUlang->count() > 0)
    <div class="col-12">
        <div class="panel p-4" style="border-left: 4px solid #16794d;">
            <h5 class="fw-bold mb-3 text-success">
                <i class="bi bi-megaphone-fill me-2"></i>
                Informasi Daftar Ulang
            </h5>
            <p class="text-muted small mb-3">
                Selamat! Kamu dinyatakan diterima.
                Berikut informasi untuk daftar ulang:
            </p>
            <ul class="list-unstyled mb-0">
                @foreach($infoDaftarUlang as $info)
                    <li class="mb-3 pb-3 border-bottom">
                        <p class="fw-semibold mb-1">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            {{ $info->judul }}
                        </p>
                        @if($info->konten && $info->konten !== $info->judul)
                            <p class="text-muted small mb-0 ms-4">
                                {{ $info->konten }}
                            </p>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

</div>

@else
    <div class="panel p-4 text-center mt-3">
        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
        <h5>Kamu belum mendaftar</h5>
        <p class="text-muted mb-4">
            Silakan mulai pendaftaran terlebih dahulu.
        </p>
        <a href="{{ route('pendaftaran.step1') }}" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i>Daftar Sekarang
        </a>
    </div>
@endif

@endsection