<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'periode_pendaftaran_id',
        'nomor_pendaftaran',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'no_telepon',
        'hafalan',
        'alamat',
        'anak_ke',
        'riwayat_penyakit',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'hp_ortu',
        'file_kk',
        'file_akte',
        'file_ijazah',
        'pas_foto',
        'status_verifikasi',
        'status_akhir',
        'jumlah_revisi',
        'file_bukti_bayar',   
        'status_pembayaran', 
        'catatan',
        'status_draft',
    ];

    public function isDraft(): bool
    {
    return $this->status_draft === 'draft';
    }

    public function isSubmitted(): bool
    {
    return $this->status_draft === 'submit';
    }

    public function sudahBayar(): bool
    {
    return $this->status_pembayaran === 'terverifikasi';
    }

    public function menungguVerifikasiBayar(): bool
    {
        return $this->status_pembayaran === 'menunggu_verifikasi';
    }

    // Boleh upload ulang: statusnya ditolak DAN belum habis jatah revisi (maks 2x)
    public function bisaRevisi(): bool
    {
        return $this->status_verifikasi === 'revisi' && $this->jumlah_revisi < 2;
    }

    // Sudah habis jatah revisi → benar-benar dead-end
    public function batasRevisiTercapai(): bool
    {
        return $this->status_verifikasi === 'revisi' && $this->jumlah_revisi >= 2;
    }

    public function sudahDiputuskan(): bool
    {
    return $this->status_akhir !== 'belum_ada';
    }

    public function diterima(): bool
    {
        return $this->status_akhir === 'diterima';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class);
    }

    public function hasilTes()
    {
        return $this->hasOne(HasilTes::class);
    }

    public function periode()
    {
    return $this->belongsTo(PeriodePendaftaran::class, 'periode_pendaftaran_id');
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = ucwords(strtolower(trim($value)));
    }

    public function setTempatLahirAttribute($value)
    {
        $this->attributes['tempat_lahir'] = ucwords(strtolower(trim($value)));
    }

    public function setNamaAyahAttribute($value)
    {
        $this->attributes['nama_ayah'] = ucwords(strtolower(trim($value)));
    }

    public function setNamaIbuAttribute($value)
    {
        $this->attributes['nama_ibu'] = ucwords(strtolower(trim($value)));
    }

    public function setAlamatAttribute($value)
    {
        $this->attributes['alamat'] = ucfirst(strtolower(trim($value)));
    }

    public function setAsalSekolahAttribute($value)
    {
        $this->attributes['asal_sekolah'] = trim($value);
    }

    public function setPekerjaanAyahAttribute($value)
    {
        $this->attributes['pekerjaan_ayah'] = trim($value);
    }

    public function setPekerjaanIbuAttribute($value)
    {
        $this->attributes['pekerjaan_ibu'] = trim($value);
    }


}