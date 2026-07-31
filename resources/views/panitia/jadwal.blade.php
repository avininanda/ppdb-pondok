@extends('layouts.dashboard')

@section('title', 'Input Jadwal — PPDB Nashirussunnah')
@section('page_title', 'Input Jadwal Wawancara')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-calendar-check"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Input Jadwal Tes Wawancara</h1>
            <p class="text-muted mb-0">
                Untuk: <strong>{{ $pendaftaran->nama }}</strong>
            </p>
        </div>
    </div>
    <div class="heading-actions">
        <a href="{{ route('panitia.kelola.jadwal', $pendaftaran->id) }}"
            class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-md-6">
        <div class="panel">
            <div class="panel-header">
                <h2 class="h5 mb-0 section-title">
                    <i class="bi bi-calendar-plus"></i>
                    <span>Form Jadwal</span>
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

                <form method="POST"
                    action="{{ route('panitia.jadwal.simpan', $pendaftaran->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Tes Wawancara <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_tes"
                            value="{{ old('tanggal_tes', $jadwal->tanggal_tes ?? '') }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Jam Tes Wawancara <span class="text-danger">*</span>
                        </label>
                        <input type="time" name="jam_tes"
                            value="{{ old('jam_tes', $jadwal->jam_tes ?? '') }}"
                            class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Link Google Meet <span class="text-danger">*</span>
                        </label>
                        <input type="url" name="link_tes"
                            value="{{ old('link_tes', $jadwal->link_tes ?? '') }}"
                            class="form-control"
                            placeholder="https://meet.google.com/xxx-xxxx-xxx">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Simpan Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection