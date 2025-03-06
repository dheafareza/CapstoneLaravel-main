@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="container">
    <h1 class="mt-4">Tambah Karyawan</h1>

    <!-- Tampilkan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- Form Tambah Karyawan -->
    <div class="col-lg-5 col-md-6 mb-4 custom-width">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambah Karyawan</h5>
                <form id="formKaryawan" action="{{ route('karyawan.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" placeholder="Masukkan nama karyawan" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ old('jabatan') }}" placeholder="Masukkan jabatan" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="umur">Umur</label>
                        <input type="number" name="umur" id="umur" class="form-control" value="{{ old('umur') }}" placeholder="Masukkan umur" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="no_telp">No. Telepon</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control" value="{{ old('no_telp') }}" placeholder="Masukkan no. telepon" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat" required>{{ old('alamat') }}</textarea>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.custom-width {
    width: 70%; 
    padding-bottom: 90px;
    height: 70%;
}
</style>
@endsection
