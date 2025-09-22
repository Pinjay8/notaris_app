@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($document) ? 'Edit Dokumen' : 'Tambah Dokumen'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($document) ? 'Edit' : 'Tambah' }} Dokumen</h6>
            </div>
            <div class="card-body px-4 pt-3 pb-2">
                <form action="{{ isset($document) ? route('documents.update', $document) : route('documents.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($document))
                    @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label text-sm">Nama Dokumen</label>
                        <input type=" text" name="name" id="name" class="form-control "
                            value="{{ old('name', $document->name ?? '') }}">
                        @error('name')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label text-sm">Kode Dokumen</label>
                        <input type="text" name="code" id="code" class="form-control"
                            value="{{ old('code', $document->code ?? '') }}">
                        @error('code')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label for="link" class="form-label text-sm">Link</label>
                        <input type="text" name="link" id="link" class="form-control"
                            value="{{ old('link', $document->link ?? '') }}">
                        @error('link')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label for="description" class="form-label text-sm">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control"
                            rows="3">{{ old('description', $document->description ?? '') }}</textarea>
                        @error('description')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label for="image" class="form-label text-sm">Gambar</label>
                        <input type="file" name="image" id="image" class="form-control">


                        @if(old('image'))

                        @elseif(isset($document) && $document->image)
                        <img src="{{ $document->getImageDocument() }}" alt="Preview Gambar" class="img-thumbnail mt-2"
                            width="150">
                        @endif

                        @error('image')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div> --}}
                    {{-- status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label text-sm">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="" disabled>Pilih Status</option>
                            <option value="1" {{ old('status', $document->status ?? '') == '1' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="0" {{ old('status', $document->status ?? '') == '0' ? 'selected' : '' }}>
                                Nonaktif</option>
                        </select>
                        @error('status')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($document) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection