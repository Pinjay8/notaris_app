@extends('layouts.app')

@section('title', 'Logs Akta')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Logs Akta'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ isset($data) ? 'Edit Logs Akta' : 'Tambah  Log Akta' }}</h6>
                </div>
                <hr>
                <div class="card-body px-4 pt-0 pb-2">
                    <form action="{{ isset($data) ? route('relaas-logs.update', $data->id) : route('relaas-logs.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($data))
                            @method('PUT')
                        @endif

                        {{-- clients --}}
                        <div class="mb-3">
                            <label for="client_code" class="form-label text-sm">Klien</label>
                            <select name="client_code" id="client_code" class="form-select select2">
                                <option value="" hidden>Pilih Klien</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->client_code }}"
                                        {{ isset($data) && $data->client_code == $client->client_code ? 'selected' : '' }}>
                                        {{ $client->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Relaas ID --}}
                        <div class="mb-3">
                            <label for="relaas_id" class="form-label text-sm">Transaksi Akta</label>
                            <select name="relaas_id" id="relaas_id"
                                class="form-select @error('relaas_id') is-invalid @enderror">
                                <option value="" hidden>Pilih Transaksi Akta</option>
                                @foreach ($relaasAktas as $ra)
                                    <option value="{{ $ra->id }}"
                                        {{ old('relaas_id', $data->relaas_id ?? '') == $ra->id ? 'selected' : '' }}>
                                        {{ $ra->client_code }} - {{ $ra->client->fullname }}
                                        ({{ $ra->notaris->display_name }})
                                        - {{ $ra->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('relaas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Step --}}
                            <div class="mb-3">
                                <label for="step" class="form-label text-sm">Step</label>
                                <input type="text" name="step" id="step"
                                    class="form-control @error('step') is-invalid @enderror"
                                    value="{{ old('step', $data->step ?? '') }}">
                                @error('step')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Note --}}
                            <div class="mb-3">
                                <label for="note" class="form-label text-sm">Catatan</label>
                                <textarea name="note" id="note" rows="3" class="form-control @error('note') is-invalid @enderror">{{ old('note', $data->note ?? '') }}</textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <a href="{{ route('relaas-logs.index') }}" class="btn btn-secondary">Kembali</a>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($data) ? 'Ubah' : 'Simpan' }}
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
