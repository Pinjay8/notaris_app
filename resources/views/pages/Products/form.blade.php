@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($product) ? 'Edit Layanan' : 'Tambah Layanan'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($product) ? 'Edit' : 'Tambah' }} Layanan</h6>
            </div>
            <div class="card-body px-4 pt-3 pb-2">
                <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($product))
                    @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label text-sm">Nama Layanan</label>
                        <input type=" text" name="name" id="name" class="form-control "
                            value="{{ old('name', $product->name ?? '') }}">
                        @error('name')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code_products" class="form-label text-sm">Kode Layanan</label>
                        <input type="text" name="code_products" id="code_products" class="form-control"
                            value="{{ old('code_products', $product->code_products ?? '') }}">
                        @error('code_products')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label text-sm">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control"
                            rows="3">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label text-sm">Gambar (opsional)</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(isset($product) && $product->image)
                        <img src="{{ $product->getImageProduct() }}" alt="Preview Gambar" class="img-thumbnail mt-2"
                            width="150">
                        @endif
                        @error('image')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label text-sm">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Pilih Status</option>
                            <option value="1" {{ old('status', $product->status ?? '') == '1' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="0" {{ old('status', $product->status ?? '') == '0' ? 'selected' : '' }}>
                                Nonaktif</option>
                        </select>
                        @error('status')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($product) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection