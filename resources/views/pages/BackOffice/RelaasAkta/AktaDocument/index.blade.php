@extends('layouts.app')

@section('title', 'Dokumen Akta')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'PPAT / Dokumen Akta'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Dokumen Akta</h6>
                </div>
                <div class="card-body pt-1 pb-0">

                    {{-- Form Pencarian --}}
                    <form method="GET" action="{{ route('relaas-documents.index') }}" class="mb-3" class="no-spinner">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Masukkan Kode Klien"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                        </div>
                    </form>

                    {{-- Jika ada data relaas --}}
                    @if ($relaasInfo)
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0 text-white">Detail Transaksi Akta</h6>
                            </div>
                            <div class="card-body pb-2">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h6><strong>Kode Klien</strong></h6>
                                        <p class="text-muted text-sm">{{ $relaasInfo->client_code }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6><strong>Nomor Transaksi</strong></h6>
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
                                    <div class="col-md-6">
                                        <h6 class="mb-1"><strong>Tipe Akta</strong></h6>
                                        <p class="text-muted text-sm">{{ $relaasInfo->akta_type->type ?? '-' }}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Status</strong></p>
                                        <span
                                            class="badge text-capitalize
                                    @switch($relaasInfo->status)
                                        @case('draft') bg-secondary @break
                                        @case('diproses') bg-warning @break
                                        @case('selesai') bg-success @break
                                        @case('dibatalkan') bg-danger @break
                                        @default bg-light text-dark
                                    @endswitch
                                ">
                                            {{ $relaasInfo->status }}
                                        </span>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <h6><strong>Jenis Akta</strong></h6>
                                        <p class="text-muted text-sm">{{ $relaasInfo->title?? '-' }}</p>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>Dokumen Akta</h5>
                                <a href="{{ route('relaas-documents.create', $relaasInfo->id) }}"
                                    class="btn btn-primary btn-sm">+
                                    Tambah Dokumen</a>
                            </div>

                            <div class="table-responsive p-0">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Dokumen</th>
                                            <th>Tipe</th>
                                            <th>Tanggal Upload</th>
                                            <th>File Dokumen Akta</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($documents as $doc)
                                            <tr class="text-center text-sm">
                                                <td>{{ $documents->firstItem() + $loop->index }}</td>
                                                <td>{{ $doc->name }}</td>
                                                <td>{{ $doc->type ?? '-' }}</td>
                                                <td>{{ $doc->uploaded_at ? $doc->uploaded_at->format('d F Y H:i:s') : '-' }}
                                                </td>
                                                <td class="text-center" width="10%">
                                                    @if ($doc->file_url)
                                                        <a href="{{ asset('storage/' . $doc->file_url) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center mb-0">
                                                            <i class="bi bi-image me-1"></i> Lihat Akta Dokumen
                                                        </a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="d-flex gap-1 justify-content-center">
                                                    <a href="{{ route('relaas-documents.edit', [$relaasInfo->id, $doc->id]) }}"
                                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                                    <form action="{{ route('relaas-documents.destroy', $doc->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-danger btn-sm mb-0">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted text-sm">Belum ada dokumen
                                                    akta.
                                                    .</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                {{ $documents->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <p class="text-center text-muted text-sm mb-0">Masukkan Kode Klien untuk melihat daftar dokumen
                            relaas.
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
