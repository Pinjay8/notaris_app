<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengrususan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            /* jarak ke tabel */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Laporan Pengurusan</h3>
    <h4>Notaris : {{ $processes[0]->notaris->display_name }}</h4>
    <p>Periode: {{ request('start_date') ?? '-' }} s/d {{ request('end_date') ?? '-' }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Dokumen</th>
                <th>Pic</th>
                <th>Nama Klien</th>
                <th>Proses</th>
                <th>Tanggal Pengurusan</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($processes as $process)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $process->pic_document->pic_document_code }}</td>
                <td>{{ $process->pic_document->pic->full_name }}</td>
                <td>{{ $process->pic_document->client->fullname ?? '-' }}</td>
                <td>{{ $process->step_name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($process->step_date)->format('d-m-Y') }}</td>
                <td>{{ ucfirst($process->step_status) }}</td>
                <td>{{ $process->note }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Tidak ada data laporan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>