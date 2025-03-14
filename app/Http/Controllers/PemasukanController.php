<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\SumberPemasukan;
use Illuminate\Http\Request;
use App\Exports\PemasukanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PemasukanController extends Controller
{
    /**
     * Menampilkan daftar semua pemasukan.
     */

    public function index()
    {
        // Dapatkan data semua sumber pemasukan
        $sumberPemasukan= SumberPemasukan::all()->map(function ($sumber) {
            $total = Pemasukan::where('id_sumber_pemasukan', $sumber->id)->sum('jumlah');
            $jumlahTransaksi = Pemasukan::where('id_sumber_pemasukan', $sumber->id)->count();
            $totalKeseluruhan = Pemasukan::sum('jumlah');
            $persentase = $totalKeseluruhan > 0 ? ($total / $totalKeseluruhan) * 100 : 0;

            // Tentukan warna progress bar berdasarkan ID sumber
            $warna = match ($sumber->id) {
                1 => 'bg-danger',   // Warna merah
                2 => 'bg-warning',  // Warna kuning
                3 => 'bg-info',     // Warna biru muda
                4 => 'bg-primary',  // Warna biru
                5 => 'bg-success',  // Warna hijau
                default => 'bg-secondary', // Default warna abu-abu
            };

            return [
                'nama' => $sumber->nama,
                'total' => $total,
                'jumlah_transaksi' => $jumlahTransaksi,
                'persentase' => round($persentase, 2),
                'warna' => $warna,
            ];
        });

        // Ambil semua data pemasukan untuk tabel
        $pemasukan = Pemasukan::all();

        return view('pemasukan.index', compact('sumberPemasukan', 'pemasukan'));
    }

    public function create()
    {
        $sumberPemasukan = SumberPemasukan::all(); // Mengambil semua data sumber pemasukan untuk dropdown
        return view('pemasukan.create', compact('sumberPemasukan'));
    }


    /**
     * Menyimpan data pemasukan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tgl_pemasukan' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'id_sumber_pemasukan' => 'required|exists:sumber_pemasukans,id',
        ]);

        // Simpan ke database
        Pemasukan::create($request->all());

        // Redirect ke halaman daftar pemasukan dengan pesan sukses
        return redirect()->route('pemasukan.index')->with('success', 'Pemasukan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data pemasukan.
     */
    public function show($id)
    {
        $pemasukan = Pemasukan::with('sumberPemasukan')->findOrFail($id); // Cari pemasukan berdasarkan ID dan relasi sumber
        return view('pemasukan.show', compact('pemasukan'));
    }

    /**
     * Menampilkan form untuk mengedit data pemasukan.
     */
    public function edit($id)
    {
        $pemasukan = Pemasukan::findOrFail($id); // Cari pemasukan berdasarkan ID
        $sumberPemasukan = SumberPemasukan::all(); // Mengambil semua data sumber pemasukan untuk dropdown
        return view('pemasukan.edit', compact('pemasukan', 'sumberPemasukan'));
    }

    /**
     * Memperbarui data pemasukan di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tgl_pemasukan' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'id_sumber_pemasukan' => 'required|exists:sumber_pemasukans,id',
        ]);

        // Cari pemasukan dan update datanya
        $pemasukan = Pemasukan::findOrFail($id);
        $pemasukan->update($request->all());

        // Redirect ke halaman daftar pemasukan dengan pesan sukses
        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil diperbarui.');
    }

    /**
     * Menghapus data pemasukan dari database.
     */
    public function destroy($id)
    {
        $pemasukan = Pemasukan::findOrFail($id); // Cari pemasukan berdasarkan ID
        $pemasukan->delete(); // Hapus data

        // Redirect ke halaman daftar pemasukan dengan pesan sukses
        return redirect()->route('pemasukan.index')->with('success', 'Pemasukan berhasil dihapus.');
    }

    public function exportPemasukan()
    {
    return Excel::download(new PemasukanExport, 'Data_Pemasukan.xlsx');
    }
}
