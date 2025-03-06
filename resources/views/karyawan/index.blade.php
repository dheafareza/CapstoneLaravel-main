@extends('layouts.app')

@section('title', 'Daftar Karyawan')

@section('content')
<div class="container">
    <h1 class="mt-4">Daftar Karyawan</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Karyawan -->
    <div class="mb-3">
        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">Tambah Karyawan</a>
    </div>

    <!-- Tabel Daftar Karyawan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Umur</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($karyawan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->umur }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>
                        <!-- Tombol Aksi -->
                        <a href="{{ route('karyawan.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('karyawan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data karyawan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
