@extends('layouts.app')

@section('title', 'Daftar Hutang')

@section('content')
<div class="container">
    <h1 class="mt-4">Daftar Hutang</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Hutang -->
    <div class="mb-3">
        <a href="{{ route('hutang.create') }}" class="btn btn-primary">Tambah Hutang</a>
    </div>

    <!-- Row untuk Tabel dan Grafik -->
    <div class="row">
        <!-- Tabel Daftar Hutang -->
<div class="col-lg-8">
    <div class="card shadow">
        <div class="card-header">Daftar Hutang</div>
        <div class="card-body">
            <table class="table datatable table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Penghutang</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hutangBelumLunas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $item->tgl_hutang }}</td>
                            <td>{{ $item->alasan }}</td>
                            <td>{{ $item->penghutang }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <a href="{{ route('hutang.show', $item->id_hutang) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('hutang.edit', $item->id_hutang) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('hutang.destroy', $item->id_hutang) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                                <form action="{{ route('hutang.lunasi', $item->id_hutang) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Lunasi</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada hutang yang belum lunas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


        <!-- Tabel Daftar Pelunasan -->
<div class="col-lg-8">
    <div class="card shadow">
        <div class="card-header">Daftar Pelunasan</div>
        <div class="card-body">
            <table class="table datatable table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Penghutang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hutangLunas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $item->tgl_hutang }}</td>
                            <td>{{ $item->alasan }}</td>
                            <td>{{ $item->penghutang }}</td>
                            <td><span class="badge bg-success">Lunas</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada hutang yang sudah lunas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<style>
    .col-lg-8, .col-lg-4 {
        padding-bottom: 20px;
        width: 100%; 
    }
</style>
@endsection
