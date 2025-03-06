<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemasukan</title>
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
                <td colspan="2">Total Pemasukan</td>
                <td colspan="2">Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
