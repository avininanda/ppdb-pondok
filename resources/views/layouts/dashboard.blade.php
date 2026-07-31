<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPDB Nashirussunnah')</title>

    <link rel="stylesheet" href="{{ asset('adminhmd/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminhmd/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminhmd/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('adminhmd/css/dashboard-theme.css') }}">

    @yield('css')
</head>

<body>



{{-- Paksa tema terang selalu --}}
<script>
    localStorage.setItem('adminHMD.colorTheme', 'light');
    document.documentElement.setAttribute('data-theme', 'light');
</script>

<div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a class="brand-mark" href="#">
                <span class="brand-icon">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="width:28px;">
                </span>
                <span class="brand-copy">
                    <span class="brand-title">Nashirussunnah</span>
                    <span class="brand-subtitle">PPDB {{ date('Y') }}/{{ date('Y')+1 }}</span>
                </span>
            </a>
        </div>

        <nav class="sidebar-nav">
            @auth
                {{-- Menu Panitia --}}
                @if(auth()->user()->isPanitia())
                    <a class="nav-link {{ request()->routeIs('panitia.dashboard') ? 'active' : '' }}"
                        href="{{ route('panitia.dashboard') }}">
                        <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('informasi.*') ? 'active' : '' }}"
                        href="{{ route('informasi.index') }}">
                        <span class="nav-icon"><i class="bi bi-megaphone"></i></span>
                        <span class="nav-text">Kelola Informasi</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('periode.*') ? 'active' : '' }}"
                        href="{{ route('periode.index') }}">
                        <span class="nav-icon"><i class="bi bi-calendar-range"></i></span>
                        <span class="nav-text">Periode Pendaftaran</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('panitia.pendaftar') ? 'active' : '' }}"
                        href="{{ route('panitia.pendaftar') }}">
                        <span class="nav-icon"><i class="bi bi-people"></i></span>
                        <span class="nav-text">Kelola Pendaftar</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('panitia.kelola.jadwal') ? 'active' : '' }}"
                        href="{{ route('panitia.kelola.jadwal') }}">
                        <span class="nav-icon"><i class="bi bi-calendar-check"></i></span>
                        <span class="nav-text">Kelola Jadwal</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('panitia.kelola.hasil') ? 'active' : '' }}"
                        href="{{ route('panitia.kelola.hasil') }}">
                        <span class="nav-icon"><i class="bi bi-clipboard-check"></i></span>
                        <span class="nav-text">Kelola Hasil Tes</span>
                    </a>
                @endif

                {{-- Menu Pimpinan --}}
                @if(auth()->user()->isPimpinan())
                    <a class="nav-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}"
                        href="{{ route('pimpinan.dashboard') }}">
                        <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('pimpinan.laporan') ? 'active' : '' }}"
                        href="{{ route('pimpinan.laporan') }}">
                        <span class="nav-icon"><i class="bi bi-bar-chart"></i></span>
                        <span class="nav-text">Laporan</span>
                    </a>
                @endif

                {{-- Menu Calon Santri --}}
                @if(auth()->user()->isCalonSantri())
                <a class="nav-link {{ request()->routeIs('santri.dashboard') ? 'active' : '' }}"
                    href="{{ route('santri.dashboard') }}">
                    <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
               <a class="nav-link {{ request()->routeIs('pendaftaran.step*') || request()->routeIs('pendaftaran.preview') || request()->routeIs('pendaftaran.detail') ? 'active' : '' }}"
                    href="{{ isset($pendaftaranSantri) && $pendaftaranSantri?->isSubmitted() ? route('pendaftaran.detail') : route('pendaftaran.step1') }}">
                    <span class="nav-icon"><i class="bi bi-file-earmark-text"></i></span>
                    <span class="nav-text">
                        {{ isset($pendaftaranSantri) && $pendaftaranSantri?->isSubmitted() ? 'Data Pendaftaran' : 'Input Pendaftaran' }}
                    </span>
                </a>
                {{-- Status Pendaftaran hanya aktif kalau di halaman status --}}
                <a class="nav-link {{ request()->routeIs('pendaftaran.status') ? 'active' : '' }}"
                    href="{{ route('pendaftaran.status') }}">
                    <span class="nav-icon"><i class="bi bi-info-circle"></i></span>
                    <span class="nav-text">Lihat Status Pendaftaran</span>
                </a>
            @endif
            @endauth
        </nav>

        {{-- User Info --}}
        <div class="sidebar-user">
            <div>
                <strong>{{ auth()->user()->name ?? '' }}</strong>
                <small>{{ ucfirst(auth()->user()->role ?? '') }}</small>
            </div>
        </div>

        {{-- Footer Sidebar --}}
        <div class="sidebar-footer">
            <span class="status-dot"></span>
            <span class="sidebar-footer-text">PPDB Nashirussunnah</span>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="admin-main">

        {{-- Navbar --}}
        <nav class="navbar admin-navbar navbar-expand bg-white">
            <div class="container-fluid px-3 px-lg-4">
                <button class="sidebar-toggle" type="button" data-sidebar-toggle>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                {{-- Nama Halaman --}}
                <span class="ms-3 fw-semibold text-muted" style="font-size:14px;">
                    @yield('page_title', 'Dashboard')
                </span>

                {{-- Kanan Navbar --}}
                <div class="navbar-actions ms-auto">
                    <div class="dropdown">
                        <button class="profile-button dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            <span class="profile-name d-none d-sm-inline" style="font-size:13px;">
                                {{ auth()->user()->name ?? '' }}
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text text-muted" style="font-size:12px;">
                                    {{ ucfirst(auth()->user()->role ?? '') }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-left me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Page Content --}}
        <main class="dashboard-content">
            <div class="container-fluid px-3 px-lg-4 py-4">

                {{-- Alert Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Alert Error --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Alert Info --}}
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Konten Halaman --}}
                @yield('content')

            </div>
        </main>

        {{-- Footer --}}
        <footer class="admin-footer">
            <div class="container-fluid px-3 px-lg-4">
                <span>© {{ date('Y') }} PPDB Pondok Pesantren Tahfidz Nashirussunnah</span>
            </div>
        </footer>

    </div>
</div>

<script src="{{ asset('adminhmd/js/bootstrap.bundle.min.js') }}"></script>
<script>
    window.adminHMDUser = {
        name: @json(auth()->user()->name ?? ''),
        workspace: @json(ucfirst(auth()->user()->role ?? '')),
        avatar: "{{ asset('assets/img/logo.png') }}"
    };
</script>
<script src="{{ asset('adminhmd/js/main.js') }}"></script>

@yield('js')
</body>
</html>