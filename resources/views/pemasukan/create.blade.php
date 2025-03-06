@extends('layouts.app')

@section('title', 'Tambah Pemasukan')

@section('content')
<div class="container">
    <h1 class="mt-4">Tambah Pemasukan</h1>

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
    
    <!-- Form Tambah Pemasukan -->
    <div class="col-lg-5 col-md-6 mb-4 custom-width">
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tambah Pendapatan</h5>
              <form id="formPemasukan" action="{{ route('pemasukan.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="tgl_pemasukan">Tanggal Pemasukan</label>
                        <input type="date" name="tgl_pemasukan" id="tgl_pemasukan" class="form-control" value="{{ old('tgl_pemasukan') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah pemasukan" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_sumber_pemasukan">Sumber Pemasukan</label>
                        <select id="id_sumber_pemasukan" name="id_sumber_pemasukan" class="form-select" required>
                            <option value="">-- Pilih Sumber --</option>
                            @foreach ($sumberPemasukan as $sumber)
                                <option value="{{ $sumber->id }}" {{ old('id_sumber_pemasukan') == $sumber->id ? 'selected' : '' }}>
                                    {{ $sumber->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('pemasukan.index') }}" class="btn btn-secondary">Kembali</a>
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
