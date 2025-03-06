@extends('layouts.app')

@section('title', 'Edit Hutang')

@section('content')
<div class="container">
    <h1 class="mt-4">Edit Hutang</h1>

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

    <!-- Form Edit Hutang -->
    <form action="{{ route('hutang.update', $hutang->id_hutang) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tgl_hutang" class="form-label">Tanggal Hutang</label>
            <input type="date" id="tgl_hutang" name="tgl_hutang" class="form-control" 
                   value="{{ old('tgl_hutang', $hutang->tgl_hutang) }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" class="form-control" 
                   value="{{ old('jumlah', $hutang->jumlah) }}" required>
        </div>

        <div class="mb-3">
            <label for="alasan" class="form-label">Barang</label>
            <textarea id="alasan" name="alasan" class="form-control" required>{{ old('alasan', $hutang->alasan) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="penghutang" class="form-label">Penghutang</label>
            <input type="text" id="penghutang" name="penghutang" class="form-control" 
                   value="{{ old('penghutang', $hutang->penghutang) }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="form-control" required>{{ old('keterangan', $hutang->keterangan) }}</textarea>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('hutang.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
