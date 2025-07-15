@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Subscription'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Layanan</h6>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm mb-0">
                    + Tambah Layanan
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <form method="GET" action="{{ route('products.index') }}" class="d-flex gap-2 ms-auto me-4 mb-3"
                        style="max-width: 500px;">
                        <input type="text" name="search" placeholder="Cari kode/nama layanan..."
                            value="{{ request('search') }}" class="form-control">
                        <select name="status" class="form-select">
                            <option value="1" {{ request('status')=='1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('status')=='0' ? 'selected' : '' }}>Nonaktif</option>
                            </option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </form>
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="th-title">
                                    Id
                                </th>
                                <th class="th-title">
                                    Nama Layanan
                                </th>
                                <th class="th-title">
                                    Kode Layanan
                                </th>
                                <th class="th-title">
                                    Deskripsi
                                </th>
                                <th class="th-title">
                                    Gambar
                                </th>
                                <th class="th-title">
                                    Status
                                </th>
                                <th class="th-title">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>
                                    <p class="text-sm mb-0 text-center">{{ $loop->iteration }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center"> {{
                                        $product->name
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $product->code_products
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $product->description
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <img src="{{ $product->getImageProduct() }}" alt="Gambar Layanan" width="100"
                                        class="rounded-circle img-fluid">
                                </td>
                                <td>
                                    <span
                                        class="badge text-center d-block mx-auto bg-{{ $product->status == 1 ? 'success' : 'secondary' }}">
                                        {{ $product->status == 1 ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                    <form action="{{ route('products.deactivate', $product->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning btn-sm mb-0">Nonaktifkan</button>
                                    </form>
                                    {{-- <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $product->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                    @include('pages.Products.modal.index') --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data layanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection