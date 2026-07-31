@extends('layouts.dashboard')

@section('title', 'Kelola Informasi — PPDB Nashirussunnah')
@section('page_title', 'Kelola Informasi')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-megaphone"></i></span>
        <div>
            <p class="eyebrow mb-1">Panitia PPDB</p>
            <h1 class="h3 mb-1">Kelola Informasi</h1>
            <p class="text-muted mb-0">Pengumuman & persyaratan yang tampil di landing page.</p>
        </div>
    </div>
    <div class="heading-actions">
        <a href="{{ route('informasi.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Informasi
        </a>
    </div>
</div>

{{-- Pengumuman --}}
<section class="panel mt-3">
    <div class="panel-header">
        <h2 class="h5 mb-0 section-title">
            <i class="bi bi-megaphone"></i>
            <span>Pengumuman</span>
        </h2>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">Urutan</th>
                    <th>Judul</th>
                    <th>Konten</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($informasis->where('kategori', 'pengumuman') as $info)
                <tr>
                    <td>{{ $info->urutan }}</td>
                    <td class="fw-semibold">{{ $info->judul }}</td>
                    <td class="text-muted" style="max-width:300px;">
                        {{ \Illuminate\Support\Str::limit($info->konten, 60) }}
                    </td>
                    <td>
                        @if($info->is_aktif)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('informasi.edit', $info->id) }}"
                            class="btn btn-light btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('informasi.destroy', $info->id) }}"
                            class="d-inline" onsubmit="return confirm('Yakin ingin hapus informasi ini?')">
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
                        Belum ada pengumuman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- Persyaratan --}}
<section class="panel mt-3">
    <div class="panel-header">
        <h2 class="h5 mb-0 section-title">
            <i class="bi bi-card-checklist"></i>
            <span>Persyaratan Pendaftaran</span>
        </h2>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">Urutan</th>
                    <th>Judul</th>
                    <th>Konten</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($informasis->where('kategori', 'persyaratan') as $info)
                <tr>
                    <td>{{ $info->urutan }}</td>
                    <td class="fw-semibold">{{ $info->judul }}</td>
                    <td class="text-muted" style="max-width:300px;">
                        {{ \Illuminate\Support\Str::limit($info->konten, 60) }}
                    </td>
                    <td>
                        @if($info->is_aktif)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('informasi.edit', $info->id) }}"
                            class="btn btn-light btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('informasi.destroy', $info->id) }}"
                            class="d-inline" onsubmit="return confirm('Yakin ingin hapus informasi ini?')">
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
                        Belum ada persyaratan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- Daftar Ulang --}}
<section class="panel mt-3">
    <div class="panel-header">
        <h2 class="h5 mb-0 section-title">
            <i class="bi bi-megaphone-fill"></i>
            <span>Daftar Ulang</span>
        </h2>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">Urutan</th>
                    <th>Judul</th>
                    <th>Konten</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($informasis->where('kategori', 'daftar_ulang') as $info)
                <tr>
                    <td>{{ $info->urutan }}</td>
                    <td class="fw-semibold">{{ $info->judul }}</td>
                    <td class="text-muted" style="max-width:300px;">
                        {{ \Illuminate\Support\Str::limit($info->konten, 60) }}
                    </td>
                    <td>
                        @if($info->is_aktif)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('informasi.edit', $info->id) }}"
                            class="btn btn-light btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('informasi.destroy', $info->id) }}"
                            class="d-inline" onsubmit="return confirm('Yakin ingin hapus informasi ini?')">
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
                        Belum ada informasi daftar ulang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>


@endsection