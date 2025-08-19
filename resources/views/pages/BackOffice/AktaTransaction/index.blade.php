@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Transaksi Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h6>Transaksi Akta</h6>
                <a href="{{ route('akta-transactions.create') }}" class="btn btn-primary btn-sm">+ Tambah Transaksi</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form method="GET" action="{{ route('akta-transactions.index') }}"
                    class="d-flex gap-2 ms-auto me-4 mb-3" style="max-width:500px;">
                    <input type="text" name="registration_code" placeholder="Cari kode registrasi..."
                        value="{{ request('registration_code') }}" class="form-control">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach(['draft','diproses','selesai','dibatalkan'] as $status)
                        <option value="{{ $status }}" {{ request('status')==$status ? 'selected' : '' }}>{{
                            ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                </form>

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Jenis Akta</th>
                                <th>Status</th>
                                <th>Year</th>
                                <th>Akta Number</th>
                                <th>Registration Code</th>
                                <th>Waktu Dibuat</th>
                                <th>Waktu Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->client->fullname }}</td>
                                <td>{{ $transaction->akta_type->type ?? '-' }}</td>
                                <td>{{ ucfirst($transaction->status) }}</td>
                                <td>{{ $transaction->year ?? '-' }}</td>
                                <td>{{ $transaction->akta_number ?? '-' }}</td>
                                <td>{{ $transaction->registration_code ?? '-' }}</td>
                                <td>
                                    {{ $transaction->date_submission ?
                                    \Illuminate\Support\Carbon::parse($transaction->date_submission)->format('d F Y
                                    H:i:s') : '-' }}
                                </td>
                                <td>
                                    {{ $transaction->date_finished ?
                                    \Illuminate\Support\Carbon::parse($transaction->date_finished)->format('d F Y
                                    H:i:s')
                                    : '-' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('akta-transactions.edit', $transaction->id) }}"
                                        class="btn btn-info btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-url="{{ route('akta-transactions.destroy', $transaction->id) }}">
                                        Hapus
                                    </button>
                                    @include('pages.BackOffice.AktaTransaction.modal.index')
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted text-sm">Belum ada transaksi akta.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection