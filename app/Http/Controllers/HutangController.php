<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HutangController extends Controller
{
    /**
     * Menampilkan daftar semua hutang.
     */
    public function index()
    {
        // Total pemasukan dan pengeluaran
        $jumlahmasuk = Pemasukan::sum('jumlah');
        $jumlahkeluar = Pengeluaran::sum('jumlah');
        $uang = $jumlahmasuk - $jumlahkeluar;
    
        // Data untuk chart area (7 hari terakhir)
        $chartData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = Pemasukan::whereDate('tgl_pemasukan', $date)->sum('jumlah');
        }
    
        // Ambil data hutang berdasarkan status
        $hutangBelumLunas = Hutang::where('status', 'belum lunas')->get();
        $hutangLunas = Hutang::where('status', 'lunas')->get();
    
        return view('hutang.index', compact(
            'hutangBelumLunas', 
            'hutangLunas', 
            'jumlahmasuk', 
            'jumlahkeluar', 
            'uang', 
            'chartData'
        ));
    }

    /**
     * Menampilkan form untuk menambahkan hutang baru.
     */
    public function create()
    {
        return view('hutang.create');
    }

    /**
     * Menyimpan data hutang baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'tgl_hutang' => 'required|date',
            'alasan' => 'required|string',
            'penghutang' => 'required|string|max:40',
            'keterangan' => 'required|string',
        ]);

        // Simpan ke database
        Hutang::create($request->all());

        // Redirect ke halaman daftar hutang dengan pesan sukses
        return redirect()->route('hutang.index')->with('success', 'Hutang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data hutang.
     */
    public function show($id)
    {
        $hutang = Hutang::findOrFail($id); // Cari hutang berdasarkan ID
        return view('hutang.show', compact('hutang'));
    }

    /**
     * Menampilkan form untuk mengedit data hutang.
     */
    public function edit($id)
    {
        $hutang = Hutang::findOrFail($id); // Cari hutang berdasarkan ID
        return view('hutang.edit', compact('hutang'));
    }

    /**
     * Memperbarui data hutang di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'tgl_hutang' => 'required|date',
            'alasan' => 'required|string',
            'penghutang' => 'required|string|max:40',
            'keterangan' => 'required|string',
        ]);

        // Cari hutang dan update datanya
        $hutang = Hutang::findOrFail($id);
        $hutang->update($request->all());

        // Redirect ke halaman daftar hutang dengan pesan sukses
        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil diperbarui.');
    }

    /**
     * Menghapus data hutang dari database.
     */
    public function destroy($id)
    {
        $hutang = Hutang::findOrFail($id); // Cari hutang berdasarkan ID
        $hutang->delete(); 

        // Redirect ke halaman daftar hutang dengan pesan sukses
        return redirect()->route('hutang.index')->with('success', 'Hutang berhasil dihapus.');
    }

    public function lunasi($id)
{
    $hutang = Hutang::findOrFail($id);
    $hutang->update(['status' => 'lunas']);

    return redirect()->route('hutang.index')->with('success', 'Hutang berhasil dilunasi.');
}

}
