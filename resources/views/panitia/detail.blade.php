@extends('layouts.dashboard')

@section('title', 'Detail Pendaftar — PPDB Nashirussunnah')
@section('page_title', 'Detail Pendaftar')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-person-badge"></i></span>
        <div>
            <h1 class="h3 mb-1">{{ $pendaftaran->nama }}</h1>
            <p class="text-muted mb-0">
                No. Pendaftaran: <strong class="text-dark">{{ $pendaftaran->nomor_pendaftaran ?? '-' }}</strong>
            </p>
        </div>
    </div>
    <div class="heading-actions">
        <a href="{{ route('panitia.pendaftar') }}"
            class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-3 mt-1">

    {{-- Kolom Kiri --}}
    <div class="col-12 col-lg-8">

        {{-- Data Diri --}}
        <div class="panel mb-3">
            <div class="panel-header">
                <h2 class="h5 mb-0 section-title">
                    <i class="bi bi-person"></i>
                    <span>Data Diri</span>
                </h2>
            </div>
            <div class="p-3">
                @if($pendaftaran->pas_foto)
                    <div class="mb-3 text-center text-md-start">
                        <img src="{{ asset('storage/' . $pendaftaran->pas_foto) }}"
                            alt="Pas Foto {{ $pendaftaran->nama }}"
                            class="rounded" style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Nama Lengkap</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->nama }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Tempat, Tanggal Lahir</p>
                        <p class="fw-semibold mb-0">
                            {{ $pendaftaran->tempat_lahir }},
                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Asal Sekolah</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->asal_sekolah }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">No. Telepon</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->no_telepon }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Hafalan</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->hafalan ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Alamat</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->alamat }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Anak Ke-</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->anak_ke ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Riwayat Penyakit</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->riwayat_penyakit ?: 'Tidak ada' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Orang Tua --}}
        <div class="panel mb-3">
            <div class="panel-header">
                <h2 class="h5 mb-0 section-title">
                    <i class="bi bi-people"></i>
                    <span>Data Orang Tua</span>
                </h2>
            </div>
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Nama Ayah</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->nama_ayah }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Pekerjaan Ayah</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->pekerjaan_ayah }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Nama Ibu</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->nama_ibu }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Pekerjaan Ibu</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->pekerjaan_ibu }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">HP Orang Tua</p>
                        <p class="fw-semibold mb-0">{{ $pendaftaran->hp_ortu }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dokumen --}}
        <div class="panel mb-3">
            <div class="panel-header">
                <h2 class="h5 mb-0 section-title">
                    <i class="bi bi-paperclip"></i>
                    <span>Dokumen</span>
                </h2>
            </div>
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <p class="text-muted small mb-1">Kartu Keluarga</p>
                        @if($pendaftaran->file_kk)
                            <a href="{{ asset('storage/' . $pendaftaran->file_kk) }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Lihat File
                            </a>
                        @else
                            <span class="badge text-bg-danger">Belum Upload</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted small mb-1">Akte Kelahiran</p>
                        @if($pendaftaran->file_akte)
                            <a href="{{ asset('storage/' . $pendaftaran->file_akte) }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Lihat File
                            </a>
                        @else
                            <span class="badge text-bg-danger">Belum Upload</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted small mb-1">Ijazah</p>
                        @if($pendaftaran->file_ijazah)
                            <a href="{{ asset('storage/' . $pendaftaran->file_ijazah) }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Lihat File
                            </a>
                        @else
                            <span class="badge text-bg-danger">Belum Upload</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Bukti Pembayaran --}}
        <div class="panel mb-3">
            <div class="panel-header">
                <h2 class="h5 mb-0 section-title">
                    <i class="bi bi-cash-coin"></i>
                    <span>Bukti Pembayaran</span>
                </h2>
            </div>
            <div class="p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Bukti Transfer</p>
                        @if($pendaftaran->file_bukti_bayar)
                            <a href="{{ asset('storage/' . $pendaftaran->file_bukti_bayar) }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Lihat Bukti
                            </a>
                        @else
                            <span class="badge text-bg-secondary">Belum Upload</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Status Pembayaran</p>
                        @if($pendaftaran->status_pembayaran === 'terverifikasi')
                            <span class="badge text-bg-success">✅ Terverifikasi</span>
                        @elseif($pendaftaran->status_pembayaran === 'menunggu_verifikasi')
                            <span class="badge text-bg-warning">⏳ Menunggu Verifikasi</span>
                        @else
                            <span class="badge text-bg-secondary">Belum Bayar</span>
                        @endif
                    </div>
                </div>

                {{-- Tombol Verifikasi Pembayaran --}}
                @if($pendaftaran->file_bukti_bayar && $pendaftaran->status_pembayaran !== 'terverifikasi')
                    <form method="POST"
                        action="{{ route('panitia.verifikasi.pembayaran', $pendaftaran->id) }}"
                        class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm"
                            onclick="return confirm('Yakin verifikasi pembayaran ini?')">
                            <i class="bi bi-check-circle me-1"></i>
                            Verifikasi Pembayaran
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </div>

    {{-- Kolom Kanan --}}
    <div class="col-12 col-lg-4">

        {{-- Verifikasi Berkas --}}
        <div class="panel mb-3">
            <div class="panel-header">
                <h2 class="h5 mb-0 section-title">
                    <i class="bi bi-check2-circle"></i>
                    <span>Verifikasi Berkas</span>
                </h2>
            </div>
            <div class="p-3">
                <div class="mb-3">
                    <p class="text-muted small mb-1">Status Sekarang</p>
                    @if($pendaftaran->status_verifikasi === 'pending')
                        <span class="badge text-bg-warning">Pending</span>
                    @elseif($pendaftaran->status_verifikasi === 'diverifikasi')
                        <span class="badge text-bg-info">Diverifikasi</span>
                    @elseif($pendaftaran->status_verifikasi === 'diterima')
                        <span class="badge text-bg-success">Diterima</span>
                    @elseif($pendaftaran->status_verifikasi === 'ditolak')
                        <span class="badge text-bg-danger">Ditolak</span>
                    @endif
                </div>
                <form method="POST"
                    action="{{ route('panitia.verifikasi', $pendaftaran->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Ubah Status</label>
                        <select name="status_verifikasi" class="form-select form-select-sm">
                            <option value="diverifikasi"
                                {{ $pendaftaran->status_verifikasi === 'diverifikasi' ? 'selected' : '' }}>
                                ✅ Berkas Valid — Lanjut ke Jadwal
                            </option>
                            <option value="revisi"
                                {{ $pendaftaran->status_verifikasi === 'revisi' ? 'selected' : '' }}>
                                ⚠️ Perlu Revisi — Minta Upload Ulang
                            </option>
                            <option value="ditolak"
                                {{ $pendaftaran->status_verifikasi === 'ditolak' ? 'selected' : '' }}>
                                ❌ Ditolak — Tidak Memenuhi Syarat
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Catatan (opsional)
                        </label>
                        <textarea name="catatan" class="form-control form-control-sm"
                            rows="3"
                            placeholder="Catatan untuk calon santri...">{{ $pendaftaran->catatan }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-save me-1"></i>Simpan Verifikasi
                    </button>
                </form>
            </div>
        </div>
        </div>

    </div>
</div>

@endsection