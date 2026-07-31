<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $fillable = [
        'judul',
        'konten',
        'kategori',
        'urutan',
        'is_aktif',
    ];

    // Helper biar gampang dipanggil di view/landing page
    public function isPengumuman(): bool
    {
        return $this->kategori === 'pengumuman';
    }

    public function isPersyaratan(): bool
    {
        return $this->kategori === 'persyaratan';
    }

    public function isDaftarUlang(): bool
    {
        return $this->kategori === 'daftar_ulang';
    }
}