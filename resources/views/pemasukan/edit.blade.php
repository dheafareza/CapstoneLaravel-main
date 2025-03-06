@extends('layouts.app')

@section('title', 'Edit Pemasukan')

@section('content')
<div class="container">
    <h1 class="mt-4">Edit Pemasukan</h1>

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

    <!-- Form Edit Pemasukan -->
    <form action="{{ route('pemasukan.update', $pemasukan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tgl_pemasukan" class="form-label">Tanggal Pemasukan</label>
            <input type="date" id="tgl_pemasukan" name="tgl_pemasukan" class="form-control" 
                   value="{{ old('tgl_pemasukan', $pemasukan->tgl_pemasukan) }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" class="form-control" 
                   value="{{ old('jumlah', $pemasukan->jumlah) }}" required>
        </div>

        <div class="mb-3">
            <label for="id_sumber_pemasukan" class="form-label">Sumber Pemasukan</label>
            <select id="id_sumber_pemasukan" name="id_sumber_pemasukan" class="form-select" required>
            @foreach ($sumberPemasukan as $sumber)
            <option value="{{ $sumber->id }}" 
                    {{ old('id_sumber_pemasukan', $pemasukan->id_sumber_pemasukan) == $sumber->id ? 'selected' : '' }}>
                    {{ $sumber->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('pemasukan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
