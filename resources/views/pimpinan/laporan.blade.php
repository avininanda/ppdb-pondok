@extends('layouts.dashboard')

@section('title', 'Laporan PPDB — PPDB Nashirussunnah')
@section('page_title', 'Laporan')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-bar-chart"></i></span>
        <div>
            <p class="eyebrow mb-1">Pimpinan</p>
            <h1 class="h3 mb-1">Laporan Lengkap PPDB</h1>
            <p class="text-muted mb-0">Seluruh data pendaftar yang sudah submit pendaftaran.</p>
        </div>
    </div>
    <div class="heading-actions d-flex gap-2 align-items-center">
    {{-- Filter Periode & Status --}}
    <form method="GET" action="{{ route('pimpinan.laporan') }}" class="d-flex gap-2">
        <select name="periode_id" class="form-select form-select-sm"
            onchange="this.form.submit()" style="min-width: 160px;">
            <option value="">Semua Periode</option>
            @foreach($periodes as $periode)
                <option value="{{ $periode->id }}"
                    {{ (string) $periodeId === (string) $periode->id ? 'selected' : '' }}>
                    {{ $periode->tahun_ajaran }}
                </option>
            @endforeach
        </select>

        <select name="status" class="form-select form-select-sm"
            onchange="this.form.submit()" style="min-width: 160px;">
            <option value="">Semua Status</option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="diverifikasi" {{ $status === 'diverifikasi' ? 'selected' : '' }}>Berkas Valid</option>
            <option value="revisi" {{ $status === 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
            <option value="diterima" {{ $status === 'diterima' ? 'selected' : '' }}>Diterima</option>
            <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
    </form>

        {{-- Export Excel --}}
        <a href="{{ route('pimpinan.laporan.export.excel', ['periode_id' => $periodeId, 'status' => $status]) }}"
            class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i>Export Excel
        </a>

        {{-- Export CSV 
        <a href="{{ route('pimpinan.laporan.export', ['periode_id' => $periodeId]) }}"
            class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i>Export CSV
        </a>
        --}}
    </div>
</div>

{{-- Tabel Lengkap --}}
<section class="panel mt-3">
    <div class="panel-header">
        <h2 class="h5 mb-0 section-title">
            <i class="bi bi-table"></i>
            <span>Daftar Pendaftar</span>
        </h2>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Pendaftaran</th>
                    <th>Nama</th>
                    <th>Asal Sekolah</th>
                    <th>Hafalan</th>
                    <th>Periode</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Hasil Tes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftars as $index => $p)
                <tr>
                    <td class="text-muted">{{ $index + 1 }}</td>
                    <td class="text-muted">{{ $p->nomor_pendaftaran ?? '-' }}</td>
                    <td class="fw-semibold">{{ $p->nama }}</td>
                    <td class="text-muted">{{ $p->asal_sekolah }}</td>
                    <td class="text-muted">{{ $p->hafalan ?? '-' }}</td>
                    <td class="text-muted">{{ $p->periode->tahun_ajaran ?? '-' }}</td>
                    <td class="text-muted">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                    <td>
                        {{-- Tampilkan status_akhir kalau sudah ada,
                            fallback ke status_verifikasi kalau belum --}}
                        @if($p->status_akhir === 'diterima')
                            <span class="badge text-bg-success">Diterima</span>
                        @elseif($p->status_akhir === 'ditolak')
                            <span class="badge text-bg-danger">Tidak Lulus</span>
                        @elseif($p->status_verifikasi === 'pending')
                            <span class="badge text-bg-warning">Pending</span>
                        @elseif($p->status_verifikasi === 'diverifikasi')
                            <span class="badge text-bg-info">Berkas Valid</span>
                        @elseif($p->status_verifikasi === 'revisi')
                            <span class="badge text-bg-warning">Perlu Revisi</span>
                        @elseif($p->status_verifikasi === 'ditolak')
                            <span class="badge text-bg-danger">Ditolak (Berkas)</span>
                        @endif
                    </td>
                    <td>
                        @if($p->hasilTes)
                            <span class="fw-semibold {{ $p->hasilTes->hasil === 'lulus' ? 'text-success' : 'text-danger' }} small">
                                {{ ucfirst($p->hasilTes->hasil) }}
                            </span>
                        @else
                            <span class="text-muted small">Belum ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada data pendaftar untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection