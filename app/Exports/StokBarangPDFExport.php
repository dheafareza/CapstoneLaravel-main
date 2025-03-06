<?php

namespace App\Exports;

use App\Models\StokBarang;
use Dompdf\Dompdf;
use Dompdf\Options;

class StokBarangPDFExport
{
    public function download()
    {
        // Ambil data stok barang
        $data = StokBarang::select('id', 'kode_barang', 'nama_barang', 'ukuran',  'tipe', 'quantity', 'total_stok')->get();

        // Render data ke view
        $html = view('exports.stok_barang', compact('data'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Ukuran dan orientasi kertas
        $dompdf->render();

        // Unduh file PDF
        return $dompdf->stream('stok_barang.pdf', ['Attachment' => true]);
    }
}
