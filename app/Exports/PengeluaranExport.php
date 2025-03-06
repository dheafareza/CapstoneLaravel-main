<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PengeluaranExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $start_date, $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $pengeluaran = Pengeluaran::select(
            'pengeluarans.id',
            'pengeluarans.tgl_pengeluaran',
            'pengeluarans.jumlah',
            'sumber_pengeluarans.nama as sumber_pengeluaran'
        )
        ->join('sumber_pengeluarans', 'pengeluarans.id_sumber_pengeluaran', '=', 'sumber_pengeluarans.id')
        ->whereBetween('pengeluarans.tgl_pengeluaran', [$this->start_date, $this->end_date])
        ->get();

        // Hitung total pengeluaran
        $totalPengeluaran = $pengeluaran->sum('jumlah');

        // Tambahkan nomor urut ke data pengeluaran
        $data = $pengeluaran->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Tgl Pengeluaran' => $item->tgl_pengeluaran,
                'Jumlah' => $item->jumlah,
                'Sumber' => $item->sumber_pengeluaran,
            ];
        });

        // Tambahkan total pengeluaran di akhir
        $data->push([
            'No' => '',
            'Tgl Pengeluaran' => 'Total Pengeluaran',
            'Jumlah' => $totalPengeluaran,
            'Sumber' => '',
        ]);

        return $data;
    }

    public function headings(): array
    {
        return ['No', 'Tgl Pengeluaran', 'Jumlah', 'Sumber'];
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
                'color' => ['argb' => 'FFFF5733'], // Warna merah
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

        // Style untuk total pengeluaran (baris terakhir)
        $lastRow = count($this->collection()) + 1;
        $sheet->getStyle("A{$lastRow}:D{$lastRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFC107'], // Warna kuning
            ],
        ]);
    }

    public function title(): string
    {
        return 'Data Pengeluaran';
    }
}