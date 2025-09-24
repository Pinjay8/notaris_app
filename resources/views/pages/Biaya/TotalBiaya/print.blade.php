<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Notary Cost</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            display: inline-block;
            padding-bottom: 5px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
            font-size: 11px;
            border: none;
        }

        .info td {
            padding: 4px 6px;
        }

        .info td:first-child {
            width: 35%;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 7px 10px;
            font-size: 11px;
        }

        th {
            background-color: #eaeaea;
            text-align: center;
        }

        td.amount {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .footer {
            margin-top: 60px;
            width: 100%;
            font-size: 11px;
            clear: both;
        }

        .footer .left {
            float: left;
            width: 45%;
            text-align: center;
        }

        .footer .right {
            float: right;
            width: 45%;
            text-align: center;
        }

        .signature-space {
            margin-top: 70px;
        }

        .info p {
            margin: 3px 0;
            font-size: 11px;
        }

        .info strong {
            display: inline-block;
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Notary Cost Estimation</h2>
    </div>

    {{-- Informasi utama --}}
    <div class="info">
        <p><strong>Kode Pembayaran:</strong> {{ $costs->payment_code }}</p>
        <p><strong>Klien:</strong> {{ $costs->client->fullname ?? '-' }}</p>
        <p><strong>Notaris:</strong> {{ $costs->notaris->display_name ?? '-' }}</p>
        <p><strong>Status Pembayaran:</strong>
            @if($costs->payment_status == 'unpaid')
            Belum Dibayar
            @elseif($costs->payment_status == 'partial')
            Sebagian Dibayar
            @else
            Lunas
            @endif
        </p>
        <p><strong>Tanggal Jatuh Tempo:</strong>
            {{ $costs->due_date ? \Carbon\Carbon::parse($costs->due_date)->format('d/m/Y') : '-' }}
        </p>
        <p><strong>Tanggal Bayar:</strong>
            {{ $costs->paid_date ? \Carbon\Carbon::parse($costs->paid_date)->format('d/m/Y') : '-' }}
        </p>
        <p><strong>Catatan:</strong> {{ $costs->note ?? '-' }}</p>
    </div>

    {{-- Rincian biaya --}}
    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="amount">Biaya (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Biaya Produk/Jasa</td>
                <td class="amount">{{ number_format($costs->product_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Administrasi</td>
                <td class="amount">{{ number_format($costs->admin_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Lain-lain</td>
                <td class="amount">{{ number_format($costs->other_cost, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td>Total Biaya</td>
                <td class="amount">{{ number_format($costs->total_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Jumlah Dibayar</td>
                <td class="amount">{{ number_format($costs->amount_paid, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Tanda tangan --}}
    <div class="footer">
        <div class="left">
            <p>Jakarta, {{ now()->format('d F Y') }}</p>
            <p class="signature-space">_________________________<br>Notaris</p>
        </div>
        <div class="right">
            <p>Mengetahui,</p>
            <p class="signature-space">_________________________<br>Klien</p>
        </div>
    </div>
</body>

</html>