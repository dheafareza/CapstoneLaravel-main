@extends('layouts.app')

@section('title', 'Detail Pemasukan')

@section('content')
<div class="container">
    <h1 class="mt-4">Detail Pemasukan</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Informasi Detail Pemasukan -->
    <div class="card">
        <div class="card-header">
            Detail Pemasukan
        </div>
        <div class="card-body">
            <p><strong>Tanggal:</strong> {{ $pemasukan->tgl_pemasukan }}</p>
            <p><strong>Jumlah:</strong> Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</p>
            <p><strong>Sumber:</strong> {{ $pemasukan->sumberPemasukan->nama }}</p>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-3">
        <a href="{{ route('pemasukan.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('pemasukan.edit', $pemasukan->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('pemasukan.destroy', $pemasukan->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
        </form>
    </div>
</div>
@endsection
