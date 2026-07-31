<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePendaftaran extends Model
{
    protected $fillable = [
        'tahun_ajaran',
        'tanggal_buka',
        'tanggal_tutup',
        'is_aktif',
    ];

    public function sedangDibuka(): bool
    {
        $hariIni = now()->format('Y-m-d');
        return $this->is_aktif
            && $hariIni >= $this->tanggal_buka
            && $hariIni <= $this->tanggal_tutup;
    }

    // Belum sampai tanggal buka
    public function belumDibuka(): bool
    {
        $hariIni = now()->format('Y-m-d');
        return $hariIni < $this->tanggal_buka;
    }

    // Sudah lewat tanggal tutup
    public function sudahTutup(): bool
    {
        $hariIni = now()->format('Y-m-d');
        return $hariIni > $this->tanggal_tutup;
    }
}