<?php

namespace App\Exports;

use App\Models\Pemasukan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PemasukanExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $start_date, $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $pemasukan = Pemasukan::select(
            'pemasukans.id',
            'pemasukans.tgl_pemasukan',
            'pemasukans.jumlah',
            'sumber_pemasukans.nama as sumber_pemasukan'
        )
        ->join('sumber_pemasukans', 'pemasukans.id_sumber_pemasukan', '=', 'sumber_pemasukans.id')
        ->whereBetween('pemasukans.tgl_pemasukan', [$this->start_date, $this->end_date])
        ->get();

        // Hitung total pemasukan
        $totalPemasukan = $pemasukan->sum('jumlah');

        // Tambahkan nomor urut ke data pemasukan
        $data = $pemasukan->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Tgl Pemasukan' => $item->tgl_pemasukan,
                'Jumlah' => $item->jumlah,
                'Sumber' => $item->sumber_pemasukan,
            ];
        });

        // Tambahkan total pemasukan di akhir
        $data->push([
            'No' => '',
            'Tgl Pemasukan' => 'Total Pemasukan',
            'Jumlah' => $totalPemasukan,
            'Sumber' => '',
        ]);

        return $data;
    }

    public function headings(): array
    {
        return ['No', 'Tgl Pemasukan', 'Jumlah', 'Sumber'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FF4CAF50'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:D100')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Style untuk total pemasukan (baris terakhir)
        $lastRow = count($this->collection()) + 1;
        $sheet->getStyle("A{$lastRow}:D{$lastRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFC107'], // Kuning
            ],
        ]);
    }

    public function title(): string
    {
        return 'Data Pemasukan';
    }
}