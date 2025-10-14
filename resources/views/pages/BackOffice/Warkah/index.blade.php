@extends('layouts.app')

@section('title', 'Warkah')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Warkah'])

<div class="row mt-4 mx-4">
    <div class="col md-12">
        {{-- Table List --}}
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-2 px-3 flex-wrap">
                <h6>Warkah</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#uploadModal">
                    + Tambah Warkah
                </button>
                <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Tambah Dokumen Warkah Klien</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>

                            <form method="POST" action="{{ route('warkah.addDocument') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">

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
                                        <label class="form-label text-sm">Dokumen</label>
                                        <select name="warkah_code" class="form-select" required>
                                            <option value="" hidden>Pilih Dokumen</option>
                                            @foreach($documents as $doc)
                                            <option value="{{ $doc->code }}">{{ $doc->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label text-sm">File Dokumen</label>
                                        <input type="file" name="warkah_link" class="form-control"
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
                    <form method="GET" action="{{ route('warkah.index') }}" class="row g-3" class="no-spinner">
                        <div class="col-md-5">
                            <input type="text" name="registration_code" value="{{ request('registration_code') }}"
                                class="form-control" placeholder="Kode Registrasi">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="client_name" value="{{ request('client_name') }}"
                                class="form-control" placeholder="Nama Klien">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary ">Cari</button>
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
                                <td>{{ $product->warkah_name ?? '-' }}</td>
                                <td>{{ $product->warkah_code ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($product->uploaded_at)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->status == 'done' ? 'success' : 'warning' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td>{{ $product->note ?? '-' }}</td>
                                <td>
                                    @if($product->status !== 'done' && $product->status !== 'valid')
                                    <button type="button" class="btn btn-success btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#validationModal-{{ $product->registration_code }}">
                                        <i class="fa fa-check"></i>
                                    </button>

                                    <div class="modal fade" id="validationModal-{{ $product->registration_code }}"
                                        tabindex="-1"
                                        aria-labelledby="validationModalLabel-{{ $product->registration_code }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Validasi Dokumen</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    Apakah dokumen <strong>{{ $product->document_name }}</strong> dengan
                                                    kode registrasi
                                                    <strong>{{ $product->registration_code }}</strong> <br>
                                                    dinyatakan <span class="text-success fw-bold">VALID</span> atau
                                                    <span class="text-danger fw-bold">TIDAK VALID</span>?
                                                </div>
                                                <div class="modal-footer d-flex justify-content-between">
                                                    {{-- Tidak Valid --}}
                                                    <form method="POST" action="{{ route('warkah.updateStatus') }}">
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
                                                    </form>

                                                    {{-- Valid --}}
                                                    <form method="POST" action="{{ route('warkah.updateStatus') }}">
                                                        @csrf
                                                        <input type="hidden" name="registration_code"
                                                            value="{{ $product->registration_code }}">
                                                        <input type="hidden" name="notaris_id"
                                                            value="{{ $product->notaris_id }}">
                                                        <input type="hidden" name="client_id"
                                                            value="{{ $product->client_id }}">
                                                        <input type="hidden" name="status" value="valid">
                                                        <button type="submit" class="btn btn-success">Valid</button>
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