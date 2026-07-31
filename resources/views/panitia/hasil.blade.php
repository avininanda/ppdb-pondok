@extends('layouts.dashboard')

@section('title', 'Input Penilaian — PPDB Nashirussunnah')
@section('page_title', 'Input Penilaian Wawancara')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-clipboard-check"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Penilaian Tes Wawancara</h1>
            <p class="text-muted mb-0">
                Untuk: <strong>{{ $pendaftaran->nama }}</strong>
                — {{ $pendaftaran->nomor_pendaftaran }}
            </p>
        </div>
    </div>
    <div class="heading-actions">
        <a href="{{ route('panitia.kelola.hasil') }}"
            class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

{{-- Info threshold --}}
<div class="alert alert-info mt-3 small">
    <i class="bi bi-info-circle me-2"></i>
    Keputusan <strong>Lulus</strong> diberikan secara otomatis jika nilai akhir ≥ 75.
    Nilai dihitung berdasarkan bobot masing-masing kriteria.
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p class="mb-0">⚠️ {{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- Nilai sebelumnya kalau sudah pernah dinilai --}}
@if($hasil)
    <div class="panel p-4 mb-3" style="border-left: 4px solid {{ $hasil->hasil === 'lulus' ? '#16794d' : '#c0392b' }};">
        <p class="text-muted small mb-3 text-uppercase" style="letter-spacing: 0.5px;">Hasil Wawancara</p>
        <div class="d-flex align-items-center gap-4">
            <div>
                <p class="text-muted small mb-1">Nilai Akhir</p>
                <h4 class="fw-bold mb-0"
                    style="color: {{ $hasil->hasil === 'lulus' ? '#16794d' : '#c0392b' }};">
                    {{ $hasil->nilai_akhir ?? '-' }}<small class="fs-6 text-muted fw-normal">/100</small>
                </h4>
            </div>
            <div class="vr" style="height: 48px; opacity: 0.15;"></div>
            <div>
                <p class="text-muted small mb-1">Keputusan</p>
                <span class="badge fs-6 px-3 py-2 {{ $hasil->hasil === 'lulus' ? 'text-bg-success' : 'text-bg-danger' }}">
                    <i class="bi bi-{{ $hasil->hasil === 'lulus' ? 'check-circle-fill' : 'x-circle-fill' }} me-1"></i>
                    {{ $hasil->hasil === 'lulus' ? 'Lulus' : 'Tidak Lulus' }}
                </span>
            </div>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('panitia.hasil.simpan', $pendaftaran->id) }}">
    @csrf

    {{-- Penilaian per kriteria --}}
    <div class="panel mb-3">
        <div class="panel-header">
            <h2 class="h5 mb-0 section-title">
                <i class="bi bi-star-half"></i>
                <span>Penilaian Per Kriteria</span>
            </h2>
        </div>
        <div class="p-4">
            @forelse($kriterias as $kriteria)
            <div class="mb-4 pb-4 border-bottom">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $kriteria->nama_kriteria }}</h6>
                        @if($kriteria->deskripsi)
                            <p class="text-muted small mb-0">{{ $kriteria->deskripsi }}</p>
                        @endif
                    </div>
                    <span class="badge text-bg-secondary">
                        Bobot: {{ $kriteria->bobot }}%
                    </span>
                </div>

                {{-- Skala penilaian --}}
                <div class="row g-2 mb-3">
                    @foreach(['Sangat Baik' => 90, 'Baik' => 80, 'Cukup' => 70, 'Kurang' => 60, 'Sangat Kurang' => 50] as $label => $angka)
                    <div class="col">
                        <input type="radio"
                            class="btn-check"
                            name="penilaian[{{ $kriteria->id }}][nilai]"
                            id="nilai_{{ $kriteria->id }}_{{ $loop->index }}"
                            value="{{ $label }}"
                            {{ isset($penilaians[$kriteria->id]) && $penilaians[$kriteria->id]->nilai_label === $label ? 'checked' : '' }}
                            required>
                        <label class="btn btn-outline-secondary btn-sm w-100 text-center"
                            for="nilai_{{ $kriteria->id }}_{{ $loop->index }}">
                            <span class="d-block fw-bold">{{ $label }}</span>
                            <span class="d-block text-muted" style="font-size:11px;">{{ $angka }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>

                {{-- Catatan per kriteria --}}
                <div>
                    <label class="form-label small fw-semibold">
                        Catatan untuk kriteria ini (opsional)
                    </label>
                    <textarea name="penilaian[{{ $kriteria->id }}][catatan]"
                        class="form-control form-control-sm" rows="2"
                        placeholder="Deskripsikan hasil penilaian...">{{ isset($penilaians[$kriteria->id]) ? $penilaians[$kriteria->id]->catatan : '' }}</textarea>
                </div>
            </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                    Belum ada kriteria penilaian.<br>
                    <small>Tambahkan kriteria terlebih dahulu.</small>
                </div>
            @endforelse
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-3">
        <i class="bi bi-save me-2"></i>
        Simpan Penilaian
    </button>
</form>

@endsection