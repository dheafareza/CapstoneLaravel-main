@extends('layouts.app')

@section('title', 'Tambah Hutang')

@section('content')
<div class="container">
    <h1 class="mt-4">Tambah Hutang</h1>

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
    
    <!-- Form Tambah Hutang -->
    <div class="col-lg-5 col-md-6 mb-4 custom-width">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Form Tambah Hutang</h5>
                <form id="formHutang" action="{{ route('hutang.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="tgl_hutang">Tanggal Hutang</label>
                        <input type="date" name="tgl_hutang" id="tgl_hutang" class="form-control" value="{{ old('tgl_hutang') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah hutang" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="alasan">Barang</label>
                        <textarea name="alasan" id="alasan" class="form-control" rows="3" placeholder="Masukkan nama barang" required>{{ old('alasan') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="penghutang">Penghutang</label>
                        <input type="text" name="penghutang" id="penghutang" class="form-control" value="{{ old('penghutang') }}" placeholder="Nama penghutang" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan" required>{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('hutang.index') }}" class="btn btn-secondary">Kembali</a>
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
