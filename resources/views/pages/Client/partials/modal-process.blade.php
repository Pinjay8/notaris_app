<div class="modal fade" id="processModal-{{ $doc->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Proses - Kode {{ $doc->pic_document_code }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($doc->processes->isEmpty())
                <p class="text-muted mb-0">Belum ada history proses</p>
                @else
                <table class="table table-sm mb-0 text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Notaris</th>
                            <th>Tanggal</th>
                            <th>Nama Proses</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doc->processes as $process)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $process->notaris->display_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($process->step_date)->format('Y-m-d') }}</td>
                            <td>{{ $process->step_name }}</td>
                            <td>
                                @if($process->step_status === 'done')
                                <span class="badge bg-success">Selesai</span>
                                @elseif($process->step_status === 'in_progress')
                                <span class="badge bg-warning">Sedang Diproses</span>
                                @elseif($process->step_status === 'pending')
                                <span class="badge bg-secondary">Menunggu</span>
                                @else
                                <span class="badge bg-secondary">{{ ucfirst($process->step_status) }}</span>
                                @endif
                            </td>
                            <td>{{ $process->note ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>