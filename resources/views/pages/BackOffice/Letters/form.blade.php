@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Surat Keluar'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ isset($data) ? 'Edit Surat Keluar' : 'Tambah Surat Keluar' }}</h6>
                </div>
                <hr>
                <div class="card-body px-4 pt-0 pb-2">
                    <form method="POST"
                        action="{{ isset($data) ? route('notary-letters.update', $data->id) : route('notary-letters.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($data))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label text-sm">Klien</label>
                            <select name="client_code"
                                class="form-select select2 @error('client_code') is-invalid @enderror">
                                <option value="" hidden>Pilih Klien</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->client_code }}"
                                        {{ old('client_code', $data->client_code ?? '') == $client->client_code ? 'selected' : '' }}>
                                        {{ $client->fullname ?? $client->name }} - {{ $client->client_code }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm">Nomor Surat</label>
                            <input type="text" name="letter_number"
                                class="form-control @error('letter_number') is-invalid @enderror"
                                value="{{ old('letter_number', $data->letter_number ?? '') }}">
                            @error('letter_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm">Jenis Surat</label>
                            <input type="text" name="type" class="form-control"
                                value="{{ old('type', $data->type ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm">Penerima</label>
                            <input type="text" name="recipient"
                                class="form-control @error('recipient') is-invalid @enderror"
                                value="{{ old('recipient', $data->recipient ?? '') }}">
                            @error('recipient')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm">Subjek</label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                                value="{{ old('subject', $data->subject ?? '') }}">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm">Tanggal Surat</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date', isset($data->date) ? \Carbon\Carbon::parse($data->date)->format('Y-m-d') : '') }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm">Ringkasan</label>
                            <textarea name="summary" class="form-control">{{ old('summary', $data->summary ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm">Lampiran</label>
                            <input type="text" name="attachment" class="form-control"
                                value="{{ old('attachment', $data->attachment ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm">Catatan</label>
                            <textarea name="notes" class="form-control">{{ old('notes', $data->notes ?? '') }}</textarea>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label text-sm">File Surat Keluar</label>
                            <input type="file" name="file_path" class="form-control">

                            @if (isset($data) && $data->file_path)
                                @php
                                    $ext = pathinfo($data->file_path, PATHINFO_EXTENSION);
                                @endphp
                                @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $data->file_path) }}" alt="Preview"
                                            class="img-fluid" style="max-height: 200px;">
                                    </div>
                                @else
                                    <small class="text-muted">
                                        File saat ini:
                                        <a href="{{ asset('storage/' . $data->file_path) }}" target="_blank">Lihat /
                                            Download</a>
                                    </small>
                                @endif
                            @endif
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label text-sm">File Surat Keluar</label>
                            <input type="file" name="file_path" class="form-control" id="fileInput">

                            @if (isset($data) && $data->file_path)
                                <button type="button" class="btn btn-primary btn-sm mb-0 mt-2" data-bs-toggle="modal"
                                    data-bs-target="#previewModal">
                                    Lihat File
                                </button>
                            @endif
                        </div>

                        @if (isset($data) && $data->file_path)
                            @php
                                $ext = strtolower(pathinfo($data->file_path, PATHINFO_EXTENSION));
                            @endphp

                            <!-- Modal -->
                            <div class="modal fade" id="previewModal" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">File Surat Keluar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body text-center">

                                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <img src="{{ asset('storage/' . $data->file_path) }}" class="img-fluid"
                                                    style="max-height: 250;">
                                            @else
                                                <a href="{{ asset('storage/' . $data->file_path) }}" target="_blank"
                                                    class="btn btn-primary">
                                                    Download / Lihat File
                                                </a>
                                            @endif

                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('notary-letters.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Ubah' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
