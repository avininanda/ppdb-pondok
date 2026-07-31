<!doctype html>
<html lang="id">
<head>
    <title>Daftar Akun — PPDB Nashirussunnah</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('login-template/style.css') }}">
    <link rel="stylesheet" href="{{ asset('login-template/auth.css') }}">
</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">

                    {{-- Panel Kiri --}}
                    <div class="img" style="background-image: url('{{ asset('assets/img/carousel-1.png') }}');">
                    </div>

                    {{-- Panel Kanan --}}
                    <div class="login-wrap p-4 p-md-5">

                        <div class="logo-wrap">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                            <div class="logo-text">
                                <h4>Nashirussunnah</h4>
                                <span>Studi Al-Qur'an & Bahasa Arab</span>
                            </div>
                        </div>

                        <h3>Buat Akun Baru</h3>
                        <p class="subtitle">Daftarkan akun calon santri kamu</p>

                        @if ($errors->any())
                            <div class="alert-error">
                                @foreach ($errors->all() as $error)
                                    <p style="margin:0">⚠️ {{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" class="signin-form">
                            @csrf

                            <div class="form-group mb-3">
                                <label class="label" for="name">Nama Lengkap</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name') }}"
                                    class="form-control"
                                    placeholder="Masukkan nama lengkap"
                                    required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <label class="label" for="email">Email</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email') }}"
                                    class="form-control"
                                    placeholder="Masukkan email aktif"
                                    required>
                            </div>

                           <div class="form-group mb-3">
                            <label class="label" for="password">Password</label>
                            <div style="position: relative;">
                                <input type="password" id="password" name="password"
                                    class="form-control"
                                    placeholder="Minimal 8 karakter"
                                    required
                                    style="padding-right: 44px;">
                                <button type="button" id="togglePassword"
                                    style="position: absolute; right: 12px; top: 50%;
                                        transform: translateY(-50%); background: none;
                                        border: none; cursor: pointer; color: #888;
                                        padding: 0; line-height: 1;">
                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="label" for="password_confirmation">Konfirmasi Password</label>
                            <div style="position: relative;">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password kamu"
                                    required
                                    style="padding-right: 44px;">
                                <button type="button" id="togglePasswordConfirm"
                                    style="position: absolute; right: 12px; top: 50%;
                                        transform: translateY(-50%); background: none;
                                        border: none; cursor: pointer; color: #888;
                                        padding: 0; line-height: 1;">
                                    <i class="fa fa-eye" id="eyeIconConfirm"></i>
                                </button>
                            </div>
                        </div>

                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>

                        <hr class="divider">

                        <p class="text-center" style="font-size:13px; color:#888;">
                            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                        </p>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Toggle password
    document.getElementById('togglePassword').addEventListener('click', function () {
        var input = document.getElementById('password');
        var icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    // Toggle konfirmasi password
    document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
        var input = document.getElementById('password_confirmation');
        var icon  = document.getElementById('eyeIconConfirm');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>
<script src="{{ asset('login-template/js/jquery.min.js') }}"></script>
<script src="{{ asset('login-template/js/popper.js') }}"></script>
<script src="{{ asset('login-template/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('login-template/js/main.js') }}"></script>
</body>
</html>