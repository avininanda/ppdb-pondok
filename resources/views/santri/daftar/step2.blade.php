@extends('layouts.dashboard')

@section('title', 'Pendaftaran Step 2 — PPDB Nashirussunnah')
@section('page_title', 'Form Pendaftaran')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-text"></i></span>
        <div>
            <p class="eyebrow mb-1">Calon Santri</p>
            <h1 class="h3 mb-1">Form Pendaftaran</h1>
            <p class="text-muted mb-0">Lengkapi data orang tua / wali.</p>
        </div>
    </div>
</div>

{{-- Progress Bar --}}
<div class="panel p-4 mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="small fw-semibold">Step 2 dari 3 — Data Orang Tua</span>
        <span class="small text-muted">66%</span>
    </div>
    <div class="progress" style="height: 8px;">
        <div class="progress-bar bg-primary" style="width: 66%"></div>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <span class="badge text-bg-success">✓ Data Diri</span>
        <span class="badge text-bg-primary">2. Data Orang Tua</span>
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

            <form method="POST" action="{{ route('pendaftaran.simpanStep2') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Ayah <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_ayah"
                        value="{{ old('nama_ayah', $pendaftaran->nama_ayah ?? '') }}"
                        class="form-control"
                        placeholder="Nama lengkap ayah">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Pekerjaan Ayah <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="pekerjaan_ayah"
                        value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah ?? '') }}"
                        class="form-control"
                        placeholder="Contoh: Wiraswasta">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Ibu <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_ibu"
                        value="{{ old('nama_ibu', $pendaftaran->nama_ibu ?? '') }}"
                        class="form-control"
                        placeholder="Nama lengkap ibu">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Pekerjaan Ibu <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="pekerjaan_ibu"
                        value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu ?? '') }}"
                        class="form-control"
                        placeholder="Contoh: Ibu Rumah Tangga">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Nomor HP Orang Tua <span class="text-danger">*</span>
                    </label>
                    <input type="tel"
                            name="hp_ortu"
                            value="{{ old('hp_ortu', $pendaftaran->hp_ortu ?? '') }}"
                            class="form-control"
                            placeholder="08xxxxxxxxxx"
                            pattern="[0-9+\-\s]+"
                            minlength="10"
                            maxlength="15"
                            oninput="this.value = this.value.replace(/[^0-9+\-\s]/g, '')">
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('pendaftaran.step1') }}"
                        class="btn btn-outline-secondary w-25">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        Simpan & Lanjut <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection