<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Karyawan;
use App\Models\StokBarang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah karyawan
        $karyawan = Karyawan::count();

        // Pengeluaran hari ini
        $pengeluaran_hari_ini = Pengeluaran::whereDate('tgl_pengeluaran', Carbon::today())->sum('jumlah');

        // Pemasukan hari ini
        $pemasukan_hari_ini = Pemasukan::whereDate('tgl_pemasukan', Carbon::today())->sum('jumlah');

        $pemasukan_hari_ini_data = Pemasukan::whereDate('tgl_pemasukan', Carbon::today())
        ->with('sumberPemasukan')
        ->get();

        // Total pemasukan dan pengeluaran
        $jumlahmasuk = Pemasukan::sum('jumlah');
        $jumlahkeluar = Pengeluaran::sum('jumlah');

        // Sisa uang
        $uang = $jumlahmasuk - $jumlahkeluar;

        // Data pendapatan minggu ini (7 hari terakhir tanpa duplikasi hari ini)
        $pendapatan_mingguan = Pemasukan::whereBetween('tgl_pemasukan', [Carbon::today()->subDays(6), Carbon::today()])
            ->orderBy('tgl_pemasukan', 'desc')
            ->with('sumberPemasukan')
            ->get();

        // Data untuk grafik pendapatan (7 hari terakhir)
        $chartLabels = [];
        $chartData = [];

        for ($i = 29; $i >= 0; $i--) { // Ambil data dari 29 hari lalu sampai hari ini
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $chartLabels[] = $date;
            $chartData[] = Pemasukan::whereDate('tgl_pemasukan', $date)->sum('jumlah');
        }

        // Ambil semua transaksi barang masuk/keluar
        $stokBarangs = StokBarang::all();
    
        // Hitung total stok berdasarkan transaksi
        $totalStok = StokBarang::select(
            'kode_barang',
            'nama_barang',
            'ukuran',
            DB::raw("SUM(CASE 
                        WHEN tipe = 'In' THEN quantity 
                        WHEN tipe = 'Out' THEN -quantity 
                        ELSE 0 END) as total_stok")
        )
        ->groupBy('kode_barang', 'nama_barang', 'ukuran')
        ->havingRaw('total_stok > 0') // Hanya tampilkan yang punya stok
        ->get();

        // Hitung total stok secara keseluruhan
        $totalStokValue = $totalStok->sum('total_stok');

        // Hitung total stok keluar
        $totalStokKeluar = StokBarang::select(
            'kode_barang',
            'nama_barang',
            'ukuran',
            DB::raw("SUM(CASE 
                        WHEN tipe = 'Out' THEN quantity 
                        ELSE 0 END) as total_stok_keluar")
        )
        ->groupBy('kode_barang', 'nama_barang', 'ukuran')
        ->havingRaw('total_stok_keluar > 0') // Hanya tampilkan yang punya stok keluar
        ->get();

        // Hitung total stok keluar keseluruhan
        $totalStokKeluarValue = $totalStokKeluar->sum('total_stok_keluar');

        // Hitung total barang masuk hari ini
        $totalBarangMasukHariIni = StokBarang::select(
            'kode_barang',
            'nama_barang',
            'ukuran',
            DB::raw("SUM(CASE 
                        WHEN tipe = 'In' AND DATE(tanggal) = CURDATE() THEN quantity 
                        ELSE 0 END) as total_barang_masuk")
        )
        ->groupBy('kode_barang', 'nama_barang', 'ukuran')
        ->havingRaw('total_barang_masuk > 0') // Hanya tampilkan barang yang masuk hari ini
        ->get();

        // Hitung total barang masuk hari ini secara keseluruhan
        $totalBarangMasukHariIniValue = $totalBarangMasukHariIni->sum('total_barang_masuk');

        // Hitung total barang keluar hari ini
        $totalBarangKeluarHariIni = StokBarang::select(
            'kode_barang',
            'nama_barang',
            'ukuran',
            DB::raw("SUM(CASE 
                        WHEN tipe = 'Out' AND DATE(tanggal) = CURDATE() THEN quantity 
                        ELSE 0 END) as total_barang_keluar")
        )
        ->groupBy('kode_barang', 'nama_barang', 'ukuran')
        ->havingRaw('total_barang_keluar > 0') // Hanya tampilkan barang yang keluar hari ini
        ->get();

        // Hitung total barang keluar hari ini secara keseluruhan
        $totalBarangKeluarHariIniValue = $totalBarangKeluarHariIni->sum('total_barang_keluar');

        // Data untuk grafik barang masuk dan keluar (menggunakan contoh data yang telah ada sebelumnya)
        $barangMasukData = [];
        $barangKeluarData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $barangMasukData[] = StokBarang::whereDate('tanggal', $date)->where('tipe', 'In')->sum('quantity');
            $barangKeluarData[] = StokBarang::whereDate('tanggal', $date)->where('tipe', 'Out')->sum('quantity');
        }

        $chartLabels = []; // Label untuk grafik (tanggal)
        for ($i = 29; $i >= 0; $i--) {
            $chartLabels[] = Carbon::today()->subDays($i)->format('Y-m-d');
        }

        return view('master', compact(
            'karyawan',
            'pengeluaran_hari_ini',
            'pemasukan_hari_ini',
            'pemasukan_hari_ini_data',
            'jumlahmasuk',
            'jumlahkeluar',
            'uang',
            'pendapatan_mingguan',
            'chartLabels',
            'chartData',
            'stokBarangs',
            'totalStok',
            'totalStokValue',
            'totalStokKeluar',
            'totalStokKeluarValue',
            'totalBarangMasukHariIni',
            'totalBarangMasukHariIniValue',
            'totalBarangKeluarHariIni',
            'totalBarangKeluarHariIniValue',
            'barangMasukData',
            'barangKeluarData'
        ));
    }
}