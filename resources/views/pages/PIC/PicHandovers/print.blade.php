<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Serah Terima Dokumen</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
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

        table,
        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        .handover-info {
            max-width: 500px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
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
    <div class="header">
        <h2>Berita Acara Serah Terima Dokumen</h2>
        <p>Notaris: {{ $handover->notaris->display_name ?? '-' }}</p>
    </div>

    <div class="section">
        <div class="handover-info">
            <div class="info-row">
                <span class="label">Kode Dokumen:</span>
                <span class="value">{{ $handover->picDocument->pic_document_code ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tanggal Serah Terima:</span>
                <span class="value">{{ $handover->handover_date }}</span>
            </div>
            <div class="info-row">
                <span class="label">Nama Penerima:</span>
                <span class="value">{{ $handover->recipient_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Kontak Penerima:</span>
                <span class="value">{{ $handover->recipient_contact ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <span class="label">Catatan:</span> {{ $handover->note ?? '-' }}
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
                <td>1</td>
                <td style="text-transform: capitalize">{{ $handover->picDocument->transaction_type ?? '-' }}
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

                <td>
                    <span class="badge bg-{{ $badgeColors[$handover->picDocument->status] ?? 'secondary' }}">
                        {{ $statusText[$handover->picDocument->status] ?? ($handover->picDocument->status ?? '-') }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top:40px;">Pihak penerima menyatakan telah menerima dokumen sebagaimana tertera di atas dengan
        kondisi baik dan lengkap.</p>

    <table style="margin-top:50px; border:none;">
        <tr style="border:none;">
            <td style="text-align:center; border:none;">
                <p>Yang Menyerahkan</p>
                <br><br><br>
                <p>(_____________________)</p>
            </td>
            <td style="text-align:center; border:none;">
                <p>Yang Menerima</p>
                <br><br><br>
                <p>({{ $handover->recipient_name }})</p>
            </td>
        </tr>
    </table>
</body>

</html>
