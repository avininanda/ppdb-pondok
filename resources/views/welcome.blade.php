<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>PPDB Pondok Pesantren Tahfidz Nashirussunnah</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="PPDB, pondok pesantren tahfidz, studi Al-Quran, bahasa Arab, Nashirussunnah" name="keywords">
    <meta content="Sistem informasi penerimaan santri baru Pondok Pesantren Tahfidz Nashirussunnah studi Al-Quran dan bahasa Arab." name="description">

    <link href="{{ asset('assets/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Saira:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
@php
    $pendaftaranDibuka = $periodeAktif && $periodeAktif->sedangDibuka();

    // Pesan status yang lebih jelas untuk tombol nonaktif
    $statusTutup = 'Pendaftaran Belum Dibuka';
    
    if ($periodeAktif) {
        if ($periodeAktif->belumDibuka()) {
            $statusTutup = 'Pendaftaran Belum Dibuka';
        } elseif ($periodeAktif->sudahTutup()) {
            $statusTutup = 'Pendaftaran Telah Ditutup';
        }
    }
@endphp

    <!-- Navbar Start -->
     <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar text-white-50 row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>Jl. H. Gofur, Cilame, Kec. Ngamprah, Kabupaten Bandung Barat, Jawa Barat</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Ikuti Kami:</small>
                <a class="text-white-50 ms-3" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="text-white-50 ms-3" href="tahfiznashirussunnah@gmail.com"><i class="fas fa-envelope"></i></a>
                <a class="text-white-50 ms-3" href="https://www.instagram.com/ptqnashirussunnah"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="/" class="navbar-brand ms-4 ms-lg-0">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Pondok Pesantren Nashirussunnah" class="navbar-logo">
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="#beranda" class="nav-item nav-link">Beranda</a>
                    <a href="#tentang" class="nav-item nav-link">Tentang</a>
                    <a href="#kurikulum" class="nav-item nav-link">Kurikulum</a>
                    <a href="#alur" class="nav-item nav-link">Alur PPDB</a>
                    <a href="#kegiatan" class="nav-item nav-link">Kegiatan</a>
                </div>
                    <div class="d-none d-lg-flex ms-lg-3">
                    @if($pendaftaranDibuka)
                        <a href="{{ route('register') }}" class="btn btn-primary py-2 px-4">Daftar</a>
                    @else
                        <button type="button" class="btn px-4 btn-closed-state" disabled>
                            <i class="fa fa-lock me-1"></i>Ditutup
                        </button>
                    @endif
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Carousel Start -->
    <section id="beranda">
        <div class="container-fluid p-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="w-100" src="{{ asset('assets/img/carousel-1.png') }}" alt="Pondok Pesantren Tahfidz Nashirussunnah">
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-9 pt-5">
                                        <div class="d-inline-block mb-4 animated slideInDown ppdb-badge-premium">
                                            <div class="badge-marquee-flex">
                                                <span class="badge-icon-alert"><i class="fa fa-bullhorn animate-pulse"></i></span>
                                                <div class="badge-marquee-viewport">
                                                    <div class="badge-marquee-track">
                                                    {{-- Info periode otomatis — selalu tampil --}}
                                                    <span class="text-uppercase text-white text-marquee-item">
                                                        @if($pendaftaranDibuka)
                                                            PPDB {{ $periodeAktif->tahun_ajaran }} Pondok Pesantren Tahfidz Nashirussunnah telah dibuka
                                                        @else
                                                            Informasi PPDB akan segera diperbarui oleh panitia
                                                        @endif
                                                    </span>

                                                    {{-- Pengumuman tambahan dari panitia, kalau ada --}}
                                                    @forelse($pengumumans as $info)
                                                        <span class="text-white-50 mx-3">&bull;</span>
                                                        <span class="text-uppercase text-white text-marquee-item">{{ $info->judul }}</span>
                                                    @empty
                                                    @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="hero-kicker animated slideInDown">Studi Al-Quran dan Bahasa Arab</p>
                                        <h1 class="display-4 text-white mb-3 animated slideInDown">PPDB Pondok Pesantren Tahfidz Nashirussunnah</h1>
                                        <p class="fs-5 text-white-50 mb-5 animated slideInDown">Membina Generasi Penghafal Al-Qur'an yang Berakhlak, Berprestasi, dan Bermanfaat bagi Sesama</p>
                                        <div class="hero-actions animated slideInDown">
                                        @if($pendaftaranDibuka)
                                            <a href="{{ route('register') }}" class="btn btn-primary py-3 px-5 rounded-pill">
                                                Daftar Sekarang <i class="fa fa-arrow-right ms-2"></i>
                                            </a>
                                        @else
                                            <button type="button" class="btn py-3 px-5 rounded-pill btn-closed-state" disabled>
                                                <i class="fa fa-lock me-2"></i>{{ $statusTutup }}
                                            </button>
                                        @endif
                                        <a href="#alur" class="btn btn-outline-light py-3 px-5 rounded-pill">Lihat Alur PPDB</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <!-- Carousel End -->

    <!-- About Start -->
    <section id="tentang" class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative overflow-hidden h-100 about-photo" style="min-height: 440px;">
                        <img class="position-absolute w-100 h-100 pt-5 pe-5" src="{{ asset('assets/img/about 1.png') }}" alt="Kegiatan santri" style="object-fit: cover;">
                        <img class="position-absolute top-0 end-0 bg-white ps-2 pb-2" src="{{ asset('assets/img/about 2.png') }}" alt="Pembelajaran Al-Quran" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="h-100">
                        <div class="d-inline-block rounded-pill bg-light text-dark py-1 px-3 mb-3">Tentang Kami</div>
                        <h2 class="display-6 mb-4">Mengenal Pesantren Kami</h2>
                        <div class="quote-panel p-4 mb-4">
                            <p class="text-dark mb-2 text-justify-custom">Mempelajari Al-Qur'an bukan sekadar kewajiban, melainkan solusi nyata atas berbagai permasalahan umat di akhir zaman ini. Jauhnya kaum muslimin dari Al-Qur'an menjadi akar kemunduran moral, ketertinggalan, dan kehinaan yang terus melanda. Maka, jalan satu-satunya untuk bangkit adalah kembali kepada petunjuk Ilahi dengan membaca, memahami, dan mengamalkan isinya.</p>
                            <p class="text-dark mb-2 text-justify-custom">Berangkat dari kesadaran inilah, Pondok Pesantren Tahfizh Al-Qur'an dan Dirosah Islamiyyah Nashirussunnah Bandung Barat hadir di bawah naungan Yayasan Islam Nashirusunnah Permata (YASHIRUNA). Kami berdiri dengan semangat integrasi antara wahyu dan sains, untuk mencetak generasi muslim yang kuat secara spiritual, mandiri, dan penuh manfaat bagi umat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About End -->

    <!-- Visi Misi Start -->
    <section id="visi-misi" class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="vision-card h-100">
                        <div class="d-inline-block rounded-pill bg-light text-dark  py-1 px-3 mb-3">Visi</div>
                        <h2 class="display-6 mb-4">Melahirkan Mukmin Quraniy</h2>
                        <p class="mb-0">Melahirkan mukmin quraniy yang kuat dalam hafalan, tadabbur, dan pengamalan. Mahir ilmu-ilmu keislaman dan menjadi da'i berakhlak mulia serta penuh manfaat.</p>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="mission-card h-100">
                        <div class="d-inline-block rounded-pill bg-light text-dark py-1 px-3 mb-3">Misi</div>
                        <ul class="mission-list">
                            <li>Menyelenggarakan pembelajaran Al-Qur'an dari segi al-hifzhu atau hafalan, fahmul ma'aani atau pemahaman, dan tathbiiqul 'amaliy atau pengamalan.</li>
                            <li>Menyediakan fasilitas yang maksimal untuk pembelajaran Al-Qur'an dan Dirosah Islamiyah.</li>
                            <li>Membekali santri hal-hal yang urgen untuk menghadapi tantangan dakwah dan menegakkan amar ma'ruf nahi munkar.</li>
                            <li>Membangun manhaj yang lurus, ahlussunnah wal jama'ah, berlandaskan pada Al-Qur'an dan Sunnah sesuai pemahaman para sahabat dan ulama mu'tabar.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Visi Misi End -->

    <!-- Kurikulum Start -->
    <section id="kurikulum" class="container-xxl bg-light my-5 py-5">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 760px;">
                <h2 class="display-6 mb-3">Kurikulum Khas 4T dan 1K</h2>
                <p>Program unggulan Ponpes Tahfizhul Qur'an dan Dirosah Islamiyyah Nashirussunnah dikemas dalam kurikulum khas 4T dan 1K.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="curriculum-card h-100">
                        <span class="curriculum-number">01</span>
                        <h4>Ta'dib</h4>
                        <p>Membentuk karakter mahasantri yang berakhlaqul karimah, disiplin, taat syari'ah, hormat dan berbakti kepada orang tua, guru, dan lembaga.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="curriculum-card h-100">
                        <span class="curriculum-number">02</span>
                        <h4>Ta'lim</h4>
                        <p>Membentuk pola pikir dan wawasan keislaman yang pertengahan atau wasathiyah sesuai manhaj ahlussunnah waljama'ah dalam aqidah, syari'ah, ibadah, dan muamalah.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="curriculum-card h-100">
                        <span class="curriculum-number">03</span>
                        <h4>Tahfizh</h4>
                        <p>Menghasilkan kader penghafal Al-Quran yang mahir membaca, kuat hafalan, lurus pemahaman makna, dan konsisten dalam pengamalan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="curriculum-card h-100">
                        <span class="curriculum-number">04</span>
                        <h4>Tadrib</h4>
                        <p>Menghasilkan kader penghafal Al-Quran yang memiliki bekal kemandirian dan keterampilan muamalah atau life skill yang bermanfaat bagi pribadi, keluarga, dan masyarakat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="curriculum-card h-100">
                        <span class="curriculum-number">05</span>
                        <h4>Khodimul Ummah</h4>
                        <p>Menghasilkan lulusan yang memiliki kesadaran dan kesiapan mental untuk berkhidmat, memberi manfaat seluas-luasnya untuk umat, masyarakat, bangsa, dan negara dalam bingkai NKRI.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <!-- Kurikulum End -->

    <section id="alur" class="container-fluid donate my-5 py-5" data-parallax="scroll" data-image-src="{{ asset('assets/img/carousel-2.jpg') }}">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 720px;">
                <div class="d-inline-block rounded-pill bg-light text-dark  py-1 px-3 mb-3">Alur Pendaftaran</div>
                <p class="text-white-50 mb-0">Alur pendaftaran dalam penerimaan calon santri baru di Pondok Pesantren Nashirussunnah</p>
            </div>
           <div class="row g-3">

            {{-- Step 1 --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="flow-card h-100">
                    <span>01</span>
                    <div class="flow-icon mb-3">
                        <i class="bi bi-file-text fs-1" style="color:#C9A84C;"></i>
                    </div>
                    <h5>Baca Informasi PPDB</h5>
                    <p>Baca syarat pendaftaran dan dokumen yang diperlukan sebelum mulai mendaftar.</p>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="flow-card h-100">
                    <span>02</span>
                    <div class="flow-icon mb-3">
                        <i class="bi bi-person-plus fs-1" style="color:#C9A84C;"></i>
                    </div>
                    <h5>Buat Akun & Masuk</h5>
                    <p>Klik tombol <strong>"Daftar"</strong>, isi nama, email, dan password. Lalu masuk ke akun kamu.</p>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="flow-card h-100">
                    <span>03</span>
                    <div class="flow-icon mb-3">
                        <i class="bi bi-pencil-square fs-1" style="color:#C9A84C;"></i>
                    </div>
                    <h5>Isi Formulir Online</h5>
                    <p>Isi data diri calon santri dan data orang tua secara lengkap melalui formulir bertahap.</p>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="flow-card h-100">
                    <span>04</span>
                    <div class="flow-icon mb-3">
                        <i class="bi bi-upload fs-1" style="color:#C9A84C;"></i>
                    </div>
                    <h5>Upload Berkas & Bukti Bayar</h5>
                    <p>Upload foto/scan KK, Akte Kelahiran, Ijazah, dan bukti transfer biaya pendaftaran.</p>
                </div>
            </div>

            {{-- Step 5 --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="flow-card h-100">
                    <span>05</span>
                    <div class="flow-icon mb-3">
                        <i class="bi bi-camera-video fs-1" style="color:#C9A84C;"></i>
                    </div>
                    <h5>Verifikasi & Tes Wawancara</h5>
                    <p>Panitia memeriksa berkas kamu. Jika lolos, jadwal tes wawancara via Google Meet akan dikirim.</p>
                </div>
            </div>

            {{-- Step 6 --}}
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                <div class="flow-card h-100">
                    <span>06</span>
                    <div class="flow-icon mb-3">
                        <i class="bi bi-megaphone fs-1" style="color:#C9A84C;"></i>
                    </div>
                    <h5>Pengumuman & Daftar Ulang</h5>
                    <p>Cek hasil wawancara di akun kamu. Jika diterima, lakukan daftar ulang sesuai petunjuk panitia.</p>
                </div>
            </div>
    </section>

    {{-- ================================================
     SECTION TIMELINE PPDB
     Dinamis dari database periode pendaftaran
================================================ --}}
<section id="timeline" class="py-5" style="background: #f8f9fa;">
    <div class="container">

        {{-- Heading --}}
        <div class="text-center mb-5">
            <button class="btn btn-sm rounded-pill px-3 py-1 mb-3"
                style="background:rgba(201,168,76,0.15); color:#C9A84C; border:1px solid #C9A84C; font-size:13px;">
                Jadwal PPDB
            </button>
            <h2 class="fw-bold" style="color:#0a1628; font-size:2rem;">
                Timeline PPDB {{ $periode->tahun_ajaran ?? date('Y').'/'.date('Y', strtotime('+1 year')) }}
            </h2>
            <p class="text-muted">
                Jadwal lengkap pelaksanaan penerimaan peserta didik baru
            </p>
        </div>

        @if($periode)
        @php
            // Hitung tanggal otomatis dari periode
            $buka         = \Carbon\Carbon::parse($periode->tanggal_buka);
            $tutup        = \Carbon\Carbon::parse($periode->tanggal_tutup);
            $verifikasi   = $buka->copy()->addDays(3);  // 3 hari setelah buka
            $pengumuman   = $tutup->copy()->addDays(7); // 7 hari setelah tutup
            $wawancara    = $tutup->copy()->addDays(14); // 14 hari setelah tutup
            $hasilAkhir   = $tutup->copy()->addDays(21); // 21 hari setelah tutup
            $daftarUlang  = $tutup->copy()->addDays(28); // 28 hari setelah tutup
            $now          = \Carbon\Carbon::now();

            // Tentukan status tiap tahap
            $tahapan = [
                [
                    'nomor'    => '01',
                    'judul'    => 'Pendaftaran Dibuka',
                    'tanggal'  => $buka->format('d M Y'),
                    'deskripsi'=> 'Calon santri dapat mendaftar secara online melalui sistem PPDB.',
                    'icon'     => 'bi-door-open',
                    'selesai'  => $now->gte($buka),
                    'aktif'    => $now->gte($buka) && $now->lt($tutup),
                ],
                [
                    'nomor'    => '02',
                    'judul'    => 'Batas Akhir Pendaftaran',
                    'tanggal'  => $tutup->format('d M Y'),
                    'deskripsi'=> 'Pendaftaran ditutup. Pastikan seluruh berkas dan bukti pembayaran sudah diunggah.',
                    'icon'     => 'bi-calendar-x',
                    'selesai'  => $now->gte($tutup),
                    'aktif'    => $now->gte($verifikasi) && $now->lt($tutup),
                ],
                [
                    'nomor'    => '03',
                    'judul'    => 'Verifikasi Berkas',
                    'tanggal'  => $verifikasi->format('d M Y').' - '.$tutup->format('d M Y'),
                    'deskripsi'=> 'Panitia melakukan verifikasi kelengkapan berkas dan pembayaran pendaftar.',
                    'icon'     => 'bi-file-earmark-check',
                    'selesai'  => $now->gte($tutup),
                    'aktif'    => $now->gte($verifikasi) && $now->lt($tutup),
                ],
                [
                    'nomor'    => '04',
                    'judul'    => 'Tes Wawancara',
                    'tanggal'  => $wawancara->format('d M Y'),
                    'deskripsi'=> 'Calon santri yang lolos verifikasi berkas mengikuti tes wawancara via Google Meet.',
                    'icon'     => 'bi-camera-video',
                    'selesai'  => $now->gte($wawancara),
                    'aktif'    => $now->gte($tutup) && $now->lt($hasilAkhir),
                ],
                [
                    'nomor'    => '05',
                    'judul'    => 'Pengumuman Hasil',
                    'tanggal'  => $hasilAkhir->format('d M Y'),
                    'deskripsi'=> 'Hasil seleksi wawancara diumumkan melalui akun masing-masing calon santri.',
                    'icon'     => 'bi-megaphone',
                    'selesai'  => $now->gte($hasilAkhir),
                    'aktif'    => $now->gte($wawancara) && $now->lt($daftarUlang),
                ],
                [
                    'nomor'    => '06',
                    'judul'    => 'Daftar Ulang',
                    'tanggal'  => $daftarUlang->format('d M Y'),
                    'deskripsi'=> 'Calon santri yang diterima wajib melakukan daftar ulang sesuai petunjuk panitia.',
                    'icon'     => 'bi-check-circle',
                    'selesai'  => $now->gte($daftarUlang),
                    'aktif'    => $now->gte($hasilAkhir),
                ],
            ];
        @endphp

        {{-- Timeline Desktop --}}
        <div class="d-none d-lg-block">

            {{-- Progress Bar Horizontal --}}
            <div class="position-relative mb-5">
                <div class="progress" style="height: 4px; background: #dee2e6;">
                    @php
                        $selesaiCount = collect($tahapan)->where('selesai', true)->count();
                        $persen = ($selesaiCount / count($tahapan)) * 100;
                    @endphp
                    <div class="progress-bar"
                        style="width: {{ $persen }}%; background: linear-gradient(90deg, #C9A84C, #a8872e);">
                    </div>
                </div>

                {{-- Dots --}}
                <div class="d-flex justify-content-between position-absolute w-100"
                    style="top: -8px;">
                    @foreach($tahapan as $tahap)
                        <div class="text-center" style="width: {{ 100/count($tahapan) }}%;">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                style="width:20px; height:20px;
                                background: {{ $tahap['selesai'] ? '#C9A84C' : ($tahap['aktif'] ? '#C9A84C' : '#dee2e6') }};
                                border: 3px solid {{ $tahap['selesai'] || $tahap['aktif'] ? '#C9A84C' : '#dee2e6' }};">
                                @if($tahap['selesai'])
                                    <i class="bi bi-check text-white" style="font-size:10px;"></i>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Cards Timeline --}}
            <div class="row g-3">
                @foreach($tahapan as $index => $tahap)
                <div class="col-lg-2">
                    <div class="card h-100 border-0 shadow-sm"
                        style="border-top: 3px solid {{ $tahap['selesai'] ? '#C9A84C' : ($tahap['aktif'] ? '#0a1628' : '#dee2e6') }} !important;
                               border-radius: 12px;">
                        <div class="card-body p-3">

                            {{-- Status Badge --}}
                            @if($tahap['aktif'] && !$tahap['selesai'])
                                <span class="badge mb-2"
                                    style="background:#0a1628; color:#C9A84C; font-size:10px;">
                                    🔵 Sedang Berlangsung
                                </span>
                            @elseif($tahap['selesai'])
                                <span class="badge mb-2"
                                    style="background:rgba(201,168,76,0.15); color:#C9A84C; font-size:10px;">
                                    ✅ Selesai
                                </span>
                            @else
                                <span class="badge mb-2"
                                    style="background:#f8f9fa; color:#adb5bd; font-size:10px;">
                                    ⏳ Akan Datang
                                </span>
                            @endif

                            {{-- Icon --}}
                            <div class="mb-2">
                                <i class="bi {{ $tahap['icon'] }}"
                                    style="font-size:1.5rem;
                                    color: {{ $tahap['selesai'] || $tahap['aktif'] ? '#C9A84C' : '#adb5bd' }};"></i>
                            </div>

                            {{-- Nomor --}}
                            <span class="fw-bold d-block mb-1"
                                style="color:#C9A84C; font-size:11px;">
                                TAHAP {{ $tahap['nomor'] }}
                            </span>

                            {{-- Judul --}}
                            <h6 class="fw-bold mb-1" style="color:#0a1628; font-size:13px;">
                                {{ $tahap['judul'] }}
                            </h6>

                            {{-- Tanggal --}}
                            <p class="mb-2"
                                style="color:#C9A84C; font-size:11px; font-weight:600;">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $tahap['tanggal'] }}
                            </p>

                            {{-- Deskripsi --}}
                            <p class="mb-0 text-muted" style="font-size:11px; line-height:1.5;">
                                {{ $tahap['deskripsi'] }}
                            </p>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        {{-- Timeline Mobile (Vertikal) --}}
        <div class="d-lg-none">
            <div class="position-relative">
                {{-- Garis vertikal --}}
                <div class="position-absolute"
                    style="left: 20px; top: 0; bottom: 0; width: 2px;
                           background: linear-gradient(180deg, #C9A84C, #dee2e6);">
                </div>

                @foreach($tahapan as $tahap)
                <div class="d-flex gap-3 mb-4 position-relative">

                    {{-- Dot --}}
                    <div class="rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center"
                        style="width:40px; height:40px; z-index:1;
                        background: {{ $tahap['selesai'] ? 'linear-gradient(135deg, #C9A84C, #a8872e)' : ($tahap['aktif'] ? '#0a1628' : '#f8f9fa') }};
                        border: 2px solid {{ $tahap['selesai'] || $tahap['aktif'] ? '#C9A84C' : '#dee2e6' }};">
                        <i class="bi {{ $tahap['icon'] }}"
                            style="font-size:16px;
                            color: {{ $tahap['selesai'] ? '#fff' : ($tahap['aktif'] ? '#C9A84C' : '#adb5bd') }};"></i>
                    </div>

                    {{-- Konten --}}
                    <div class="card border-0 shadow-sm flex-grow-1"
                        style="border-radius:12px;
                        border-left: 3px solid {{ $tahap['selesai'] ? '#C9A84C' : ($tahap['aktif'] ? '#0a1628' : '#dee2e6') }} !important;">
                        <div class="card-body p-3">
                            @if($tahap['aktif'] && !$tahap['selesai'])
                                <span class="badge mb-1"
                                    style="background:#0a1628; color:#C9A84C; font-size:10px;">
                                    🔵 Sedang Berlangsung
                                </span>
                            @elseif($tahap['selesai'])
                                <span class="badge mb-1"
                                    style="background:rgba(201,168,76,0.15); color:#C9A84C; font-size:10px;">
                                    ✅ Selesai
                                </span>
                            @endif
                            <h6 class="fw-bold mb-1" style="color:#0a1628;">
                                {{ $tahap['judul'] }}
                            </h6>
                            <p class="mb-1"
                                style="color:#C9A84C; font-size:12px; font-weight:600;">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $tahap['tanggal'] }}
                            </p>
                            <p class="mb-0 text-muted" style="font-size:12px;">
                                {{ $tahap['deskripsi'] }}
                            </p>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        {{-- Info Tambahan --}}
        <div class="row g-3 mt-4">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                    style="background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.3);">
                    <i class="bi bi-calendar-range fs-4" style="color:#C9A84C;"></i>
                    <div>
                        <p class="fw-bold mb-0 small" style="color:#0a1628;">Periode Pendaftaran</p>
                        <p class="mb-0 text-muted" style="font-size:12px;">
                            {{ $buka->format('d M Y') }} — {{ $tutup->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                    style="background:rgba(10,22,40,0.05); border:1px solid rgba(10,22,40,0.1);">
                    <i class="bi bi-clock-history fs-4" style="color:#0a1628;"></i>
                    <div>
                        <p class="fw-bold mb-0 small" style="color:#0a1628;">Sisa Waktu Pendaftaran</p>
                        <p class="mb-0 text-muted" style="font-size:12px;">
                            @if($now->lt($buka))
                                Dibuka {{ $buka->diffForHumans() }}
                            @elseif($now->between($buka, $tutup))
                                Ditutup {{ $tutup->diffForHumans() }}
                            @else
                                Pendaftaran telah ditutup
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                    style="background:rgba(22,121,77,0.08); border:1px solid rgba(22,121,77,0.2);">
                    <i class="bi bi-mortarboard fs-4" style="color:#16794d;"></i>
                    <div>
                        <p class="fw-bold mb-0 small" style="color:#0a1628;">Tahun Ajaran</p>
                        <p class="mb-0 text-muted" style="font-size:12px;">
                            {{ $periode->tahun_ajaran }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @else
        {{-- Kalau tidak ada periode aktif --}}
        <div class="text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
            <h5 class="text-muted">Jadwal PPDB belum tersedia</h5>
            <p class="text-muted small">Silakan pantau halaman ini untuk informasi lebih lanjut.</p>
        </div>
        @endif

    </div>
</section>

    <section id="pendaftaran" class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
               <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-inline-block rounded-pill bg-light text-dark py-1 px-3 mb-3">Persyaratan</div>
                    <h2 class="display-6 mb-4">Siapkan Data Sebelum Mendaftar</h2>
                    <ul class="requirement-list">
                        @forelse($persyaratans as $syarat)
                            <li><i class="fa fa-check-circle"></i> {{ $syarat->judul }}</li>
                        @empty
                            {{-- Fallback kalau panitia belum input persyaratan --}}
                            <li><i class="fa fa-file-alt"></i> Identitas calon santri dan data orang tua atau wali.</li>
                            <li><i class="fa fa-id-card"></i> Kartu keluarga, akta kelahiran, dan pas foto terbaru.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="cta-panel p-5">
                        <h3 class="text-white mb-3">Mulai Pendaftaran Online</h3>

                        {{-- Info periode pendaftaran --}}
                        @if($periodeAktif)
                            <p class="text-white-50 mb-2">
                                <i class="fa fa-calendar-alt me-2"></i>
                                Periode {{ $periodeAktif->tahun_ajaran }}:
                                {{ \Carbon\Carbon::parse($periodeAktif->tanggal_buka)->format('d M Y') }}
                                &ndash;
                                {{ \Carbon\Carbon::parse($periodeAktif->tanggal_tutup)->format('d M Y') }}
                            </p>
                        @endif

                        <p class="text-white-50 mb-4">Setelah membuat akun, calon santri dapat melengkapi formulir, mengunggah berkas, dan melihat status verifikasi langsung dari dashboard.</p>
                    @if($pendaftaranDibuka)
                        <a href="{{ route('register') }}" class="btn btn-primary py-3 px-5 rounded-pill">
                            Buat Akun PPDB <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    @else
                        <button type="button" class="btn py-3 px-5 rounded-pill btn-closed-state" disabled>
                            <i class="fa fa-lock me-2"></i>{{ $statusTutup }}
                        </button>
                    @endif
                        <a href="{{ route('login') }}" class="btn btn-outline-light py-3 px-5 rounded-pill ms-lg-2 mt-3 mt-lg-0">Masuk</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kegiatan Start -->
    <section id="kegiatan" class="container-xxl py-5">
        <div class="container">

            <div class="text-center mb-5">
                <div class="d-inline-block rounded-pill kegiatan-badge px-4 py-2 mb-3">
                    Kegiatan Pesantren
                </div>

                <p class="text-muted mx-auto" style="max-width:700px;">
                    Berbagai kegiatan yang dirancang untuk membentuk santri menjadi
                    Mukmin Qur'aniy, pribadi mandiri, berilmu, dan berakhlak mulia.
                </p>
            </div>

            <div class="owl-carousel kegiatan-carousel">

                <!-- Card 1 -->
                <div class="kegiatan-item">
                    <img src="{{ asset('assets/img/kegiatan-1.png') }}" alt="">

                    <div class="kegiatan-content">
                        <h5>Daurah Tamhidiyah</h5>
                        <p>
                            Kegiatan pembekalan santri baru sebelum memulai agenda di Pondok Pesantren Nashirussunnah.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="kegiatan-item">
                    <img src="{{ asset('assets/img/kegiatan-2.png') }}" alt="">

                    <div class="kegiatan-content">
                        <h5>Esktrakurikuler</h5>
                        <p>
                            Kegiatan esktrakurikuler pada Pondok Pesantren Nashirussunnah.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="kegiatan-item">
                    <img src="{{ asset('assets/img/kegiatan-3.png') }}" alt="">

                    <div class="kegiatan-content">
                        <h5>Wisuda Santri Nashirussunnah</h5>

                        <p>
                            Pelepasan santri dalam meneruskan pendidikan ke jenjang selanjutnya.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="kegiatan-item">
                    <img src="{{ asset('assets/img/kegiatan-4.png') }}" alt="">

                    <div class="kegiatan-content">
                        <h5>Tasmi Al-Qur'an</h5>

                        <p>
                            Kegiatan penyetoran hafalan Al-Qur'an oleh santri.
                        </p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="kegiatan-item">
                    <img src="{{ asset('assets/img/kegiatan-5.png') }}" alt="Kebersihan">

                    <div class="kegiatan-content">
                        <h5>Ujian Dirosah</h5>

                        <p>
                            Ujian dirosah bertujuan mengevaluasi perkembangan akademik santri.
                        </p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="kegiatan-item">
                    <img src="{{ asset('assets/img/kegiatan-6.png') }}" alt="Sosial">

                    <div class="kegiatan-content">
                        <h5>Khutbah Bahasa Arab </h5>

                        <p>
                            Santri menyampaikan khutbah dalam bahasa Arab sebagai sarana melatih kemampuan berbahasa Arab dan public speaking.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- Kegiatan End -->

    <div class="container-fluid bg-dark text-white-50 footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
               <div class="col-lg-4 col-md-6">
                    <h5 class="text-light mb-4">Lokasi Kami</h5>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.4159550810664!2d107.52598518066132!3d-6.84063307551457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e32227546c97%3A0xb225b5aa1193ab51!2sPonpes%20Tahfizh%20Qur&#39;an%20Nashirussunnah%20Pakuhaji%201!5e0!3m2!1sid!2sid!4v1783248501393!5m2!1sid!2sid" 
                        width="70%" 
                        height="150" 
                        style="border:0; border-radius: 8px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-light mb-4">Kontak</h5>
                    <p><i class="fa fa-map-marker-alt me-3"></i>Jl. H. Gofur, Cilame, Ngamprah</p>
                    <p><i class="fa fa-phone-alt me-3"></i>0857-7500-0894</p>
                    <p><i class="fa fa-envelope me-3"></i>ppdb@nashirussunnah.sch.id</p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-light mb-4">Navigasi</h5>
                    <a class="btn btn-link" href="#tentang">Tentang Kami</a>
                    <a class="btn btn-link" href="#kurikulum">Kurikulum 4T dan 1K</a>
                    <a class="btn btn-link" href="#alur">Alur Pendaftaran</a>
                    <a class="btn btn-link" href="#alur">Kegiatan</a>
                    @if($pendaftaranDibuka)
                        <a class="btn btn-link" href="{{ route('register') }}">Daftar Online</a>
                    @else
                        <span class="btn btn-link text-muted" style="cursor:not-allowed;">Pendaftaran Ditutup</span>
                    @endif
                </div>
                
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="#">PPDB Nashirussunnah</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/lib/parallax/parallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
