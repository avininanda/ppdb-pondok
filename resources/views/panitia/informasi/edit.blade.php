@extends('layouts.dashboard')

@section('title', 'Edit Informasi — PPDB Nashirussunnah')
@section('page_title', 'Edit Informasi')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-pencil-square"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Edit Informasi</h1>
            <p class="text-muted mb-0">{{ $informasi->judul }}</p>
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
                    <i class="bi bi-file-earmark-text"></i>
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

                <form method="POST" action="{{ route('informasi.update', $informasi->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="kategori" class="form-select">
                            <option value="pengumuman" {{ $informasi->kategori === 'pengumuman' ? 'selected' : '' }}>
                                Pengumuman
                            </option>
                            <option value="persyaratan" {{ $informasi->kategori === 'persyaratan' ? 'selected' : '' }}>
                                Persyaratan
                            </option>
                            <option value="daftar_ulang" {{ $informasi->kategori === 'daftar_ulang' ? 'selected' : '' }}>
                                Daftar Ulang
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Judul <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $informasi->judul) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Konten <span class="text-danger">*</span>
                        </label>
                        <textarea name="konten" rows="4" class="form-control">{{ old('konten', $informasi->konten) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" value="{{ old('urutan', $informasi->urutan) }}"
                            class="form-control" style="max-width:120px;">
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_aktif" id="is_aktif" class="form-check-input"
                            {{ $informasi->is_aktif ? 'checked' : '' }}>
                        <label for="is_aktif" class="form-check-label">
                            Tampilkan di landing page
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Perbarui Informasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection