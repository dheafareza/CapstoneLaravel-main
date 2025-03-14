@extends('layouts.app')

@section('title', 'Pengeluaran')

@section('content')
<div class="container">
    <h1 class="mt-4">Daftar Pengeluaran</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Pengeluaran -->
    <div class="mb-3">
        <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary-i">
            <i class="bi bi-plus"> Pengeluaran</i>
        </a>
    </div>

    <!-- Filter Tanggal -->
    <div class="col-lg-12 col-md-12 custom-width-i">
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

    <!-- Tabel Daftar Pengeluaran -->
    <div class="col-lg-12 col-md-12 mb-4 custom-width-i">
        <div class="card shadow mb-4">
            <div class="card-header">Transaksi Keluar</div>
            <div class="card-body">
                <table id="tabelPengeluaran" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Sumber</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengeluaran as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tgl_pengeluaran }}</td>
                                <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $item->sumberpengeluaran->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('pengeluaran.show', $item->id) }}" class="btn btn-outline-primary">Detail</a>
                                    <a href="{{ route('pengeluaran.edit', $item->id) }}" class="btn btn-outline-warning">Edit</a>
                                    <form action="{{ route('pengeluaran.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pengeluaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Script DataTables & Filter Tanggal -->
<script>
   $(document).ready(function() {
    var table = $('#tabelPengeluaran').DataTable({
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

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var date = new Date(data[1]);
                var start = new Date(startDate);
                var end = new Date(endDate);

                if ((!startDate || date >= start) && (!endDate || date <= end)) {
                    return true;
                }
                return false;
            }
        );
        table.draw();
    });
});
</script>

<!-- Style Custom -->
<style>
    .custom-width-i {
        width: 80%;
        padding-bottom: 20px;
    }

    .btn-primary-i {
        background-color: rgb(28, 200, 138);
        color: white;
        border: none;
        padding: 5px 13px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-primary-i:hover {
        background-color: rgb(20, 170, 115);
        color: white;
    }

    .btn-primary-i i {
        font-style: normal;
        font-weight: bold;
    }
</style>
@endsection
