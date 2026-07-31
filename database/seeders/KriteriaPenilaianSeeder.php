<?php
namespace Database\Seeders;

use App\Models\KriteriaPenilaian;
use Illuminate\Database\Seeder;

class KriteriaPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $kriterias = [
            [
                'nama_kriteria' => 'Bacaan Al-Qur\'an',
                'deskripsi'     => 'Kelancaran dan ketepatan bacaan Al-Qur\'an calon santri',
                'bobot'         => 30,
                'urutan'        => 1,
            ],
            [
                'nama_kriteria' => 'Tajwid',
                'deskripsi'     => 'Penguasaan ilmu tajwid dalam membaca Al-Qur\'an',
                'bobot'         => 25,
                'urutan'        => 2,
            ],
            [
                'nama_kriteria' => 'Motivasi & Niat',
                'deskripsi'     => 'Kesungguhan dan motivasi calon santri untuk mondok',
                'bobot'         => 25,
                'urutan'        => 3,
            ],
            [
                'nama_kriteria' => 'Karakter & Kepribadian',
                'deskripsi'     => 'Adab, sopan santun, dan karakter calon santri',
                'bobot'         => 20,
                'urutan'        => 4,
            ],
        ];

        foreach ($kriterias as $k) {
            KriteriaPenilaian::create($k);
        }
    }
}