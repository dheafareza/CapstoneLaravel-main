<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua admin.
     */
    public function index()
    {
        $admins = Admin::with('role')->get(); // Mengambil semua data admin
        return view('admin.index', compact('admins'));
    }

    /**
     * Menampilkan form untuk menambahkan admin baru.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.create', compact('roles'));
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
            'role_id' => 'required|exists:roles,id',
        ]);

        // Simpan ke database
        Admin::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        // Redirect ke halaman daftar admin dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data admin.
     */
    public function show($id)
    {
        $admin = Admin::with('role')->findOrFail($id);
        return view('admin.show', compact('admin'));
    }
    
    /**
     * Menampilkan form untuk mengedit data admin.
     */
    public function edit($id_admin)
    {
        $admin = Admin::findOrFail($id_admin);
        $roles = Role::all();
        return view('admin.edit', compact('admin', 'roles'));
    }
    

    /**
     * Memperbarui data admin di database.
     */
    public function update(Request $request, $id_admin)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id_admin . ',id_admin',
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
    
        $admin = Admin::where('id_admin', $id_admin)->firstOrFail();
        $admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);
    
        if ($request->filled('password')) {
            $admin->update(['password' => Hash::make($request->password)]);
        }
    
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