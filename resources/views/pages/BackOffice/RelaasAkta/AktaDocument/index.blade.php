@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen Relaas'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Dokumen Relaas</h6>
            </div>
            <div class="card-body">

                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('relaas-documents.index') }}" class="mb-3">
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
                                <p><strong>Kode Registrasi</strong></p>
                                <p class="text-muted">{{ $relaasInfo->registration_code }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Nomor Relaas</strong></p>
                                <p class="text-muted">{{ $relaasInfo->relaas_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Notaris</strong></p>
                                <p class="text-muted">{{ $relaasInfo->notaris->display_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Client</strong></p>
                                <p class="text-muted">{{ $relaasInfo->client->fullname ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('relaas-documents.create', $relaasInfo->id) }}"
                            class="btn btn-primary btn-sm">+
                            Tambah Dokumen</a>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Dokumen</th>
                                <th>Tipe</th>
                                <th>File</th>
                                <th>Uploaded At</th>
                                {{-- <th>Status</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $doc->name }}</td>
                                <td>{{ $doc->type ?? '-' }}</td>
                                <td class="text-center">
                                    @if($doc->file_url)
                                    <a href="{{ asset('storage/'.$doc->file_url) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                                        <i class="bi bi-eye me-1"></i> Lihat
                                    </a>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $doc->uploaded_at ? $doc->uploaded_at->format('d-m-Y H:i') : '-' }}</td>
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
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('relaas-documents.destroy', $doc->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus dokumen ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada dokumen</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted">Silakan cari kode registrasi atau nomor relaas terlebih dahulu.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection