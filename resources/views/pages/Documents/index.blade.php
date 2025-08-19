@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Dokumen</h6>
                <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm mb-0">
                    + Tambah Dokumen
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <form method="GET" action="{{ route('documents.index') }}" class="d-flex gap-2 ms-auto me-4 mb-3"
                        style="max-width: 500px;">
                        <input type="text" name="search" placeholder="Cari kode/nama dokumen..."
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
                                    Nama Dokumen
                                </th>
                                <th class="th-title">
                                    Kode Dokumen
                                </th>
                                <th class="th-title">
                                    Deskripsi
                                </th>
                                <th class="th-title">
                                    Link
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
                            @forelse ($documents as $document)
                            <tr>
                                <td>
                                    <p class="text-sm mb-0 text-center">{{ $loop->iteration }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center"> {{
                                        $document->name
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $document->code
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $document->description
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $document->link
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <img src="{{asset('storage/'.$document->image) }}" alt="Gambar Layanan" width="100"
                                        class="rounded-circle img-fluid">
                                </td>
                                <td>
                                    <span
                                        class="badge text-center d-block mx-auto bg-{{ $document->status == 1 ? 'success' : 'secondary' }}">
                                        {{ $document->status == 1 ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('documents.edit', $document->id) }}"
                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                    <form action="{{ route('documents.deactivate', $document->id) }}" method="POST"
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
                                <td colspan="8" class="text-center text-muted">Belum ada data dokumen.</td>
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