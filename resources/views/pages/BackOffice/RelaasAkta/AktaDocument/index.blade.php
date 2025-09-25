@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen Relaas'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Dokumen Relaas</h6>
            </div>
            <div class="card-body pt-1">

                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('relaas-documents.index') }}" class="mb-3" class="no-spinner">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Masukkan Kode Registrasi / Nomor Relaas" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </div>
                </form>

                {{-- Jika ada data relaas --}}
                @if($relaasInfo)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0 text-white">Detail Relaas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6><strong>Kode Registrasi</strong></h6>
                                <p class="text-muted text-sm">{{ $relaasInfo->registration_code }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Nomor Relaas</strong></h6>
                                <p class="text-muted text-sm">{{ $relaasInfo->relaas_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Notaris</strong></h6>
                                <p class="text-muted text-sm">{{ $relaasInfo->notaris->display_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Klien</strong></h6>
                                <p class="text-muted text-sm">{{ $relaasInfo->client->fullname ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('relaas-documents.create', $relaasInfo->id) }}"
                            class="btn btn-primary btn-sm">+
                            Tambah Dokumen Relaas</a>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Dokumen</th>
                                <th>Tipe</th>
                                <th>Tanggal Upload</th>
                                <th>File</th>
                                {{-- <th>Status</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $doc->name }}</td>
                                <td>{{ $doc->type ?? '-' }}</td>
                                <td>{{ $doc->uploaded_at ? $doc->uploaded_at->format('d-m-Y H:i') : '-' }}</td>
                                <td class="text-center">
                                    @if($doc->file_url)
                                    <a href="{{ asset('storage/'.$doc->file_url) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center mb-0">
                                        <i class="bi bi-eye me-1"></i> Lihat
                                    </a>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    <form action="{{ route('relaas-documents.toggleStatus', $doc->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ $doc->status ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $doc->status ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td> --}}
                                <td>
                                    <a href="{{ route('relaas-documents.edit', [$relaasInfo->id, $doc->id]) }}"
                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                    <form action="{{ route('relaas-documents.destroy', $doc->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm mb-0">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted text-sm">Belum ada dokumen relaas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted text-sm">Silakan cari kode registrasi terlebih dahulu.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection