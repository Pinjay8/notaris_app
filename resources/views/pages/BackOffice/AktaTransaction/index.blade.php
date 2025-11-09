@extends('layouts.app')

@section('title', 'Transaksi Akta')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Transaksi Akta'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-header d-flex justify-content-between align-items-center pb-0">
                    <h5>Transaksi Akta</h5>
                    <a href="{{ route('akta-transactions.create') }}" class="btn btn-primary btn-sm">+ Tambah Transaksi</a>
                </div>
                <div class="d-flex justify-content-md-end w-100 justify-content-center">
                    <form method="GET" action="{{ route('akta-transactions.index') }}"
                        class="d-flex  gap-2  justify-content-end flex-wrap flex-md-nowrap px-3"
                        style="max-width: 500px; width: 100%;">

                        <input type="text" name="registration_code" placeholder="Cari kode registrasi..."
                            value="{{ request('registration_code') }}" class="form-control">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach (['draft', 'diproses', 'selesai', 'dibatalkan'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </form>
                </div>

                <hr>
                <div class="card-body px-0 pt-0 pb-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Klien</th>
                                    <th>Kode Registrasi</th>
                                    <th>Nomor Akta</th>
                                    <th>Jenis Akta</th>
                                    <th>Tahun</th>
                                    <th>Waktu Dibuat</th>
                                    <th>Waktu Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr class="text-center text-sm">
                                        <td>{{ $transactions->firstItem() + $loop->index }}</td>
                                        <td>{{ $transaction->client->fullname }}</td>
                                        <td>{{ $transaction->registration_code ?? '-' }}</td>
                                        <td>{{ $transaction->akta_number ?? '-' }}</td>
                                        <td>{{ $transaction->akta_type->type ?? '-' }}</td>

                                        <td>{{ $transaction->year ?? '-' }}</td>
                                        <td>
                                            {{ $transaction->date_submission
                                                ? \Illuminate\Support\Carbon::parse($transaction->date_submission)->format('d F Y
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        H:i:s')
                                                : '-' }}
                                        </td>
                                        <td>
                                            {{ $transaction->date_finished
                                                ? \Illuminate\Support\Carbon::parse($transaction->date_finished)->format('d F Y
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        H:i:s')
                                                : '-' }}
                                        </td>
                                        <td>{{ ucfirst($transaction->status) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('akta-transactions.edit', $transaction->id) }}"
                                                class="btn btn-info btn-sm mb-0">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-url="{{ route('akta-transactions.destroy', $transaction->id) }}">
                                                Hapus
                                            </button>
                                            @include('pages.BackOffice.AktaTransaction.modal.index')
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted text-sm">Belum ada transaksi akta.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
