@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dokumen Layanan'])

<div class="container mt-4">
    <div class="row mt-4 mx-4">
        <div class="card mb-4">
            <div class="card-header px-1 pb-0 d-flex justify-content-between align-items-center mb-1">
                <h5 class="mb-0 text-capitalize">Layanan {{ $product->name }}</h5>
            </div>
            {{-- <div class="row mt-3">
                <div class="mx-2 mb-3">
                    <h5>Pilih Layanan</h5>
                </div>
            </div> --}}
            <form action="{{ route('products.documents.store', $product->id) }}" method="POST"
                class="row g-2 mb-4 mt-2">
                @csrf
                <div class="col-md-12">
                    <label for="" class="form-label text-sm">Dokumen</label>
                    <select name="document_code" class="form-select">
                        <option value="" hidden>Pilih Dokumen</option>
                        @foreach ($availableDocuments as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }} - {{ $doc->code }}</option>
                        @endforeach
                    </select>
                    @error('document_code')
                    <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label text-sm">Catatan</label>
                    <input type="text" name="description" class="form-control"
                        placeholder="Catatan (misal: Fotokopi 3 lembar)">
                    @error('description')
                    <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label text-sm">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="" hidden>Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                    @error('status')
                    <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary mt-1">Tambah Dokumen</button>
                </div>
            </form>

            <!-- Tabel dokumen -->
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Dokumen</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <h5>List Dokumen</h5>
                    @forelse ($documents as $doc)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $doc->name }}</td>
                        <td class="text-center">{{ $doc->pivot->description ?? '-' }}</td>
                        {{-- <td class="text-center">{{ $doc->pivot->status ?? '-' }}</td> --}}
                        {{-- give bg status --}}
                        <td class="text-center">
                            @if ($doc->pivot->status == 1)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center d-flex align-items-center justify-content-center gap-2">
                            <button type="button" class="btn btn-warning d-flex align-items-center gap-2 text-sm"
                                data-bs-toggle="modal" data-bs-target="#editModal{{ $doc->id }}">
                                <i class="fas fa-edit fa-md"></i> Edit
                            </button>
                            <form action="{{ route('products.documents.destroy', [$product->id, $doc->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger  d-flex align-items-center gap-2 text-sm" type="submit"><i
                                        class="fa fa-trash fa-md" aria-hidden="true"></i>Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">Belum ada dokumen</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Modal Edit Dokumen -->
            @foreach ($documents as $doc)
            <div class="modal fade" id="editModal{{ $doc->id }}" tabindex="-1"
                aria-labelledby="editModalLabel{{ $doc->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('products.documents.update', [$product->id, $doc->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $doc->id }}">Edit Dokumen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Catatan</label>
                                    <input type="text" name="description" class="form-control"
                                        value="{{ old('description', $doc->pivot->description) }}">
                                    @error('description')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="1" {{ $doc->pivot->status == 1 ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="0" {{ $doc->pivot->status == 0 ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                    @error('status')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('js')
@if(session('document_id'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        var modal = new bootstrap.Modal(document.getElementById('editModal{{ session('edit_modal_id') }}'));
        modal.show();
    });
</script>
@endif
@endpush