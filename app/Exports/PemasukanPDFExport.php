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
        $data = Pemasukan::select(
            'pemasukans.id',
            'pemasukans.tgl_pemasukan',
            'pemasukans.jumlah',
            'sumber_pemasukans.nama as sumber_pemasukan'
        )
        ->join('sumber_pemasukans', 'pemasukans.id_sumber_pemasukan', '=', 'sumber_pemasukans.id')
        ->whereBetween('pemasukans.tgl_pemasukan', [$this->start_date, $this->end_date])
        ->get();    

        // Render data ke view
        $html = view('exports.pemasukan', compact('data'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Ukuran dan orientasi kertas
        $dompdf->render();

        // Unduh file PDF
        return $dompdf->stream('data_pemasukan.pdf', ['Attachment' => true]);
    }
}
