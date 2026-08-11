@extends('layouts.dashboard')

@section('title', 'Detail Pendaftaran — PPDB Nashirussunnah')
@section('page_title', 'Detail Pendaftaran')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-text"></i></span>
        <div>
            <p class="eyebrow mb-1">Calon Santri</p>
            <h1 class="h3 mb-1">Data Pendaftaran</h1>
            <p class="text-muted mb-0">
                Data pendaftaran kamu — hanya bisa dilihat, tidak bisa diubah.
            </p>
        </div>
    </div>
</div>

{{-- Info read only --}}
<div class="alert alert-info small mt-3">
    <i class="bi bi-lock me-2"></i>
    Data pendaftaran sudah disubmit dan tidak bisa diubah.
    Hubungi panitia jika ada kesalahan data.
</div>

<div class="row g-3 mt-1">

    {{-- Data Diri --}}
    <div class="col-12 col-md-6">
        <div class="panel p-4 h-100">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-person me-2 text-primary"></i>Data Diri
            </h5>

            @if($pendaftaran->pas_foto)
            <div class="mb-3 text">
                <img src="{{ asset('storage/' . $pendaftaran->pas_foto) }}"
                    alt="Pas Foto {{ $pendaftaran->nama }}"
                    class="rounded" style="width: 120px; height: 120px; object-fit: cover;">
            </div>
        @endif

            <div class="text-muted small">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Nama Lengkap</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->nama }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Tempat, Tanggal Lahir</span>
                    <span class="fw-semibold text-dark">
                        {{ $pendaftaran->tempat_lahir }},
                        {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d M Y') }}
                    </span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Asal Sekolah</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->asal_sekolah }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>No. Telepon</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->no_telepon }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Hafalan</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->hafalan ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span>Alamat</span>
                    <span class="fw-semibold text-dark text-end" style="max-width:60%;">
                        {{ $pendaftaran->alamat }}
                    </span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                <span>Anak Ke-</span>
                <span class="fw-semibold text-dark">{{ $pendaftaran->anak_ke ?? '-' }}</span>
            </div>
            <div class="d-flex justify-content-between py-2">
                <span>Riwayat Penyakit</span>
                <span class="fw-semibold text-dark text-end" style="max-width:60%;">
                    {{ $pendaftaran->riwayat_penyakit ?: 'Tidak ada' }}
                </span>
            </div>
            </div>
        </div>
    </div>

   {{-- Data Orang Tua / Wali --}}
<div class="col-12 col-md-6">
    <div class="panel p-4 h-100">
        <h5 class="fw-bold mb-4">
            <i class="bi bi-people me-2 text-primary"></i>Data Orang Tua / Wali
        </h5>
        <div class="text-muted small">
            <div class="d-flex justify-content-between py-2 border-bottom">
                <span>Status Orang Tua</span>
                <span class="fw-semibold text-dark">
                    @switch($pendaftaran->status_ortu)
                        @case('yatim') Yatim (Ayah telah meninggal) @break
                        @case('piatu') Piatu (Ibu telah meninggal) @break
                        @case('yatim_piatu') Yatim Piatu @break
                        @case('wali') Diasuh Wali @break
                        @default Orang Tua Lengkap
                    @endswitch
                </span>
            </div>

            @if(!in_array($pendaftaran->status_ortu, ['yatim', 'yatim_piatu', 'wali']))
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Nama Ayah</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->nama_ayah }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Pekerjaan Ayah</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->pekerjaan_ayah }}</span>
                </div>
            @endif

            @if(!in_array($pendaftaran->status_ortu, ['piatu', 'yatim_piatu', 'wali']))
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Nama Ibu</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->nama_ibu }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Pekerjaan Ibu</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->pekerjaan_ibu }}</span>
                </div>
            @endif

            @if(in_array($pendaftaran->status_ortu, ['yatim_piatu', 'wali']))
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Nama Wali</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->nama_wali }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Hubungan dengan Santri</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->hubungan_wali }}</span>
                </div>
            @endif

            <div class="d-flex justify-content-between py-2">
                <span>HP Orang Tua / Wali</span>
                <span class="fw-semibold text-dark">{{ $pendaftaran->hp_ortu }}</span>
            </div>
        </div>
    </div>
</div>

    {{-- Dokumen --}}
    <div class="col-12 col-md-6">
        <div class="panel p-4 h-100">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-paperclip me-2 text-primary"></i>Dokumen
            </h5>
            <div class="text-muted small">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span>Kartu Keluarga</span>
                    @if($pendaftaran->file_kk)
                        <a href="{{ asset('storage/' . $pendaftaran->file_kk) }}"
                            target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-danger">Belum Upload</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span>Akte Kelahiran</span>
                    @if($pendaftaran->file_akte)
                        <a href="{{ asset('storage/' . $pendaftaran->file_akte) }}"
                            target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-danger">Belum Upload</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <span>Ijazah</span>
                    @if($pendaftaran->file_ijazah)
                        <a href="{{ asset('storage/' . $pendaftaran->file_ijazah) }}"
                            target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-danger">Belum Upload</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Bukti Pembayaran --}}
    <div class="col-12 col-md-6">
        <div class="panel p-4 h-100">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-cash-coin me-2 text-primary"></i>Bukti Pembayaran
            </h5>
            <div class="text-muted small">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span>Bukti Transfer</span>
                    @if($pendaftaran->file_bukti_bayar)
                        <a href="{{ asset('storage/' . $pendaftaran->file_bukti_bayar) }}"
                            target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-secondary">Belum Upload</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <span>Status Pembayaran</span>
                    @if($pendaftaran->status_pembayaran === 'terverifikasi')
                        <span class="badge text-bg-success">✅ Terverifikasi</span>
                    @elseif($pendaftaran->status_pembayaran === 'menunggu_verifikasi')
                        <span class="badge text-bg-warning">⏳ Menunggu Verifikasi</span>
                    @else
                        <span class="badge text-bg-secondary">Belum Bayar</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Catatan Panitia --}}
    @if($pendaftaran->catatan)
    <div class="col-12">
        <div class="panel p-4">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-chat-left-text me-2 text-warning"></i>Catatan Panitia
            </h5>
            <p class="text-muted mb-0">{{ $pendaftaran->catatan }}</p>
        </div>
    </div>
    @endif

</div>

@endsection