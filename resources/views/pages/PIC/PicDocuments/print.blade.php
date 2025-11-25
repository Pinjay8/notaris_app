<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>PIC Dokumen</title>
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/logo-ct.png">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        /* Header dengan logo dan informasi kantor (gunakan tabel agar sejajar di mPDF) */
        .header-top {
            width: 100%;
            /* border-bottom: 2px solid #000; */
            padding-bottom: 8px;
            /* border: none; */
            border-bottom: : 1px solid #000;
            margin-bottom: 10px;
        }

        .header-top td {
            vertical-align: middle;
            border-bottom: : 1px solid #000;
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
            border-top: 1px solid #000;
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
    </style>
</head>

<body>
    <table class="header-top">
        <tr>
            <td class="logo">
                <img src="file://{{ public_path('img/logo-ct-dark.png') }}" alt="Logo Notaris"
                    style="width:40px; height:auto;">
            </td>
            <td class="company-info">
                <h3>Notaris App</h3>
                <p>Jl. Melati No. 45, Jakarta Selatan</p>
                <p>Telp: (021) 123-4567</p>
            </td>
        </tr>
    </table>

    <div class="header">
        <h2>PIC Dokumen</h2>
    </div>

    {{-- Rincian biaya --}}
    <table>
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Kode Klien</th>
                <th>Kode Dokumen</th>
                <th>Tanggal Diterima</th>
                <th>Tipe Transaksi</th>
                <th>PIC Staff</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if ($picDocuments->transaction_type === 'akta')
                        {{ $picDocuments->aktaTransaction->transaction_code ?? '-' }}
                    @elseif ($picDocuments->transaction_type === 'ppat')
                        {{ $picDocuments->relaasTransaction->transaction_code ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $picDocuments->client->client_code }}</td>
                <td>{{ $picDocuments->pic_document_code }}</td>
                <td>{{ $picDocuments->received_date ? \Carbon\Carbon::parse($picDocuments->received_date)->translatedFormat('d F Y H:i') : '-' }}
                </td>
                <td style="text-transform: capitalize">{{ $picDocuments->transaction_type }}</td>
                <td>{{ $picDocuments->pic->full_name ?? '-' }}</td>
                @php
                    $statusText = [
                        'delivered' => 'Dikirim',
                        'completed' => 'Selesai',
                        'process' => 'Diproses',
                        'received' => 'Diterima',
                    ];
                @endphp
                <td style="text-transform: capitalize">
                    {{ $statusText[$picDocuments->status] ?? $picDocuments->status }}
                </td>
                <td>{{ $picDocuments->note ?? '-' }}</td>
            </tr>

        </tbody>
    </table>

</body>

</html>
