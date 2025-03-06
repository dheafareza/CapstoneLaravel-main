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

        // Total pemasukan dan pengeluaran
        $jumlahmasuk = Pemasukan::sum('jumlah');
        $jumlahkeluar = Pengeluaran::sum('jumlah');

        // Sisa uang
        $uang = $jumlahmasuk - $jumlahkeluar;

        // Data untuk chart area (7 hari terakhir)
        $chartData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = Pemasukan::whereDate('tgl_pemasukan', $date)->sum('jumlah');
        }

        // Membalik array agar urutannya dari hari ke-7 ke hari ini
        $chartData = array_reverse($chartData);

        return view('master', compact(
            'karyawan',
            'pengeluaran_hari_ini',
            'pemasukan_hari_ini',
            'jumlahmasuk',
            'jumlahkeluar',
            'uang',
            'chartData'
        ));
    }
}