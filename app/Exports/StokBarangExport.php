<?php

namespace App\Exports;

use App\Models\StokBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StokBarangExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    /**
     * Ambil data untuk diexport.
     */
    public function collection()
    {
        return StokBarang::select('id','kode_barang', 'nama_barang', 'ukuran', 'total_stok')->get();
    }

    /**
     * Tambahkan heading pada file Excel.
     */
    public function headings(): array
    {
        return [
            'NO',
            'Kode Barang',
            'Nama Barang',
            'Ukuran',
            'Total Stok',
        ];        
    }

    /**
     * Tambahkan style ke file Excel.
     */
    public function styles(Worksheet $sheet)
    {
        // Heading style
        $sheet->getStyle('A1:H1')->applyFromArray([
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

        // Border styling
        $sheet->getStyle('A1:H100')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Set column width to auto-size
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    /**
     * Berikan judul untuk sheet Excel.
     */
    public function title(): string
    {
        return 'Data Stok Barang';
    }
}
