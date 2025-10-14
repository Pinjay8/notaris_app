@extends('layouts.app')

@section('title', 'PIC Staff')


@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'PIC Staff'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($pic_staff) ? 'Edit' : 'Tambah' }} PIC Staff</h6>
            </div>
            <hr>
            <div class="card-body px-4 pt-0 pb-2">
                <form
                    action="{{ isset($pic_staff) ? route('pic_staff.update', $pic_staff) : route('pic_staff.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($pic_staff))
                    @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="full_name" class="form-label text-sm">Nama Lengkap</label>
                        <input type="text" name="full_name" id="full_name" class="form-control"
                            value="{{ old('full_name', $pic_staff->full_name ?? '') }}">
                        @error('full_name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-sm">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $pic_staff->email ?? '') }}">
                        @error('email')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label text-sm">No. HP</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                            value="{{ old('phone_number', $pic_staff->phone_number ?? '') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        @error('phone_number')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label text-sm">Jabatan</label>
                        <input type="text" name="position" id="position" class="form-control"
                            value="{{ old('position', $pic_staff->position ?? '') }}">
                        @error('position')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label text-sm">Alamat</label>
                        <textarea name="address" id="address" rows="2"
                            class="form-control">{{ old('address', $pic_staff->address ?? '') }}</textarea>
                        @error('address')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label text-sm">Catatan</label>
                        <textarea name="note" id="note" rows="2"
                            class="form-control">{{ old('note', $pic_staff->note ?? '') }}</textarea>

                    </div>

                    <div class="mt-4">
                        <a href="{{ route('pic_staff.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">{{ isset($pic_staff) ? 'Update' : 'Simpan'
                            }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection