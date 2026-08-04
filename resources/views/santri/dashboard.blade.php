@extends('layouts.dashboard')

@section('title', 'Dashboard — PPDB Nashirussunnah')
@section('page_title', 'Dashboard')

@section('content')

@php
    $pendaftaran = \App\Models\Pendaftaran::where('user_id', auth()->id())
                   ->with(['jadwal', 'hasilTes'])
                   ->first();
@endphp

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-house"></i></span>
        <div>
            <p class="eyebrow mb-1">Calon Santri</p>
            <h1 class="h3 mb-1">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-muted mb-0">Sistem Penerimaan Peserta Didik Baru Nashirussunnah</p>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">

    {{-- Belum pernah daftar --}}
    @if(!$pendaftaran)
        <div class="col-12">
            <div class="panel p-4 text-center">
                <i class="bi bi-file-earmark-plus fs-1 text-primary mb-3 d-block"></i>
                <h4 class="fw-bold">Kamu Belum Mendaftar</h4>
                <p class="text-muted mb-4">
                    Silakan lengkapi formulir pendaftaran untuk memulai proses PPDB.
                </p>
                <a href="{{ route('pendaftaran.step1') }}"
                    class="btn btn-primary px-5">
                    <i class="bi bi-pencil-square me-2"></i>Mulai Pendaftaran
                </a>
            </div>
        </div>

    {{-- Masih draft --}}
    @elseif($pendaftaran->isDraft())
        <div class="col-12">
            <div class="panel p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge text-bg-warning fs-6">
                        📝 Draft — Belum Disubmit
                    </span>
                    @if($pendaftaran->nomor_pendaftaran)
                        <span class="text-muted small">
                            No. Pendaftaran: <strong class="text-dark">{{ $pendaftaran->nomor_pendaftaran }}</strong>
                        </span>
                    @endif
                </div>
                <p class="text-muted mb-4">
                    Pendaftaran kamu masih dalam tahap pengisian. Segera lengkapi dan submit!
                </p>

                {{-- Progress --}}
                <div class="mb-4">
                    <p class="fw-semibold mb-3">Progress Pengisian:</p>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded
                                {{ $pendaftaran->nama ? 'bg-success bg-opacity-10' : 'bg-light' }}">
                                <i class="bi bi-{{ $pendaftaran->nama ? 'check-circle-fill text-success' : 'circle text-muted' }} fs-5"></i>
                                <span class="small fw-semibold">Data Diri</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded
                                {{ $pendaftaran->nama_ayah ? 'bg-success bg-opacity-10' : 'bg-light' }}">
                                <i class="bi bi-{{ $pendaftaran->nama_ayah ? 'check-circle-fill text-success' : 'circle text-muted' }} fs-5"></i>
                                <span class="small fw-semibold">Data Orang Tua</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded
                                {{ $pendaftaran->file_kk ? 'bg-success bg-opacity-10' : 'bg-light' }}">
                                <i class="bi bi-{{ $pendaftaran->file_kk ? 'check-circle-fill text-success' : 'circle text-muted' }} fs-5"></i>
                                <span class="small fw-semibold">Upload Dokumen</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('pendaftaran.step1') }}"
                        class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i>Lanjut Isi Formulir
                    </a>
                    @if($pendaftaran->nama && $pendaftaran->nama_ayah && $pendaftaran->file_kk)
                        <a href="{{ route('pendaftaran.preview') }}"
                            class="btn btn-success">
                            <i class="bi bi-eye me-1"></i>Preview & Submit
                        </a>
                    @endif
                </div>
            </div>
        </div>

    {{-- Sudah submit --}}
    @else
        {{-- Status Card --}}
        <div class="col-12 col-md-6">
            <div class="panel p-4 h-100">
                    <p class="text-muted small mb-2">Nomor Pendaftaran</p>
                    <h4 class="fw-bold text-primary mb-3">{{ $pendaftaran->nomor_pendaftaran ?? '-' }}</h4>
                    <p class="text-muted small mb-2">Status Pendaftaran</p>

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
                            Cek detail tanggal, jam, dan link wawancara di panel sebelah kanan.

                @elseif($pendaftaran->status_verifikasi === 'diverifikasi')
                    {{-- Cek status pembayaran --}}
                    @if($pendaftaran->status_pembayaran === 'terverifikasi')
                        <span class="badge text-bg-info fs-7 px-4 py-2">
                            ✅ Berkas & Pembayaran Valid — Menunggu Jadwal Wawancara
                        </span>
                        <p class="text-muted small mt-2 mb-0">
                            Semua persyaratan sudah terpenuhi.
                            Tunggu jadwal wawancara dari panitia.
                        </p>
                    @elseif($pendaftaran->status_pembayaran === 'menunggu_verifikasi')
                        <span class="badge text-bg-warning fs-6 px-4 py-2">
                            ✅ Berkas Valid — ⏳Menunggu Verifikasi Pembayaran
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

                <div class="mt-3 text-muted small">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Nama</span>
                        <span class="fw-semibold text-dark">{{ $pendaftaran->nama }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Asal Sekolah</span>
                        <span class="fw-semibold text-dark">{{ $pendaftaran->asal_sekolah }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tanggal Daftar</span>
                        <span class="fw-semibold text-dark">
                            {{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jadwal & Hasil --}}
        <div class="col-12 col-md-6">

            {{-- Jadwal Wawancara --}}
            @if($pendaftaran->jadwal)
                <div class="panel p-4 mb-3">
                    <p class="fw-semibold mb-3">
                        <i class="bi bi-calendar-check text-primary me-2"></i>
                        Jadwal Tes
                    </p>
                    <div class="text-muted small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Tanggal</span>
                            <span class="fw-semibold text-dark">
                                {{ \Carbon\Carbon::parse($pendaftaran->jadwal->tanggal_tes)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Jam</span>
                            <span class="fw-semibold text-dark">
                                {{ $pendaftaran->jadwal->jam_tes }}
                            </span>
                        </div>
                        <a href="{{ $pendaftaran->jadwal->link_tes }}" target="_blank"
                            class="btn btn-success btn-sm w-100">
                            <i class="bi bi-camera-video me-1"></i>Buka Link Tes
                        </a>
                    </div>
                </div>
            @else
                <div class="panel p-4 mb-3">
                    <p class="fw-semibold mb-2">
                        <i class="bi bi-calendar text-muted me-2"></i>
                        Jadwal Wawancara
                    </p>
                    <p class="text-muted small mb-0">
                        Belum ada jadwal. Silakan tunggu informasi dari panitia.
                    </p>
                </div>
            @endif

            {{-- Hasil Tes --}}
            @if($pendaftaran->hasilTes)
                <div class="panel p-4">
                    <p class="fw-semibold mb-3">
                        <i class="bi bi-clipboard-check text-primary me-2"></i>
                        Hasil Wawancara
                    </p>
                    <span class="badge fs-6 {{ $pendaftaran->hasilTes->hasil === 'lulus' ? 'text-bg-success' : 'text-bg-danger' }}">
                        {{ ucfirst($pendaftaran->hasilTes->hasil) }}
                    </span>
                    @if($pendaftaran->hasilTes->keterangan)
                        <p class="text-muted small mt-2 mb-0">
                            {{ $pendaftaran->hasilTes->keterangan }}
                        </p>
                    @endif
                </div>
            @endif

        </div>

        {{-- Link ke status lengkap --}}
        <div class="col-12">
            <a href="{{ route('pendaftaran.status') }}"
                class="btn btn-outline-primary btn-sm">
                <i class="bi bi-info-circle me-1"></i>Lihat Detail Status Lengkap
            </a>
        </div>
    @endif

</div>

@endsection