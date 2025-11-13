<table class="table table-bordered table-striped">
    <thead>
        <tr class="text-center fw-bold text-black">
            <th>#</th>
            <th>Kode Klien</th>
            <th>Jenis Pengurusan</th>
            <th>Status Terakhir</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($picDocuments as $doc)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $doc->pic_document_code }}</td>
                <td class="text-capitalize">{{ $doc->document_type ?? '-' }}</td>
                <td>
                    @php
                        $status = optional($doc->processes->last())->step_status ?? null;
                    @endphp
                    @if ($status === 'in_progress')
                        <span class="badge bg-warning">Sedang Diproses</span>
                    @elseif($status === 'done')
                        <span class="badge bg-success">Selesai</span>
                    @elseif($status === 'pending')
                        <span class="badge bg-secondary">Menunggu</span>
                    @else
                        <span class="badge bg-light text-dark">Belum ada progres</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                        data-bs-target="#processModal-{{ $doc->id }}">
                        Detail
                    </button>

                    @include('pages.Client.partials.modal-process', ['doc' => $doc])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
