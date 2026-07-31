<?php

namespace App\Http\Controllers;

use App\Mail\BerkasVerified;
use App\Mail\HasilCreated;
use App\Mail\JadwalCreated;
use App\Models\HasilTes;
use App\Models\KriteriaPenilaian;
use App\Models\PenilaianTes;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PanitiaController extends Controller
{
    // ============================================
    // DASHBOARD
    // ============================================
    public function dashboard()
    {
    $stats = [
        'total'        => Pendaftaran::where('status_draft', 'submit')->count(),
        'pending'      => Pendaftaran::where('status_draft', 'submit')
                                     ->where('status_verifikasi', 'pending')->count(),
        'diverifikasi' => Pendaftaran::where('status_verifikasi', 'diverifikasi')->count(),
        'diterima'     => Pendaftaran::where('status_akhir', 'diterima')->count(),
        'ditolak'      => Pendaftaran::where('status_verifikasi', 'ditolak')
                                     ->orWhere('status_akhir', 'ditolak')->count(),
    ];

   // Jadwal wawancara hari ini — buat notifikasi cepat di dashboard
    $jadwalHariIni = Jadwal::whereDate('tanggal_tes', now()->toDateString())
                            ->with('pendaftaran')
                            ->orderBy('jam_tes')
                            ->get();

    return view('panitia.dashboard', compact('stats', 'jadwalHariIni'));
    }

    // ============================================
    // KELOLA PENDAFTAR — Semua pendaftar untuk
    // verifikasi berkas
    // ============================================
    public function pendaftar(Request $request)
    {
    $search = $request->query('search');

    $pendaftars = Pendaftaran::where('status_draft', 'submit')
                              ->with('user', 'hasilTes')
                              ->when($search, function ($query) use ($search) {
                                $query->where(function($q) use ($search) {
                                    $q->where('nama', 'like', '%' . $search . '%')
                                    ->orWhere('nomor_pendaftaran', 'like', '%' . $search . '%');
                                });
                                })
                              ->latest()
                              ->paginate(20)
                              ->withQueryString();

    return view('panitia.pendaftar', compact('pendaftars'));
    }

    // ============================================
    // DETAIL PENDAFTAR
    // ============================================
    public function detail($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'jadwal', 'hasilTes'])
                                   ->findOrFail($id);

        return view('panitia.detail', compact('pendaftaran'));
    }

    // ============================================
    // VERIFIKASI BERKAS
    // ============================================
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:diverifikasi,revisi,ditolak',
            'catatan'           => 'nullable|string',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $statusBaru  = $request->status_verifikasi;

        if ($statusBaru === 'revisi' && $pendaftaran->jumlah_revisi >= 2) {
            $statusBaru = 'ditolak';
        }


        $pendaftaran->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan'           => $request->catatan,
        ]);

        // Kirim email notifikasi
        try {
            Mail::to($pendaftaran->user->email)
                ->send(new BerkasVerified($pendaftaran));
        } catch (\Exception $e) {
            // Kalau email gagal, sistem tetap jalan
        }

        return redirect()->route('panitia.detail', $id)
                         ->with('success', 'Status verifikasi berhasil diupdate!');
    }

    // ============================================
    // VERIFIKASI PEMBAYARAN
    // ============================================
    public function verifikasiPembayaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_pembayaran' => 'terverifikasi',
        ]);

        return redirect()->route('panitia.detail', $id)
                         ->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    // ============================================
    // KELOLA JADWAL — Hanya yang sudah diverifikasi
    // ============================================
    public function kelolaJadwal(Request $request)
    {
        $filter  = $request->query('filter', 'all');
        $tanggal = $request->query('tanggal');

        if (!in_array($filter, ['all', 'belum', 'dijadwalkan'])) {
            $filter = 'all';
        }

        $pendaftarsQuery = Pendaftaran::where('status_draft', 'submit')
                                ->where('status_verifikasi', 'diverifikasi')
                                ->where('status_pembayaran', 'terverifikasi')
                                ->with(['user', 'jadwal']);

        $pendaftars = $pendaftarsQuery->get();

        $counts = [
            'all'         => $pendaftars->count(),
            'belum'       => $pendaftars->filter(fn($p) => !$p->jadwal)->count(),
            'dijadwalkan' => $pendaftars->filter(fn($p) => $p->jadwal)->count(),
        ];

        if ($filter === 'belum') {
            $pendaftars = $pendaftars->filter(fn($p) => !$p->jadwal);
        } elseif ($filter === 'dijadwalkan') {
            $pendaftars = $pendaftars->filter(fn($p) => $p->jadwal);
        }

        // Filter tambahan: cek jadwal di tanggal tertentu (independen dari filter status)
        if ($tanggal) {
            $pendaftars = $pendaftars->filter(function ($p) use ($tanggal) {
                return $p->jadwal && $p->jadwal->tanggal_tes === $tanggal;
            });
        }

        $pendaftars = $pendaftars->sortBy(function ($p) {
            return $p->jadwal
                ? $p->jadwal->tanggal_tes . ' ' . $p->jadwal->jam_tes
                : '9999-12-31 23:59:59';
        })->values();

        return view('panitia.kelola-jadwal', compact('pendaftars', 'filter', 'counts', 'tanggal'));
    }
    // ============================================
    // FORM INPUT JADWAL
    // ============================================
    public function createJadwal($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Validasi berkas
        if ($pendaftaran->status_verifikasi !== 'diverifikasi') {
            return redirect()->route('panitia.pendaftar')
                            ->with('error', 'Berkas pendaftar belum diverifikasi!');
        }

        // Validasi pembayaran
        if ($pendaftaran->status_pembayaran !== 'terverifikasi') {
            return redirect()->route('panitia.pendaftar')
                            ->with('error', 'Pembayaran pendaftar belum diverifikasi!');
        }

        $jadwal = $pendaftaran->jadwal;
        return view('panitia.jadwal', compact('pendaftaran', 'jadwal'));
    }

    // ============================================
    // SIMPAN JADWAL
    // ============================================
    public function simpanJadwal(Request $request, $id)
    {
        $request->validate([
            'tanggal_tes' => 'required|date',
            'jam_tes'     => 'required',
            'link_tes'    => 'required|url',
        ], [
            'tanggal_tes.required' => 'Tanggal wawancara wajib diisi.',
            'jam_tes.required'     => 'Jam wawancara wajib diisi.',
            'link_tes.required'    => 'Link Google Meet wajib diisi.',
            'link_tes.url'         => 'Format link tidak valid.',
        ]);

        $jadwal = Jadwal::updateOrCreate(
            ['pendaftaran_id' => $id],
            [
                'tanggal_tes' => $request->tanggal_tes,
                'jam_tes'     => $request->jam_tes,
                'link_tes'    => $request->link_tes,
            ]
        );

        $pendaftaran = Pendaftaran::with('user')->findOrFail($id);

        // Kirim email notifikasi jadwal
        try {
            Mail::to($pendaftaran->user->email)
                ->send(new JadwalCreated($pendaftaran, $jadwal));
        } catch (\Exception $e) {
            \Log::error('Email jadwal gagal untuk pendaftaran #' . $id . ': ' . $e->getMessage());
            return redirect()->route('panitia.kelola.jadwal')
                            ->with('success', 'Jadwal berhasil disimpan, namun email notifikasi gagal terkirim.');
        }

        return redirect()->route('panitia.kelola.jadwal')
                         ->with('success', 'Jadwal wawancara berhasil disimpan!');
    }

    // ============================================
    // HAPUS JADWAL
    // ============================================
    public function hapusJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('panitia.kelola.jadwal')
                         ->with('success', 'Jadwal wawancara berhasil dihapus!');
    }

    // ============================================
    // TANDAI JADWAL SUDAH DILAKSANAKAN
    // ============================================
    public function tandaiSelesai($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update(['sudah_dilaksanakan' => true]);

        return redirect()->route('panitia.kelola.jadwal')
                        ->with('success', 'Wawancara ditandai sudah dilaksanakan. Silakan input hasil di menu Kelola Hasil.');
    }

    // ============================================
    // KELOLA HASIL — Hanya yang sudah ada jadwal
    // ============================================
    public function kelolaHasil(Request $request)
    {
        $filter = $request->query('filter', 'all');

        // Pengaman URL parameter jika ada input kustom/lama yang aneh
        if (!in_array($filter, ['all', 'belum_dinilai', 'sudah_dinilai'])) {
            $filter = 'all';
        }

        $pendaftars = Pendaftaran::where('status_draft', 'submit')
                                  ->where('status_verifikasi','diverifikasi')
                                  ->where('status_pembayaran', 'terverifikasi')
                                  ->whereHas('jadwal', function ($q) {
                                      $q->where('sudah_dilaksanakan', true);
                                  })
                                  ->with(['user', 'jadwal', 'hasilTes'])
                                  ->latest()
                                  ->get();

        // Counter dinamis untuk dropdown menu badge
        $counts = [
            'all'           => $pendaftars->count(),
            'belum_dinilai' => $pendaftars->filter(fn($p) => !$p->hasilTes)->count(),
            'sudah_dinilai' => $pendaftars->filter(fn($p) => $p->hasilTes)->count(),
        ];

        // Jalankan penyaringan koleksi data berdasarkan filter terpilih
        if ($filter === 'belum_dinilai') {
            $pendaftars = $pendaftars->filter(fn($p) => !$p->hasilTes);
        } elseif ($filter === 'sudah_dinilai') {
            $pendaftars = $pendaftars->filter(fn($p) => $p->hasilTes);
        }

        return view('panitia.kelola-hasil', compact('pendaftars', 'filter', 'counts'));
    }

    // ============================================
    // FORM INPUT HASIL
    // ============================================
    public function createHasil($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if (!$pendaftaran->jadwal) {
            return redirect()->route('panitia.kelola.jadwal')
                            ->with('error', 'Input jadwal wawancara terlebih dahulu!');
        }

        // Ambil semua kriteria aktif
        $kriterias = KriteriaPenilaian::where('is_aktif', true)
                                    ->orderBy('urutan')
                                    ->get();

        // Ambil penilaian yang sudah ada (kalau edit)
        $penilaians = PenilaianTes::where('pendaftaran_id', $id)
                                ->get()
                                ->keyBy('kriteria_id');

        $hasil = $pendaftaran->hasilTes;

        return view('panitia.hasil', compact(
            'pendaftaran', 'hasil', 'kriterias', 'penilaians'
        ));
    }

    // ============================================
    // SIMPAN HASIL
    // ============================================
    public function simpanHasil(Request $request, $id)
    {
        $request->validate([
            'penilaian'             => 'required|array',
            'penilaian.*.nilai'     => 'required|in:Sangat Baik,Baik,Cukup,Kurang,Sangat Kurang',
            'penilaian.*.catatan'   => 'nullable|string',
            'keterangan_umum'       => 'nullable|string',
        ]);

        $pendaftaran = Pendaftaran::with('user')->findOrFail($id);
        $kriterias   = KriteriaPenilaian::where('is_aktif', true)->get()->keyBy('id');

        // Hitung nilai akhir berbobot
        $totalBobot    = 0;
        $nilaiAkhir    = 0;

        foreach ($request->penilaian as $kriteriaId => $data) {
            $kriteria   = $kriterias[$kriteriaId];
            $nilaiAngka = PenilaianTes::$konversiNilai[$data['nilai']];

            // Simpan/update penilaian per kriteria
            PenilaianTes::updateOrCreate(
                [
                    'pendaftaran_id' => $id,
                    'kriteria_id'    => $kriteriaId,
                ],
                [
                    'nilai_label' => $data['nilai'],
                    'nilai_angka' => $nilaiAngka,
                    'catatan'     => $data['catatan'] ?? null,
                ]
            );

            // Akumulasi nilai berbobot
            $nilaiAkhir += ($nilaiAngka * $kriteria->bobot / 100);
            $totalBobot += $kriteria->bobot;
        }

        // Keputusan otomatis berdasarkan nilai akhir
        // Threshold: nilai rata-rata ≥ 75 = lulus
        $nilaiAkhir = round($nilaiAkhir, 2);
        $keputusan  = $nilaiAkhir >= 75 ? 'lulus' : 'tidak lulus';

        // Simpan ke HasilTes
        $hasilTes = \App\Models\HasilTes::updateOrCreate(
            ['pendaftaran_id' => $id],
            [
                'hasil'       => $keputusan,
                'nilai_akhir' => $nilaiAkhir,
                'keterangan'  => $request->keterangan_umum,
            ]
        );

        // Update status akhir
        $pendaftaran->update([
            'status_akhir' => $keputusan === 'lulus' ? 'diterima' : 'ditolak',
        ]);

        // Kirim email
        try {
            Mail::to($pendaftaran->user->email)
                ->send(new HasilCreated($pendaftaran, $hasilTes));
        } catch (\Exception $e) {}

        return redirect()->route('panitia.kelola.hasil')
                        ->with('success', "Penilaian berhasil disimpan! Nilai akhir: {$nilaiAkhir} — " . ucfirst($keputusan));
    }

    // ============================================
    // HAPUS HASIL
    // ============================================
    public function hapusHasil($id)
    {
        $hasil = HasilTes::findOrFail($id);

        // Reset status akhir ke belum_ada (bukan status_verifikasi, itu tidak pernah berubah dari 'diverifikasi')
        $hasil->pendaftaran->update([
            'status_akhir' => 'belum_ada',
        ]);

        $hasil->delete();

        return redirect()->route('panitia.kelola.hasil')
                        ->with('success', 'Hasil tes berhasil dihapus!');
    }
}