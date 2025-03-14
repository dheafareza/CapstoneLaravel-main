<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Karyawan;
use Carbon\Carbon;

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
            'chartData'
        ));
    }
}