@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="container">
    <h1 class="mt-4">Laporan Stok Barang</h1>

    <!-- Filter Tanggal -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan Stok Barang Berdasarkan Tanggal</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('laporan.stok.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Tanggal Awal</label>
                <input type="date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date', now()->endOfMonth()->toDateString()) }}" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

    <!-- Tabel Laporan Stok Barang -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Stok Barang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table">
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Ukuran</th>
                            <th>Total Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stokBarangs as $barang)
                        <tr>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->ukuran }}</td>
                            <td>{{ $barang->total_stok }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Export -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Export Laporan</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('laporan.stok.exportExcel', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-success w-100">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('laporan.stok.exportPDF', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-danger w-100">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
