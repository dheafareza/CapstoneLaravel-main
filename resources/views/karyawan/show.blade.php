@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="container">
    <h1 class="mt-4">Detail Karyawan</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Karyawan</h5>
            <table class="table table-bordered mt-3">
                <tr>
                    <th>Nama</th>
                    <td>{{ $karyawan->nama }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $karyawan->jabatan }}</td>
                </tr>
                <tr>
                    <th>Umur</th>
                    <td>{{ $karyawan->umur }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $karyawan->email }}</td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td>{{ $karyawan->no_telp }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $karyawan->alamat }}</td>
                </tr>
            </table>
            <div class="mt-4">
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
