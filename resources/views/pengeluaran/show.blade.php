@extends('layouts.app')

@section('title', 'Detail Pengeluaran')

@section('content')
<div class="container">
    <h1 class="mt-4">Detail Pengeluaran</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Informasi Detail Pengeluaran -->
    <div class="card">
        <div class="card-header">
            Detail Pengeluaran
        </div>
        <div class="card-body">
            <p><strong>Tanggal:</strong> {{ $pengeluaran->tgl_pengeluaran }}</p>
            <p><strong>Jumlah:</strong> Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</p>
            <p><strong>Sumber:</strong> {{ $pengeluaran->sumberPengeluaran->nama }}</p>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-3">
        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('pengeluaran.edit', $pengeluaran->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
        </form>
    </div>
</div>
@endsection
