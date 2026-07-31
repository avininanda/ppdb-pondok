@extends('layouts.dashboard')

@section('title', 'Periode Pendaftaran — PPDB Nashirussunnah')
@section('page_title', 'Periode Pendaftaran')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-calendar-range"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Periode Pendaftaran</h1>
            <p class="text-muted mb-0">Atur kapan pendaftaran dibuka & ditutup.</p>
        </div>
    </div>
    <div class="heading-actions">
        <a href="{{ route('periode.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Periode
        </a>
    </div>
</div>

<section class="panel mt-3">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Tahun Ajaran</th>
                    <th>Tanggal Buka</th>
                    <th>Tanggal Tutup</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periodes as $p)
                <tr>
                    <td class="fw-semibold">{{ $p->tahun_ajaran }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_buka)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_tutup)->format('d M Y') }}</td>
                    <td>
                        @if($p->is_aktif)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Nonaktif</span>
                        @endif

                        @if($p->is_aktif && $p->sedangDibuka())
                            <span class="badge text-bg-primary">Sedang Dibuka</span>
                        @elseif($p->is_aktif && !$p->sedangDibuka())
                            <span class="badge text-bg-warning">Di Luar Rentang Tanggal</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('periode.edit', $p->id) }}"
                            class="btn btn-light btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form method="POST" action="{{ route('periode.destroy', $p->id) }}"
                            class="d-inline" onsubmit="return confirm('Yakin ingin hapus periode {{ $p->tahun_ajaran }}? Data riwayat periode ini akan hilang permanen.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light btn-sm text-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        Belum ada periode pendaftaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection