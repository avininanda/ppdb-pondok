{{-- layout.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        /* CSS inline di sini — ini pengecualian yang diizinkan */
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; }
        .header { background: #0a1628; padding: 30px; text-align: center; }
        .header h1 { color: #C9A84C; font-size: 20px; margin: 0; }
        .header p { color: rgba(255,255,255,0.7); font-size: 13px; margin: 5px 0 0; }
        .body { padding: 30px; }
        .body h2 { color: #0a1628; }
        .body p { color: #555; font-size: 14px; line-height: 1.6; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #888; }
        .info-box { background: #f8f9fa; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .label { color: #888; }
        .value { color: #333; font-weight: bold; }
        .badge-warning { background: #fff3cd; color: #856404; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .badge-success { background: #d1e7dd; color: #0a3622; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .badge-danger { background: #f8d7da; color: #58151c; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .badge-info { background: #cff4fc; color: #055160; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .btn { display: inline-block; background: #C9A84C; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; }
        .btn-success { display: inline-block; background: #198754; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; }
        .catatan { background: #fff3cd; border-left: 4px solid #C9A84C; padding: 15px; border-radius: 4px; margin: 15px 0; font-size: 14px; }
        .hasil-lulus { background: #d1e7dd; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
        .hasil-lulus h3 { color: #0a3622; font-size: 22px; margin: 0 0 5px; }
        .hasil-gagal { background: #f8d7da; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
        .hasil-gagal h3 { color: #58151c; font-size: 22px; margin: 0 0 5px; }
    </style>
</head>
<body>
<div class="container">

    {{-- Header --}}
    <div class="header">
        <h1>PPDB Nashirussunnah</h1>
        <p>Pondok Pesantren Tahfidz Nashirussunnah</p>
    </div>

    {{-- Konten dari masing-masing email --}}
    <div class="body">
        @yield('content')
    </div>

    {{-- Footer --}}
    <div class="footer">
        © {{ date('Y') }} PPDB Pondok Pesantren Tahfidz Nashirussunnah
    </div>

</div>
</body>
</html>