@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($data) ? 'Edit Relaas Akta' : 'Tambah Relaas Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($data) ? 'Edit Relaas Akta' : 'Tambah Relaas Akta' }}</h6>
            </div>
            <div class="card-body px-4 pt-3 pb-2">
                <form
                    action="{{ isset($data) ? route('relaas-aktas.update', $data->id) : route('relaas-aktas.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($data)) @method('PUT') @endif

                    {{-- Notaris --}}
                    {{-- <div class="mb-3">
                        <label for="notaris_id" class="form-label">Notaris</label>
                        <select name="notaris_id" id="notaris_id"
                            class="form-select @error('notaris_id') is-invalid @enderror">
                            <option value="" hidden>-- Pilih Notaris --</option>
                            @foreach($notaris as $notary)
                            <option value="{{ $notary->id }}" {{ old('notaris_id', $data->notaris_id ?? '') ==
                                $notary->id ? 'selected' : '' }}>
                                {{ $notary->display_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('notaris_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- Client --}}
                    <div class="mb-3">
                        <label for="client_id" class="form-label">Client</label>
                        <select name="client_id" id="client_id"
                            class="form-select @error('client_id') is-invalid @enderror">
                            <option value="" hidden>-- Pilih Client --</option>
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $data->client_id ?? '') == $client->id
                                ? 'selected' : '' }}>
                                {{ $client->fullname }}
                            </option>
                            @endforeach
                        </select>
                        @error('client_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Registration Code --}}
                    <div class="mb-3">
                        <label for="registration_code" class="form-label">Kode Registrasi</label>
                        <input type="text" name="registration_code" id="registration_code"
                            class="form-control @error('registration_code') is-invalid @enderror"
                            value="{{ old('registration_code', $data->registration_code ?? '') }}">
                        @error('registration_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $data->title ?? '') }}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- story --}}
                    <div class="mb-3">
                        <label for="story" class="form-label">Cerita</label>
                        {{-- textarea --}}
                        <textarea name="story" id="story" class="form-control @error('story') is-invalid @enderror"
                            rows="3">{{ old('story', $data->story ?? '') }}</textarea>
                        @error('story')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Story Date --}}
                    <div class="mb-3">
                        <label for="story_date" class="form-label">Tanggal Cerita</label>
                        <input type="datetime-local" name="story_date" id="story_date"
                            class="form-control @error('story_date') is-invalid @enderror"
                            value="{{ old('story_date', isset($data->story_date) ? \Carbon\Carbon::parse($data->story_date)->format('Y-m-d\TH:i') : '') }}">
                        @error('story_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Story Location --}}
                    <div class="mb-3">
                        <label for="story_location" class="form-label">Lokasi Cerita</label>
                        <input type="text" name="story_location" id="story_location"
                            class="form-control @error('story_location') is-invalid @enderror"
                            value="{{ old('story_location', $data->story_location ?? '') }}">
                        @error('story_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach(['draft','diproses','selesai','dibatalkan'] as $status)
                            <option value="" hidden>-- Pilih Status --</option>
                            <option value="{{ $status }}" {{ old('status', $data->status ?? '') == $status ? 'selected'
                                : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Note --}}
                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                            rows="3">{{ old('note', $data->note ?? '') }}</textarea>
                        @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Simpan' }}</button>
                    <a href="{{ route('relaas-aktas.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection