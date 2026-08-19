@extends('layouts.dashboard')

@section('title', 'Kelola Jadwal — PPDB Nashirussunnah')
@section('page_title', 'Kelola Jadwal Wawancara')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-calendar-check"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Kelola Jadwal Tes</h1>
            <p class="text-muted mb-0">
                Pendaftar yang sudah diverifikasi berkasnya.
            </p>
        </div>
    </div>
</div>

<section class="panel mt-4">
   <div class="panel-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h2 class="h5 mb-0 section-title d-flex align-items-center">
        <i class="bi bi-table me-2"></i>
        <span>
            Daftar Pendaftar Terverifikasi 
        </span>
    </h2>

    <div class="d-flex align-items-center gap-2">
        {{-- Filter Tanggal --}}
        <form method="GET" action="{{ route('panitia.kelola.jadwal') }}" class="d-flex align-items-center gap-2">
            <input type="hidden" name="filter" value="{{ $filter }}">
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                class="form-control form-control-sm" style="width: 160px;"
                onchange="this.form.submit()">
            @if($tanggal)
                <a href="{{ route('panitia.kelola.jadwal', ['filter' => $filter]) }}"
                    class="btn btn-outline-secondary btn-sm" title="Hapus filter tanggal">
                    <i class="bi bi-x"></i>
                </a>
            @endif
        </form>

        <!-- DROPDOWN DI SEBELAH KANAN HEADER -->
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle px-3 rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-funnel me-1"></i>
                Filter: 
                <strong>
                    @if($filter === 'all') Semua (@endif
                    @if($filter === 'belum') Belum Dijadwalkan (@endif
                    @if($filter === 'wawancara_ulang') Wawancara Ulang (@endif
                    @if($filter === 'dijadwalkan') Sudah Dijadwalkan (@endif
                    {{ $counts[$filter] }})
                </strong>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $filter === 'all' ? 'active' : '' }}" 
                       href="{{ route('panitia.kelola.jadwal', ['filter' => 'all']) }}">
                        <span>Semua Pendaftar</span>
                        <span class="badge text-bg-secondary ms-3">{{ $counts['all'] }}</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $filter === 'belum' ? 'active' : '' }}" 
                       href="{{ route('panitia.kelola.jadwal', ['filter' => 'belum']) }}">
                        <span>Belum Dijadwalkan</span>
                        <span class="badge text-bg-warning ms-3">{{ $counts['belum'] }}</span>
                    </a>
                </li>
                {{-- 👇 TAMBAHAN MENU DROPDOWN FILTER WAWANCARA ULANG 👇 --}}
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $filter === 'wawancara_ulang' ? 'active' : '' }}" 
                       href="{{ route('panitia.kelola.jadwal', ['filter' => 'wawancara_ulang']) }}">
                        <span>Wawancara Ulang</span>
                        <span class="badge text-bg-info ms-3">{{ $counts['wawancara_ulang'] }}</span>
                    </a>
                </li>
                {{-- ------------------------------------------------ --}}
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $filter === 'dijadwalkan' ? 'active' : '' }}" 
                       href="{{ route('panitia.kelola.jadwal', ['filter' => 'dijadwalkan']) }}">
                        <span>Sudah Dijadwalkan</span>
                        <span class="badge text-bg-success ms-3">{{ $counts['dijadwalkan'] }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div> 
</div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th class="text end" style="width: 20px;">No</th>
                    <th>Nama Pendaftar</th>
                    <th>Asal Sekolah</th>
                    <th>Status Jadwal</th>
                    <th>Tanggal & Jam</th>
                    <th>Link Tes</th>
                    <th>Status Tes</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pendaftars as $index => $p)
            <tr class="{{ $p->jadwal && !$p->jadwal->sudah_dilaksanakan && \Carbon\Carbon::parse($p->jadwal->tanggal_tes)->isToday() ? 'table-warning' : '' }}">
                <td>{{ $index + 1 }}</td>
                <td>
                    <p class="fw-semibold mb-0">
                        {{ $p->nama }}
                        @if($p->jadwal && !$p->jadwal->sudah_dilaksanakan && \Carbon\Carbon::parse($p->jadwal->tanggal_tes)->isToday())
                            <span class="badge text-bg-warning ms-1">Hari Ini</span>
                        @endif

                        {{-- 👇 TAMBAHAN BADGE PENANDA WAWANCARA ULANG 👇 --}}
                        @if($p->status_akhir === 'wawancara_ulang')
                            <span class="badge text-bg-info ms-1">🔄 Wawancara Ulang</span>
                        @endif
                        {{-- ----------------------------------------- --}}
                    </p>
                </td>
                <td>{{ $p->asal_sekolah }}</td>
                <td>
                    @if($p->jadwal)
                        <span class="badge text-bg-success">✅ Sudah Dijadwalkan</span>
                    @else
                        <span class="badge text-bg-warning">⏳ Belum Dijadwalkan</span>
                    @endif
                </td>
                   <td>
                        @if($p->jadwal)
                            <span class="fw-semibold small">
                                {{ \Carbon\Carbon::parse($p->jadwal->tanggal_tes)->format('d M Y') }}
                                {{ $p->jadwal->jam_tes }}
                            </span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                    @if($p->jadwal && $p->jadwal->link_tes)
                        <a href="{{ $p->jadwal->link_tes }}" target="_blank" class="small text-success text-decoration-none">
                            <i class="bi bi-camera-video me-1"></i>Buka Link
                        </a>
                    @else
                        <span class="text-muted small">—</span>
                    @endif
                </td>
                <td>
                    @if($p->jadwal)
                        @if($p->jadwal->sudah_dilaksanakan)
                            <span class="badge text-bg-info">✅ Sudah Dilaksanakan</span>
                        @else
                            <form method="POST" action="{{ route('panitia.jadwal.selesai', $p->jadwal->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success btn-sm"
                                    onclick="return confirm('Tandai wawancara {{ $p->nama }} sudah dilaksanakan?')">
                                    <i class="bi bi-check2 me-1"></i>Tandai Selesai
                                </button>
                            </form>
                        @endif
                    @else
                        <span class="text-muted small">—</span>
                    @endif
                </td>
                    <td class="text-end">
                        <a href="{{ route('panitia.jadwal.create', $p->id) }}"
                            class="btn btn-sm {{ $p->jadwal ? 'btn-outline-primary' : 'btn-primary' }}">
                            <i class="bi bi-{{ $p->jadwal ? 'pencil' : 'plus-circle' }} me-1"></i>
                            {{ $p->jadwal ? 'Edit' : 'Input Jadwal' }}
                        </a>
                        @if($p->jadwal)
                            <form method="POST"
                                action="{{ route('panitia.jadwal.hapus', $p->jadwal->id) }}"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Yakin hapus jadwal ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        @if($tanggal)
                            Tidak ada jadwal Tes wawancara pada tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}.
                        @else
                            Tidak ada pendaftar dalam kategori ini.<br>
                            <small>Silakan cek tab kategori lainnya.</small>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection