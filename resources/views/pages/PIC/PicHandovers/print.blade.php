<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Serah Terima Dokumen</title>
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

        .section {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .logo img {
            width: 40px;
            height: auto;
        }

        /* table,
        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        } */

        th,
        td {
            border: 1px solid #000;
            padding: 7px 10px;
            font-size: 11px;
        }


        .handover-info {
            max-width: 500px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
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

        th {
            background-color: #eaeaea;
            text-align: center;
        }

        td.amount {
            text-align: right;
        }

        /* Grid untuk label dan value */
        .handover-info .info-row {
            display: grid;
            grid-template-columns: 150px 1fr;
            /* label tetap, value fleksibel */
            margin-bottom: 8px;
        }

        .handover-info .label {
            font-weight: 600;
            color: #555;
        }

        .handover-info .value {
            color: #333;
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
                <p>Office {{ $notaris->office_name }}</p>
                <p>{{ $notaris->office_address }}</p>
                <p>{{ $notaris->phone }}</p>
            </td>
        </tr>
    </table>

    <div class="header">
        <h2 style="text-transform: capitalize">Serah Terima Dokumen</h2>
    </div>


    <div class="info">
        <table class="info-table">
            <tr>
                <td style="font-weight: bold">Kode Dokumen</td>
                <td>{{ $handover->picDocument->pic_document_code ?? '-' }}</td>
                <td>Tanggal Serah Terima</td>
                <td>{{ $handover->handover_date }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold">Nama Penerima</td>
                <td>{{ $handover->recipient_name ?? '-' }}</td>
                <td>Kontak</td>
                <td>{{ $handover->recipient_contact ?? '-' }}</td>
            </tr>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Dokumen</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- Contoh kalau mau tampilkan list detail dokumen terkait --}}
            <tr style="text-align: center">
                <td style="text-align: center">1</td>
                <td style="text-transform: capitalize; text-align: center">
                    {{ $handover->picDocument->transaction_type ?? '-' }}
                </td>
                @php
                    $badgeColors = [
                        'delivered' => 'primary', // biru
                        'received' => 'info', // biru muda
                        'process' => 'warning', // kuning/oranye
                        'completed' => 'success', // hijau
                    ];

                    $statusText = [
                        'delivered' => 'Dikirim',
                        'received' => 'Diterima',
                        'process' => 'Proses',
                        'completed' => 'Selesai',
                    ];
                @endphp

                <td style="text-align:  center">
                    <span
                        class="badge bg-{{ $badgeColors[$handover->picDocument->status] ?? 'secondary' }} text-align: center">
                        {{ $statusText[$handover->picDocument->status] ?? ($handover->picDocument->status ?? '-') }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="section" style="margin-top:20px;">
        <span class="label">Catatan:</span> {{ $handover->note ?? '-' }}
    </div>

    <p style="margin-top:20px;">Pihak penerima menyatakan telah menerima dokumen sebagaimana tertera di atas dengan
        kondisi baik dan lengkap.</p>

    <table style="margin-top:50px; border:none;">
        <tr style="border:none;">
            <td style="text-align:center; border:none;">
                <p>Yang Menyerahkan</p>
                <br><br><br>
                <p>___________________________</p>
                <p>{{ $notaris->display_name }}</p>
            </td>
            <td style="text-align:center; border:none;">
                <p>Yang Menerima</p>
                <br><br><br>
                <p>___________________________</p>
                <p>{{ $handover->recipient_name }}</p>
            </td>
        </tr>
    </table>
</body>

</html>
