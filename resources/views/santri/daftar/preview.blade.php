@extends('layouts.dashboard')

@section('title', 'Preview Pendaftaran — PPDB Nashirussunnah')
@section('page_title', 'Preview Pendaftaran')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-eye"></i></span>
        <div>
            <p class="eyebrow mb-1">Calon Santri</p>
            <h1 class="h3 mb-1">Preview Pendaftaran</h1>
            <p class="text-muted mb-0">Periksa kembali data sebelum submit.</p>
        </div>
    </div>
</div>

<div class="alert alert-warning mt-3">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>Perhatian!</strong> Pastikan semua data sudah benar sebelum submit.
    Setelah disubmit, data tidak bisa diubah.
</div>

<div class="row g-3 mt-1">

    {{-- Data Diri --}}
    <div class="col-12 col-md-6">
        <div class="panel p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">📋 Data Diri</h5>
                <a href="{{ route('pendaftaran.step1') }}"
                    class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
            </div>
            <div class="text-muted small">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Nama</span>
                    <span class="fw-semibold text-dark">{{ $pendaftaran->nama }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>TTL</span>
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
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Alamat</span>
                    <span class="fw-semibold text-dark text-end" style="max-width: 60%;">
                        {{ $pendaftaran->alamat }}
                    </span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Anak Ke-</span>
                    <span class="fw-semibold text-dark" style="max-width: 60%;">
                        {{ $pendaftaran->anak_ke ?? '-' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span>Riwayat Penyakit</span>
                    <span class="fw-semibold text-dark text-end" style="max-width: 60%;">
                       {{ $pendaftaran->riwayat_penyakit ?: 'Tidak ada' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

   {{-- Data Orang Tua / Wali --}}
<div class="col-12 col-md-6">
    <div class="panel p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">👨‍👩‍👧 Data Orang Tua / Wali</h5>
            <a href="{{ route('pendaftaran.step2') }}"
                class="btn btn-outline-primary btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
        </div>
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

{{-- Dokumen & Pembayaran --}}
<div class="col-12">
    <div class="panel p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">📎 Dokumen & Pembayaran</h5>
            <a href="{{ route('pendaftaran.step3') }}"
                class="btn btn-outline-primary btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
        </div>

        <div class="row row-cols-2 row-cols-md-5 g-3">

            {{-- Pas Foto --}}
            <div class="col">
                <div class="border rounded p-3 text-center h-100 d-flex flex-column justify-content-between">
                    <div>
                        @if($pendaftaran->pas_foto)
                            <img src="{{ asset('storage/' . $pendaftaran->pas_foto) }}"
                                alt="Pas Foto" class="rounded mb-2"
                                style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="rounded bg-light mb-2 mx-auto d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-person fs-3 text-muted"></i>
                            </div>
                        @endif
                        <p class="small fw-semibold mb-2">Pas Foto</p>
                    </div>
                    @if($pendaftaran->pas_foto)
                        <a href="{{ asset('storage/' . $pendaftaran->pas_foto) }}" target="_blank"
                            class="btn btn-outline-success btn-sm w-100">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-danger w-100">Belum Upload</span>
                    @endif
                </div>
            </div>

            {{-- Kartu Keluarga --}}
            <div class="col">
                <div class="border rounded p-3 text-center h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="rounded bg-light mb-2 mx-auto d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-file-earmark-text fs-3 text-muted"></i>
                        </div>
                        <p class="small fw-semibold mb-2">Kartu Keluarga</p>
                    </div>
                    @if($pendaftaran->file_kk)
                        <a href="{{ asset('storage/' . $pendaftaran->file_kk) }}" target="_blank"
                            class="btn btn-outline-success btn-sm w-100">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-danger w-100">Belum Upload</span>
                    @endif
                </div>
            </div>

            {{-- Akte Kelahiran --}}
            <div class="col">
                <div class="border rounded p-3 text-center h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="rounded bg-light mb-2 mx-auto d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-file-earmark-text fs-3 text-muted"></i>
                        </div>
                        <p class="small fw-semibold mb-2">Akte Kelahiran</p>
                    </div>
                    @if($pendaftaran->file_akte)
                        <a href="{{ asset('storage/' . $pendaftaran->file_akte) }}" target="_blank"
                            class="btn btn-outline-success btn-sm w-100">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-danger w-100">Belum Upload</span>
                    @endif
                </div>
            </div>

            {{-- Ijazah --}}
            <div class="col">
                <div class="border rounded p-3 text-center h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="rounded bg-light mb-2 mx-auto d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-file-earmark-text fs-3 text-muted"></i>
                        </div>
                        <p class="small fw-semibold mb-2">Ijazah</p>
                    </div>
                    @if($pendaftaran->file_ijazah)
                        <a href="{{ asset('storage/' . $pendaftaran->file_ijazah) }}" target="_blank"
                            class="btn btn-outline-success btn-sm w-100">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-danger w-100">Belum Upload</span>
                    @endif
                </div>
            </div>

            {{-- Bukti Pembayaran --}}
            <div class="col">
                <div class="border rounded p-3 text-center h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="rounded bg-light mb-2 mx-auto d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-receipt fs-3 text-muted"></i>
                        </div>
                        <p class="small fw-semibold mb-2">Bukti Pembayaran</p>
                    </div>
                    @if($pendaftaran->file_bukti_bayar)
                        <a href="{{ asset('storage/' . $pendaftaran->file_bukti_bayar) }}" target="_blank"
                            class="btn btn-outline-success btn-sm w-100">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                    @else
                        <span class="badge text-bg-danger w-100">Belum Upload</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

    {{-- Tombol Submit --}}
    <div class="col-12">
        <div class="panel p-4">
            <form method="POST" action="{{ route('pendaftaran.submit') }}">
                @csrf
                <button type="submit" class="btn btn-success btn-lg w-100"
                    onclick="return confirm('Yakin ingin submit pendaftaran? Data tidak bisa diubah setelah disubmit!')">
                    <i class="bi bi-send me-2"></i>Submit Pendaftaran
                </button>
            </form>

            <form method="POST" action="{{ route('pendaftaran.hapus') }}" class="mt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100"
                    onclick="return confirm('Yakin ingin hapus draft dan mulai ulang?')">
                    <i class="bi bi-trash me-1"></i>Hapus Draft & Mulai Ulang
                </button>
            </form>
        </div>
    </div>

</div>

@endsection