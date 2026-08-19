@extends('layouts.dashboard')

@section('title', 'Dashboard Pimpinan — PPDB Nashirussunnah')
@section('page_title', 'Dashboard')

@section('css')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endsection

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-speedometer2"></i></span>
        <div>
            <p class="eyebrow mb-1">Pimpinan</p>
            <h1 class="h3 mb-1">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="text-muted mb-0">Ringkasan data PPDB Pondok Pesantren Nashirussunnah.</p>
        </div>
    </div>
    <div class="heading-actions">
        <a href="{{ route('pimpinan.laporan') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-bar-chart me-1"></i>Laporan Lengkap
        </a>
    </div>
</div>

{{-- Metric Cards --}}
<section class="row g-3 mt-1">
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('pimpinan.laporan') }}" class="text-decoration-none text-reset">
            <article class="metric-card metric-primary">
                <div class="metric-top">
                    <span class="metric-label">Total Pendaftar</span>
                    <span class="metric-icon"><i class="bi bi-people"></i></span>
                </div>
                <div class="metric-value">{{ $stats['total'] }}</div>
                <div class="metric-meta"><span>Semua periode</span></div>
            </article>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('pimpinan.laporan', ['status' => 'pending']) }}" class="text-decoration-none text-reset">
            <article class="metric-card metric-warning">
                <div class="metric-top">
                    <span class="metric-label">Menunggu Verifikasi</span>
                    <span class="metric-icon"><i class="bi bi-hourglass-split"></i></span>
                </div>
                <div class="metric-value">{{ $stats['pending'] }}</div>
                <div class="metric-meta"><span>Perlu diproses panitia</span></div>
            </article>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('pimpinan.laporan', ['status' => 'diterima']) }}" class="text-decoration-none text-reset">
            <article class="metric-card metric-success">
                <div class="metric-top">
                    <span class="metric-label">Diterima</span>
                    <span class="metric-icon"><i class="bi bi-check-circle"></i></span>
                </div>
                <div class="metric-value">{{ $stats['diterima'] }}</div>
                <div class="metric-meta"><span>Lulus seleksi wawancara</span></div>
            </article>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('pimpinan.laporan', ['status' => 'ditolak']) }}" class="text-decoration-none text-reset">
            <article class="metric-card metric-danger">
                <div class="metric-top">
                    <span class="metric-label">Ditolak</span>
                    <span class="metric-icon"><i class="bi bi-x-circle"></i></span>
                </div>
                <div class="metric-value">{{ $stats['ditolak'] }}</div>
                <div class="metric-meta"><span>Tidak lulus seleksi</span></div>
            </article>
        </a>
    </div>
</section>

{{-- Bar Chart per Periode --}}
<section class="panel mt-3">
    <div class="panel-header">
        <h2 class="h5 mb-0 section-title">
            <i class="bi bi-bar-chart-line"></i>
            <span>Statistik Pendaftar per Periode</span>
        </h2>
    </div>
    <div class="p-4">
        @if($periodes->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bar-chart fs-1 d-block mb-2"></i>
                Belum ada data periode pendaftaran.
            </div>
        @else
            <canvas id="chartPeriode" height="100"></canvas>
        @endif
    </div>
</section>

{{-- Detail Klik Chart --}}
<section class="panel mt-3" id="detailPanel" style="display:none;">
    <div class="panel-header">
        <h2 class="h5 mb-0 section-title">
            <i class="bi bi-pie-chart"></i>
            <span id="detailJudul">Detail Periode</span>
        </h2>
        <button class="btn btn-light btn-sm" onclick="tutupDetail()">
            <i class="bi bi-x me-1"></i>Tutup
        </button>
    </div>
    <div class="p-4">
        <div class="row g-3" id="detailCards"></div>
    </div>
</section>

@endsection

@section('js')
<script>
const periodeData = @json($periodes);

const labels  = periodeData.map(p => p.tahun_ajaran);
const totals  = periodeData.map(p => p.total);
const diterima = periodeData.map(p => p.diterima);
const ditolak  = periodeData.map(p => p.ditolak);

const ctx = document.getElementById('chartPeriode');
if (ctx) {
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Pendaftar',
                    data: totals,
                    backgroundColor: 'rgba(37, 99, 235, 0.7)',
                    borderColor: '#2563eb',
                    borderWidth: 1.5,
                    borderRadius: 6,
                },
                {
                    label: 'Diterima',
                    data: diterima,
                    backgroundColor: 'rgba(22, 121, 77, 0.7)',
                    borderColor: '#16794d',
                    borderWidth: 1.5,
                    borderRadius: 6,
                },
                {
                    label: 'Ditolak',
                    data: ditolak,
                    backgroundColor: 'rgba(192, 57, 43, 0.7)',
                    borderColor: '#c0392b',
                    borderWidth: 1.5,
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        footer: () => 'Klik untuk lihat detail'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            onClick: (e, elements) => {
                if (!elements.length) return;
                const idx = elements[0].index;
                tampilDetail(periodeData[idx]);
            },
            onHover: (e, elements) => {
                e.native.target.style.cursor = elements.length ? 'pointer' : 'default';
            }
        }
    });
}

function tampilDetail(p) {
    document.getElementById('detailJudul').textContent =
        'Detail Periode ' + p.tahun_ajaran;

    const belumSelesai = p.total - p.diterima - p.ditolak;
    const persen = (val) => p.total > 0 ? Math.round((val / p.total) * 100) : 0;

    document.getElementById('detailCards').innerHTML = `
        <div class="col-6 col-md-3">
            <div class="panel p-3 text-center">
                <p class="text-muted small mb-1">Total Pendaftar</p>
                <h3 class="fw-bold text-primary mb-0">${p.total}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="panel p-3 text-center">
                <p class="text-muted small mb-1">Diterima</p>
                <h3 class="fw-bold text-success mb-0">${p.diterima}</h3>
                <small class="text-muted">${persen(p.diterima)}% dari total</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="panel p-3 text-center">
                <p class="text-muted small mb-1">Ditolak</p>
                <h3 class="fw-bold text-danger mb-0">${p.ditolak}</h3>
                <small class="text-muted">${persen(p.ditolak)}% dari total</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="panel p-3 text-center">
                <p class="text-muted small mb-1">Masih Proses</p>
                <h3 class="fw-bold text-warning mb-0">${belumSelesai}</h3>
                <small class="text-muted">${persen(belumSelesai)}% dari total</small>
            </div>
        </div>
    `;

    const panel = document.getElementById('detailPanel');
    panel.style.display = 'block';
    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function tutupDetail() {
    document.getElementById('detailPanel').style.display = 'none';
}
</script>
@endsection