<?php

namespace App\Http\Controllers;
use App\Models\Informasi;
use App\Models\PeriodePendaftaran;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil pengumuman aktif, urutkan sesuai field 'urutan'
        $pengumumans = Informasi::where('kategori', 'pengumuman')
                                 ->where('is_aktif', true)
                                 ->orderBy('urutan')
                                 ->get();

        // Ambil persyaratan aktif
        $persyaratans = Informasi::where('kategori', 'persyaratan')
                                  ->where('is_aktif', true)
                                  ->orderBy('urutan')
                                  ->get();

        // Ambil periode pendaftaran yang sedang aktif (hanya boleh 1)
        $periodeAktif = PeriodePendaftaran::where('is_aktif', true)->first();

        return view('welcome', compact('pengumumans', 'persyaratans', 'periodeAktif'));
    }
}