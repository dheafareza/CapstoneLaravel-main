@extends('layouts.app')

@section('title', 'Detail Hutang')

@section('content')
<div class="container">
    <h1 class="mt-4">Detail Hutang</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Card Detail Hutang -->
    <div class="card">
        <div class="card-header">
            Detail Hutang
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Tanggal Hutang:</strong>
                <p>{{ $hutang->tgl_hutang }}</p>
            </div>
            <div class="mb-3">
                <strong>Jumlah:</strong>
                <p>Rp {{ number_format($hutang->jumlah, 0, ',', '.') }}</p>
            </div>
            <div class="mb-3">
                <strong>Barang:</strong>
                <p>{{ $hutang->alasan }}</p>
            </div>
            <div class="mb-3">
                <strong>Penghutang:</strong>
                <p>{{ $hutang->penghutang }}</p>
            </div>
            <div class="mb-3">
                <strong>Keterangan:</strong>
                <p>{{ $hutang->keterangan }}</p>
            </div>
        </div>
        <div class="card-footer">
        <a href="{{ route('hutang.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            <a href="{{ route('hutang.edit', $hutang->id_hutang) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('hutang.destroy', $hutang->id_hutang) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus hutang ini?')">Hapus</button>
            </form>
            
        </div>
    </div>
</div>
@endsection
