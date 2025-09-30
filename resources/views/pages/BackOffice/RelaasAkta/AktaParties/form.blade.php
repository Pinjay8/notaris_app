@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($party) ? 'Edit Pihak Akta' : 'Tambah Pihak Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($party) ? 'Edit Pihak Akta' : 'Tambah Pihak Akta' }}</h6>
            </div>
            <hr>
            <div class="card-body px-4 pt-3 pb-2">
                <form action="{{ isset($party)
                        ? route('relaas-parties.update', [$relaas->id, $party->id])
                        : route('relaas-parties.store', $relaas->id) }}" method="POST">
                    @csrf
                    @if(isset($party)) @method('PUT') @endif

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label text-sm">Nama Pihak</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $party->name ?? '') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label for="role" class="form-label text-sm">Peran</label>
                        <input type="text" name="role" id="role"
                            class="form-control @error('role') is-invalid @enderror"
                            value="{{ old('role', $party->role ?? '') }}">
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-3">
                        <label for="address" class="form-label text-sm">Alamat</label>
                        <textarea name="address" id="address"
                            class="form-control @error('address') is-invalid @enderror"
                            rows="2">{{ old('address', $party->address ?? '') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nomor Identitas --}}
                    <div class="mb-3">
                        <label for="id_number" class="form-label text-sm">Nomor Identitas</label>
                        <input type="text" name="id_number" id="id_number"
                            class="form-control @error('id_number') is-invalid @enderror"
                            value="{{ old('id_number', $party->id_number ?? '') }}">
                        @error('id_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis Identitas --}}
                    <div class="mb-3">
                        <label for="id_type" class="form-label text-sm">Jenis Identitas</label>
                        <input type="text" name="id_type" id="id_type"
                            class="form-control @error('id_type') is-invalid @enderror"
                            value="{{ old('id_type', $party->id_type ?? '') }}">
                        @error('id_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    {{-- <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                            rows="2">{{ old('note', $party->note ?? '') }}</textarea>
                        @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}


                    <a href="{{ route('relaas-parties.index', ['search' => $relaas->registration_code]) }}"
                        class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($party) ? 'Update' : 'Simpan' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection