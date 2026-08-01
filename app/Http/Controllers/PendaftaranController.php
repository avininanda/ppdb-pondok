<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\PeriodePendaftaran;
use App\Models\Informasi;
use Illuminate\Http\Request;
use App\Mail\PendaftaranSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    // =========================================================
    // STEP 1 — Data Diri
    // =========================================================

    public function step1()
    {
        // Ambil data pendaftaran yang masih draft milik user ini
        // Kalau belum ada, $pendaftaran akan null
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        // Kalau sudah submit (bukan draft), arahkan ke status
        if ($pendaftaran && $pendaftaran->isSubmitted()) {
            return redirect()->route('pendaftaran.detail')
                             ->with('info', 'Pendaftaran kamu sudah disubmit!');
        }

        return view('santri.daftar.step1', compact('pendaftaran'));
    }

   public function simpanStep1(Request $request)
{
    $request->validate([
        'nama'          => 'required|string|max:255',
        'tempat_lahir'  => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'asal_sekolah'  => 'required|string|max:255',
        'no_telepon'    => [
        'required',
        'string',
        'min:10',      
        'max:15',      
        'regex:/^[0-9+\-\s]+$/' 
        ],
        'hafalan'       => 'nullable|string',
        'alamat'        => 'required|string',
        'anak_ke'          => 'required|integer|min:1',
        'riwayat_penyakit' => 'nullable|string',
    ], [
        'nama.required'          => 'Nama lengkap wajib diisi.',
        'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
        'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
        'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
        'asal_sekolah.required'  => 'Asal sekolah wajib diisi.',
        'no_telepon.required'    => 'Nomor telepon wajib diisi.',
        'alamat.required'        => 'Alamat wajib diisi.',
        'anak_ke.required'       => 'Anak ke berapa wajib diisi.',
        'anak_ke.integer'        => 'Anak ke berapa harus berupa angka.',
        'anak_ke.min'            => 'Anak ke berapa minimal 1.',
    ]);

    $pendaftaranLama = Pendaftaran::where('user_id', auth()->id())->first();

    // Kalau pendaftar lama sudah punya nomor, pakai yang sama (jangan generate ulang)
    // Kalau belum pernah ada sama sekali, generate nomor baru
    if ($pendaftaranLama && $pendaftaranLama->nomor_pendaftaran) {
        $nomorPendaftaran = $pendaftaranLama->nomor_pendaftaran;
    } else {
        $tahun = now()->format('Y');

    // DB::transaction + lockForUpdate "mengunci" proses penghitungan
    // supaya kalau ada 2 pendaftar submit di waktu hampir bersamaan
    $nomorPendaftaran = DB::transaction(function () use ($tahun) {
        $urutan = Pendaftaran::whereYear('created_at', $tahun)
                              ->lockForUpdate()
                              ->count() + 1;

        return 'PPDB-' . $tahun . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    });
}
    $periodeAktif = PeriodePendaftaran::where('is_aktif', true)->first();

    Pendaftaran::updateOrCreate(
        ['user_id' => auth()->id()],
        [
            'nomor_pendaftaran'      => $nomorPendaftaran,
            'periode_pendaftaran_id' => $periodeAktif?->id,
            'nama'          => $request->nama,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'asal_sekolah'  => $request->asal_sekolah,
            'no_telepon'    => $request->no_telepon,
            'hafalan'       => $request->hafalan,
            'alamat'        => $request->alamat,
            'anak_ke'          => $request->anak_ke,
            'riwayat_penyakit' => $request->riwayat_penyakit,
            'status_draft'  => 'draft',
        ]
    );

    return redirect()->route('pendaftaran.step2');
}

    // =========================================================
    // STEP 2 — Data Orang Tua
    // =========================================================

    public function step2()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        // Kalau belum isi step 1 sama sekali, kembalikan ke step 1
        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.step1')
                             ->with('error', 'Silakan isi data diri terlebih dahulu.');
        }

        // Kalau sudah submit, arahkan ke status
        if ($pendaftaran->isSubmitted()) {
            return redirect()->route('pendaftaran.status');
        }

        return view('santri.daftar.step2', compact('pendaftaran'));
    }

    public function simpanStep2(Request $request)
    {
        $request->validate([
            'nama_ayah'      => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu'       => 'required|string|max:255',
            'pekerjaan_ibu'  => 'required|string|max:255',
            'hp_ortu'        => [ 'required','string','min:10','max:15','regex:/^[0-9+\-\s]+$/'],
        ], [
            'nama_ayah.required'      => 'Nama ayah wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'nama_ibu.required'       => 'Nama ibu wajib diisi.',
            'pekerjaan_ibu.required'  => 'Pekerjaan ibu wajib diisi.',
            'hp_ortu.required'        => 'Nomor HP orang tua wajib diisi.',
        ]);

        // Update data orang tua ke pendaftaran yang sudah ada
        Pendaftaran::where('user_id', auth()->id())->update([
            'nama_ayah'      => $request->nama_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'nama_ibu'       => $request->nama_ibu,
            'pekerjaan_ibu'  => $request->pekerjaan_ibu,
            'hp_ortu'        => $request->hp_ortu,
        ]);

        return redirect()->route('pendaftaran.step3');
    }


    // =========================================================
    // STEP 3 — Upload Dokumen (KK, Akte, Ijazah, Bukti Bayar)
    // =========================================================

    public function step3()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.step1')
                             ->with('error', 'Silakan isi data dari awal.');
        }

        if ($pendaftaran->isSubmitted() && $pendaftaran->bisaRevisi()) {
        return view('santri.daftar.step3', compact('pendaftaran'));
        }

        if ($pendaftaran->isSubmitted()) {
            return redirect()->route('pendaftaran.status');
        }

        return view('santri.daftar.step3', compact('pendaftaran'));
    }

    public function simpanStep3(Request $request)
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        // Guard tambahan: kalau sudah submit tapi TIDAK sedang dalam kondisi boleh revisi,
        // jangan biarkan request nyelonong lewat form/URL langsung
        if ($pendaftaran->isSubmitted() && !$pendaftaran->bisaRevisi()) {
            return redirect()->route('pendaftaran.status');
        }

        $request->validate([
            'file_kk'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_akte'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_bukti_bayar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = [];

        // Hanya update file kalau ada file baru yang diupload
        // Kalau tidak ada file baru, file lama tetap dipakai

        if ($request->hasFile('pas_foto')) {
        $data['pas_foto'] = $request->file('pas_foto')->store('dokumen', 'public');
        }
        if ($request->hasFile('file_kk')) {
            $data['file_kk'] = $request->file('file_kk')->store('dokumen', 'public');
        }
        if ($request->hasFile('file_akte')) {
            $data['file_akte'] = $request->file('file_akte')->store('dokumen', 'public');
        }
        if ($request->hasFile('file_ijazah')) {
            $data['file_ijazah'] = $request->file('file_ijazah')->store('dokumen', 'public');
        }
        if ($request->hasFile('file_bukti_bayar')) {
            $data['file_bukti_bayar']  = $request->file('file_bukti_bayar')->store('dokumen', 'public');
            $data['status_pembayaran'] = 'menunggu_verifikasi';
        }

        if ($pendaftaran->isSubmitted() && $pendaftaran->status_verifikasi === 'revisi') {
        $data['status_verifikasi'] = 'pending';
        $data['jumlah_revisi']     = $pendaftaran->jumlah_revisi + 1;
        $data['catatan']           = null; // catatan lama sudah tidak relevan
        }

        if (!empty($data)) {
            $pendaftaran->update($data);
        }

        if ($pendaftaran->isSubmitted()) {
        return redirect()->route('pendaftaran.status')
                         ->with('success', 'Dokumen berhasil diupload ulang! Menunggu verifikasi panitia.');
        }

        return redirect()->route('pendaftaran.preview');
    }


    // =========================================================
    // PREVIEW & SUBMIT
    // =========================================================

    public function preview()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.step1');
        }

        return view('santri.daftar.preview', compact('pendaftaran'));
    }

    public function submit()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

    // Cegah submit kalau periode pendaftaran sudah tutup
    $periodeAktif = \App\Models\PeriodePendaftaran::where('is_aktif', true)->first();
    if ($periodeAktif && now()->gt(\Carbon\Carbon::parse($periodeAktif->tanggal_tutup)->endOfDay())) {
        return redirect()->route('pendaftaran.step3')
                     ->with('error', 'Maaf, periode pendaftaran sudah ditutup pada ' . \Carbon\Carbon::parse($periodeAktif->tanggal_tutup)->format('d M Y') . '. Pendaftaran tidak dapat dilanjutkan.');
    }

        // Validasi: pastikan semua dokumen sudah diupload
       if (!$pendaftaran->pas_foto || !$pendaftaran->file_kk || !$pendaftaran->file_akte || !$pendaftaran->file_ijazah || !$pendaftaran->file_bukti_bayar) {
        return redirect()->route('pendaftaran.step3')
                  ->with('error', 'Semua dokumen termasuk pas foto dan bukti pembayaran wajib diupload sebelum submit!');
        }

        // Ubah status:
        // status_draft      : draft → submit
        // status_verifikasi : tetap pending (menunggu panitia)
        $pendaftaran->update([
            'status_draft'      => 'submit',
            'status_verifikasi' => 'pending',
        ]);

        // Email bersifat notifikasi pendukung — kalau gagal kirim
        // (misal koneksi internet putus), proses submit yang sudah
        // berhasil TIDAK boleh ikut gagal. Maka dibungkus try-catch.
        try {
            Mail::to($pendaftaran->user->email)
                ->send(new PendaftaranSubmitted($pendaftaran));
        } catch (\Exception $e) {
            return redirect()->route('pendaftaran.status')
                             ->with('success', 'Pendaftaran berhasil disubmit! Namun email notifikasi gagal terkirim.');
        }

        return redirect()->route('pendaftaran.status')
                         ->with('success', 'Pendaftaran berhasil disubmit! Silakan tunggu verifikasi panitia.');
    }


    // =========================================================
    // HAPUS DRAFT
    // =========================================================

    public function hapusDraft()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        // Keamanan: hanya draft yang boleh dihapus
        // Data yang sudah disubmit tidak boleh dihapus sendiri
        if ($pendaftaran && $pendaftaran->isDraft()) {
            $pendaftaran->delete();
            return redirect()->route('pendaftaran.step1')
                             ->with('success', 'Draft dihapus. Silakan isi ulang pendaftaran.');
        }

        return redirect()->route('pendaftaran.status')
                         ->with('error', 'Pendaftaran yang sudah disubmit tidak bisa dihapus.');
    }


    // =========================================================
    // STATUS PENDAFTARAN
    // =========================================================

        public function status()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())
                                ->with(['jadwal', 'hasilTes'])
                                ->first();

       $infoDaftarUlang = collect();
    if ($pendaftaran && $pendaftaran->status_akhir === 'diterima') {
        $infoDaftarUlang = \App\Models\Informasi::where('kategori', 'daftar_ulang')
                                                ->where('is_aktif', true)
                                                ->orderBy('urutan')
                                                ->get();
    }

        return view('santri.status', compact('pendaftaran', 'infoDaftarUlang'));
    }

    public function detail()
    {
    $pendaftaran = Pendaftaran::where('user_id', auth()->id())
                              ->with(['jadwal', 'hasilTes'])
                              ->first();

    if (!$pendaftaran || $pendaftaran->isDraft()) {
        return redirect()->route('pendaftaran.step1');
    }

    return view('santri.daftar.detail', compact('pendaftaran'));
    }
}