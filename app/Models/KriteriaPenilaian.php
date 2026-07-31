<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    protected $fillable = [
        'nama_kriteria',
        'deskripsi',
        'bobot',
        'is_aktif',
        'urutan',
    ];

    public function penilaians()
    {
        return $this->hasMany(PenilaianTes::class, 'kriteria_id');
    }
}