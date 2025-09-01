@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($aktaType) ? 'Edit Tipe Akta' : 'Tambah Tipe Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6 class="mb-0">{{ isset($aktaType) ? 'Edit Tipe Akta' : 'Tambah Tipe Akta' }}</h6>
            </div>
            <div class="card-body px-4 pt-3 pb-2">
                <form
                    action="{{ isset($aktaType) ? route('akta-types.update', $aktaType->id) : route('akta-types.store') }}"
                    method="POST"
                >
                    @csrf
                    @if(isset($aktaType))
                        @method('PUT')
                    @endif

                    {{-- <div class="mb-3">
                        <label for="notaris_id" class="form-label">Notaris</label>
                        <select name="notaris_id" id="notaris_id" class="form-select" required>
                            <option value="" hidden>-- Pilih Notaris --</option>
                            @foreach($notaris as $notary)
                                <option value="{{ $notary->id }}" {{ isset($aktaType) && $aktaType->notaris_id == $notary->id ? 'selected' : '' }}>
                                    {{ $notary->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category" id="category" class="form-select">
                            <option value="" hidden>-- Pilih Kategori --</option>
                            @foreach(['pendirian','perubahan','pemutusan'] as $cat)
                                <option value="{{ $cat }}" {{ isset($aktaType) && $aktaType->category == $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe</label>
                        <input type="text" name="type" id="type" class="form-control"
                            value="{{ $aktaType->type ?? old('type') }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control">{{ $aktaType->description ?? old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="documents" class="form-label">Dokumen</label>
                        <textarea name="documents" id="documents" class="form-control" required>{{ $aktaType->documents ?? old('documents') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ isset($aktaType) ? 'Update' : 'Simpan' }}
                    </button>
                    <a href="{{ route('akta-types.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection