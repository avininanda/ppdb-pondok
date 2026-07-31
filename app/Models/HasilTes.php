<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilTes extends Model
{
    use HasFactory;

    // Beritahu Laravel nama tabelnya
    // karena konvensi Laravel: HasilTes → hasil_tes (bukan hasil_tes_s)
    protected $table = 'hasil_tes';

    protected $fillable = [
        'pendaftaran_id',
        'hasil',
        'nilai_akhir',
        'keterangan',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}