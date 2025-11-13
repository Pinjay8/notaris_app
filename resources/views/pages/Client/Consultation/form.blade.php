@extends('layouts.app')

@section('title', 'Konsultasi')


@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Konsultasi'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ isset($notaryConsultation) ? 'Edit Konsultasi' : 'Tambah Konsultasi' }}</h6>
                </div>
                <hr>
                <div class="card-body px-4 pt-0  pb-2">
                    <form
                        action="{{ isset($notaryConsultation) ? route('consultation.update', $notaryConsultation->id) : route('consultation.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($notaryConsultation))
                            @method('PUT')
                        @endif

                        <input type="hidden" name="notaris_id" value="{{ auth()->user()->notaris_id }}">
                        <input type="hidden" name="client_id"
                            value="{{ $notaryConsultation->client_id ?? request('client_id') }}">

                        <div class="row">

                            {{-- <div class="mb-3 col-md-12">
                                <label class="form-label fw-bold text-sm">Kode Klien</label>
                                <input type="text" name="client_code" class="form-control"
                                    value="{{ old('client_code', $registrationCode ?? ($notaryConsultation->client_code ?? '')) }}"
                                    readonly>
                            </div> --}}
                            <div class="col-md-12 mb-3">
                                <label for="client_code" class="form-label text-sm">Klien</label>
                                <select name="client_code" class="form-select select2">
                                    <option value="" hidden>Pilih Klien</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->client_code }}"
                                            {{ old('client_code', $notaryConsultation->client_code ?? '') == $client->client_code ? 'selected' : '' }}>
                                            {{ $client->fullname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_code')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="subject" class="form-label text-sm">Subjek</label>
                                <input type="text" name="subject" class="form-control"
                                    value="{{ old('subject', $notaryConsultation->subject ?? '') }}">
                                @error('subject')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label text-sm">Status</label>
                                <select name="status" class="form-select">
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="progress"
                                        {{ old('status', $notaryConsultation->status ?? '') == 'progress' ? 'selected' : '' }}>
                                        Proses</option>
                                    <option value="done"
                                        {{ old('status', $notaryConsultation->status ?? '') == 'done' ? 'selected' : '' }}>
                                        Selesai</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label text-sm">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $notaryConsultation->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('consultation.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($notaryConsultation) ? 'Ubah' : 'Simpan' }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
