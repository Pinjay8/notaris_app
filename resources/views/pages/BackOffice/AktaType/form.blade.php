@extends('layouts.app')

@section('title', 'Jenis Akta')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tipe Akta'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">{{ isset($aktaType) ? 'Edit Tipe Akta' : 'Tambah Tipe Akta' }}</h6>
                </div>
                <hr>
                <div class="card-body px-4 pt-0 pb-2">
                    <form
                        action="{{ isset($aktaType) ? route('akta-types.update', $aktaType->id) : route('akta-types.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($aktaType))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label for="category" class="form-label text-sm">Kategori Akta</label>
                            <select name="category" id="category"
                                class="form-select @error('category') is-invalid @enderror">
                                <option value="" hidden>Pilih Kategori Akta</option>
                                @foreach (['pendirian', 'perubahan', 'pemutusan'] as $cat)
                                    <option value="{{ $cat }}"
                                        {{ old('category', $aktaType->category ?? '') == $cat ? 'selected' : '' }}>
                                        {{ ucfirst($cat) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label text-sm">Tipe</label>
                            <input type="text" name="type" id="type"
                                class="form-control @error('type') is-invalid @enderror"
                                value="{{ old('type', $aktaType->type ?? '') }}" placeholder="Contoh: Akta Pendirian PT">
                            {{-- <div class="form-text text-secondary">Contoh: Akta Pendirian PT</div> --}}
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-sm">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control">{{ $aktaType->description ?? old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="documents" class="form-label text-sm">Kebutuhan Dokumen</label>
                            <textarea name="documents" id="documents" class="form-control"
                                placeholder="Contoh: Fotokopi KTP, NPWP, Fotokopi Akta Pendirian">{{ $aktaType->documents ?? old('documents') }}</textarea>
                            {{-- <div class="form-text">Contoh: Fotokopi KTP, NPWP, Fotokopi Akta Pendirian</div> --}}
                        </div>


                        <a href="{{ route('akta-types.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($aktaType) ? 'Ubah' : 'Simpan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
