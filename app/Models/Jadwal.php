<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftaran_id',
        'tanggal_tes',
        'jam_tes',
        'link_tes',
        'sudah_dilaksanakan',
    ];
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}