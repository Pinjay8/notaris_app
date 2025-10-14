@extends('layouts.app')

@section('title', 'Dokumen Akta')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center  mb-0 pb-0">
                <h5>Dokumen Akta</h5>
            </div>
            <div class="card-body">
                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('akta-documents.index') }}"
                    class="d-flex gap-2 mb-3 justify-content-end" class="no-spinner">
                    <input type="text" name="registration_code" class="form-control"
                        placeholder="Cari kode registrasi..." value="{{ $filters['registration_code'] ?? '' }}">
                    <input type="text" name="akta_number" class="form-control" placeholder="Cari nomor akta..."
                        value="{{ $filters['akta_number'] ?? '' }}">
                    <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                </form>

                {{-- Tampilkan transaksi jika ada --}}
                @if($transaction)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0 text-white">Detail Transaksi Akta</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Kode Registrasi</strong></h6>
                                <p class="text-muted text-sm">{{ $transaction->registration_code }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Nomor Akta</strong></h6>
                                <p class="text-muted text-sm">{{ $transaction->akta_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Jenis Akta</strong></h6>
                                <p class="text-muted text-sm">{{ $transaction->akta_type->type ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Notaris</strong></h6>
                                <p class="text-muted text-sm">{{ $transaction->notaris->display_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Klien</strong></h6>
                                <p class="text-muted text-sm">{{ $transaction->client->fullname ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status</strong></p>
                                <span class="badge
                                    @switch($transaction->status)
                                        @case('draft') bg-secondary @break
                                        @case('diproses') bg-warning @break
                                        @case('selesai') bg-success @break
                                        @case('dibatalkan') bg-danger @break
                                        @default bg-light text-dark
                                    @endswitch
                                ">
                                    {{ $transaction->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Dokumen --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('akta-documents.createData', ['akta_transaction_id' => $transaction->id]) }}"
                            class="btn btn-primary btn-sm mb-2 ">+ Tambah Akta Dokumen</a>
                    </div>
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Dokumen</th>
                                <th>Tipe</th>
                                <th>Tanggal Upload</th>
                                <th>File Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $doc->name }}</td>
                                <td>{{ $doc->type }}</td>
                                <td>
                                    {{ $doc->uploaded_at ? \Carbon\Carbon::parse($doc->uploaded_at)->format('d-m-Y H:i')
                                    : '-' }}
                                </td>
                                <td class="text-center">
                                    @if($doc->file_url)
                                    <a href="{{ asset('storage/'.$doc->file_url) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary d-inline-flex align-items-center mb-0">
                                        <i class="bi bi-file-earmark-text me-1"></i> Lihat File
                                    </a>
                                    @else
                                    <span class="badge bg-secondary">Tidak Ada File</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('akta-documents.edit', $doc->id) }}"
                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                    <form action="{{ route('akta-documents.destroy', $doc->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-0">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada akta dokumen.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted text-sm mt-5">Silakan cari kode registrasi atau nomor akta untuk
                    menampilkan
                    transaksi.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection