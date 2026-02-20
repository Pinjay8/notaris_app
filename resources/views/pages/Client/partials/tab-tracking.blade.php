<table class="table table-bordered table-striped">
    <thead>
        <tr class="text-center fw-bold text-black">
            <th>#</th>
            <th>Notaris</th>
            <th>Kode Dokumen</th>
            <th>Tipe Transaksi</th>
            <th></th>
            <th>Status Terakhir</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($picDocuments as $doc)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $doc->notaris->full_name ?? '-' }}</td>
                <td>{{ $doc->pic_document_code }}</td>
                <td class="text-capitalize">{{ $doc->transaction_type ?? '-' }}</td>
                <td class="text-capitalize">
                    @php
                        // $status = optional($doc->processes->last())->step_status ?? null;
                        $status = $doc->status;
                    @endphp
                    @if ($status === 'delivered')
                        <span class="badge bg-warning text-capitalize">Sedang Diproses</span>
                    @elseif($status === 'done')
                        <span class="badge bg-success text-capitalize">Selesai</span>
                    @elseif($status === 'pending')
                        <span class="badge bg-secondary text-capitalize">Menunggu</span>
                    @else
                        <span class="badge bg-light text-dark text-capitalize">Belum ada progres</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-info mb-0" data-bs-toggle="modal"
                        data-bs-target="#processModal-{{ $doc->id }}">
                        Detail
                    </button>

                    @include('pages.Client.partials.modal-process', ['doc' => $doc])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
