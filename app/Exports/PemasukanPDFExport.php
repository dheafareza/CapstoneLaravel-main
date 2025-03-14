<?php

namespace App\Exports;

use App\Models\Pemasukan;
use Dompdf\Dompdf;
use Dompdf\Options;

class PemasukanPDFExport
{
    public function download()
    {
        // Ambil data pemasukan
        $pemasukan = Pemasukan::select(
            'pemasukans.tgl_pemasukan as tanggal',
            'pemasukans.jumlah',
            'sumber_pemasukans.nama as sumber',
            DB::raw("'Pemasukan' as jenis")
        )
        ->join('sumber_pemasukans', 'pemasukans.id_sumber_pemasukan', '=', 'sumber_pemasukans.id');

        // Ambil data pengeluaran
        $pengeluaran = Pengeluaran::select(
            'pengeluarans.tgl_pengeluaran as tanggal',
            'pengeluarans.jumlah',
            'sumber_pengeluarans.nama as sumber',
            DB::raw("'Pengeluaran' as jenis")
        )
        ->join('sumber_pengeluarans', 'pengeluarans.id_sumber_pengeluaran', '=', 'sumber_pengeluarans.id');

        // Gabungkan data pemasukan dan pengeluaran
        $data = $pemasukan->union($pengeluaran)->orderBy('tanggal')->get();

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $data->where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = $data->where('jenis', 'Pengeluaran')->sum('jumlah');

        // Render data ke view
        $html = view('exports.keuangan', compact('data', 'totalPemasukan', 'totalPengeluaran'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Ukuran dan orientasi kertas
        $dompdf->render();

        // Unduh file PDF
        return $dompdf->stream('data_keuangan.pdf', ['Attachment' => true]);
    }
}

