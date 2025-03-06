@extends('layouts.app')

@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="container">
    <h1 class="mt-4">Tambah Pengeluaran</h1>

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
    
    <!-- Form Tambah Pengeluaran -->
    <div class="col-lg-5 col-md-6 mb-4 custom-width">
    <div class="card">
            <div class="card-body">
            <h5 class="card-title">Tambah Pengeluaran</h5>
    <form id="formPengeluaran" action="{{ route('pengeluaran.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="tgl_pengeluaran">Tanggal Pengeluaran</label>
                        <input type="date" name="tgl_pengeluaran" id="tgl_pengeluaran" class="form-control" value="{{ old('tgl_pengeluaran') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah pengeluaran" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_sumber_pengeluaran">Sumber Pengeluaran</label>
                        <select id="id_sumber_pengeluaran" name="id_sumber_pengeluaran" class="form-select" required>
                            <option value="">-- Pilih Sumber --</option>
                            @foreach ($sumberPengeluaran as $sumber)
                                <option value="{{ $sumber->id }}" {{ old('id_sumber_pengeluaran') == $sumber->id ? 'selected' : '' }}>
                                    {{ $sumber->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Kembali</a>
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
