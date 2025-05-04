<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use Illuminate\Http\Request;
use App\Exports\StokBarangExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class StokBarangController extends Controller
{
    /**
     * Tampilkan daftar stok barang.
     */
    public function index()
    {
        
        // Ambil semua transaksi barang masuk/keluar
        $stokBarangs = StokBarang::with('createdBy')->get();
    
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
        
            
        return view('stok_barang.index', compact('stokBarangs', 'totalStok'));
    }

    /**
     * Tampilkan form tambah stok barang.
     */
    public function create()
    {
        return view('stok_barang.create');
    }

    /**
     * Simpan data stok barang baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:225',
            'nama_barang' => 'required|string|max:225',
            'ukuran' => 'required|string|max:225',
            'tanggal' => 'required|date',
            'tipe' => 'required|in:In,Out',
            'quantity' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
    
        $stokSebelumnya = StokBarang::where('kode_barang', $request->kode_barang)
        ->where('nama_barang', $request->nama_barang)
        ->where('ukuran', $request->ukuran)
        ->sum(DB::raw("CASE WHEN tipe = 'In' THEN quantity ELSE -quantity END"));    
    
        $total_stok = ($request->tipe === 'In') 
            ? $stokSebelumnya + $request->quantity 
            : max(0, $stokSebelumnya - $request->quantity);
        
        StokBarang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'ukuran' => $request->ukuran,
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'quantity' => $request->quantity,
            'total_stok' => $total_stok,
            'created_by' => auth()->id(),
        ]);
    
        return redirect()->route('stok_barang.index')->with('success', 'Stok barang berhasil ditambahkan.');
    }
    

    /**
     * Tampilkan detail stok barang.
     */
    public function show($id)
    {
        $stokBarang = StokBarang::findOrFail($id);
        return view('stok_barang.show', compact('stokBarang'));
    }

    /**
     * Tampilkan form edit stok barang.
     */
    public function edit($id)
    {
        $stokBarang = StokBarang::findOrFail($id);
        return view('stok_barang.edit', compact('stokBarang'));
    }

    /**
     * Perbarui data stok barang.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:225',
            'nama_barang' => 'required|string|max:225',
            'ukuran' => 'required|string|max:225',
            'tanggal' => 'required|date',
            'tipe' => 'required|in:In,Out',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $stokBarang = StokBarang::findOrFail($id);
    
        // Hitung ulang stok sebelumnya, kecuali stok yang sedang diedit
        $stokSebelumnya = StokBarang::where('kode_barang', $stokBarang->kode_barang)
        ->where('nama_barang', $stokBarang->nama_barang)
        ->where('ukuran', $stokBarang->ukuran)
        ->where('id', '!=', $id) // Hindari menghitung stok dari item yang sedang diedit
        ->sum(DB::raw("CASE WHEN tipe = 'In' THEN quantity ELSE -quantity END"));    
    
        // Perhitungan stok baru
        $total_stok = ($request->tipe === 'In') 
            ? $stokSebelumnya + $request->quantity 
            : max(0, $stokSebelumnya - $request->quantity); // Hindari stok negatif
    
        $stokBarang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'ukuran' => $request->ukuran,
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'quantity' => $request->quantity,
            'total_stok' => $total_stok,
        ]);
    
        return redirect()->route('stok_barang.index')->with('success', 'Stok barang berhasil diperbarui.');
    }
    

    /**
     * Hapus stok barang.
     */
    public function destroy($id)
    {
        $stokBarang = StokBarang::findOrFail($id);
        $stokBarang->delete();
        return redirect()->route('stok_barang.index')->with('success', 'Stok barang berhasil dihapus.');
    }

    /**
     * Export stok barang ke Excel.
     */
    public function export()
    {
        return Excel::download(new StokBarangExport, 'stok_barang.xlsx');
    }

    /**
     * Export stok barang ke PDF.
     */
    public function exportStokBarangPDF()
    {
        $stok_barang = StokBarang::all();
        $pdf = Pdf::loadView('exports.stok_barang', compact('stok_barang'));
        return $pdf->download('Data_Stok_Barang.pdf');
    }
}
