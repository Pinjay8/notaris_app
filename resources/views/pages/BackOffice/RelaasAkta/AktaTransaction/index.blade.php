@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Relaas Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h6>Relaas Akta</h6>
                <a href="{{ route('relaas-aktas.create') }}" class="btn btn-primary btn-sm">+ Tambah Relaas</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                {{-- Filter & Search --}}
                <form method="GET" action="{{ route('relaas-aktas.index') }}" class="d-flex gap-2 ms-auto me-4 mb-3"
                    style="max-width:500px;" onchange="this.submit()">
                    <input type="text" name="registration_code" placeholder="Cari kode registrasi..."
                        value="{{ request('registration_code') }}" class="form-control">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach(['draft','diproses','selesai','dibatalkan'] as $status)
                        <option value="{{ $status }}" {{ request('status')==$status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                        @endforeach
                    </select>
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
                                <th>Tahun</th>
                                <th>Angka Relaas</th>
                                <th>Waktu Angka Relaas</th>
                                <th>Status</th>
                                <th>Tanggal Cerita</th>
                                <th>Lokasi Cerita</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $akta)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $akta->notaris->display_name ?? '-' }}</td>
                                <td>{{ $akta->client->fullname ?? '-' }}</td>
                                <td>{{ $akta->registration_code ?? '-' }}</td>
                                <td>{{ $akta->year ?? '-' }}</td>
                                <td>{{ $akta->relaas_number ?? '-' }}</td>
                                <td>{{ $akta->relaas_number_created_at ?
                                    \Carbon\Carbon::parse($akta->relaas_date)->format('d M Y H:i')
                                    : '-' }}</td>
                                <td>{{ ucfirst($akta->status) ?? '-' }}</td>
                                <td>{{ $akta->story_date ? \Carbon\Carbon::parse($akta->story_date)->format('d M Y H:i')
                                    : '-' }}</td>
                                <td>{{ $akta->story_location ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('relaas-aktas.edit', $akta->id) }}"
                                        class="btn btn-info btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $akta->id }}">
                                        Hapus
                                    </button>
                                    @include('pages.BackOffice.RelaasAkta.AktaTransaction.Modal.index' , ['akta' =>
                                    $akta])
                                    {{-- End Modal --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-muted">Belum ada Relaas Akta.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 mt-3">
                    {{ $data->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection