@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($notaryConsultation) ? 'Edit Konsultasi' : 'Tambah
Konsultasi'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($notaryConsultation) ? 'Edit Konsultasi' : 'Tambah Konsultasi' }}</h6>
            </div>
            <div class="card-body px-4 pt-3 pb-2">
                <form
                    action="{{ isset($notaryConsultation) ? route('consultation.update', $notaryConsultation->id) : route('consultation.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($notaryConsultation))
                    @method('PUT')
                    @endif

                    <input type="hidden" name="notaris_id" value="{{ auth()->user()->notaris_id }}">

                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-bold">Registration Code</label>
                            <input type="text" name="registration_code" class="form-control"
                                value="{{ old('registration_code', $registrationCode ?? $notaryConsultation->registration_code ?? '') }}"
                                readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="client_id" class="form-label">Klien</label>
                            <select name="client_id" class="form-select" required>
                                <option value="" hidden>Pilih Klien</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $notaryConsultation->client_id ??
                                    '') == $client->id ? 'selected' : '' }}>
                                    {{ $client->fullname }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Subjek</label>
                            <input type="text" name="subject" class="form-control"
                                value="{{ old('subject', $notaryConsultation->subject ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="" hidden>Pilih Status</option>
                                <option value="progress" {{ old('status', $notaryConsultation->status ?? '') ==
                                    'progress'
                                    ? 'selected' : '' }}>Progress</option>
                                <option value="done" {{ old('status', $notaryConsultation->status ?? '') == 'done' ?
                                    'selected' : '' }}>Done</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control"
                                rows="3">{{ old('description', $notaryConsultation->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('consultation.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">{{ isset($notaryConsultation) ? 'Update' :
                            'Simpan' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection