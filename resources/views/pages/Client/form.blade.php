@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => isset($client) ? 'Edit Klien' : 'Tambah Klien'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ isset($client) ? 'Edit' : 'Tambah' }} Klien</h6>
            </div>
            <hr>
            <div class="card-body px-4 pt-3 pb-2">
                <form action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($client))
                    @method('PUT')
                    @endif

                    <div class="row">
                        <input type="hidden" name="notaris_id" value="{{ auth()->user()->notaris_id }}">
                        <div class="col-md-6 mb-3">
                            <label for="fullname" class="form-label text-sm">Nama Lengkap</label>
                            <input type="text" name="fullname" class="form-control"
                                value="{{ old('fullname', $client->fullname ?? '') }}">
                            @error('fullname')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label text-sm">NIK</label>
                            <input type="text" name="nik" class="form-control"
                                value="{{ old('nik', $client->nik ?? '') }}">
                            @error('nik')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="birth_place" class="form-label text-sm">Tempat Lahir</label>
                            <input type="text" name="birth_place" class="form-control"
                                value="{{ old('birth_place', $client->birth_place ?? '') }}">
                            @error('birth_place')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label text-sm">Jenis Kelamin</label>
                            <select name="gender" class="form-select">
                                <option value="" hidden>Pilih</option>
                                <option value="Laki-Laki" {{ old('gender', $client->gender ?? '') == 'Laki-Laki' ?
                                    'selected' : ''
                                    }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender', $client->gender ?? '') == 'Perempuan' ?
                                    'selected'
                                    : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="marital_status" class="form-label text-sm">Status Perkawinan</label>
                            <select name="marital_status" class="form-select">
                                <option value="" hidden>Pilih Status</option>
                                <option value="Belum Menikah" {{ old('marital_status', $client->marital_status ?? '') ==
                                    'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Menikah" {{ old('marital_status', $client->marital_status ?? '') ==
                                    'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Cerai" {{ old('marital_status', $client->marital_status ?? '') ==
                                    'Cerai' ? 'selected' : '' }}>Cerai</option>
                                <option value="widow" {{ old('marital_status', $client->marital_status ?? '') == 'widow'
                                    ? 'selected' : '' }}>Janda/Duda</option>
                            </select>
                            @error('marital_status')
                            <div class="text-danger text-sm mt-1">{{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="job" class="form-label text-sm">Pekerjaan</label>
                            <input type="text" name="job" class="form-control"
                                value="{{ old('job', $client->job ?? '') }}">
                            @error('job')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label text-sm">Alamat</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $client->address ?? '') }}">
                            @error('address')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label text-sm">Kota</label>
                            <input type="text" name="city" class="form-control"
                                value="{{ old('city', $client->city ?? '') }}">
                            @error('city')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="province" class="form-label text-sm">Provinsi</label>
                            <input type="text" name="province" class="form-control"
                                value="{{ old('province', $client->province ?? '') }}">
                            @error('province')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="postcode" class="form-label text-sm">Kode Pos</label>
                            <input type="text" name="postcode" class="form-control"
                                value="{{ old('postcode', $client->postcode ?? '') }}">
                            @error('postcode')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label text-sm">Telepon</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $client->phone ?? '') }}">
                            @error('phone')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label text-sm">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $client->email ?? '') }}">
                            @error('email')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="npwp" class="form-label text-sm">NPWP</label>
                            <input type="text" name="npwp" class="form-control"
                                value="{{ old('npwp', $client->npwp ?? '') }}">
                            @error('npwp')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label text-sm">Tipe Klien</label>
                            <select name="type" class="form-select">
                                <option value="" hidden>Pilih</option>
                                <option value="personal" {{ old('type', $client->type ?? '') == 'personal' ? 'selected'
                                    : '' }}>Personal</option>
                                <option value="company" {{ old('type', $client->type ?? '') == 'company' ? 'selected' :
                                    '' }}>Perusahaan</option>
                            </select>
                            @error('type')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="company_name" class="form-label text-sm">Nama Perusahaan</label>
                            <input type="text" name="company_name" class="form-control"
                                value="{{ old('company_name', $client->company_name ?? '') }}">
                            @error('company_name')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label text-sm">Status</label>
                            <select name="status" class="form-select">
                                <option value="" hidden>Pilih Status</option>
                                <option value="pending" {{ old('status', $client->status ?? '') == 'pending' ?
                                    'selected' : '' }}>Pending</option>
                                <option value="valid" {{ old('status', $client->status ?? '') == 'valid' ? 'selected' :
                                    '' }}>Valid</option>
                                <option value="revisi" {{ old('status', $client->status ?? '') == 'revisi' ? 'selected'
                                    : '' }}>Revisi</option>
                            </select>
                            @error('status')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="note" class="form-label text-sm">Catatan</label>
                            <textarea name="note" class="form-control"
                                rows="3">{{ old('note', $client->note ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">{{ isset($client) ? 'Update' : 'Simpan'
                            }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection