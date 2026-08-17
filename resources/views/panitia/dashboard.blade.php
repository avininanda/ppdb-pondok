@extends('layouts.dashboard')

@section('title', 'Dashboard Panitia — PPDB Nashirussunnah')
@section('page_title', 'Dashboard')

@section('content')

{{-- Page Heading --}}
<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-speedometer2"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Dashboard</h1>
            <p class="text-muted mb-0">Ringkasan data pendaftaran santri baru.</p>
        </div>
    </div>
</div>

{{-- Statistik --}}
<section class="row g-3 mt-1">
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('panitia.pendaftar') }}" class="text-decoration-none text-reset">
            <article class="metric-card metric-primary">
                <div class="metric-top">
                    <span class="metric-label">Total Pendaftar</span>
                    <span class="metric-icon"><i class="bi bi-people"></i></span>
                </div>
                <div class="metric-value">{{ $stats['total'] }}</div>
                <div class="metric-meta">
                    <span>Sudah submit pendaftaran</span>
                </div>
            </article>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('panitia.pendaftar', ['status' => 'pending']) }}" class="text-decoration-none text-reset">
            <article class="metric-card metric-warning">
                <div class="metric-top">
                    <span class="metric-label">Menunggu Verifikasi</span>
                    <span class="metric-icon"><i class="bi bi-hourglass-split"></i></span>
                </div>
                <div class="metric-value">{{ $stats['pending'] }}</div>
                <div class="metric-meta">
                    <span>Perlu ditindaklanjuti</span>
                </div>
            </article>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('panitia.pendaftar', ['status' => 'diterima']) }}" class="text-decoration-none text-reset">
            <article class="metric-card metric-success">
                <div class="metric-top">
                    <span class="metric-label">Diterima</span>
                    <span class="metric-icon"><i class="bi bi-check-circle"></i></span>
                </div>
                <div class="metric-value">{{ $stats['diterima'] }}</div>
                <div class="metric-meta">
                    <span>Lolos seleksi</span>
                </div>
            </article>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('panitia.pendaftar', ['status' => 'ditolak']) }}" class="text-decoration-none text-reset">
            <article class="metric-card metric-danger">
                <div class="metric-top">
                    <span class="metric-label">Ditolak</span>
                    <span class="metric-icon"><i class="bi bi-x-circle"></i></span>
                </div>
                <div class="metric-value">{{ $stats['ditolak'] }}</div>
                <div class="metric-meta">
                    <span>Tidak lolos seleksi</span>
                </div>
            </article>
        </a>
    </div>
</section>

{{-- Jadwal Wawancara Hari Ini --}}
<section class="panel mt-3">
    <div class="panel-header">
        <div>
            <h2 class="h5 mb-1 section-title">
                <i class="bi bi-calendar-event"></i>
                <span>Jadwal Tes Wawancara Hari Ini</span>
                @if($jadwalHariIni->count() > 0)
                    <span class="badge text-bg-primary ms-1">{{ $jadwalHariIni->count() }}</span>
                @endif
            </h2>
        </div>
        @if($jadwalHariIni->count() > 0)
            <a href="{{ route('panitia.kelola.jadwal') }}" class="btn btn-outline-primary btn-sm">
                Lihat Semua Jadwal
            </a>
        @endif
    </div>

    @if($jadwalHariIni->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Jam</th>
                        <th>Nama Pendaftar</th>
                        <th>Asal Sekolah</th>
                        <th>Status</th>
                        <th>Link Tes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwalHariIni as $j)
                    <tr>
                        <td class="fw-semibold">{{ \Carbon\Carbon::parse($j->jam_tes)->format('H:i') }}</td>
                        <td>{{ $j->pendaftaran->nama ?? '-' }}</td>
                        <td class="text-muted">{{ $j->pendaftaran->asal_sekolah ?? '-' }}</td>
                        <td>
                            @if($j->sudah_dilaksanakan)
                                <span class="badge text-bg-info">✅ Sudah Dilaksanakan</span>
                            @else
                                <span class="badge text-bg-warning">⏳ Belum Dilaksanakan</span>
                            @endif
                        </td>
                        <td>
                            @if($j->link_tes)
                                <a href="{{ $j->link_tes }}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="bi bi-camera-video me-1"></i>Buka Link
                                </a>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-4 text-muted">
            <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
            Tidak ada jadwal tes wawancara hari ini.
        </div>
    @endif
</section>

@endsection