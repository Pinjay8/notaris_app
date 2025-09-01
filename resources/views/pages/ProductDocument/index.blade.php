@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen Layanan'])
<div class="row mt-4 mx-4">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header px-2 pb-0 d-flex justify-content-between align-items-center mb-1">
                <h6 class="mb-0">Dokumen Layanan</h6>
            </div>
            <div class="row mt-3">
                <div class="mx-2 mb-3">
                    <h6 class="fw-medium">Pilih Layanan yang ingin ditambahkan ke dokumen</h6>
                </div>
                @foreach ($products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card p-4">
                        <h5 class="text-capitalize">Layanan {{ $product->name }} - Kode {{ $product->code_products
                            }}
                        </h5>
                        <a href="{{ route('products.documents.index', $product->id) }}"
                            class="btn btn-primary mt-2">Kelola
                            Dokumen</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection