@extends('layouts.dashboard')

@section('title', 'Pendaftaran Step 3 — PPDB Nashirussunnah')
@section('page_title', 'Form Pendaftaran')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-text"></i></span>
        <div>
            <p class="eyebrow mb-1">Calon Santri</p>
            <h1 class="h3 mb-1">Form Pendaftaran</h1>
            <p class="text-muted mb-0">Upload dokumen dan bukti pembayaran.</p>
        </div>
    </div>
</div>

{{-- Progress Bar --}}
<div class="panel p-4 mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="small fw-semibold">Step 3 dari 3 — Upload Dokumen</span>
        <span class="small text-muted">100%</span>
    </div>
    <div class="progress" style="height: 8px;">
        <div class="progress-bar bg-success" style="width: 100%"></div>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <span class="badge text-bg-success">✓ Data Diri</span>
        <span class="badge text-bg-success">✓ Data Orang Tua</span>
        <span class="badge text-bg-primary">3. Dokumen</span>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="panel p-4">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="alert alert-info small mb-4">
                <i class="bi bi-info-circle me-1"></i>
                Format yang diterima: PDF, JPG, PNG. Ukuran maksimal 2MB per file.
            </div>

            <form method="POST" action="{{ route('pendaftaran.simpanStep3') }}"
                enctype="multipart/form-data">
                @csrf

                <h6 class="fw-bold mb-3 text-muted">📷 Pas Foto</h6>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Pas Foto (Latar Bebas) <span class="text-danger">*</span>
                    </label>
                    @if($pendaftaran->pas_foto ?? false)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $pendaftaran->pas_foto) }}"
                                alt="Pas Foto" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="small text-success mb-1">
                            <i class="bi bi-check-circle me-1"></i>
                            Foto sudah terupload. Upload baru untuk mengganti.
                        </div>
                    @endif
                    <input type="file" name="pas_foto" accept=".jpg,.jpeg,.png" class="form-control">
                    <div class="form-text">Format JPG/PNG, maksimal 1MB.</div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold mb-3 text-muted">📎 Dokumen Persyaratan</h6>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Kartu Keluarga (KK) <span class="text-danger">*</span>
                    </label>
                    @if($pendaftaran->file_kk ?? false)
                        <div class="small text-success mb-1">
                            <i class="bi bi-check-circle me-1"></i>
                            File sudah terupload. Upload baru untuk mengganti.
                        </div>
                    @endif
                    <input type="file" name="file_kk"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Akte Kelahiran <span class="text-danger">*</span>
                    </label>
                    @if($pendaftaran->file_akte ?? false)
                        <div class="small text-success mb-1">
                            <i class="bi bi-check-circle me-1"></i>
                            File sudah terupload. Upload baru untuk mengganti.
                        </div>
                    @endif
                    <input type="file" name="file_akte"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Ijazah / Surat Keterangan Lulus <span class="text-danger">*</span>
                    </label>
                    @if($pendaftaran->file_ijazah ?? false)
                        <div class="small text-success mb-1">
                            <i class="bi bi-check-circle me-1"></i>
                            File sudah terupload. Upload baru untuk mengganti.
                        </div>
                    @endif
                    <input type="file" name="file_ijazah"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="form-control">
                </div>

                <hr class="my-4">

                <h6 class="fw-bold mb-3 text-muted">💰 Bukti Pembayaran</h6>

                <div class="alert alert-warning small mb-3">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <strong>Silakan transfer biaya pendaftaran sebesar Rp 350.000</strong> ke rekening berikut, lalu upload bukti transfernya di sini:
                    <div class="mt-2 ps-3 border-start border-3 border-warning">
                        Bank BSI &mdash; <strong>7082130432</strong><br>
                        a.n. PONPES TAHFIZH QURAN NASHIRUSSUNNAH
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Bukti Transfer / Pembayaran <span class="text-danger">*</span>
                    </label>
                    @if($pendaftaran->file_bukti_bayar ?? false)
                        <div class="small text-success mb-1">
                            <i class="bi bi-check-circle me-1"></i>
                            Bukti pembayaran sudah terupload. Upload baru untuk mengganti.
                        </div>
                    @endif
                    <input type="file" name="file_bukti_bayar"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="form-control">
                    <div class="form-text">
                        Upload foto/screenshot bukti transfer pembayaran biaya pendaftaran.
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('pendaftaran.step2') }}"
                        class="btn btn-outline-secondary w-25">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        Simpan & Preview <i class="bi bi-eye ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection