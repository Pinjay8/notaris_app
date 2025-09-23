@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Tipe Akta</h6>
                <a href="{{ route('akta-types.create') }}" class="btn btn-primary btn-sm mb-0">
                    + Tambah Tipe Akta
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <form method="GET" action="{{ route('akta-types.index') }}" class="d-flex gap-2 ms-auto me-4 mb-3"
                        style="max-width: 500px;" class="no-spinner">
                        <input type="text" name="search" placeholder="Cari tipe..." value="{{ request('search') }}"
                            class="form-control">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </form>
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="th-title">
                                    #
                                </th>
                                <th class="th-title">
                                    Notaris
                                </th>
                                <th class="th-title">
                                    Kategori
                                </th>
                                <th class="th-title">
                                    Tipe
                                </th>
                                <th class="th-title">
                                    Deskripsi
                                </th>
                                <th class="th-title">
                                    Dokumen
                                </th>
                                <th class="th-title">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aktaTypes as $aktaType)
                            <tr>
                                <td>
                                    <p class="text-sm mb-0 text-center">{{ $loop->iteration }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center"> {{
                                        $aktaType->notaris->display_name
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center text-capitalize"> {{
                                        $aktaType->category
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center"> {{
                                        $aktaType->type
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $aktaType->description
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $aktaType->documents
                                        }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('akta-types.edit', $aktaType->id) }}"
                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $aktaType->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                    @include('pages.BackOffice.AktaType.modal.index')
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted text-sm">Belum ada data tipe akta.</td>
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