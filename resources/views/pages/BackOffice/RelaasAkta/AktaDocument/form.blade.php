@extends('layouts.app')

@section('title', 'Dokumen Akta')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' =>'Dokumen Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ $doc ? 'Edit Dokumen' : 'Tambah Dokumen' }}</h6>
            </div>
            <hr>
            <div class="card-body pt-0">
                <form
                    action="{{ $doc ? route('relaas-documents.update', [$relaas->id, $doc->id]) : route('relaas-documents.store', $relaas->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($doc)
                    @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="form-label text-sm">Nama Dokumen</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $doc->name ?? '') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-sm">Tipe Dokumen</label>
                        <input type="text" name="type" class="form-control @error('type') is-invalid @enderror"
                            value="{{ old('type', $doc->type ?? '') }}">
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-sm">File</label>
                        <input type="file" name="file" class="form-control">
                        @if($doc && $doc->file_url)
                        <img src="{{ asset('storage/'. $doc->file_url) }}" class="img-thumbnail mt-2" width="100" />
                        @endif
                    </div>

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


                    <a href="{{ route('relaas-documents.index', ['search' => $relaas->registration_code]) }}"
                        class="btn btn-secondary btn-sm ">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{ $doc ? 'Update' : 'Simpan' }}
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection