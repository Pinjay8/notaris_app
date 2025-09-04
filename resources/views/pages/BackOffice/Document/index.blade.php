@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Notary Client Document'])

<div class="row mt-4 mx-4">
    <div class="col md-12">
        {{-- Table List --}}
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-2 px-2 flex-wrap">
                <h5>List Dokumen Klien</h5>
                <form method="GET" action="{{ route('management-document.index') }}" class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="registration_code" value="{{ request('registration_code') }}"
                            class="form-control" placeholder="Registration Code">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="client_name" value="{{ request('client_name') }}" class="form-control"
                            placeholder="Client Name">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Registration Code</th>
                                <th>Client Name</th>
                                <th>Product</th>
                                <th>Dokumen Dibutuhkan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->registration_code }}</td>
                                <td>{{ $product->client->fullname ?? '-' }}</td>
                                <td>{{ $product->product->name ?? '-' }}</td>
                                <td>
                                    {{ $product->documents_list ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $product->status == 'done' ? 'success' : 'warning' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="d-flex flex-wrap gap-1 justify-content-center">
                                    {{-- Tombol Detail Dokumen --}}
                                    <button type="button" class="btn btn-info btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#documentDetailModal-{{ $product->registration_code }}">
                                        <i class="fa fa-file"></i>
                                    </button>

                                    {{-- Modal Detail Dokumen --}}
                                    <div class="modal fade" id="documentDetailModal-{{ $product->registration_code }}"
                                        tabindex="-1"
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
                                                                    {{-- <td class="text-center">
                                                                        @if($doc->document_link)
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-primary px-3"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#previewModal{{ $doc->id }}">
                                                                            <i class="bi bi-eye"></i> Lihat
                                                                        </button>

                                                                        <!-- Modal -->
                                                                        <div class="modal fade"
                                                                            id="previewModal{{ $doc->id }}"
                                                                            tabindex="-1" aria-hidden="true">
                                                                            <div
                                                                                class="modal-dialog modal-dialog-centered modal-xl">
                                                                                <!-- gunakan xl agar lebih lebar -->
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">Preview
                                                                                            Dokumen</h5>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body text-center">
                                                                                        <img src="{{ asset('storage/' . $doc->document_link) }}"
                                                                                            alt="Preview"
                                                                                            class="img-fluid rounded"
                                                                                            style="max-height:80vh; object-fit:contain;">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @else
                                                                        <span class="text-muted">Belum ada</span>
                                                                        @endif
                                                                    </td> --}}
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
                                                                        <span class="badge rounded-pill text-white
                            {{ $doc->status == 'valid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                                            {{ ucfirst($doc->status ?? 'new') }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{-- Form Update Status --}}
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
                                                                            @if($doc->status != 'valid')
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

                                                    {{-- Form Upload Dokumen Baru --}}
                                                    <form method="POST"
                                                        action="{{ route('management-document.addDocument') }}"
                                                        enctype="multipart/form-data" class="mt-3">
                                                        @csrf
                                                        <input type="hidden" name="registration_code"
                                                            value="{{ $product->registration_code }}">
                                                        <input type="hidden" name="notaris_id"
                                                            value="{{ $product->notaris_id }}">
                                                        <input type="hidden" name="client_id"
                                                            value="{{ $product->client_id }}">
                                                        {{-- <input type="hidden" name="product_id"
                                                            value="{{ $product->product_id }}"> --}}

                                                        <div class="mb-3">
                                                            <label class="form-label">Pilih Dokumen yang ingin
                                                                dikirim</label>
                                                            <select name="product_id" class="form-select">
                                                                <option value="" hidden>-- Pilih --
                                                                </option>
                                                                @foreach($product->product->documents as $pd)
                                                                <option value="{{ $pd->id }}">{{ $pd->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            {{-- <small class="text-muted">Kosongkan jika ingin input
                                                                manual</small> --}}
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Kode Dokumen</label>
                                                            <input type="text" name="document_code" class="form-control"
                                                                required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Dokumen</label>
                                                            <input type="text" name="document_name" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">File Dokumen</label>
                                                            <input type="file" name="document_link"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan</label>
                                                            <textarea name="note" class="form-control"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Upload</label>
                                                            <input type="date" name="uploaded_at" class="form-control">
                                                        </div>

                                                        <div class="text-end">
                                                            <button type="submit"
                                                                class="btn btn-primary">Upload</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tombol Mark Done --}}
                                    @if($product->status !== 'done')
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
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td>
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