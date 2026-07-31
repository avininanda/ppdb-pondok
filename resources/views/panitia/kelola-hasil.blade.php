@extends('layouts.dashboard')

@section('title', 'Kelola Hasil Tes — PPDB Nashirussunnah')
@section('page_title', 'Kelola Hasil Tes')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-clipboard-check"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Kelola Hasil Tes</h1>
            <p class="text-muted mb-0">
                Pendaftar yang sudah melaukan tes wawancara.
            </p>
        </div>
    </div>
</div>

<section class="panel mt-4">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0 section-title d-flex align-items-center">
            <i class="bi bi-table me-2"></i>
            <span>
                Daftar Pendaftar 
            </span>
        </h2>

        <!-- DROPDOWN FILTER DI SEBELAH KANAN HEADER -->
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle px-3 rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-funnel me-1"></i>
                Filter: 
                <strong>
                    @if($filter === 'all') Semua (@endif
                    @if($filter === 'belum_dinilai') ⏳ Belum Dinilai (@endif
                    @if($filter === 'sudah_dinilai') ✅ Sudah Dinilai (@endif
                    {{ $counts[$filter] }})
                </strong>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $filter === 'all' ? 'active' : '' }}" 
                       href="{{ route('panitia.kelola.hasil', ['filter' => 'all']) }}">
                        <span>Semua Data</span>
                        <span class="badge text-bg-secondary ms-3">{{ $counts['all'] }}</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $filter === 'belum_dinilai' ? 'active' : '' }}" 
                       href="{{ route('panitia.kelola.hasil', ['filter' => 'belum_dinilai']) }}">
                        <span>Belum Dinilai</span>
                        <span class="badge text-bg-warning ms-3">{{ $counts['belum_dinilai'] }}</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $filter === 'sudah_dinilai' ? 'active' : '' }}" 
                       href="{{ route('panitia.kelola.hasil', ['filter' => 'sudah_dinilai']) }}">
                        <span>Sudah Dinilai</span>
                        <span class="badge text-bg-success ms-3">{{ $counts['sudah_dinilai'] }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Pendaftar</th>
                    <th>Asal Sekolah</th>
                    <th>Jadwal Tes</th>
                    <th>Hasil Tes</th>
                    <th class="text-center" style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftars as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <p class="fw-semibold mb-0">{{ $p->nama }}</p>
                        <p class="text-muted small mb-0">{{ $p->user->email ?? '-' }}</p>
                    </td>
                    <td>{{ $p->asal_sekolah }}</td>
                    <td>
                        <span class="small fw-semibold">
                            {{ \Carbon\Carbon::parse($p->jadwal->tanggal_tes)->format('d M Y') }}
                            {{ $p->jadwal->jam_tes }}
                        </span>
                    </td>
                    <td>
                        @if($p->hasilTes)
                            <span class="badge {{ $p->hasilTes->hasil === 'lulus' ? 'text-bg-success' : 'text-bg-danger' }}">
                                {{ ucfirst($p->hasilTes->hasil) }}
                            </span>
                        @else
                            <span class="badge text-bg-warning">Belum Ada</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('panitia.hasil.create', $p->id) }}"
                            class="btn btn-sm {{ $p->hasilTes ? 'btn-outline-primary' : 'btn-primary' }}">
                            <i class="bi bi-{{ $p->hasilTes ? 'pencil' : 'plus-circle' }} me-1"></i>
                            {{ $p->hasilTes ? 'Edit' : 'Input Hasil' }}
                        </a>
                        @if($p->hasilTes)
                            <form method="POST"
                                action="{{ route('panitia.hasil.hapus', $p->hasilTes->id) }}"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Yakin hapus hasil tes ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Tidak ada pendaftar dalam kategori ini.<br>
                        <small>Silakan cek opsi filter lainnya.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection