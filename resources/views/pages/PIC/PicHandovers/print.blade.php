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
    </style>
</head>

<body>
    <div class="header">
        <h2>Berita Acara Serah Terima Dokumen</h2>
        <p>Notaris: {{ $handover->notaris_id->display_name ?? '-' }}</p>
    </div>

    <div class="section">
        <span class="label">Kode Dokumen:</span> {{ $handover->picDocument->pic_document_code ?? '-' }} <br>
        <span class="label">Tanggal Serah Terima:</span> {{ $handover->handover_date }} <br>
        <span class="label">Nama Penerima:</span> {{ $handover->recipient_name }} <br>
        <span class="label">Kontak Penerima:</span> {{ $handover->recipient_contact ?? '-' }} <br>
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
                <td>{{ $handover->picDocument->document_type ?? '-' }} ({{ $handover->picDocument->document_number ??
                    '-' }})</td>
                <td>{{ $handover->picDocument->status ?? '-' }}</td>
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