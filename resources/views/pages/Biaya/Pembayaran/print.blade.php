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
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 11px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        td.amount {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
            font-size: 11px;
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
            margin-top: 50px;
        }

        table.cost-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
        }

        .cost-table th,
        .cost-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }

        .cost-table thead {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
        }

        .cost-table td.amount {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .cost-table tr.total td {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .cost-table tr.balance td {
            font-weight: bold;
            color: #dc3545;
            /* merah untuk sisa */
            background-color: #fff5f5;
        }

        .cost-table tr.paid td {
            font-weight: bold;
            color: #198754;
            /* hijau untuk sudah dibayar */
            background-color: #f5fff8;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>DETAIL PEMBAYARAN NOTARIS</h2>
    </div>

    {{-- Informasi Utama --}}
    <div class="info">
        <table style="width:100%; border-collapse:collapse; font-size:11px;">
            <tbody>
                <tr>
                    <td style="width:35%; padding:4px 6px; font-weight:bold;">Kode Pembayaran</td>
                    <td style="padding:4px 6px;"> {{ $cost->payment_code }}</td>
                </tr>
                <tr>
                    <td style="padding:4px 6px; font-weight:bold;">Klien</td>
                    <td style="padding:4px 6px;"> {{ $cost->client->fullname ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:4px 6px; font-weight:bold;">Notaris</td>
                    <td style="padding:4px 6px;"> {{ $cost->notaris->display_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:4px 6px; font-weight:bold;">Kode Dokumen</td>
                    <td style="padding:4px 6px;"> {{ $cost->picDocument->pic_document_code ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:4px 6px; font-weight:bold;">Status</td>
                    <td style="padding:4px 6px;">
                        @if($cost->payment_status == 'unpaid') Belum Dibayar
                        @elseif($cost->payment_status == 'partial') Sebagian Dibayar
                        @else Lunas
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 6px; font-weight:bold;">Tanggal Jatuh Tempo</td>
                    <td style="padding:4px 6px;"> {{ $cost->due_date ?
                        \Carbon\Carbon::parse($cost->due_date)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:4px 6px; font-weight:bold;">Catatan</td>
                    <td style="padding:4px 6px;"> {{ $cost->note ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Rincian Biaya --}}

    <table class="cost-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="amount">Biaya (Rp)</th>
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
            <tr class="paid">
                <td>Jumlah Dibayar</td>
                <td class="amount">{{ number_format($cost->amount_paid, 0, ',', '.') }}</td>
            </tr>
            <tr class="balance">
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
                <th>Bukti</th>
                <th>Jumlah (Rp)</th>
                <th>Status Validasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cost->payments as $payment)
            <tr>
                <td style="text-align:center">{{ $loop->iteration }}</td>
                <td style="text-align:center">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($payment->payment_type) }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->payment_file ? 'Ada' : '-' }}</td>
                <td class="amount">{{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td style="text-align:center">{{ $payment->is_valid ? 'Tervalidasi' : 'Menunggu' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada pembayaran</td>
            </tr>
            @endforelse
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