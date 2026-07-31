<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    // Tampilkan semua informasi (pengumuman + persyaratan)
    public function index()
    {
        $informasis = Informasi::orderBy('kategori')
                                ->orderBy('urutan')
                                ->get();

        return view('panitia.informasi.index', compact('informasis'));
    }

    public function create()
    {
        return view('panitia.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'konten'   => 'required|string',
            'kategori' => 'required|in:pengumuman,persyaratan,daftar_ulang',
            'urutan'   => 'nullable|integer',
        ]);

        Informasi::create([
            'judul'    => $request->judul,
            'konten'   => $request->konten,
            'kategori' => $request->kategori,
            'urutan'   => $request->urutan ?? 0,
            'is_aktif' => $request->has('is_aktif'),
        ]);

        return redirect()->route('informasi.index')
                         ->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('panitia.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'konten'   => 'required|string',
            'kategori' => 'required|in:pengumuman,persyaratan,daftar_ulang',
            'urutan'   => 'nullable|integer',
        ]);

        $informasi = Informasi::findOrFail($id);
        $informasi->update([
            'judul'    => $request->judul,
            'konten'   => $request->konten,
            'kategori' => $request->kategori,
            'urutan'   => $request->urutan ?? 0,
            'is_aktif' => $request->has('is_aktif'),
        ]);

        return redirect()->route('informasi.index')
                         ->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Informasi::findOrFail($id)->delete();

        return redirect()->route('informasi.index')
                         ->with('success', 'Informasi berhasil dihapus!');
    }
}