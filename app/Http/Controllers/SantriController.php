<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function dashboard()
{
    // Kirim data pendaftaran ke semua view santri
    // supaya sidebar bisa cek status tanpa query di blade
    $pendaftaran = Pendaftaran::where('user_id', auth()->id())
                              ->with(['jadwal', 'hasilTes'])
                              ->first();

    return view('santri.dashboard', compact('pendaftaran'));
}
}