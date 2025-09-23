@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Log Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h6>Log Akta</h6>
                <a href="{{ route('akta-logs.create') }}" class="btn btn-primary btn-sm">+ Tambah Log</a>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('akta-logs.index') }}" class="d-flex gap-2 mb-3 justify-content-end"
                    style="max-width: 500px; margin-left: auto;" class="no-spinner">
                    <input type="text" name="registration_code" class="form-control"
                        placeholder="Cari kode registrasi..." value="{{ $filters['registration_code'] ?? '' }}">
                    <input type="text" name="step" class="form-control" placeholder="Cari step..."
                        value="{{ $filters['step'] ?? '' }}">
                    <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                </form>

                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Notaris</th>
                            <th>Client</th>
                            <th>Transaksi Akta</th>
                            <th>Registration Code</th>
                            <th>Step</th>
                            <th>Note</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr class="text-center text-sm">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->notaris->display_name ?? '-' }}</td>
                            <td>{{ $log->client->fullname ?? '-' }}</td>
                            <td>{{ $log->akta_transaction->registration_code ?? '-' }}</td>
                            <td>{{ $log->registration_code }}</td>
                            <td>{{ $log->step }}</td>
                            <td>{{ $log->note }}</td>
                            <td class="text-center">
                                <a href="{{ route('akta-logs.edit', $log->id) }}" class="btn btn-info btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $log->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $log->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $log->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $log->id }}">Hapus Log</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus log ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('akta-logs.destroy', $log->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted text-sm">Belum ada data log.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection