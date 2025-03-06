@extends('layouts.app')

@section('title', 'Edit Pengeluaran')

@section('content')
<div class="container">
    <h1 class="mt-4">Edit Pengeluaran</h1>

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

    <!-- Form Edit Pengeluaran -->
    <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tgl_pengeluaran" class="form-label">Tanggal Pengeluaran</label>
            <input type="date" id="tgl_pengeluaran" name="tgl_pengeluaran" class="form-control" 
                   value="{{ old('tgl_pengeluaran', $pengeluaran->tgl_pengeluaran) }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" class="form-control" 
                   value="{{ old('jumlah', $pengeluaran->jumlah) }}" required>
        </div>

        <div class="mb-3">
            <label for="id_sumber_pengeluaran" class="form-label">Sumber Pengeluaran</label>
            <select id="id_sumber_pengeluaran" name="id_sumber_pengeluaran" class="form-select" required>
                <option value="">-- Pilih Sumber --</option>
                @foreach ($sumberPengeluaran as $sumber)
                <option value="{{ $sumber->id }}" 
                    {{ old('id_sumber_pengeluaran', $pengeluaran->id_sumber_pengeluaran) == $sumber->id ? 'selected' : '' }}>
                    {{ $sumber->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
