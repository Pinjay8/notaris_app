<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        h3 {
            text-align: center;
            margin: 0;
        }
    </style>
</head>

<body>
    <h3>Laporan Pembayaran Notaris</h3>
    <p>Periode: {{ request('start_date') ?? '-' }} s/d {{ request('end_date') ?? '-' }}</p>
    <p>Status: {{ request('status') ?? 'Semua' }}</p>

    <table>
        <thead>
            <tr>
                <th>Kode Pembayaran</th>
                <th>Nama Klien</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($costs as $cost)
            <tr>
                <td>{{ $cost->payment_code }}</td>
                <td>{{ $cost->client_name }}</td>
                <td>{{ $cost->created_at->format('d-m-Y') }}</td>
                <td>{{ ucfirst($cost->status) }}</td>
                <td>Rp {{ number_format($cost->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>