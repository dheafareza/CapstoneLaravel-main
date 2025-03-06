<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Dompdf\Dompdf;
use Dompdf\Options;

class PengeluaranPDFExport
{
    public function download()
    {
        // Ambil data pengeluaran
        $data = Pengeluaran::select('pengeluarans.id', 'pengeluarans.tgl_pengeluaran', 'pengeluarans.jumlah', 'sumber_pengeluarans.nama as sumber_pengeluaran')
        
        ->join('sumber_pengeluarans', 'pengeluarans.id_sumber_pengeluaran', '=', 'sumber_pengeluarans.id')
        ->get(); 

        // Render data ke view
        $html = view('exports.pengeluaran', compact('data'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Ukuran dan orientasi kertas
        $dompdf->render();

        // Unduh file PDF
        return $dompdf->stream('data_pengeluaran.pdf', ['Attachment' => true]);
    }
}
