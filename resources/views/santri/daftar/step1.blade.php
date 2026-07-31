@extends('layouts.dashboard')

@section('title', 'Pendaftaran Step 1 — PPDB Nashirussunnah')
@section('page_title', 'Form Pendaftaran')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-text"></i></span>
        <div>
            <p class="eyebrow mb-1">Calon Santri</p>
            <h1 class="h3 mb-1">Form Pendaftaran</h1>
            <p class="text-muted mb-0">Lengkapi data diri kamu dengan benar.</p>
        </div>
    </div>
</div>

{{-- Progress Bar --}}
<div class="panel p-4 mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="small fw-semibold">Step 1 dari 3 — Data Diri</span>
        <span class="small text-muted">33%</span>
    </div>
    <div class="progress" style="height: 8px;">
        <div class="progress-bar bg-primary" style="width: 33%"></div>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <span class="badge text-bg-primary">1. Data Diri</span>
        <span class="badge text-bg-light text-muted">2. Data Orang Tua</span>
        <span class="badge text-bg-light text-muted">3. Dokumen</span>
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

            @if(session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Info draft --}}
            <div class="alert alert-info small mb-4">
                <i class="bi bi-info-circle me-1"></i>
                Data akan tersimpan otomatis sebagai draft. Kamu bisa kembali dan edit kapan saja sebelum submit.
            </div>

            <form method="POST" action="{{ route('pendaftaran.simpanStep1') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama"
                        value="{{ old('nama', $pendaftaran->nama ?? '') }}"
                        class="form-control"
                        placeholder="Masukkan nama lengkap">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Tempat Lahir <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="tempat_lahir"
                            value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir ?? '') }}"
                            class="form-control"
                            placeholder="Kota lahir">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Tanggal Lahir <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir ?? '') }}"
                            class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Asal Sekolah <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="asal_sekolah"
                        value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah ?? '') }}"
                        class="form-control"
                        placeholder="Nama sekolah asal">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nomor Telepon <span class="text-danger">*</span>
                    </label>
                    <input type="tel"
                        name="no_telepon"
                        value="{{ old('no_telepon', $pendaftaran->no_telepon ?? '') }}"
                        class="form-control"
                        placeholder="08xxxxxxxxxx"
                        pattern="[0-9+\-\s]+"
                        minlength="10"
                        maxlength="15"
                        title="Nomor telepon hanya boleh berisi angka"
                        oninput="this.value = this.value.replace(/[^0-9+\-\s]/g, '')">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Hafalan (opsional)</label>
                    <input type="text" name="hafalan"
                        value="{{ old('hafalan', $pendaftaran->hafalan ?? '') }}"
                        class="form-control"
                        placeholder="Contoh: Juz 30">
                </div>

                                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Alamat Lengkap <span class="text-danger">*</span>
                    </label>
                    <textarea name="alamat" rows="3" class="form-control"
                        placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota">{{ old('alamat', $pendaftaran->alamat ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Anak Ke- <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="anak_ke" min="1"
                        value="{{ old('anak_ke', $pendaftaran->anak_ke ?? '') }}"
                        class="form-control" style="max-width: 150px;"
                        placeholder="Contoh: 1">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Riwayat Penyakit (opsional)</label>
                    <textarea name="riwayat_penyakit" rows="2" class="form-control"
                        placeholder="Kosongkan jika tidak ada riwayat penyakit">{{ old('riwayat_penyakit', $pendaftaran->riwayat_penyakit ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Simpan & Lanjut <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection