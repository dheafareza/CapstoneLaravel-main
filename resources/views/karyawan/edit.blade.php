@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="container">
    <h1 class="mt-4">Edit Karyawan</h1>

    <!-- Tampilkan pesan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit Karyawan -->
    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control" 
                   value="{{ old('nama', $karyawan->nama) }}" placeholder="Masukkan nama karyawan" required>
        </div>

        <div class="form-group mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" id="jabatan" name="jabatan" class="form-control" 
                   value="{{ old('jabatan', $karyawan->jabatan) }}" placeholder="Masukkan jabatan" required>
        </div>

        <div class="form-group mb-3">
            <label for="umur" class="form-label">Umur</label>
            <input type="number" id="umur" name="umur" class="form-control" 
                   value="{{ old('umur', $karyawan->umur) }}" placeholder="Masukkan umur" required>
        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" 
                   value="{{ old('email', $karyawan->email) }}" placeholder="Masukkan email" required>
        </div>

        <div class="form-group mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" id="no_telp" name="no_telp" class="form-control" 
                   value="{{ old('no_telp', $karyawan->no_telp) }}" placeholder="Masukkan no. telepon" required>
        </div>

        <div class="form-group mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control" 
                      placeholder="Masukkan alamat" required>{{ old('alamat', $karyawan->alamat) }}</textarea>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
