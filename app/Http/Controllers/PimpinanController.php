<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\PeriodePendaftaran;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class PimpinanController extends Controller
{
    public function dashboard()
    {
        // Ambil semua periode beserta statistik pendaftarnya
        // Ini yang jadi data bar chart
        $periodes = \App\Models\PeriodePendaftaran::orderBy('tanggal_buka')
            ->get()
            ->map(function ($periode) {
                $pendaftars = \App\Models\Pendaftaran::where('status_draft', 'submit')
                    ->where('periode_pendaftaran_id', $periode->id)
                    ->get();

                return [
                    'id'           => $periode->id,
                    'tahun_ajaran' => $periode->tahun_ajaran,
                    'is_aktif'     => $periode->is_aktif,
                    'total'        => $pendaftars->count(),
                    'diterima'     => $pendaftars->filter(fn($p) =>
                                        optional($p->hasilTes)->hasil === 'lulus'
                                    )->count(),
                    'ditolak'      => $pendaftars->filter(fn($p) =>
                                        optional($p->hasilTes)->hasil === 'tidak lulus'
                                    )->count(),
                    'diverifikasi' => $pendaftars->where('status_verifikasi', 'diverifikasi')->count(),
                    'pending'      => $pendaftars->where('status_verifikasi', 'pending')->count(),
                ];
            });

        // Statistik total lintas semua periode (untuk metric card atas)
        $stats = [
            'total'        => \App\Models\Pendaftaran::where('status_draft', 'submit')->count(),
            'pending'      => \App\Models\Pendaftaran::where('status_draft', 'submit')
                            ->where('status_verifikasi', 'pending')->count(),
            'diverifikasi' => \App\Models\Pendaftaran::where('status_verifikasi', 'diverifikasi')->count(),
            'diterima'     => \App\Models\HasilTes::where('hasil', 'lulus')->count(),
            'ditolak'      => \App\Models\HasilTes::where('hasil', 'tidak lulus')->count(),
        ];

        return view('pimpinan.dashboard', compact('stats', 'periodes'));
    }

    // ============================================
    // LAPORAN — Bisa difilter berdasarkan periode
    // ============================================
    public function laporan(Request $request)
{
    $periodeId = $request->query('periode_id');
    $status    = $request->query('status');

    $query = Pendaftaran::where('status_draft', 'submit')
                         ->with(['user', 'hasilTes', 'periode']);

    if ($periodeId) {
        $query->where('periode_pendaftaran_id', $periodeId);
    }

    $pendaftars = $query->orderBy('nomor_pendaftaran')->get();

    // Stats dihitung dari data SEBELUM filter status diterapkan,
    // supaya angka ringkasan tetap konsisten walau dropdown status diganti-ganti
    $stats = [
        'total'    => $pendaftars->count(),
        'diterima' => $pendaftars->where('status_akhir', 'diterima')->count(),
        'ditolak'  => $pendaftars->filter(function ($p) {
                          return $p->status_verifikasi === 'ditolak' || $p->status_akhir === 'ditolak';
                      })->count(),
        'pending'  => $pendaftars->where('status_verifikasi', 'pending')->count(),
    ];

    // Filter status diterapkan setelah stats dihitung, cuma mempengaruhi
    // baris yang tampil di tabel, bukan angka ringkasan
    if ($status) {
        $pendaftars = $pendaftars->filter(function ($p) use ($status) {
            return match($status) {
                'diterima'     => $p->status_akhir === 'diterima',
                'ditolak'      => $p->status_akhir === 'ditolak' || $p->status_verifikasi === 'ditolak',
                'pending'      => $p->status_verifikasi === 'pending',
                'diverifikasi' => $p->status_verifikasi === 'diverifikasi' && $p->status_akhir === 'belum_ada',
                'revisi'       => $p->status_verifikasi === 'revisi',
                default        => true,
            };
        })->values();
    }

    $periodes = PeriodePendaftaran::orderByDesc('tanggal_buka')->get();

    return view('pimpinan.laporan', compact('pendaftars', 'stats', 'periodes', 'periodeId', 'status'));
}

    // ============================================
    // EXPORT CSV — Unduh data sesuai filter yang aktif
    // ============================================
    public function exportCsv(Request $request)
    {
        $periodeId = $request->query('periode_id');

        $query = Pendaftaran::where('status_draft', 'submit')
                             ->with(['hasilTes', 'periode']);

        if ($periodeId) {
            $query->where('periode_pendaftaran_id', $periodeId);
        }

        $pendaftars = $query->latest()->get();

        $filename = 'laporan-ppdb-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($pendaftars) {
            $file = fopen('php://output', 'w');

            // BOM supaya karakter Indonesia tampil benar saat dibuka di Excel
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, ['No', 'Nama', 'Asal Sekolah', 'Periode', 'Tanggal Daftar', 'Status Verifikasi', 'Hasil Tes']);

            foreach ($pendaftars as $index => $p) {
               if ($p->status_akhir === 'diterima') {
                    $statusTampil = 'Diterima';
                } elseif ($p->status_akhir === 'ditolak') {
                    $statusTampil = 'Tidak Lulus Wawancara';
                } elseif ($p->status_verifikasi === 'ditolak') {
                    $statusTampil = 'Ditolak (Berkas)';
                } elseif ($p->status_verifikasi === 'diverifikasi') {
                    $statusTampil = 'Berkas Valid';
                } elseif ($p->status_verifikasi === 'revisi') {
                    $statusTampil = 'Perlu Revisi';
                } else {
                    $statusTampil = 'Menunggu Verifikasi';
                }

                fputcsv($file, [
                    $index + 1,
                    $p->nama,
                    $p->asal_sekolah,
                    $p->periode->tahun_ajaran ?? '-',
                    $p->created_at->format('d-m-Y'),
                    $statusTampil,
                    $p->hasilTes->hasil ?? '-',
                ]);
            }

            fclose($file);
        }, $filename);
    }

    public function exportExcel(Request $request)
    {
    $periodeId = $request->query('periode_id');

    $query = Pendaftaran::where('status_draft', 'submit')
                         ->with(['hasilTes', 'periode']);

    if ($periodeId) {
        $query->where('periode_pendaftaran_id', $periodeId);
    }

    $pendaftars = $query->orderBy('nomor_pendaftaran')->get();

    $stats = [
        'total'    => $pendaftars->count(),
        'pending'  => $pendaftars->where('status_verifikasi', 'pending')->count(),
        'diterima' => $pendaftars->where('status_akhir', 'diterima')->count(),
        'ditolak'  => $pendaftars->filter(function ($p) {
                        return $p->status_verifikasi === 'ditolak' || $p->status_akhir === 'ditolak';
                    })->count(),
    ];

    $periodeLabel = $periodeId
        ? (PeriodePendaftaran::find($periodeId)->tahun_ajaran ?? 'Tidak diketahui')
        : 'Semua Periode';

    $filename = 'laporan-ppdb-' . now()->format('Ymd-His') . '.xlsx';

    return Excel::download(new LaporanExport($pendaftars, $stats, $periodeLabel), $filename);
}
}