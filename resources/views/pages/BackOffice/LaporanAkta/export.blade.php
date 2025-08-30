<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Akta</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; }
        h3 { text-align: center; }
    </style>
</head>
<body>
    <h3>Laporan Akta ({{ ucfirst($queryType) }})<br>
        Periode: {{ $startDate }} s/d {{ $endDate }}</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Akta / Relaas</th>
                <th>Kode Registrasi</th>
                <th>Nama Klien / Pihak</th>
                <th>Tanggal Dibuat</th>
                <th>Jenis Akta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->akta_number ?? $row->relaas_number ?? '-' }}</td>
                    <td>{{ $row->registration_code ?? '-' }}</td>
                    <td>{{ $row->client->fullname ?? '-' }}</td>
                    <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ ucfirst($queryType) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>