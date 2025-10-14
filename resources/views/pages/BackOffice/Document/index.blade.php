@extends('layouts.app')


@section('title', 'Dokumen')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen'])

<div class="row mt-4 mx-4">
    <div class="col md-12">
        {{-- Table List --}}
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-2 px-3 flex-wrap">

                <h5>Dokumen</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#uploadModal">
                    + Tambah Dokumen
                </button>
                {{-- Modal Upload --}}
                <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Tambah Dokumen Klien</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>

                            <form method="POST" action="{{ route('management-document.addDocument') }}"
                                enctype="multipart/form-data" class="no-spinner">
                                @csrf
                                <div class="modal-body">
                                    {{-- <div class="mb-3">
                                        <label class="form-label">Dokumen yang Harus Diisi</label>
                                        @if($requiredDocuments->isEmpty())
                                        <p class="text-muted">Semua dokumen sudah diisi.</p>
                                        @else
                                        <ul class="list-group">
                                            @foreach($requiredDocuments->pluck('name') as $docName)
                                            <li class="list-group-item list-group-item-secondary">
                                                {{ $docName }}
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div> --}}
                                    {{-- client_id --}}
                                    <div class="mb-3">
                                        <label class="form-label text-sm">Klien</label>
                                        @php
                                        $clients = $clients ?? collect();
                                        @endphp
                                        <select name="client_id" class="form-select" required>
                                            <option value="" hidden>Pilih Klien</option>
                                            @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->fullname }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="mb-3">
                                        <label class="form-label">Kode Regsitrasi</label>
                                        <input type="text" name="registration_code" class="form-control" required>
                                    </div> --}}

                                    <div class="mb-3">
                                        <label class="form-label text-sm">Pilih Jenis Dokumen</label>
                                        <select name="document_code" class="form-select" required>
                                            <option value="" hidden>Pilih Dokumen</option>
                                            @foreach($documents as $doc)
                                            <option value="{{ $doc->code }}">{{ $doc->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label text-sm">File Dokumen</label>
                                        <input type="file" name="document_link" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-sm">Catatan</label>
                                        <textarea name="note" class="form-control"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-sm">Tanggal Upload</label>
                                        <input type="date" name="uploaded_at" class="form-control">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="d-flex justify-content-end w-100 px-2">
                    <form method="GET" action="{{ route('management-document.index') }}" class="row g-3"
                        class="no-spinner">
                        <div class="col-md-5">
                            <input type="text" name="registration_code" value="{{ request('registration_code') }}"
                                class="form-control" placeholder="Kode Registrasi">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="client_name" value="{{ request('client_name') }}"
                                class="form-control" placeholder="Nama Klien">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Kode Registrasi</th>
                                <th>Nama Klien</th>
                                <th>Dokumen</th>
                                <th>Kode Dokumen</th>
                                <th>Tanggal Upload</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->registration_code }}</td>
                                <td>{{ $product->client->fullname ?? '-' }}</td>
                                <td>{{ $product->document_name ?? '-' }}</td>
                                <td>{{ $product->document_code ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($product->uploaded_at)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge
                                        @if($product->status == 'new') bg-primary
                                        @elseif($product->status == 'valid') bg-success
                                        @elseif($product->status == 'invalid') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td>{{ $product->note ?? '-' }}</td>
                                <td>
                                    {{-- Tombol Detail Dokumen --}}
                                    {{-- <button type="button" class="btn btn-info btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#documentDetailModal-{{ $product->registration_code }}">
                                        <i class="fa fa-file"></i>
                                    </button> --}}

                                    {{-- Modal Detail Dokumen --}}
                                    {{-- <div class="modal fade"
                                        id="documentDetailModal-{{ $product->registration_code }}" tabindex="-1"
                                        aria-labelledby="documentDetailLabel-{{ $product->registration_code }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content shadow-lg border-0 rounded-3">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title text-white"
                                                        id="documentDetailLabel-{{ $product->registration_code }}">
                                                        <i class="bi bi-folder2-open me-2"></i> Dokumen - {{
                                                        $product->registration_code }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    @php
                                                    $docs = $product->documentHistory ?? collect();
                                                    @endphp

                                                    @if($docs->isEmpty())
                                                    <div class="text-center text-muted py-5">
                                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                                        <h6 class="mb-1">Belum ada dokumen</h6>
                                                        <p class="small mb-0">Silakan upload dokumen terlebih dahulu</p>
                                                    </div>
                                                    @else
                                                    <div class="table-responsive shadow-sm rounded">
                                                        <table
                                                            class="table table-bordered table-striped table-hover align-middle mb-0">
                                                            <thead class="table-primary text-center">
                                                                <tr class="text-center">
                                                                    <th style="width: 5%">#</th>
                                                                    <th style="width: 25%">Nama Dokumen</th>
                                                                    <th style="width: 15%">Dokumen</th>
                                                                    <th style="width: 30%">Catatan</th>
                                                                    <th style="width: 15%">Status</th>
                                                                    <th style="width: 15%">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($docs as $doc)
                                                                <tr class="text-center">
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $doc->document_name }}</td>
                                                                    <td>
                                                                        <a href="{{ asset('storage/' . $doc->document_link) }}"
                                                                            target="_blank">
                                                                            <img src="{{ asset('storage/' . $doc->document_link) }}"
                                                                                alt="Dokumen" class="img-fluid"
                                                                                style="max-width: 150px; cursor: pointer;">
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $doc->note ?? '-' }}</td>
                                                                    <td class="text-center">
                                                                        <span
                                                                            class="badge rounded-pill text-white {{ $doc->status == 'valid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                                            {{ ucfirst($doc->status ?? 'new') }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">

                                                                        <form method="POST"
                                                                            action="{{ route('management-document.updateStatus') }}"
                                                                            class="d-inline">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <input type="hidden"
                                                                                name="registration_code"
                                                                                value="{{ $product->registration_code }}">
                                                                            <input type="hidden" name="notaris_id"
                                                                                value="{{ $product->notaris_id }}">
                                                                            <input type="hidden" name="client_id"
                                                                                value="{{ $product->client_id }}">
                                                                            <input type="hidden" name="product_id"
                                                                                value="{{ $product->product_id }}">
                                                                            <input type="hidden" name="status"
                                                                                value="valid">
                                                                            @if($doc->status === 'new')
                                                                            <button type="submit"
                                                                                class="btn btn-success btn-sm px-3 mb-0">
                                                                                <i class="bi bi-check-circle"></i> Valid
                                                                            </button>
                                                                            @endif
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    {{-- Tombol Mark Done --}}
                                    {{-- @if($product->status !== 'done')
                                    <button type="button" class="btn btn-success btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#markDoneModal-{{ $product->registration_code }}">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <div class="modal fade" id="markDoneModal-{{ $product->registration_code }}"
                                        tabindex="-1" aria-labelledby="markDoneLabel-{{ $product->registration_code }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form method="POST" action="{{ route('management-document.markDone') }}">
                                                @csrf
                                                <input type="hidden" name="registration_code"
                                                    value="{{ $product->registration_code }}">
                                                <input type="hidden" name="notaris_id"
                                                    value="{{ $product->notaris_id }}">
                                                <input type="hidden" name="client_id" value="{{ $product->client_id }}">
                                                <input type="hidden" name="product_id"
                                                    value="{{ $product->product_id }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Konfirmasi Selesai</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin mengubah status
                                                        <strong>{{ $product->registration_code }}</strong> menjadi
                                                        <span class="badge bg-success">DONE</span>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Ya,
                                                            Selesaikan</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endif --}}
                                    @if($product->status !== 'done' && $product->status !== 'valid')
                                    <button type="button" class="btn btn-success btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#validationModal-{{ $product->registration_code }}">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#invalidModal-{{ $product->registration_code }}">
                                        <i class="fa-solid fa-x"></i>
                                    </button>
                                    <div class="modal fade" id="validationModal-{{ $product->registration_code }}"
                                        tabindex="-1"
                                        aria-labelledby="validationModalLabel-{{ $product->registration_code }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Validasi Dokumen</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center text-wrap">
                                                    Apakah dokumen <strong>{{ $product->document_name }}</strong> dengan
                                                    kode registrasi
                                                    <strong>{{ $product->registration_code }}</strong> <br>
                                                    dinyatakan <span class="text-success fw-bold">VALID?</span>
                                                </div>
                                                <div class="modal-footer d-flex justify-content-end">
                                                    {{-- Tidak Valid --}}
                                                    {{-- <form method="POST"
                                                        action="{{ route('management-document.updateStatus') }}">
                                                        @csrf
                                                        <input type="hidden" name="registration_code"
                                                            value="{{ $product->registration_code }}">
                                                        <input type="hidden" name="notaris_id"
                                                            value="{{ $product->notaris_id }}">
                                                        <input type="hidden" name="client_id"
                                                            value="{{ $product->client_id }}">
                                                        <input type="hidden" name="status" value="invalid">
                                                        <button type="submit" class="btn btn-danger">Tidak
                                                            Valid</button>
                                                    </form> --}}

                                                    {{-- Valid --}}
                                                    <form method="POST"
                                                        action="{{ route('management-document.updateStatus') }}">
                                                        @csrf
                                                        <input type="hidden" name="registration_code"
                                                            value="{{ $product->registration_code }}">
                                                        <input type="hidden" name="notaris_id"
                                                            value="{{ $product->notaris_id }}">
                                                        <input type="hidden" name="client_id"
                                                            value="{{ $product->client_id }}">
                                                        <input type="hidden" name="status" value="valid">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="invalidModal-{{ $product->registration_code }}"
                                        tabindex="-1"
                                        aria-labelledby="invalidModalLabel-{{ $product->registration_code }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Validasi Dokumen</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center text-wrap">
                                                    Apakah dokumen <strong>{{ $product->document_name }}</strong> dengan
                                                    kode registrasi
                                                    <strong>{{ $product->registration_code }}</strong> dinyatakan
                                                    <span class="text-danger fw-bold">TIDAK VALID</span>?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST"
                                                        action="{{ route('management-document.updateStatus') }}">
                                                        @csrf
                                                        <input type="hidden" name="registration_code"
                                                            value="{{ $product->registration_code }}">
                                                        <input type="hidden" name="notaris_id"
                                                            value="{{ $product->notaris_id }}">
                                                        <input type="hidden" name="client_id"
                                                            value="{{ $product->client_id }}">
                                                        <input type="hidden" name="status" value="invalid">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted text-sm">Data dokumen warkah tidak
                                    ditemukan.
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
@endsection