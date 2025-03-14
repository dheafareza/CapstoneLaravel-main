<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

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
        // Ambil data pemasukan
        $pemasukan = DB::table('pemasukans')
            ->select(
                'pemasukans.tgl_pemasukan as tanggal',
                'pemasukans.jumlah',
                'sumber_pemasukans.nama as sumber',
                DB::raw("'Pemasukan' as jenis")
            )
            ->join('sumber_pemasukans', 'pemasukans.id_sumber_pemasukan', '=', 'sumber_pemasukans.id')
            ->whereBetween('pemasukans.tgl_pemasukan', [$this->start_date, $this->end_date])
            ->get();

        // Ambil data pengeluaran
        $pengeluaran = DB::table('pengeluarans')
            ->select(
                'pengeluarans.tgl_pengeluaran as tanggal',
                'pengeluarans.jumlah',
                'sumber_pengeluarans.nama as sumber',
                DB::raw("'Pengeluaran' as jenis")
            )
            ->join('sumber_pengeluarans', 'pengeluarans.id_sumber_pengeluaran', '=', 'sumber_pengeluarans.id')
            ->whereBetween('pengeluarans.tgl_pengeluaran', [$this->start_date, $this->end_date])
            ->get();

        // Konversi koleksi menjadi array dan tambahkan header tabel kedua dengan baris kosong sebagai pemisah
        $data = [];
        
        // Header Pemasukan
        $data[] = ['TANGGAL', 'JUMLAH', 'SUMBER', 'JENIS'];
        
        // Data Pemasukan
        foreach ($pemasukan as $item) {
            $data[] = [
                $item->tanggal,
                $item->jumlah,
                $item->sumber,
                $item->jenis
            ];
        }

        // Tambah baris kosong sebagai pemisah
        $data[] = ["", "", "", ""];

        // Header Pengeluaran
        $data[] = ['TANGGAL', 'JUMLAH', 'SUMBER', 'JENIS'];
        
        // Data Pengeluaran
        foreach ($pengeluaran as $item) {
            $data[] = [
                $item->tanggal,
                $item->jumlah,
                $item->sumber,
                $item->jenis
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return []; // Headings sudah ditambahkan dalam data
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk judul tabel pemasukan
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'FF4CAF50'],
            ],
        ]);

        // Style untuk judul tabel pengeluaran
        $rowPengeluaranHeader = count(DB::table('pemasukans')->whereBetween('tgl_pemasukan', [$this->start_date, $this->end_date])->get()) + 3;
        $sheet->getStyle("A{$rowPengeluaranHeader}:D{$rowPengeluaranHeader}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFF5733'],
            ],
        ]);
    }

    public function title(): string
    {
        return 'Laporan Keuangan';
    }
}
