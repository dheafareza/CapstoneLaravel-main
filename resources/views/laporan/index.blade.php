@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="container">
    <h1 class="mt-4">Laporan Keuangan</h1>

    <div class="row d-flex justify-content-center">
   
<style>
.card-body h4 {
    font-size: 14px;
    margin-bottom: 8px;
}
.progress {
    height: 18px;
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>

<!-- Total Pemasukan & Pengeluaran -->
<div class="row">
        <div class="col-md-6">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h5>Total Pemasukan</h5>
                    <h3>Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h5>Total Pengeluaran</h5>
                    <h3>Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Form Pilih Tanggal -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan Keuangan Berdasarkan Tanggal</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Awal</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date', now()->endOfMonth()->toDateString()) }}" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Laporan Keuangan -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Keuangan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Sumber</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporanKeuangan as $laporan)
                        <tr>
                            <td>{{ $laporan['tanggal'] }}</td>
                            <td>{{ $laporan['tipe'] }}</td>
                            <td>{{ $laporan['sumber'] }}</td>
                            <td>Rp. {{ number_format($laporan['jumlah'], 0, ',', '.') }}</td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Form Export Laporan Keuangan -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Export Laporan</h6>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="card-title">Export Pemasukan</h6>
                    <a href="{{ route('export.pemasukan') }}" class="btn btn-success w-100 mb-2">Excel</a>
                    <a href="{{ route('export.pemasukan.pdf') }}" class="btn btn-danger w-100">PDF</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="card-title">Export Pengeluaran</h6>
                    <a href="{{ route('export.pengeluaran') }}" class="btn btn-success w-100 mb-2">Excel</a>
                    <a href="{{ route('export.pengeluaran.pdf') }}" class="btn btn-danger w-100">PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection