@extends('layouts.app')

@section('title', 'Daftar Admin')

@section('content')
<div class="container">
    <h1 class="mt-4">Daftar Akun</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Admin -->
    <div class="mb-3">
        <a href="{{ route('admin.create') }}" class="btn btn-primary">Tambah Akun</a>
    </div>

    <!-- Tabel Daftar Admin -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($admins as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->role->name ?? 'Tidak ada role' }}</td>
                    <td>
                        <!-- Tombol Aksi -->
                        <a href="{{ route('admin.show', $item->id_admin) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.edit', $item->id_admin) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.destroy', $item->id_admin) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data admin.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
