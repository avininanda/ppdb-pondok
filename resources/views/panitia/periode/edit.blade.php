@extends('layouts.dashboard')

@section('title', 'Edit Periode — PPDB Nashirussunnah')
@section('page_title', 'Edit Periode')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-calendar-week"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Edit Periode Pendaftaran</h1>
            <p class="text-muted mb-0">{{ $periode->tahun_ajaran }}</p>
        </div>
    </div>
    <div class="heading-actions">
        <a href="{{ route('periode.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-md-6">
        <div class="panel">
            <div class="panel-header">
                <h2 class="h5 mb-0 section-title">
                    <i class="bi bi-calendar-event"></i>
                    <span>Form Periode</span>
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

                <form method="POST" action="{{ route('periode.update', $periode->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tahun Ajaran <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="tahun_ajaran"
                            value="{{ old('tahun_ajaran', $periode->tahun_ajaran) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Buka <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_buka"
                            value="{{ old('tanggal_buka', $periode->tanggal_buka) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Tutup <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_tutup"
                            value="{{ old('tanggal_tutup', $periode->tanggal_tutup) }}"
                            class="form-control">
                    </div>
                   <hr class="my-4">
                    <h6 class="fw-bold text-muted mb-3">Tahap Selanjutnya</h6>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">
                                Tes Wawancara Mulai <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_tes_mulai"
                                value="{{ old('tanggal_tes_mulai', $periode->tanggal_tes_mulai) }}"
                                class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">
                                Tes Wawancara Selesai <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_tes_selesai"
                                value="{{ old('tanggal_tes_selesai', $periode->tanggal_tes_selesai) }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Pengumuman Kelulusan <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_pengumuman"
                            value="{{ old('tanggal_pengumuman', $periode->tanggal_pengumuman) }}"
                            class="form-control">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-semibold">
                                Daftar Ulang Mulai <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_daftar_ulang_mulai"
                                value="{{ old('tanggal_daftar_ulang_mulai', $periode->tanggal_daftar_ulang_mulai) }}"
                                class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">
                                Daftar Ulang Selesai <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_daftar_ulang_selesai"
                                value="{{ old('tanggal_daftar_ulang_selesai', $periode->tanggal_daftar_ulang_selesai) }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_aktif" id="is_aktif" class="form-check-input"
                            {{ $periode->is_aktif ? 'checked' : '' }}>
                        <label for="is_aktif" class="form-check-label">
                            Jadikan periode aktif
                        </label>
                        <div class="form-text">
                            Mengaktifkan ini akan menonaktifkan periode lain secara otomatis.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Perbarui Periode
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection