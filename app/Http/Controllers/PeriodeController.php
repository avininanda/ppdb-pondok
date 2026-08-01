<?php

namespace App\Http\Controllers;

use App\Models\PeriodePendaftaran;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = PeriodePendaftaran::latest()->get();
        return view('panitia.periode.index', compact('periodes'));
    }

    public function create()
    {
        return view('panitia.periode.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'tahun_ajaran'  => 'required|string|max:255',
        'tanggal_buka'  => 'required|date',
        'tanggal_tutup' => 'required|date|after:tanggal_buka',
        'tanggal_tes_mulai'            => 'required|date|after_or_equal:tanggal_tutup',
        'tanggal_tes_selesai'          => 'required|date|after_or_equal:tanggal_tes_mulai',
        'tanggal_pengumuman'           => 'required|date|after_or_equal:tanggal_tes_selesai',
        'tanggal_daftar_ulang_mulai'   => 'required|date|after_or_equal:tanggal_pengumuman',
        'tanggal_daftar_ulang_selesai' => 'required|date|after_or_equal:tanggal_daftar_ulang_mulai',
    ], [
        'tanggal_tes_mulai.after_or_equal' => 'Tanggal tes wawancara tidak boleh sebelum pendaftaran ditutup.',
        'tanggal_tes_selesai.after_or_equal' => 'Tanggal selesai tes tidak boleh sebelum tanggal mulai tes.',
        'tanggal_pengumuman.after_or_equal' => 'Tanggal pengumuman tidak boleh sebelum tes wawancara selesai.',
        'tanggal_daftar_ulang_mulai.after_or_equal' => 'Tanggal daftar ulang tidak boleh sebelum pengumuman.',
        'tanggal_daftar_ulang_selesai.after_or_equal' => 'Tanggal selesai daftar ulang tidak boleh sebelum tanggal mulai.',
    ]);

    // Kalau periode baru diaktifkan,
    // nonaktifkan periode lain dulu
    // (hanya boleh 1 periode aktif)
    if ($request->has('is_aktif')) {
        PeriodePendaftaran::query()->update(['is_aktif' => false]);
    }

    PeriodePendaftaran::create([
        'tahun_ajaran'  => $request->tahun_ajaran,
        'tanggal_buka'  => $request->tanggal_buka,
        'tanggal_tutup' => $request->tanggal_tutup,
        'tanggal_tes_mulai'            => $request->tanggal_tes_mulai,
        'tanggal_tes_selesai'          => $request->tanggal_tes_selesai,
        'tanggal_pengumuman'           => $request->tanggal_pengumuman,
        'tanggal_daftar_ulang_mulai'   => $request->tanggal_daftar_ulang_mulai,
        'tanggal_daftar_ulang_selesai' => $request->tanggal_daftar_ulang_selesai,
        'is_aktif'      => $request->has('is_aktif'),
    ]);

    return redirect()->route('periode.index')
                     ->with('success', 'Periode pendaftaran berhasil ditambahkan!');
}
    public function edit($id)
    {
        $periode = PeriodePendaftaran::findOrFail($id);
        return view('panitia.periode.edit', compact('periode'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'tahun_ajaran'  => 'required|string|max:255',
        'tanggal_buka'  => 'required|date',
        'tanggal_tutup' => 'required|date|after:tanggal_buka',
        'tanggal_tes_mulai'            => 'required|date|after_or_equal:tanggal_tutup',
        'tanggal_tes_selesai'          => 'required|date|after_or_equal:tanggal_tes_mulai',
        'tanggal_pengumuman'           => 'required|date|after_or_equal:tanggal_tes_selesai',
        'tanggal_daftar_ulang_mulai'   => 'required|date|after_or_equal:tanggal_pengumuman',
        'tanggal_daftar_ulang_selesai' => 'required|date|after_or_equal:tanggal_daftar_ulang_mulai',
    ], [
        'tanggal_tes_mulai.after_or_equal' => 'Tanggal tes wawancara tidak boleh sebelum pendaftaran ditutup.',
        'tanggal_tes_selesai.after_or_equal' => 'Tanggal selesai tes tidak boleh sebelum tanggal mulai tes.',
        'tanggal_pengumuman.after_or_equal' => 'Tanggal pengumuman tidak boleh sebelum tes wawancara selesai.',
        'tanggal_daftar_ulang_mulai.after_or_equal' => 'Tanggal daftar ulang tidak boleh sebelum pengumuman.',
        'tanggal_daftar_ulang_selesai.after_or_equal' => 'Tanggal selesai daftar ulang tidak boleh sebelum tanggal mulai.',
    ]);

    if ($request->has('is_aktif')) {
        PeriodePendaftaran::query()->update(['is_aktif' => false]);
    }

    $periode = PeriodePendaftaran::findOrFail($id);
    $periode->update([
        'tahun_ajaran'  => $request->tahun_ajaran,
        'tanggal_buka'  => $request->tanggal_buka,
        'tanggal_tutup' => $request->tanggal_tutup,
        'tanggal_tes_mulai'            => $request->tanggal_tes_mulai,
        'tanggal_tes_selesai'          => $request->tanggal_tes_selesai,
        'tanggal_pengumuman'           => $request->tanggal_pengumuman,
        'tanggal_daftar_ulang_mulai'   => $request->tanggal_daftar_ulang_mulai,
        'tanggal_daftar_ulang_selesai' => $request->tanggal_daftar_ulang_selesai,
        'is_aktif'      => $request->has('is_aktif'),
    ]);

    return redirect()->route('periode.index')
                     ->with('success', 'Periode pendaftaran berhasil diperbarui!');
}

    public function destroy($id)
{
    PeriodePendaftaran::findOrFail($id)->delete();

    return redirect()->route('periode.index')
                     ->with('success', 'Periode pendaftaran berhasil dihapus!');
}
}