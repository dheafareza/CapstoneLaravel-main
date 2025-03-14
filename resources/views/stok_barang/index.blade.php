@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Stok Barang</h4>
                    <div>
                        <a href="{{ route('stok_barang.create') }}" class="btn btn-primary">Tambah Stok Barang</a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Filter Tanggal -->
                    <div class="col-lg-12 col-md-12 mb-4 custom-width-i">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">Filter Tanggal</div>
                        <div class="card-body">
                            <form id="filterForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="start_date">Tanggal Awal</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date">Tanggal Akhir</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary" id="filterBtn">Tampilkan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>

                    <!-- Filter Ukuran -->
                    <div class="mb-3">
                        <label for="sizeFilter" class="form-label">Filter Ukuran:</label>
                        <select id="sizeFilter" class="form-control">
                            <option value="">Semua Ukuran</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>

                    <!-- TABEL 1: Transaksi Barang Masuk / Keluar -->
                    <h5 class="mb-3">Transaksi Barang Masuk / Keluar</h5>
                    <table id="tabelStokBarang" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Ukuran</th>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Quantity</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokBarangs as $stokBarang)
                                <tr>
                                    <td>{{ $stokBarang->kode_barang }}</td>
                                    <td>{{ $stokBarang->nama_barang }}</td>
                                    <td>{{ $stokBarang->ukuran }}</td>
                                    <td>{{ $stokBarang->tanggal }}</td>
                                    <td>{{ $stokBarang->tipe }}</td>
                                    <td>{{ $stokBarang->quantity }}</td>
                                    <td>
                                        <a href="{{ route('stok_barang.show', $stokBarang->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('stok_barang.edit', $stokBarang->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('stok_barang.destroy', $stokBarang->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada transaksi barang masuk/keluar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- TABEL 2: Total Stok Barang -->
                    <h5 class="mt-4 mb-3">Total Stok Barang</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Ukuran</th>
                                <th>Total Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($totalStok->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data stok barang.</td>
                                </tr>
                            @else
                                @foreach($totalStok as $stok)
                                    <tr>
                                        <td>{{ $stok->kode_barang }}</td>
                                        <td>{{ $stok->nama_barang }}</td>
                                        <td>{{ $stok->ukuran }}</td>
                                        <td>{{ $stok->total_stok }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
    var table = $('#tabelStokBarang').DataTable({
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
        }
    });

    // Filter berdasarkan tanggal
    $('#filterBtn').on('click', function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        if (startDate && endDate) {
            var start = new Date(startDate).getTime();
            var end = new Date(endDate).getTime();
            var hasData = false;

            table.rows().every(function() {
                var row = this.data();
                var rowDate = new Date(row[3]).getTime(); // Ambil tanggal dari kolom ke-4

                if ((isNaN(start) || rowDate >= start) && (isNaN(end) || rowDate <= end)) {
                    this.nodes().to$().show();
                    hasData = true;
                } else {
                    this.nodes().to$().hide();
                }
            });

            if (!hasData) {
                $('#tabelStokBarang tbody').html('<tr><td colspan="5" class="text-center">Tidak ada data yang tersedia</td></tr>');
            }
        }
    });

    // **Pencarian Berdasarkan Nama/Kode Barang**
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // **Filter Berdasarkan Ukuran**
    $('#sizeFilter').on('change', function() {
        var selectedSize = $(this).val();
        table.column(2).search(selectedSize ? selectedSize : '', true, false).draw();
    });
});

</script>
@endsection
