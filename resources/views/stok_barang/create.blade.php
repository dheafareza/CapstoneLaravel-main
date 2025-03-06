@extends('layouts.app')

@section('title', 'Tambah Stok Barang')

@section('content')
<div class="container">
    <h1 class="mt-4">Tambah Stok Barang</h1>

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

    <form action="{{ route('stok_barang.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kode_barang" class="form-label">Kode Barang</label>
            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}" required>
        </div>

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
        </div>

        <div class="mb-3">
            <label for="ukuran" class="form-label">Ukuran</label>
            <input type="text" class="form-control" id="ukuran" name="ukuran" value="{{ old('ukuran') }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="tipe" class="form-label">Tipe Transaksi</label>
            <select class="form-control" id="tipe" name="tipe" required>
                <option value="" disabled selected>Pilih Tipe</option>
                <option value="In" {{ old('tipe') == 'In' ? 'selected' : '' }}>In</option>
                <option value="Out" {{ old('tipe') == 'Out' ? 'selected' : '' }}>Out</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('stok_barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
