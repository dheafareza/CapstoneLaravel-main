<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemasukan dan Pengeluaran</title>
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

    <!-- Bagian Data Pemasukan -->
    <h2>Data Pemasukan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Pemasukan</th>
                <th>Jumlah</th>
                <th>Sumber</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemasukan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tgl_pemasukan }}</td>
                    <td>Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $item->sumberPemasukan->nama ?? 'Tidak Diketahui' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total Pemasukan</strong></td>
                <td colspan="2"><strong>Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <br><br>

    <!-- Bagian Data Pengeluaran -->
    <h2>Data Pengeluaran</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Pengeluaran</th>
                <th>Jumlah</th>
                <th>Sumber</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengeluaran as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tgl_pengeluaran }}</td>
                    <td>Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $item->sumberPengeluaran->nama ?? 'Tidak Diketahui' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total Pengeluaran</strong></td>
                <td colspan="2"><strong>Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
