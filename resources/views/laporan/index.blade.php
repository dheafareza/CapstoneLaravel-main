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
        <div class="card-header py-3">Filter Laporan Keuangan Berdasarkan Tanggal
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
        <div class="card-header py-3">Laporan Keuangan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabelLaporan">
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
    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Script DataTables untuk Laporan Keuangan -->
    <script>
        $(document).ready(function() {
            $('#tabelLaporan').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10
            });

            $('#tabelPemasukan_filter input').on('keyup', function() {
        table.columns(3).search(this.value).draw(); // Kolom ke-4 (indeks 3) adalah Sumber Pemasukan
    });
        });
    </script>
    <!-- Form Export Laporan Keuangan -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">Export Laporan
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
            <a href="{{ route('export.pemasukan') }}" class="btn btn-success w-100 mb-2">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
            </div>
            <div class="col-md-6">
            <a href="{{ route('export.pemasukan.pdf') }}" class="btn btn-danger w-100">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
    </div>
</div>
</div>
@endsection