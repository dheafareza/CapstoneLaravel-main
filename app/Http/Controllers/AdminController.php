<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua admin.
     */
    public function index()
    {
        $admins = Admin::all(); // Mengambil semua data admin
        return view('admin.index', compact('admins'));
    }

    /**
     * Menampilkan form untuk menambahkan admin baru.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Menyimpan data admin baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan ke database
        Admin::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);

        // Redirect ke halaman daftar admin dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data admin.
     */
    public function show($id)
    {
        $admin = Admin::findOrFail($id); // Cari admin berdasarkan ID
        return view('admin.show', compact('admin'));
    }

    /**
     * Menampilkan form untuk mengedit data admin.
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id); // Cari admin berdasarkan ID
        $admin = User::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    /**
     * Memperbarui data admin di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Cari admin dan update datanya
        $admin = Admin::findOrFail($id);
        $admin->update($request->only(['nama', 'email']));
        $user = User::where('email', $admin->email)->first();
        if ($user) {
            $user->update([
                'name' => $request->nama,
                'email' => $request->username,
            ]);
        }
        // Redirect ke halaman daftar admin dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * Menghapus data admin dari database.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id); // Cari admin berdasarkan ID
        $admin->delete(); // Hapus data

        // Redirect ke halaman daftar admin dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}