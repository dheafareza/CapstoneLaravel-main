<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Stok Barang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Stok Barang</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Ukuran</th>
                <th>Tanggal</th>
                <th>Total Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stok_barang as $barang)
            <tr>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->ukuran }}</td>
                <td>{{ $barang->tanggal }}</td>
                <td>{{ $barang->total_stok }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>