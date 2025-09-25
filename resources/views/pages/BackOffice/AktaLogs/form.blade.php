@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($log) ? 'Edit Log Akta' : 'Tambah Log Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($log) ? 'Edit Log Akta' : 'Tambah Log Akta' }}</h6>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <form action="{{ isset($log) ? route('akta-logs.update', $log->id) : route('akta-logs.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($log))
                    @method('PUT')
                    @endif

                    {{-- <div class="mb-3">
                        <label for="notaris_id" class="form-label">Notaris</label>
                        <select name="notaris_id" id="notaris_id" class="form-select" required>
                            <option value="" hidden>-- Pilih Notaris --</option>
                            @foreach($notaris as $notary)
                            <option value="{{ $notary->id }}" {{ isset($log) && $log->notaris_id == $notary->id ?
                                'selected' : '' }}>
                                {{ $notary->display_name }}
                            </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mb-3">
                        <label for="client_id" class="form-label">Klien</label>
                        <select name="client_id" id="client_id" class="form-select" required>
                            <option value="" hidden>Pilih Klien</option>
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ isset($log) && $log->client_id == $client->id ?
                                'selected' : '' }}>
                                {{ $client->fullname }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="akta_transaction_id" class="form-label">Transaksi Akta</label>
                        <select name="akta_transaction_id" id="akta_transaction_id" class="form-select" required>
                            <option value="" hidden>Pilih Transaksi</option>
                            @foreach($transactions as $trx)
                            <option value="{{ $trx->id }}" {{ isset($log) && $log->akta_transaction_id == $trx->id ?
                                'selected' : '' }}>
                                {{ $trx->registration_code }} - {{ $trx->akta_type->type ?? '-' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="registration_code" class="form-label">Registration Code</label>
                        <input type="text" name="registration_code" id="registration_code" class="form-control"
                            value="{{ $log->registration_code ?? old('registration_code') }}">
                    </div> --}}

                    <div class="mb-3">
                        <label for="step" class="form-label">Step</label>
                        <input type="text" name="step" id="step" class="form-control"
                            value="{{ $log->step ?? old('step') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea name="note" id="note" class="form-control">{{ $log->note ?? old('note') }}</textarea>
                    </div>

                    <a href="{{ route('akta-logs.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($log) ? 'Update' : 'Simpan' }}</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection