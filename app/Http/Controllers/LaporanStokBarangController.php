<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use App\Exports\StokBarangExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanStokBarangController extends Controller
{
    public function index(Request $request)
    {
        $end_date = $request->end_date ?? now()->toDateString();
        $nama_barang = $request->nama_barang;

        // Query stok barang berdasarkan filter tanggal akhir dan nama barang
        $stokBarangs = StokBarang::select(
            'kode_barang',
            'nama_barang',
            'ukuran',
            DB::raw("SUM(CASE 
                        WHEN tipe = 'In' THEN quantity 
                        WHEN tipe = 'Out' THEN -quantity 
                        ELSE 0 END) as total_stok")
        )
        ->whereDate('tanggal', '<=', $end_date)
        ->when($nama_barang, function ($query) use ($nama_barang) {
            $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
        })
        ->groupBy('kode_barang', 'nama_barang', 'ukuran')
        ->havingRaw('total_stok > 0')
        ->get();

        // Hitung total masuk dan keluar
        $jumlahMasuk = StokBarang::where('tipe', 'In')
            ->whereDate('tanggal', '<=', $end_date)
            ->when($nama_barang, function ($query) use ($nama_barang) {
                $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
            })
            ->sum('quantity');

        $jumlahKeluar = StokBarang::where('tipe', 'Out')
            ->whereDate('tanggal', '<=', $end_date)
            ->when($nama_barang, function ($query) use ($nama_barang) {
                $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
            })
            ->sum('quantity');

        $totalTransaksiMasuk = StokBarang::where('tipe', 'In')
            ->whereDate('tanggal', '<=', $end_date)
            ->when($nama_barang, function ($query) use ($nama_barang) {
                $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
            })
            ->count();

        $totalTransaksiKeluar = StokBarang::where('tipe', 'Out')
            ->whereDate('tanggal', '<=', $end_date)
            ->when($nama_barang, function ($query) use ($nama_barang) {
                $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
            })
            ->count();

        return view('laporan.stok_barang', compact(
            'stokBarangs',
            'jumlahMasuk',
            'jumlahKeluar',
            'totalTransaksiMasuk',
            'totalTransaksiKeluar'
        ));
    }

    /**
     * Export laporan stok barang ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $endDate = $request->query('end_date', now()->toDateString());
        $namaBarang = $request->query('nama_barang');

        return Excel::download(new StokBarangExport($endDate, $namaBarang), 'Laporan_Stok_Barang.xlsx');
    }

    /**
     * Export laporan stok barang ke PDF.
     */
    public function exportPDF(Request $request)
    {
        $endDate = $request->query('end_date', now()->toDateString());
        $namaBarang = $request->query('nama_barang');

        $stok_barang = StokBarang::whereDate('tanggal', '<=', $endDate)
            ->when($namaBarang, function ($query) use ($namaBarang) {
                $query->where('nama_barang', 'like', '%' . $namaBarang . '%');
            })
            ->get();

        $pdf = Pdf::loadView('exports.laporan_stok_barang', compact('stok_barang', 'endDate', 'namaBarang'));

        return $pdf->download("Laporan_Stok_Barang_sampai_{$endDate}.pdf");
    }
}
