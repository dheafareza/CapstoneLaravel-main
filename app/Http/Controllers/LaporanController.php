<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\SumberPemasukan;
use App\Models\SumberPengeluaran;
use App\Exports\PemasukanExport;
use App\Exports\PengeluaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
{
    $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
    $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());
    $tipe = $request->query('tipe');
    $sumber = $request->query('sumber');

    // Query awal
    $pemasukanQuery = Pemasukan::whereBetween('tgl_pemasukan', [$startDate, $endDate]);
    $pengeluaranQuery = Pengeluaran::whereBetween('tgl_pengeluaran', [$startDate, $endDate]);

    // Filter sumber
    if ($sumber) {
        $pemasukanQuery->whereHas('sumberPemasukan', function ($q) use ($sumber) {
            $q->where('nama', 'like', '%' . $sumber . '%');
        });

        $pengeluaranQuery->whereHas('sumberPengeluaran', function ($q) use ($sumber) {
            $q->where('nama', 'like', '%' . $sumber . '%');
        });
    }

    // Filter tipe
    if ($tipe == 'Pemasukan') {
        $pengeluaran = collect();
        $pemasukan = $pemasukanQuery->get();
    } elseif ($tipe == 'Pengeluaran') {
        $pemasukan = collect();
        $pengeluaran = $pengeluaranQuery->get();
    } else {
        $pemasukan = $pemasukanQuery->get();
        $pengeluaran = $pengeluaranQuery->get();
    }

    $totalPemasukan = $pemasukan->sum('jumlah');
    $totalPengeluaran = $pengeluaran->sum('jumlah');

    // Hitung sumber pemasukan
    $sumberPemasukan = SumberPemasukan::all()->map(function ($sumber) use ($totalPemasukan) {
        return $this->hitungSumber($sumber, 'pemasukan', $totalPemasukan);
    });

    // Hitung sumber pengeluaran
    $sumberPengeluaran = SumberPengeluaran::all()->map(function ($sumber) use ($totalPengeluaran) {
        return $this->hitungSumber($sumber, 'pengeluaran', $totalPengeluaran);
    });

    // Gabungkan pemasukan dan pengeluaran
    $laporanKeuangan = collect();

    foreach ($pemasukan as $item) {
        $laporanKeuangan->push([
            'tanggal' => $item->tgl_pemasukan,
            'tipe' => 'Pemasukan',
            'sumber' => $item->sumberPemasukan->nama ?? 'Tidak Diketahui',
            'jumlah' => $item->jumlah
        ]);
    }

    foreach ($pengeluaran as $item) {
        $laporanKeuangan->push([
            'tanggal' => $item->tgl_pengeluaran,
            'tipe' => 'Pengeluaran',
            'sumber' => $item->sumberPengeluaran->nama ?? 'Tidak Diketahui',
            'jumlah' => $item->jumlah
        ]);
    }

    // Urutkan berdasarkan tanggal
    $laporanKeuangan = $laporanKeuangan->sortByDesc('tanggal');

    return view('laporan.index', compact(
        'sumberPemasukan',
        'sumberPengeluaran',
        'pemasukan',
        'pengeluaran',
        'laporanKeuangan',
        'startDate',
        'endDate',
        'totalPemasukan',
        'totalPengeluaran'
    ));
}


    private function hitungSumber($sumber, $tipe, $totalKeseluruhan)
    {
        $model = $tipe === 'pemasukan' ? Pemasukan::class : Pengeluaran::class;
        $kolom = $tipe === 'pemasukan' ? 'id_sumber_pemasukan' : 'id_sumber_pengeluaran';

        $total = $model::where($kolom, $sumber->id)->sum('jumlah');
        $jumlahTransaksi = $model::where($kolom, $sumber->id)->count();
        $persentase = $totalKeseluruhan > 0 ? ($total / $totalKeseluruhan) * 100 : 0;

        return [
            'nama' => $sumber->nama,
            'total' => $total,
            'jumlah_transaksi' => $jumlahTransaksi,
            'persentase' => round($persentase, 2),
            'warna' => $this->getWarna($sumber->id),
        ];
    }

    private function getWarna($id)
    {
        return match ($id) {
            1 => 'bg-danger',
            2 => 'bg-warning',
            3 => 'bg-info',
            4 => 'bg-primary',
            5 => 'bg-success',
            default => 'bg-secondary',
        };
    }

    public function exportPemasukan(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

        return Excel::download(new PemasukanExport($startDate, $endDate), 'Laporan_Keuangan.xlsx');
    }

    public function exportPemasukanPDF(Request $request)
{
    $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
    $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

    // Ambil data pemasukan
    $pemasukan = Pemasukan::whereBetween('tgl_pemasukan', [$startDate, $endDate])->get();
    $totalPemasukan = $pemasukan->sum('jumlah');

    // Ambil data pengeluaran
    $pengeluaran = Pengeluaran::whereBetween('tgl_pengeluaran', [$startDate, $endDate])->get();
    $totalPengeluaran = $pengeluaran->sum('jumlah');

    // Generate PDF
    $pdf = Pdf::loadView('exports.pemasukan', compact(
        'pemasukan',
        'totalPemasukan',
        'pengeluaran',
        'totalPengeluaran',
        'startDate',
        'endDate'
    ));

    return $pdf->download('Data_Keuangan_' . $startDate . '_to_' . $endDate . '.pdf');
}

    
}
