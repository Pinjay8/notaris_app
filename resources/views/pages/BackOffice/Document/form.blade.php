@extends('layouts.app')

@section('title', isset($document) ? 'Edit Dokumen' : 'Tambah Dokumen')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($document) ? 'Edit Dokumen' : 'Tambah Dokumen' }}</h6>
            </div>
            <hr>
            <div class="card-body px-4 pt-0 pb-2">
                <form
                    action="{{ isset($document) ? route('management-document.update', $document->id) : route('management-document.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($document))
                    @method('PUT')
                    @endif

                    <input type="hidden" name="notaris_id" value="{{ auth()->user()->notaris_id }}">

                    <div class="row">

                        {{-- <div class="mb-3 col-md-6">
                            <label class="form-label fw-bold text-sm">Kode Registrasi</label>
                            <input type="text" name="registration_code" class="form-control"
                                value="{{ old('registration_code', $registrationCode ?? $document->registration_code ?? '') }}"
                                readonly>
                        </div> --}}

                        <div class="col-md-12 mb-3">
                            <label class="form-label text-sm">Klien</label>
                            <select name="client_id"
                                class="form-select @error('client_id') is-invalid @enderror select2">
                                <option value="" hidden>Pilih Klien</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $document->client_id ??
                                    request('client_id')) == $client->id ? 'selected' : '' }}>
                                    {{ $client->fullname }}
                                </option>
                                @endforeach
                            </select>
                            @error('client_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label text-sm">Jenis Dokumen</label>
                            <select name="document_code"
                                class="form-select @error('document_code') is-invalid @enderror">
                                <option value="" hidden>Pilih Dokumen</option>
                                @foreach($documents as $doc)
                                <option value="{{ $doc->code }}" {{ old('document_code', $document->document_code ?? '')
                                    == $doc->code ? 'selected' : '' }}>
                                    {{ $doc->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('document_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-md-12 mb-3">
                            <label class="form-label text-sm">Tanggal Upload</label>
                            <input type="date" name="uploaded_at"
                                class="form-control @error('uploaded_at') is-invalid @enderror"
                                value="{{ old('uploaded_at', isset($document) ? $document->uploaded_at->format('Y-m-d') : date('Y-m-d')) }}">
                            @error('uploaded_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3 col-md-12">
                            <label class="form-label text-sm">Dokumen</label>
                            <input type="file" name="document_link"
                                class="form-control @error('document_link') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.pdf">
                            @error('document_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if(isset($document) && $document->document_link)
                            <small class="text-muted">File saat ini: <a
                                    href="{{ Storage::url($document->document_link) }}"
                                    target="_blank">Lihat</a></small>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label text-sm">Catatan</label>
                            <textarea name="note"
                                class="form-control @error('note') is-invalid @enderror">{{ old('note', $document->note ?? '') }}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                    </div>

                    <div class="mt-4">
                        <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">{{ isset($document) ? 'Update' : 'Simpan'
                            }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection