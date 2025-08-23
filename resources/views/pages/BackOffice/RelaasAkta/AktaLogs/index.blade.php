@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Notary Relaas Logs'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h6>Notary Relaas Logs</h6>
                <a href="{{ route('relaas-logs.create') }}" class="btn btn-primary btn-sm">+ Tambah Log</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                {{-- Filter & Search --}}
                <form method="GET" action="{{ route('relaas-logs.index') }}"
                    class="d-flex gap-2 ms-auto me-4 mb-3" style="max-width:600px;" onchange="this.submit()">
                    <input type="text" name="registration_code" placeholder="Cari kode registrasi..."
                        value="{{ request('registration_code') }}" class="form-control">
                    <input type="text" name="step" placeholder="Cari step..." value="{{ request('step') }}"
                        class="form-control">
                    <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                </form>

                {{-- Table --}}
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 text-sm text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Notaris</th>
                                <th>Client</th>
                                <th>Kode Registrasi</th>
                                <th>Step</th>
                                <th>Note</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $log->notaris->display_name ?? '-' }}</td>
                                <td>{{ $log->client->fullname ?? '-' }}</td>
                                <td>{{ $log->registration_code ?? '-' }}</td>
                                <td>{{ $log->step ?? '-' }}</td>
                                <td>{{ $log->note ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('relaas-logs.edit', $log->id) }}"
                                        class="btn btn-info btn-sm">Edit</a>

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $log->id }}">
                                        Hapus
                                    </button>

                                    {{-- Modal Delete --}}
                                    @include('pages.BackOffice.RelaasAkta.AktaLogs.Modal.index', ['log' => $log])
                                    {{-- End Modal --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-muted">Belum ada log.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 mt-3">
                    {{ $logs->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
