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
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
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
    <h3>Laporan Pembayaran</h3>
    <h4>Notaris : {{ $costs[0]->notaris->display_name }}</h4>
    <p>Periode: {{ request('start_date') ?? '-' }} s/d {{ request('end_date') ?? '-' }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Pembayaran</th>
                <th>Nama Klien</th>
                <th>Tanggal Bayar</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($costs as $cost)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cost->payment_code }}</td>
                <td>{{ $cost->client->fullname }}</td>
                <td>{{ $cost->created_at->format('d-m-Y') }}</td>
                <td>{{ ucfirst($cost->payment_status) ?? '-'}}</td>
                <td>Rp {{ number_format($cost->total_cost, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>