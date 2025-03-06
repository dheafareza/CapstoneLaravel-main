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
    /**
     * Tampilkan laporan stok barang.
     */
    public function index(Request $request)
{
    // Ambil nilai start_date dan end_date dari request
    $start_date = $request->start_date;
    $end_date = $request->end_date;

    // Query stok barang berdasarkan filter tanggal jika ada
    $query = StokBarang::query();

    if ($start_date && $end_date) {
        $query->whereBetween('tanggal', [$start_date, $end_date]);
    }

    // Hitung total stok per barang
    $stokBarangs = StokBarang::select(
        'kode_barang',
        'nama_barang',
        'ukuran',
        DB::raw("SUM(CASE 
                    WHEN tipe = 'In' THEN quantity 
                    WHEN tipe = 'Out' THEN -quantity 
                    ELSE 0 END) as total_stok")
    )
    ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
        $q->whereBetween('tanggal', [$start_date, $end_date]);
    })
    ->groupBy('kode_barang', 'nama_barang', 'ukuran')
    ->havingRaw('total_stok > 0') // Hanya tampilkan yang masih ada stoknya
    ->get();

    // Hitung total barang masuk & keluar
    $jumlahMasuk = StokBarang::where('tipe', 'In')
        ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
            $q->whereBetween('tanggal', [$start_date, $end_date]);
        })
        ->sum('quantity');

    $jumlahKeluar = StokBarang::where('tipe', 'Out')
        ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
            $q->whereBetween('tanggal', [$start_date, $end_date]);
        })
        ->sum('quantity');

    // Hitung total transaksi masuk & keluar
    $totalTransaksiMasuk = StokBarang::where('tipe', 'In')
        ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
            $q->whereBetween('tanggal', [$start_date, $end_date]);
        })
        ->count();

    $totalTransaksiKeluar = StokBarang::where('tipe', 'Out')
        ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
            $q->whereBetween('tanggal', [$start_date, $end_date]);
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
    $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
    $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

    return Excel::download(new StokBarangExport($startDate, $endDate), 'Laporan_Stok_Barang.xlsx');
}

    /**
     * Export laporan stok barang ke PDF.
     */
    public function exportPDF(Request $request)
    {
        // Ambil tanggal dari request (default: awal dan akhir bulan ini)
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());
    
        // Query stok barang berdasarkan rentang tanggal yang dipilih
        $stok_barang = StokBarang::whereBetween('tanggal', [$startDate, $endDate])->get();
    
        // Generate PDF dengan data yang telah difilter
        $pdf = Pdf::loadView('exports.laporan_stok_barang', compact('stok_barang', 'startDate', 'endDate'));
    
        return $pdf->download("Laporan_Stok_Barang_{$startDate}_to_{$endDate}.pdf");
    }
}
