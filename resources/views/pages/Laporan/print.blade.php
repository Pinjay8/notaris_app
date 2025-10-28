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
                <th>Tanggal Pelunasan</th>
                <th>Total Biaya</th>
                <th>Total Pembayaran</th>
                <th>Piutang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($costs as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->payment_code }}</td>
                    <td>{{ $payment->client->fullname ?? '-' }}</td>
                    <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') : '-' }}
                    </td>
                    <td>Rp
                        {{ number_format($payment->cost->total_cost, 0, ',', '.') }}
                    </td>
                    <td>Rp {{ number_format($payment->cost->amount_paid, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($payment->cost->total_cost - $payment->cost->amount_paid, 0, ',', '.') }}
                    </td>
                    <td>
                        @php
                            $status = $payment->payment_type;
                            $badgeColor = match ($status) {
                                'full' => 'success',
                                'partial' => 'warning',
                                'dp' => 'info',
                                default => 'secondary',
                            };
                            $statusText = match ($status) {
                                'full' => 'Lunas',
                                'partial' => 'Bayar sebagian',
                                'dp' => 'DP',
                                default => $status,
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }} text-capitalize">
                            {{ $statusText }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
