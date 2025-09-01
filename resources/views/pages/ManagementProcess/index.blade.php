@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Proses Pengurusan'])

<div class="row mt-4 mx-4">
    <div class="col md-12">

        {{-- Table List --}}
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-2 px-2 flex-wrap">
                <h5>List Notaris Produk</h5>
                <form method="GET" action="{{ route('management-process.index') }}" class=" row g-3">
                    <div class="col-md-4">
                        <input type="text" name="registration_code" value="{{ request('registration_code') }}"
                            class="form-control" placeholder="Registration Code">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="client_name" value="{{ request('client_name') }}" class="form-control"
                            placeholder="Client Name">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Pilih Status</option>
                            <option value="new" @if(request('status')=='new' ) selected @endif>New</option>
                            <option value="done" @if(request('status')=='done' ) selected @endif>Done</option>
                            <option value="progress" @if(request('status')=='progress' ) selected @endif>
                                Progress
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-hover mb-0 table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Registration Code</th>
                                <th>Client Name</th>
                                <th>Product</th>
                                <th>Last Progress</th>
                                <th>Last Progress Date</th>
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
                                    @if($product->last_progress)
                                    {{ $product->last_progress->progress }}
                                    @else
                                    Awal Permohonan
                                    @endif
                                </td>
                                <td>
                                    @if($product->last_progress)
                                    {{ \Carbon\Carbon::parse($product->last_progress->progress_date)->format('d M Y') }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $product->status == 'done' ? 'success' : 'warning' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="d-flex flex-wrap mb-0 align-items-center gap-1">
                                    <button type="button" class="btn btn-info btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#progressDetailModal-{{ $product->registration_code }}">
                                        <i class="fa fa-info"></i>
                                    </button>
                                    {{-- Modal Detail Progress --}}
                                    <div class="modal fade" id="progressDetailModal-{{ $product->registration_code }}"
                                        tabindex="-1"
                                        aria-labelledby="progressDetailLabel-{{ $product->registration_code }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content shadow-lg border-0 rounded-3">
                                                <!-- Header -->
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title fw-bold text-white"
                                                        id="progressDetailLabel-{{ $product->registration_code }}">
                                                        <i class="bi bi-clock-history me-2"></i> Histori Progress - {{
                                                        $product->registration_code }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"
                                                        style="color: white"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    @php
                                                    $progressList = $product->progressHistory ?? collect();
                                                    @endphp

                                                    @if($progressList->isEmpty())
                                                    <div class="text-center text-muted py-4 ">
                                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                        <span>Belum ada riwayat progress.</span>
                                                    </div>
                                                    @else
                                                    <div class="timeline">
                                                        <div class="container">
                                                            <div class="row">
                                                                @foreach($progressList->sortByDesc('progress_date')->values()
                                                                as $index => $item)
                                                                <div
                                                                    class="col-md-6 {{ $index % 2 == 1 ? 'offset-md-6' : '' }} mb-4">
                                                                    <div class="d-flex align-items-start">
                                                                        <!-- Bullet -->
                                                                        <div class="flex-shrink-0">
                                                                            <span
                                                                                class="badge bg-primary rounded-circle p-2 me-3">
                                                                                <i class="bi bi-check2 text-white"></i>
                                                                            </span>
                                                                        </div>
                                                                        <!-- Content -->
                                                                        <div>
                                                                            <h6 class="mb-1 fw-bold">{{ $item->progress
                                                                                }}</h6>
                                                                            <small class="text-muted d-block mb-1">
                                                                                {{
                                                                                \Carbon\Carbon::parse($item->progress_date)->format('d
                                                                                M Y') }}
                                                                            </small>
                                                                            <p class="mb-0 text-secondary">{{
                                                                                $item->note }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Tombol Tambah Progress --}}
                                    <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#addProgressModal-{{ $product->registration_code }}">
                                        <i class="fa fa-plus"></i>
                                    </button>

                                    {{-- Modal Tambah Progress --}}
                                    <div class="modal fade" id="addProgressModal-{{ $product->registration_code }}"
                                        tabindex="-1"
                                        aria-labelledby="addProgressLabel-{{ $product->registration_code }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lgmodal-dialog-centered">
                                            <form method="POST" action="{{ route('management-process.addProgress') }}">
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
                                                        <h5 class="modal-title"
                                                            id="addProgressLabel-{{ $product->registration_code }}">
                                                            Tambah Progress Baru - {{ $product->registration_code }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label text-start d-block">Progress</label>
                                                            <input type="text" class="form-control" name="progress"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-start d-block">Tanggal
                                                                Progress</label>
                                                            <input type="date" class="form-control" name="progress_date"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-start d-block">Catatan</label>
                                                            <textarea class="form-control" name="note"
                                                                rows="3"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-start d-block">Status</label>
                                                            <input type="text" class="form-control" name="status">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    @if($product->status !== 'done')
                                    <button type="button" class="btn btn-success btn-xs" data-bs-toggle="modal"
                                        data-bs-target="#markDoneModal-{{ $product->registration_code }}">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <div class="modal fade" id="markDoneModal-{{ $product->registration_code }}"
                                        tabindex="-1" aria-labelledby="markDoneLabel-{{ $product->registration_code }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form method="POST" action="{{ route('management-process.markDone') }}">
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
                                                        <h5 class="modal-title"
                                                            id="markDoneLabel-{{ $product->registration_code }}">
                                                            Konfirmasi Selesai
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-wrap">
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
                                <td colspan="7" class="text-center text-muted text-sm">Data produk notaris tidak
                                    ditemukan.</td>
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