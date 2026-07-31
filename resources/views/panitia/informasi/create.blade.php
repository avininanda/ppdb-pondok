@extends('layouts.dashboard')

@section('title', 'Tambah Informasi — PPDB Nashirussunnah')
@section('page_title', 'Tambah Informasi')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-plus-circle"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Tambah Informasi</h1>
            <p class="text-muted mb-0">Buat pengumuman atau persyaratan baru.</p>
        </div>
    </div>
    <div class="heading-actions">
        <a href="{{ route('informasi.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-md-8">
        <div class="panel">
            <div class="panel-header">
                <h2 class="h5 mb-0 section-title">
                    <i class="bi bi-file-earmark-plus"></i>
                    <span>Form Informasi</span>
                </h2>
            </div>
            <div class="p-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="mb-0">⚠️ {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('informasi.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="kategori" class="form-select">
                            <option value="pengumuman" {{ old('kategori') === 'pengumuman' ? 'selected' : '' }}>
                                Pengumuman
                            </option>
                            <option value="persyaratan" {{ old('kategori') === 'persyaratan' ? 'selected' : '' }}>
                                Persyaratan
                            </option>
                            </option>
                            <option value="daftar_ulang" {{ old('kategori') === 'daftar_ulang' ? 'selected' : '' }}>
                                Daftar Ulang
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Judul <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                            class="form-control" placeholder="Contoh: Pendaftaran Dibuka 1 Juli 2026">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Konten <span class="text-danger">*</span>
                        </label>
                        <textarea name="konten" rows="4" class="form-control"
                            placeholder="Isi pengumuman atau persyaratan...">{{ old('konten') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" value="{{ old('urutan', 0) }}"
                            class="form-control" style="max-width:120px;">
                        <small class="text-muted">Angka lebih kecil tampil lebih dulu.</small>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_aktif" id="is_aktif" class="form-check-input"
                            checked>
                        <label for="is_aktif" class="form-check-label">
                            Tampilkan di landing page
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan Informasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection