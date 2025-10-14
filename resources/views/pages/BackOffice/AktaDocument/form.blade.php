@extends('layouts.app')

@section('title', 'Dokumen Akta')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($document) ? 'Edit Akta Dokumen' : 'Tambah Akta Dokumen' }}</h6>
            </div>
            <hr>
            <div class="card-body px-4 pt-3 pb-0">
                <form
                    action="{{ isset($document) ? route('akta-documents.update', $document->id) : route('akta-documents.storeData', $transaction->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($document))
                    @method('PUT')
                    @endif

                    {{-- <div class="mb-3">
                        <label for="registration_code" class="form-label">Kode Registrasi</label>
                        <input type="text" name="registration_code" class="form-control"
                            value="{{ $document->registration_code ?? old('registration_code') }}" required>
                    </div> --}}
                    <div class="mb-3">
                        <label for="name" class="form-label text-sm">Nama Dokumen</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $document->name ?? '') }}">

                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label text-sm">Tipe</label>
                        <input type="text" name="type" id="type"
                            class="form-control @error('type') is-invalid @enderror"
                            value="{{ old('type', $document->type ?? '') }}">

                        @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label for="file_name" class="form-label">Nama File</label>
                        <input type="text" name="file_name" class="form-control"
                            value="{{ $document->file_name ?? old('file_name') }}" required>
                    </div> --}}

                    <div class="mb-3">
                        <label for="file_url" class="form-label text-sm">File Akta Dokumen</label>
                        <input type="file" name="file_url" id="file_url"
                            class="form-control @error('file_url') is-invalid @enderror">

                        @error('file_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        @if(isset($document) && $document->file_url)
                        <a href="{{ asset('storage/'.$document->file_url) }}" target="_blank"
                            class="btn btn-outline-primary btn-sm mt-2 mb-0">
                            📂 Lihat File
                        </a>
                        @endif
                    </div>


                    {{-- <div class="mb-3">
                        <label for="file_type" class="form-label">Tipe Dokumen</label>
                        <input type="text" name="file_type" class="form-control"
                            value="{{ $document->file_type ?? old('file_type') }}" required>
                    </div> --}}

                    {{-- uploaded_at --}}
                    <div class="mb-3">
                        <label for="uploaded_at" class="form-label text-sm">Tanggal Upload</label>
                        <input type="datetime-local" name="uploaded_at" id="uploaded_at"
                            class="form-control @error('uploaded_at') is-invalid @enderror"
                            value="{{ old('uploaded_at', isset($document) && $document->uploaded_at ? \Carbon\Carbon::parse($document->uploaded_at)->format('Y-m-d\TH:i') : '') }}">

                        @error('uploaded_at')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{--
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select">
                            @foreach(['draft','submitted','approved','rejected'] as $status)
                            <option value="{{ $status }}" {{ (isset($document) && $document->status==$status) ?
                                'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div> --}}


                    <a href="{{ route('akta-documents.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($document) ? 'Update' : 'Simpan' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection