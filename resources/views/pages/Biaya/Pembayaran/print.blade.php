<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pembayaran - {{ $cost->payment_code }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        /* Header dengan logo dan informasi kantor */
        .header-top {
            width: 100%;
            padding-bottom: 8px;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .header-top td {
            vertical-align: middle;
            border: none;
        }

        .logo img {
            width: 40px;
            height: auto;
        }

        .company-info {
            text-align: right;
            font-size: 11px;
            line-height: 1.4;
        }

        .company-info h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
            /* border-top: 1px solid #000; */
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            margin-top: 10px;
            padding-bottom: 5px;
        }

        /* Informasi Utama */
        .info {
            margin-bottom: 25px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .info-table td {
            padding: 5px 8px;
            vertical-align: top;
        }

        .info-table tr td:first-child,
        .info-table tr td:nth-child(3) {
            width: 22%;
            font-weight: bold;
        }

        .info-table tr td:nth-child(2),
        .info-table tr td:nth-child(4) {
            width: 28%;
        }

        .info-table tr:not(:last-child) td {
            border-bottom: 1px solid #e0e0e0;
        }

        /* Tabel biaya */
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

        /* Footer tanda tangan */
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
    </style>
</head>

<body>

    <!-- Header -->
    <table class="header-top">
        <tr>
            <td class="logo">
                {{-- <img src="file://{{ public_path('img/logo-ct-dark.png') }}" alt="Logo Notaris"
                    style="width:40px; height:auto;"> --}}

                <img src="data:image/png;base64,{{ $qrCode }}"
                    style="
            width:80px;
            background:#fff;
            padding:10px;
            border:1px solid #000;
         ">
            </td>
            <td class="company-info">
                <h3>Notaris App</h3>
                <p>Office {{ $notaris->office_name }}</p>
                <p>{{ $notaris->office_address }}</p>
                <p>{{ $notaris->phone }}</p>
            </td>
        </tr>
    </table>

    <div class="header">
        <h2 style="text-transform: capitalize">Detail Pembayaran</h2>
    </div>
    {{-- <div style="text-align: center;">
        <p style="font-weight: bold; margin-bottom: 8px;">
            Scan QR untuk Melihat Detail Pembayaran
        </p>

        <img src="data:image/png;base64,{{ $qrCode }}"
            style="
                width:80px;
                background:#fff;
                padding:10px;
                border:1px solid #000;
             ">
    </div> --}}

    <div class="info">
        <table class="info-table">
            <tr>
                <td style="font-weight: bold">Kode Pembayaran</td>
                <td>{{ $cost->payment_code }}</td>
                <td>Notaris</td>
                <td>{{ $cost->notaris->display_name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold">Klien</td>
                <td>{{ $cost->client->fullname ?? '-' }}</td>
                <td>Status Pembayaran</td>
                <td>
                    @if ($cost->payment_status == 'unpaid')
                        Belum Dibayar
                    @elseif($cost->payment_status == 'partial')
                        Sebagian Dibayar
                    @else
                        Lunas
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold">Tanggal Jatuh Tempo</td>
                <td>{{ $cost->due_date ? \Carbon\Carbon::parse($cost->due_date)->format('d/m/Y') : '-' }}</td>
                <td>Catatan</td>
                <td>{{ $cost->note ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- Rincian Biaya --}}
    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th class="amount">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Biaya Produk/Jasa</td>
                <td class="amount">{{ number_format($cost->product_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Administrasi</td>
                <td class="amount">{{ number_format($cost->admin_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Lain-lain</td>
                <td class="amount">{{ number_format($cost->other_cost, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td>Total Biaya</td>
                <td class="amount">{{ number_format($cost->total_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Jumlah Dibayar</td>
                <td class="amount">{{ number_format($cost->amount_paid, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Sisa Pembayaran</td>
                <td class="amount">{{ number_format($cost->total_cost - $cost->amount_paid, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Rincian Pembayaran --}}
    <h4 style="margin-top:20px; font-size:13px;">Rincian Pembayaran</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Pembayaran</th>
                <th>Metode</th>
                {{-- <th>Bukti</th> --}}
                <th>Jumlah (Rp)</th>
                <th>Status Validasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cost->payments as $payment)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td style="text-align:center">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                    </td>
                    <td>{{ ucfirst($payment->payment_type) }}</td>
                    <td style="text-transform: capitalize">{{ $payment->payment_method }}</td>
                    {{-- <td>{{ $payment->payment_file ? 'Ada' : '-' }}</td> --}}
                    <td class="amount">{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td style="text-align:center">{{ $payment->is_valid ? 'Tervalidasi' : 'Menunggu' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Belum ada pembayaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tanda tangan --}}
    <div class="footer">
        <div class="left">
            <p>Jakarta, {{ now()->format('d F Y') }}</p>
            <p class="signature-space">_________________________<br>{{ $notaris->display_name }}</p>
        </div>
        <div class="right">
            <p>Mengetahui,</p>
            <p class="signature-space">_________________________<br>{{ $cost->client->fullname }}</p>
        </div>
    </div>

</body>

</html>
