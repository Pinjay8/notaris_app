@extends('layouts.app')

@section('title', 'Transaksi Akta')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'PPAT / Transaksi Akta'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center pb-0">
                    <h5>Transaksi Akta</h5>
                    <a href="{{ route('relaas-aktas.create', ['client_code' => request('client_code')]) }}"
                        class="btn btn-primary btn-sm">+ Tambah Transaksi</a>
                </div>
                <form method="GET" action="{{ route('relaas-aktas.index') }}" class="d-flex gap-2 ms-auto me-4 mb-0"
                    style="max-width:600px;" onchange="this.submit()" class="no-spinner">
                    <input type="text" name="transaction_code" placeholder="Cari Kode Transaksi"
                        value="{{ request('transaction_code') }}" class="form-control">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach (['draft', 'diproses', 'selesai', 'dibatalkan'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                </form>
                <hr>
                <div class="card-body px-0 pt-0 pb-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Klien</th>
                                    <th>Kode Klien</th>
                                    <th>Kode Transaksi</th>
                                    <th>Jenis Akta</th>
                                    <th>Tahun</th>
                                    <th>Nomor Akta</th>
                                    <th>Waktu Nomor Dibuat</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $akta)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td>{{ $akta->notaris->display_name ?? '-' }}</td> --}}
                                        <td>{{ $akta->client->fullname ?? '-' }}</td>
                                        <td>{{ $akta->client_code ?? '-' }}</td>
                                        <td>{{ $akta->transaction_code ?? '-' }}</td>
                                        <td>{{ ucfirst($akta->akta_type->type) ?? '-' }}</td>
                                        <td>{{ $akta->year ?? '-' }}</td>
                                        <td>{{ $akta->relaas_number ?? '-' }}</td>
                                        <td>{{ $akta->relaas_number_created_at ? \Carbon\Carbon::parse($akta->relaas_date)->format('d M Y H:i:ss') : '-' }}
                                        </td>
                                        <td>{{ $akta->title ?? '-' }}</td>
                                        <td>{{ $akta->story_date ? \Carbon\Carbon::parse($akta->story_date)->format('d F Y H:i:s') : '-' }}
                                        </td>
                                        <td>{{ $akta->story_location ?? '-' }}</td>
                                        <td>{{ ucfirst($akta->status) ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('relaas-aktas.edit', $akta->id) }}"
                                                class="btn btn-info btn-sm mb-0">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $akta->id }}">
                                                Hapus
                                            </button>
                                            @include(
                                                'pages.BackOffice.RelaasAkta.AktaTransaction.Modal.index',
                                                ['akta' => $akta]
                                            )
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-muted">Belum ada transaksi Akta.</td>
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
