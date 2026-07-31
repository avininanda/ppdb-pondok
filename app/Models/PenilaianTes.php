<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianTes extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'kriteria_id',
        'nilai_label',
        'nilai_angka',
        'catatan',
    ];

    // Konversi label ke angka otomatis
    public static $konversiNilai = [
        'Sangat Baik'   => 90,
        'Baik'          => 80,
        'Cukup'         => 70,
        'Kurang'        => 60,
        'Sangat Kurang' => 50,
    ];

    public function kriteria()
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}