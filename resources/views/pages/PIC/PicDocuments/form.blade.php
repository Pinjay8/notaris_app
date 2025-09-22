@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($picDocument) ? 'Edit PIC Dokumen' : 'Tambah PIC Dokumen'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($picDocument) ? 'Edit' : 'Tambah' }} PIC Dokumen</h6>
            </div>
            <div class="card-body px-4 pt-3 pb-2">
                <form
                    action="{{ isset($picDocument) ? route('pic_documents.update', $picDocument) : route('pic_documents.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($picDocument))
                    @method('PUT')
                    @endif

                    {{-- <div class="mb-3">
                        <label for="notaris_id" class="form-label text-sm">Notaris</label>
                        <select name="notaris_id" id="notaris_id" class="form-select">
                            <option value="">Pilih Notaris</option>
                            @foreach($notarisList as $notaris)
                            <option value="{{ $notaris->id }}" {{ old('notaris_id', $picDocument->notaris_id ?? '') ==
                                $notaris->id ? 'selected' : '' }}>
                                {{ $notaris->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('notaris_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label for="pic_id" class="form-label text-sm">PIC Staff</label>
                        <select name="pic_id" id="pic_id" class="form-select">
                            <option value="" hidden>Pilih PIC Staff</option>
                            @foreach($picStaffList as $pic)
                            <option value="{{ $pic->id }}" {{ old('pic_id', $picDocument->pic_id ?? '') == $pic->id ?
                                'selected' : '' }}>
                                {{ $pic->full_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('pic_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="client_id" class="form-label text-sm">Klien</label>
                        <select name="client_id" id="client_id" class="form-select">
                            <option value="" hidden>Pilih Klien</option>
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $picDocument->client_id ?? '') ==
                                $client->id ? 'selected' : '' }}>
                                {{ $client->fullname }}
                            </option>
                            @endforeach
                        </select>
                        @error('client_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label for="registration_code" class="form-label text-sm">Kode Registrasi</label>
                        <input type="text" name="registration_code" id="registration_code" class="form-control"
                            value="{{ old('registration_code', $picDocument->registration_code ?? '') }}">
                        @error('registration_code')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label for="document_type" class="form-label text-sm">Tipe Dokumen</label>
                        <input type="text" name="document_type" id="document_type" class="form-control"
                            value="{{ old('document_type', $picDocument->document_type ?? '') }}">
                        @error('document_type')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="document_number" class="form-label text-sm">Nomor Dokumen</label>
                        <input type="text" name="document_number" id="document_number" class="form-control"
                            value="{{ old('document_number', $picDocument->document_number ?? '') }}">
                        @error('document_number')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="received_date" class="form-label text-sm">Tanggal Terima</label>
                        <input type="datetime-local" name="received_date" id="received_date" class="form-control"
                            value="{{ old('received_date', isset($picDocument->received_date) ? \Carbon\Carbon::parse($picDocument->received_date)->format('Y-m-d\TH:i') : '') }}">
                        @error('received_date')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label text-sm">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Pilih Status</option>
                            <option value="delivered" {{ old('status', $picDocument->status ?? '') == 'delivered' ?
                                'selected' : '' }}>
                                Dikirim
                            </option>
                            <option value="process" {{ old('status', $picDocument->status ?? '') == 'process' ?
                                'selected' : '' }}>Proses</option>
                            <option value="received" {{ old('status', $picDocument->status ?? '') == 'diterima' ?
                                'selected' : '' }}>Diterima</option>
                            <option value="completed" {{ old('status', $picDocument->status ?? '') == 'selesai' ?
                                'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label text-sm">Catatan</label>
                        <textarea name="note" id="note" class="form-control"
                            rows="3">{{ old('note', $picDocument->note ?? '') }}</textarea>
                        @error('note')
                        <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('pic_documents.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($picDocument) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection