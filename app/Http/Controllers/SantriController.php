<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Informasi;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function dashboard()
    {
        // Ambil data pendaftaran beserta relasi jadwal, hasil tes, dan penilaian tes per kriteria
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())
                                  ->with(['jadwal', 'hasilTes', 'penilaianTes.kriteria'])
                                  ->first();

        // Mengambil informasi daftar ulang yang aktif dari model Informasi, diurutkan berdasarkan 'urutan'
        $infoDaftarUlang = Informasi::where('kategori', 'daftar_ulang')
                                    ->where('is_aktif', true)
                                    ->orderBy('urutan', 'asc')
                                    ->get();

        return view('santri.dashboard', compact('pendaftaran', 'infoDaftarUlang'));
    }
}