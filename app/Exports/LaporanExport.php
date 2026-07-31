<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LaporanExport implements FromArray, WithStyles, WithColumnWidths, WithEvents
{
    protected $pendaftars;
    protected $stats;
    protected $periodeLabel;

    protected int $headerRow = 6;

    public function __construct($pendaftars, array $stats, string $periodeLabel)
    {
        $this->pendaftars   = $pendaftars;
        $this->stats        = $stats;
        $this->periodeLabel = $periodeLabel;
    }

    public function array(): array
    {
        $rows = [];

        // Baris 1-3: Kop laporan
        $rows[] = ['LAPORAN PENDAFTARAN PPDB'];
        $rows[] = ['Pondok Pesantren Tahfizh Quran Nashirussunnah'];
        $rows[] = ['Periode: ' . $this->periodeLabel . '   |   Dicetak: ' . now()->format('d M Y, H:i')];

        // Baris 4: ringkasan jadi 1 baris teks saja, biar tidak ambigu di aplikasi manapun
        $rows[] = [
            'Total: ' . $this->stats['total']
            . '   |   Pending: ' . $this->stats['pending']
            . '   |   Diterima: ' . $this->stats['diterima']
            . '   |   Ditolak: ' . $this->stats['ditolak']
        ];

        $rows[] = [];

        // Baris 6: header tabel data
        $rows[] = ['No', 'Nama', 'Asal Sekolah', 'Hafalan', 'Periode', 'Tanggal Daftar', 'Status Verifikasi', 'Hasil Tes'];

        // Baris 7+: data pendaftar
        foreach ($this->pendaftars as $index => $p) {
            $rows[] = [
                $index + 1,
                $p->nama,
                $p->asal_sekolah,
                $p->hafalan ?: '-',
                $p->periode->tahun_ajaran ?? '-',
                $p->created_at->format('d-m-Y'),
                ucfirst($p->status_verifikasi),
                $p->hasilTes->hasil ?? '-',
            ];
        }

        return $rows;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 26,
            'C' => 24,
            'D' => 16,
            'E' => 12,
            'F' => 16,
            'G' => 18,
            'H' => 14,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['italic' => true, 'size' => 11]],
            3 => ['font' => ['size' => 10, 'color' => ['rgb' => '666666']]],
            4 => ['font' => ['bold' => true, 'size' => 11]],
            $this->headerRow => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                $sheet->mergeCells('A3:H3');
                $sheet->mergeCells('A4:H4');

                if ($this->pendaftars->count() > 0) {
                    $lastDataRow = $this->headerRow + $this->pendaftars->count();
                    $range = 'A' . $this->headerRow . ':H' . $lastDataRow;

                    $sheet->getStyle($range)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'CCCCCC'],
                            ],
                        ],
                    ]);
                }
            },
        ];
    }
}