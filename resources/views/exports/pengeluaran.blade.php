<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengeluaran</title>
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
            @php $totalPengeluaran = 0; @endphp
            @foreach($pengeluaran as $index => $item)
                @php $totalPengeluaran += $item->jumlah; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tgl_pengeluaran }}</td>
                    <td>Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $item->sumberPengeluaran->nama ?? 'Tidak Diketahui' }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">Total Pengeluaran</td>
                <td colspan="2">Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
