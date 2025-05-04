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
    protected $start_date, $end_date, $sumber;

    public function __construct($start_date, $end_date, $sumber = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->sumber = $sumber;
    }

    public function collection()
    {
        $query = DB::table('pengeluarans')
            ->select(
                'pengeluarans.tgl_pengeluaran',
                'pengeluarans.jumlah',
                'sumber_pengeluarans.nama as sumber'
            )
            ->join('sumber_pengeluarans', 'pengeluarans.id_sumber_pengeluaran', '=', 'sumber_pengeluarans.id')
            ->whereBetween('pengeluarans.tgl_pengeluaran', [$this->start_date, $this->end_date]);

        if ($this->sumber) {
            $query->where('sumber_pengeluarans.nama', 'like', '%' . $this->sumber . '%');
        }

        $pengeluaran = $query->get();

        $total = $pengeluaran->sum('jumlah');

        $data = collect();

        foreach ($pengeluaran as $index => $item) {
            $data->push([
                'No' => $index + 1,
                'Tgl Pengeluaran' => $item->tgl_pengeluaran,
                'Jumlah' => $item->jumlah,
                'Sumber' => $item->sumber,
            ]);
        }

        $data->push([
            'No' => '',
            'Tgl Pengeluaran' => 'Total Pengeluaran',
            'Jumlah' => $total,
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
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFF5733'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $lastRow = count($this->collection()) + 1;

        $sheet->getStyle("A1:D{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        $sheet->getStyle("A{$lastRow}:D{$lastRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFC107'],
            ],
        ]);
    }

    public function title(): string
    {
        return 'Data Pengeluaran';
    }
}
