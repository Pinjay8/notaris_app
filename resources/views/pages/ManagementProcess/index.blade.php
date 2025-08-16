@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Notary Client Product'])

<div class="container mt-4">
    {{-- Filter dan pencarian --}}
    <form method="GET" action="{{ route('management-process.index') }}" class="mb-4 row g-3">
        <div class="col-md-3">
            <input type="text" name="registration_code" value="{{ request('registration_code') }}" class="form-control"
                placeholder="Registration Code">
        </div>
        <div class="col-md-3">
            <input type="text" name="client_name" value="{{ request('client_name') }}" class="form-control"
                placeholder="Client Name">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Status --</option>
                <option value="pending" @if(request('status')=='pending' ) selected @endif>Pending</option>
                <option value="done" @if(request('status')=='done' ) selected @endif>Done</option>
                <option value="in_progress" @if(request('status')=='in_progress' ) selected @endif>In Progress</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- Table List --}}
    <div class="card">
        <div class="card-header">
            <h5>List Notary Client Products</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
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
                    <tr>
                        <td class="text-center">{{ $product->registration_code }}</td>
                        <td class="text-center">{{ $product->client->fullname ?? '-' }}</td>
                        <td class="text-center">{{ $product->product->name ?? '-' }}</td>
                        <td class="text-center">
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
                            <button type="button" class="btn btn-info btn-xs"
                                onclick="showProgressDetail('{{ $product->registration_code }}', '{{ $product->notaris_id }}', '{{ $product->client_id }}', '{{ $product->product_id }}')">
                                {{-- icon fa detail --}}
                                <i class="fa fa-info"></i>
                            </button>

                            <button type="button" class="btn btn-primary btn-xs"
                                onclick="showAddProgressModal('{{ $product->registration_code }}', '{{ $product->notaris_id }}', '{{ $product->client_id }}', '{{ $product->product_id }}')">
                                {{-- icon fa plus--}}
                                <i class="fa fa-plus"></i>
                            </button>

                            @if($product->status !== 'done')
                            <form method="POST" action="{{ route('management-process.markDone') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="registration_code" value="{{ $product->registration_code }}">
                                <input type="hidden" name="notaris_id" value="{{ $product->notaris_id }}">
                                <input type="hidden" name="client_id" value="{{ $product->client_id }}">
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <button type="submit" class="btn btn-success btn-xs"
                                    onclick="return confirm('Ubah status jadi DONE?')">
                                    {{-- icon fa check--}}
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>
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

{{-- Modal Detail Progress --}}
<div class="modal fade" id="progressDetailModal" tabindex="-1" aria-labelledby="progressDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="progressDetailLabel">Histori Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="progressDetailBody">
                {{-- Isi histori progress akan dimuat di sini via reload halaman --}}
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Progress --}}
<div class="modal fade" id="addProgressModal" tabindex="-1" aria-labelledby="addProgressLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('management-process.addProgress') }}">
            @csrf
            <input type="hidden" name="registration_code" id="add_progress_registration_code">
            <input type="hidden" name="notaris_id" id="add_progress_notaris_id">
            <input type="hidden" name="client_id" id="add_progress_client_id">
            <input type="hidden" name="product_id" id="add_progress_product_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProgressLabel">Tambah Progress Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="progress" class="form-label">Progress</label>
                        <input type="text" class="form-control" name="progress" id="progress" required>
                    </div>
                    <div class="mb-3">
                        <label for="progress_date" class="form-label">Tanggal Progress</label>
                        <input type="date" class="form-control" name="progress_date" id="progress_date">
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status (opsional)</label>
                        <select class="form-select" name="status" id="status">
                            <option value="">-- Pilih Status --</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Progress</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function showProgressDetail(registration_code, notaris_id, client_id, product_id) {
        // Redirect ke halaman detail (atau bisa menggunakan modal ajax jika mau)
        // Contoh redirect:
        const url = "{{ url('notary-client-product/detail') }}/" + registration_code + `?notaris_id=${notaris_id}&client_id=${client_id}&product_id=${product_id}`;
        window.location.href = url;
    }

    function showAddProgressModal(registration_code, notaris_id, client_id, product_id) {
        document.getElementById('add_progress_registration_code').value = registration_code;
        document.getElementById('add_progress_notaris_id').value = notaris_id;
        document.getElementById('add_progress_client_id').value = client_id;
        document.getElementById('add_progress_product_id').value = product_id;
        var addModal = new bootstrap.Modal(document.getElementById('addProgressModal'));
        addModal.show();
    }
</script>
@endsection