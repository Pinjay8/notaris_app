@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => $doc ? 'Edit Dokumen' : 'Tambah Dokumen'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ $doc ? 'Edit Dokumen' : 'Tambah Dokumen' }}</h6>
            </div>
            <div class="card-body">
                <form
                    action="{{ $doc ? route('relaas-documents.update', [$relaas->id, $doc->id]) : route('relaas-documents.store', $relaas->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($doc)
                    @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Nama Dokumen</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $doc->name ?? '') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe Dokumen</label>
                        <input type="text" name="type" class="form-control" value="{{ old('type', $doc->type ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File</label>
                        <input type="file" name="file" class="form-control">
                        @if($doc && $doc->file_url)
                        <img src="{{ asset('storage/'. $doc->file_url) }}" class="img-thumbnail mt-2" width="100" />
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('relaas-documents.index', ['search' => $relaas->registration_code]) }}"
                            class="btn btn-secondary btn-sm me-2">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection