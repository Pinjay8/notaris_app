@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Tambah Produk untuk Konsultasi'])

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>Tambah Produk untuk Konsultasi #{{ $consultation->registration_code }}</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('consultation.storeProduct', $consultation->id) }}" method="POST">
                @csrf
                <input type="hidden" name="consultation_id" value="{{ $consultation->id }}">
                <div class="mb-3">
                    <label for="product_id" class="form-label">Pilih Produk</label>
                    <select name="product_id" id="product_id"
                        class="form-select @error('product_id') is-invalid @enderror" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id')==$product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Catatan (Opsional)</label>
                    <textarea name="note" id="note" rows="3" class="form-control">{{ old('note') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Produk</label>
                    <select name="status" id="status" class="form-select">
                        <option value="new" {{ old('status')=='new' ? 'selected' : '' }}>New</option>
                        <option value="progress" {{ old('status')=='progress' ? 'selected' : '' }}>Progress
                        </option>
                        <option value="done" {{ old('status')=='done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Tambah Produk</button>
                <a href="{{ route('consultation.detail', $consultation->id) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection