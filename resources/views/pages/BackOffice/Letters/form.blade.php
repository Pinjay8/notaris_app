@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($data) ? 'Edit Surat Keluar' : 'Tambah Surat Keluar'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($data) ? 'Edit Surat Keluar' : 'Tambah Surat Keluar' }}</h6>
            </div>
            <div class="card-body px-4 pt-4 pb-2">
                <form method="POST"
                    action="{{ isset($data) ? route('notary-letters.update', $data->id) : route('notary-letters.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if(isset($data))
                    @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Klien</label>
                        <select name="client_id" class="form-select">
                            <option value="" hidden>Pilih Klien</option>
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $data->client_id ?? '') == $client->id
                                ? 'selected' : '' }}>
                                {{ $client->fullname ?? $client->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" name="letter_number" class="form-control"
                            value="{{ old('letter_number', $data->letter_number ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Surat</label>
                        <input type="text" name="type" class="form-control"
                            value="{{ old('type', $data->type ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penerima</label>
                        <input type="text" name="recipient" class="form-control"
                            value="{{ old('recipient', $data->recipient ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subjek</label>
                        <input type="text" name="subject" class="form-control"
                            value="{{ old('subject', $data->subject ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Surat</label>
                        <input type="date" name="date" class="form-control"
                            value="{{ old('date', isset($data->date) ? \Carbon\Carbon::parse($data->date)->format('Y-m-d') : '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="summary"
                            class="form-control">{{ old('summary', $data->summary ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lampiran</label>
                        <input type="text" name="attachment" class="form-control"
                            value="{{ old('attachment', $data->attachment ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control">{{ old('notes', $data->notes ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload File</label>
                        <input type="file" name="file_path" class="form-control">

                        @if(isset($data) && $data->file_path)
                        @php
                        $ext = pathinfo($data->file_path, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp']))
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$data->file_path) }}" alt="Preview" class="img-fluid"
                                style="max-height: 200px;">
                        </div>
                        @else
                        <small class="text-muted">
                            File saat ini:
                            <a href="{{ asset('storage/'.$data->file_path) }}" target="_blank">Lihat / Download</a>
                        </small>
                        @endif
                        @endif
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Ubah' : 'Simpan' }}</button>
                        <a href="{{ route('notary-letters.index') }}" class="btn btn-secondary">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection