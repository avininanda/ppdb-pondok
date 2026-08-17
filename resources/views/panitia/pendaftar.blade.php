@extends('layouts.dashboard')

@section('title', 'Kelola Pendaftar — PPDB Nashirussunnah')
@section('page_title', 'Kelola Pendaftar')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-people"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Kelola Pendaftar</h1>
            <p class="text-muted mb-0">Verifikasi berkas calon santri yang sudah mendaftar.</p>
        </div>
    </div>
</div>

<section class="panel mt-3">
    <div class="panel-header">
        <div>
            <h2 class="h5 mb-0 section-title">
                <i class="bi bi-table"></i>
                <span>Daftar Pendaftar</span>
            </h2>
        </div>
        {{-- Search --}}
        <form method="GET" action="{{ route('panitia.pendaftar') }}">
            <div class="input-group input-group-sm" style="width:250px;">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari nama / no. pendaftaran..."
                    value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="sticky-top bg-white">
                <tr>
                    <th class="text-nowrap">No</th>
                    <th class="text-nowrap">No. Pendaftaran</th>
                    <th>Nama Pendaftar</th>
                    <th>Asal Sekolah</th>
                    <th class="text-nowrap">Tanggal Daftar</th>
                    <th class="text-center">Pembayaran</th>
                    <th class="text-center">Status Berkas</th>
                    <th class="text-center">Hasil Tes</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftars as $index => $p)
                <tr>
                    <td class="text-nowrap">{{ $pendaftars->firstItem() + $index }}</td>
                    <td class="text-nowrap">
                        <span class="fw-semibold">{{ $p->nomor_pendaftaran ?? '-' }}</span>
                    </td>
                    <td>
                        <p class="fw-semibold mb-0 text-truncate" style="max-width: 220px;">{{ $p->nama }}</p>
                        <p class="text-muted small mb-0">{{ $p->user->email ?? '-' }}</p>
                    </td>
                    <td class="text-truncate" style="max-width: 180px;">{{ $p->asal_sekolah }}</td>
                    <td class="text-nowrap">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>

                    {{-- Kolom Pembayaran --}}
                    <td>
                        @if($p->status_pembayaran === 'terverifikasi')
                            <span class="badge text-bg-success">
                                <i class="bi bi-check-circle me-1"></i>Valid
                            </span>
                        @elseif($p->status_pembayaran === 'menunggu_verifikasi')
                            <span class="badge text-bg-warning">
                                <i class="bi bi-clock me-1"></i>Perlu Dicek
                            </span>
                        @else
                            <span class="badge text-bg-secondary">
                                <i class="bi bi-dash me-1"></i>Belum Bayar
                            </span>
                        @endif
                    </td>

                    {{-- Kolom Status Berkas --}}
                    <td>
                        @if($p->status_verifikasi === 'pending')
                            <span class="badge text-bg-warning">
                                <i class="bi bi-hourglass me-1"></i>Menunggu
                            </span>
                        @elseif($p->status_verifikasi === 'diverifikasi')
                            <span class="badge text-bg-success">
                                <i class="bi bi-check-circle me-1"></i>Berkas Valid
                            </span>
                        @elseif($p->status_verifikasi === 'revisi')
                            <span class="badge text-bg-warning">
                                <i class="bi bi-exclamation-circle me-1"></i>Perlu Revisi
                            </span>
                        @elseif($p->status_verifikasi === 'ditolak')
                            <span class="badge text-bg-danger">
                                <i class="bi bi-x-circle me-1"></i>Ditolak
                            </span>
                        @endif
                    </td>

                    {{-- Kolom Hasil Tes --}}
                    <td>
                        @if($p->hasilTes)
                            @if($p->hasilTes->hasil === 'lulus')
                                <span class="badge text-bg-success">
                                    <i class="bi bi-trophy me-1"></i>Lulus
                                </span>
                            @else
                                <span class="badge text-bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>Tidak Lulus
                                </span>
                            @endif
                        @else
                            <span class="badge text-bg-secondary">
                                <i class="bi bi-dash me-1"></i>Belum Ada
                            </span>
                        @endif
                    </td>

                    <td class="text-end">
                        <a href="{{ route('panitia.detail', $p->id) }}"
                            class="btn btn-light btn-sm">
                            <i class="bi bi-eye me-1"></i>Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada pendaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pendaftars->hasPages())
    <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
        <p class="text-muted small mb-0">
            Menampilkan {{ $pendaftars->firstItem() }}–{{ $pendaftars->lastItem() }}
            dari {{ $pendaftars->total() }} pendaftar
        </p>
        {{ $pendaftars->links() }}
    </div>
    @endif
</section>

@endsection