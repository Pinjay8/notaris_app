@extends('layouts.app')

@section('title', 'Jenis Warkah')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Jenis Warkah'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-header pb-0 mb-0 ">
                    <div class=" d-flex justify-content-between align-items">
                        <h5 class="mb-0">Jenis Warkah</h5>
                        <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm mb-0">
                            + Tambah Jenis Warkah
                        </a>
                    </div>
                    <form method="GET" action="{{ route('documents.index') }}" class="d-flex gap-2 ms-auto mt-3"
                        style="max-width: 500px;">
                        <input type="text" name="search" placeholder="Cari nama jenis warkah"
                            value="{{ request('search') }}" class="form-control">
                        <select name="status" class="form-select">
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </form>
                </div>
                <hr>
                <div class="card-body px-0 pt-0 pb-0">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="th-title">
                                        #
                                    </th>
                                    <th class="th-title">
                                        Nama
                                    </th>
                                    <th class="th-title">
                                        Kode
                                    </th>
                                    <th class="th-title">
                                        Deskripsi
                                    </th>
                                    {{-- <th class="th-title">
                                    Link
                                </th>
                                <th class="th-title">
                                    Gambar
                                </th> --}}
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
                                    <tr class="text-center text-sm">
                                        <td>
                                            <p class="text-sm mb-0 text-center">{{ $documents->firstItem() + $loop->index }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0  text-center"> {{ $document->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0  text-center">{{ $document->code }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0  text-center">{{ $document->description }}
                                            </p>
                                        </td>
                                        <td>
                                            <span
                                                class="badge text-center  bg-{{ $document->status == 1 ? 'success' : 'danger' }} text-capitalize">
                                                {{ $document->status == 1 ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($document->status != 0)
                                                <a href="{{ route('documents.edit', $document->id) }}"
                                                    class="btn btn-info btn-sm mb-0">
                                                    Edit
                                                </a>
                                                <form action="{{ route('documents.deactivate', $document->id) }}"
                                                    method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="btn btn-dark btn-sm mb-0">Nonaktif</button>
                                                </form>
                                            @else
                                                {{-- <span class="badge bg-secondary">Nonaktif</span> --}}
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted text-sm">Belum ada data dokumen.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $documents->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
