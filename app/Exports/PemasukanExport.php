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
    protected $start_date, $end_date, $tipe, $sumber;

    public function __construct($start_date, $end_date, $tipe = null, $sumber = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->tipe = $tipe;
        $this->sumber = $sumber;
    }

    public function collection()
    {
        $data = [];

        // Ambil data pemasukan jika tipe tidak hanya "Pengeluaran"
        if ($this->tipe != 'Pengeluaran') {
            $pemasukan = DB::table('pemasukans')
                ->select(
                    'pemasukans.tgl_pemasukan as tanggal',
                    'pemasukans.jumlah',
                    'sumber_pemasukans.nama as sumber',
                    DB::raw("'Pemasukan' as jenis")
                )
                ->join('sumber_pemasukans', 'pemasukans.id_sumber_pemasukan', '=', 'sumber_pemasukans.id')
                ->whereBetween('pemasukans.tgl_pemasukan', [$this->start_date, $this->end_date]);

            if ($this->sumber) {
                $pemasukan->where('sumber_pemasukans.nama', 'like', '%' . $this->sumber . '%');
            }

            $pemasukan = $pemasukan->get();

            // Tambahkan header dan data
            $data[] = ['TANGGAL', 'JUMLAH', 'SUMBER', 'JENIS'];
            foreach ($pemasukan as $item) {
                $data[] = [$item->tanggal, $item->jumlah, $item->sumber, $item->jenis];
            }
        }

        // Ambil data pengeluaran jika tipe tidak hanya "Pemasukan"
        if ($this->tipe != 'Pemasukan') {
            if (!empty($data)) {
                $data[] = ["", "", "", ""]; // baris kosong sebagai pemisah
            }

            $pengeluaran = DB::table('pengeluarans')
                ->select(
                    'pengeluarans.tgl_pengeluaran as tanggal',
                    'pengeluarans.jumlah',
                    'sumber_pengeluarans.nama as sumber',
                    DB::raw("'Pengeluaran' as jenis")
                )
                ->join('sumber_pengeluarans', 'pengeluarans.id_sumber_pengeluaran', '=', 'sumber_pengeluarans.id')
                ->whereBetween('pengeluarans.tgl_pengeluaran', [$this->start_date, $this->end_date]);

            if ($this->sumber) {
                $pengeluaran->where('sumber_pengeluarans.nama', 'like', '%' . $this->sumber . '%');
            }

            $pengeluaran = $pengeluaran->get();

            // Tambahkan header dan data
            $data[] = ['TANGGAL', 'JUMLAH', 'SUMBER', 'JENIS'];
            foreach ($pengeluaran as $item) {
                $data[] = [$item->tanggal, $item->jumlah, $item->sumber, $item->jenis];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return []; // Heading sudah langsung di-include di collection
    }

    public function styles(Worksheet $sheet)
    {
        $rowIndex = 1;
        $dataRowCount = 0;

        if ($this->tipe != 'Pengeluaran') {
            // Style header pemasukan
            $sheet->getStyle("A{$rowIndex}:D{$rowIndex}")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FF4CAF50'],
                ],
            ]);

            $pemasukanCount = DB::table('pemasukans')
                ->join('sumber_pemasukans', 'pemasukans.id_sumber_pemasukan', '=', 'sumber_pemasukans.id')
                ->whereBetween('pemasukans.tgl_pemasukan', [$this->start_date, $this->end_date]);

            if ($this->sumber) {
                $pemasukanCount->where('sumber_pemasukans.nama', 'like', '%' . $this->sumber . '%');
            }

            $dataRowCount += $pemasukanCount->count() + 2; // header + data
        }

        if ($this->tipe != 'Pemasukan') {
            $rowIndex = $dataRowCount + 1; // baris kosong + header
            $sheet->getStyle("A{$rowIndex}:D{$rowIndex}")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFFF5733'],
                ],
            ]);
        }
    }

    public function title(): string
    {
        return 'Laporan Keuangan';
    }
}
