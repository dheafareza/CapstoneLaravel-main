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

        $pemasukan = Pemasukan::whereBetween('tgl_pemasukan', [$startDate, $endDate])->get();
        $pengeluaran = Pengeluaran::whereBetween('tgl_pengeluaran', [$startDate, $endDate])->get();

        $totalPemasukan = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');

        $sumberPemasukan = SumberPemasukan::all()->map(fn($sumber) => $this->hitungSumber($sumber, 'pemasukan', $totalPemasukan));
        $sumberPengeluaran = SumberPengeluaran::all()->map(fn($sumber) => $this->hitungSumber($sumber, 'pengeluaran', $totalPengeluaran));

        $laporanKeuangan = $pemasukan->map(fn($item) => [
            'tanggal' => $item->tgl_pemasukan,
            'tipe' => 'Pemasukan',
            'sumber' => $item->sumberPemasukan->nama ?? 'Tidak Diketahui',
            'jumlah' => $item->jumlah
        ])->merge($pengeluaran->map(fn($item) => [
            'tanggal' => $item->tgl_pengeluaran,
            'tipe' => 'Pengeluaran',
            'sumber' => $item->sumberPengeluaran->nama ?? 'Tidak Diketahui',
            'jumlah' => $item->jumlah
        ]))->sortByDesc('tanggal');

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
