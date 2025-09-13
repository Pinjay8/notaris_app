@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'PIC Dokumen'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            {{-- Card Utama --}}
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Daftar PIC Dokumen</h5>
                    <a href="{{ route('pic_documents.create') }}" class="btn btn-sm btn-primary mb-0">
                        + Tambah PIC Dokumen
                    </a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <form method="GET" action="{{ route('pic_documents.index') }}"
                            class="d-flex gap-2 ms-auto me-4 mb-3" style="max-width: 500px;">
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Cari kode registrasi / PIC" value="{{ request('search') }}">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status')=='pending' ?'selected':'' }}>Pending
                                </option>
                                <option value="selesai" {{ request('status')=='selesai' ?'selected':'' }}>Selesai
                                </option>
                            </select>
                            <button class="btn btn-sm btn-primary mb-0" type="submit">Cari</button>
                        </form>

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode PIC Dokumen</th>
                                    <th>PIC</th>
                                    <th>Klien</th>
                                    <th>Tipe Dokumen</th>
                                    <th>Status</th>
                                    <th>
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($picDocuments as $doc)
                                <tr class="text-center text-sm">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $doc->pic_document_code }}</td>
                                    <td>{{ $doc->pic->full_name ?? '-' }}</td>
                                    <td>{{ $doc->client->fullname ?? '-' }}</td>
                                    <td>{{ $doc->document_type }}</td>
                                    <td>
                                        <span class="badge bg-{{ $doc->status=='selesai' ? 'success' : 'warning' }}">
                                            {{ ucfirst($doc->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('pic_documents.edit', $doc->id) }}"
                                            class="btn btn-sm btn-info mb-0">Edit</a>
                                        <form action="{{ route('pic_documents.destroy', $doc->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mb-0">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted text-sm">Tidak ada data pic dokumen
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection