@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Legalisasi'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Daftar Legalisasi</h6>
                <a href="{{ route('notary-legalisasi.create') }}" class="btn btn-primary btn-sm mb-0">
                    + Tambah Legalisasi
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form method="GET" action="{{ route('notary-legalisasi.index') }}"
                    class="d-flex justify-content-end flex-nowrap gap-2 ms-auto me-4 mb-3">
                    <input type="text" name="legalisasi_number" placeholder="Cari nomor legalisasi..."
                        value="{{ request('legalisasi_number') }}" class="form-control" style="max-width: 200px;">

                    <select name="sort" class="form-select flex-shrink-0" style="max-width: 150px;">
                        <option value="" {{ request('sort')=='' ? 'selected' : '' }}>Urutkan</option>
                        <option value="asc" {{ request('sort')=='asc' ? 'selected' : '' }}>Tanggal Awal</option>
                        <option value="desc" {{ request('sort')=='desc' ? 'selected' : '' }}>Tanggal Terbaru
                        </option>
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm flex-shrink-0 mb-0">Cari</button>
                </form>
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nomor Legalisasi</th>
                                <th>Nama Pemohon</th>
                                <th>Nama Petugas</th>
                                <th>Jenis Dokumen</th>
                                <th>Nomor Dokumen</th>
                                <th>Tanggal Permintaan</th>
                                <th>Tanggal Rilis</th>
                                <th>Catatan</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->legalisasi_number }}</td>
                                <td>{{ $item->applicant_name }}</td>
                                <td>{{ $item->officer_name }}</td>
                                <td>{{ $item->document_type }}</td>
                                <td>{{ $item->document_number }}</td>
                                <td>{{ $item->request_date ? \Carbon\Carbon::parse($item->request_date)->format('d-m-Y')
                                    : '-' }}</td>
                                <td>{{ $item->release_date ? \Carbon\Carbon::parse($item->release_date)->format('d-m-Y')
                                    : '-' }}</td>
                                <td>{{ $item->notes }}</td>
                                {{-- file image --}}
                                <td>
                                    @if ($item->file_path)
                                    @php
                                    $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp

                                    @if ($isImage)
                                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="Preview"
                                        style="max-width: 100px; max-height: 100px;">
                                    @else
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                        class="btn btn-primary btn-sm mb-0">
                                        Lihat File
                                    </a>
                                    @endif
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('notary-legalisasi.edit', $item->id) }}"
                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                    <form action="{{ route('notary-legalisasi.destroy', $item->id) }}" method="POST"
                                        class="d-inline-block" @csrf @method('DELETE') <button type="submit"
                                        class="btn btn-danger btn-sm mb-0">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Belum ada data legalisasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 ms-3">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection