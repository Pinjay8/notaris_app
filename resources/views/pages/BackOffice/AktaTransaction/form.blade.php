@extends('layouts.app')

@section('title', 'Transaksi Akta')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Transaksi Akta'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ isset($transaction) ? 'Edit Transaksi Akta' : 'Tambah Transaksi Akta' }}</h6>
                </div>
                <hr>
                <div class="card-body px-4 pt-0 pb-2">
                    <form
                        action="{{ isset($transaction) ? route('akta-transactions.update', $transaction->id) : route('akta-transactions.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($transaction))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label for="client_id" class="form-label text-sm">Klien</label>
                            <select name="client_id" id="client_id" class="form-select select2">
                                <option value="" hidden>Pilih Klien</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ isset($transaction) && $transaction->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="akta_type_id" class="form-label text-sm">Jenis Akta</label>
                            <select name="akta_type_id" id="akta_type_id" class="form-select">
                                <option value="" hidden>Pilih Jenis Akta</option>
                                @foreach ($aktaTypes as $aktaType)
                                    <option value="{{ $aktaType->id }}"
                                        {{ isset($transaction) && $transaction->akta_type_id == $aktaType->id ? 'selected' : '' }}>
                                        {{ $aktaType->type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date_submission" class="form-label text-sm">Tanggal Pengajuan</label>
                            <input type="datetime-local" name="date_submission" id="date_submission" class="form-control"
                                value="{{ isset($transaction) && $transaction->date_submission ? \Illuminate\Support\Carbon::parse($transaction->date_submission)->format('Y-m-d\TH:i') : old('date_submission') }}">
                        </div>

                        <div class="mb-3">
                            <label for="date_finished" class="form-label text-sm">Tanggal Selesai</label>
                            <input type="datetime-local" name="date_finished" id="date_finished" class="form-control"
                                value="{{ isset($transaction) && $transaction->date_finished ? \Illuminate\Support\Carbon::parse($transaction->date_finished)->format('Y-m-d\TH:i') : old('date_finished') }}">
                        </div>


                        <div class="mb-3">
                            <label for="note" class="form-label text-sm">Catatan</label>
                            <textarea name="note" id="note" class="form-control">{{ isset($transaction) ? $transaction->note : old('note') }}</textarea>
                        </div>

                        @if (isset($transaction))
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    @foreach (['draft', 'diproses', 'selesai', 'dibatalkan'] as $status)
                                        <option value="{{ $status }}"
                                            {{ $transaction->status == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <a href="{{ route('akta-transactions.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit"
                            class="btn btn-primary">{{ isset($transaction) ? 'Ubah' : 'Simpan' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
