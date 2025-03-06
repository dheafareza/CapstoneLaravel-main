<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Menampilkan daftar semua karyawan.
     */
    public function index()
    {
        $karyawan = Karyawan::all(); // Mengambil semua data karyawan
        return view('karyawan.index', compact('karyawan'));
    }

    /**
     * Menampilkan form untuk menambahkan karyawan baru.
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Menyimpan data karyawan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'umur' => 'required|integer|min:0|max:150',
            'email' => 'required|email|unique:karyawans,email',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        // Simpan ke database
        Karyawan::create($request->all());

        // Redirect ke halaman daftar karyawan dengan pesan sukses
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data karyawan.
     */
    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id); // Cari karyawan berdasarkan ID
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Menampilkan form untuk mengedit data karyawan.
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id); // Cari karyawan berdasarkan ID
        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Memperbarui data karyawan di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'umur' => 'required|integer|min:0|max:150',
            'email' => 'required|email|unique:karyawans,email,' . $id,
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        // Cari karyawan dan update datanya
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->all());

        // Redirect ke halaman daftar karyawan dengan pesan sukses
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus data karyawan dari database.
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id); // Cari karyawan berdasarkan ID
        $karyawan->delete(); // Hapus data

        // Redirect ke halaman daftar karyawan dengan pesan sukses
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}