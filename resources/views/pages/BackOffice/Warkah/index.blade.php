@extends('layouts.app')

@section('title', 'Warkah')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Warkah'])

    <div class="row mt-4 mx-4">
        <div class="col md-12">
            {{-- Table List --}}
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-3 px-3 flex-wrap">
                    <h5>Warkah</h5>
                    <a href="{{ route('warkah.create') }}" class="btn btn-primary btn-sm mb-0">
                        + Tambah Warkah
                    </a>
                </div>
                <div class="d-flex justify-content-lg-end w-100 px-2">
                    <form method="GET" action="{{ route('warkah.index') }}" class=" g-2 w-100 no-spinner d-flex gap-2"
                        style="max-width: 500px;">
                        <input type="text" name="registration_code" value="{{ request('registration_code') }}"
                            class="form-control" placeholder="Kode Registrasi">
                        <input type="text" name="client_name" value="{{ request('client_name') }}" class="form-control"
                            placeholder="Nama Klien">
                        <button type="submit" class="btn btn-primary mb-0 btn-sm">Cari</button>
                    </form>
                </div>
                <hr>
                <div class="card-body px-0 pt-0 pb-0 mt-2">

                    <div class="table-responsive p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Kode Registrasi</th>
                                    <th>Kode Dokumen</th>
                                    <th>Nama Klien</th>
                                    <th>Dokumen</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $product)
                                    <tr class="text-center text-sm">
                                        <td>{{ $documents->firstItem() + $loop->index }}</td>
                                        <td>{{ $product->registration_code }}</td>
                                        <td>{{ $product->client->fullname ?? '-' }}</td>
                                        <td>{{ $product->warkah_name ?? '-' }}</td>
                                        <td>{{ $product->warkah_code ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($product->uploaded_at)->format('d-m-Y') }}</td>
                                        <td>
                                            <span
                                                class="badge text-capitalize mb-0
                                        @if ($product->status == 'new') bg-primary
                                        @elseif($product->status == 'valid') bg-success
                                        @elseif($product->status == 'invalid') bg-danger
                                        @else bg-secondary @endif">
                                                @if ($product->status == 'new')
                                                    Baru
                                                @elseif($product->status == 'invalid')
                                                    Tidak Valid
                                                @else
                                                    {{ ucfirst($product->status) }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $product->note ?? '-' }}</td>
                                        <td>
                                            @if ($product->status !== 'done' && $product->status !== 'valid' && $product->status !== 'invalid')
                                                <button type="button" class="btn btn-success btn-xs mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#validationModal-{{ $product->registration_code }}">
                                                    <i class="fa fa-check me-1"></i> Valid
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#invalidModal-{{ $product->registration_code }}">
                                                    <i class="fa-solid fa-x me-1"></i>
                                                    Tidak Valid
                                                </button>
                                                <div class="modal fade"
                                                    id="validationModal-{{ $product->registration_code }}" tabindex="-1"
                                                    aria-labelledby="validationModalLabel-{{ $product->registration_code }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Validasi Dokumen</h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            {{-- <div class="modal-body text-center text-wrap text-sm">
                                                    Apakah dokumen <strong>{{ $product->document_name }}</strong> dengan
                                                    kode registrasi
                                                    <strong>{{ $product->registration_code }}</strong> <br>
                                                    dinyatakan <span class="text-success fw-bold">VALID?</span>
                                                </div> --}}
                                                            <div class="modal-body text-center text-wrap">
                                                                Apakah dokumen
                                                                <strong>{{ $product->document_name }}</strong> dengan
                                                                kode registrasi
                                                                <strong>{{ $product->registration_code }}</strong>
                                                                dinyatakan
                                                                <span class="text-success fw-bold">Valid</span>?
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-end">
                                                                <form method="POST"
                                                                    action="{{ route('warkah.updateStatus') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="registration_code"
                                                                        value="{{ $product->registration_code }}">
                                                                    <input type="hidden" name="notaris_id"
                                                                        value="{{ $product->notaris_id }}">
                                                                    <input type="hidden" name="client_id"
                                                                        value="{{ $product->client_id }}">
                                                                    <input type="hidden" name="status" value="valid">
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm mb-0">Submit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="invalidModal-{{ $product->registration_code }}"
                                                    tabindex="-1"
                                                    aria-labelledby="invalidModalLabel-{{ $product->registration_code }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Validasi Dokumen</h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body text-center text-wrap">
                                                                Apakah dokumen
                                                                <strong>{{ $product->document_name }}</strong> dengan
                                                                kode registrasi
                                                                <strong>{{ $product->registration_code }}</strong>
                                                                dinyatakan
                                                                <span class="text-danger fw-bold">TIDAK VALID</span>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST"
                                                                    action="{{ route('warkah.updateStatus') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="registration_code"
                                                                        value="{{ $product->registration_code }}">
                                                                    <input type="hidden" name="notaris_id"
                                                                        value="{{ $product->notaris_id }}">
                                                                    <input type="hidden" name="client_id"
                                                                        value="{{ $product->client_id }}">
                                                                    <input type="hidden" name="status" value="invalid">
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm mb-0">Submit</button>
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
                                        <td colspan="10" class="text-center text-muted text-sm">Data dokumen warkah
                                            tidak
                                            ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $documents->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
