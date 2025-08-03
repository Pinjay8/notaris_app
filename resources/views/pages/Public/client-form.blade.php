@extends('layouts.app')

@section('content')
<main class="main-content mt-0">
    <section class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0 text-white">Form Klien</h4>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ route('client.public.store', ['notaris_id' => request()->route('notaris_id')]) }}"
                                method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="fullname" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="fullname"
                                            class="form-control @error('fullname') is-invalid @enderror"
                                            value="{{ old('fullname') }}">
                                        @error('fullname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">NIK</label>
                                        <input type="text" name="nik" inputmode="numeric" pattern="\d*"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                            class="form-control @error('nik') is-invalid @enderror"
                                            value="{{ old('nik') }}">
                                        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="birth_place" class="form-label">Tempat Lahir</label>
                                        <input type="text" name="birth_place"
                                            class="form-control @error('birth_place') is-invalid @enderror"
                                            value="{{ old('birth_place') }}">
                                        @error('birth_place') <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                            <option value="" hidden>Pilih Jenis Kelamin</option>
                                            <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Status Pernikahan</label>
                                        <select name="marital_status"
                                            class="form-select @error('marital_status') is-invalid @enderror">
                                            <option value="" hidden>Pilih Status</option>
                                            <option value="Belum Menikah" {{ old('marital_status')=='Belum Menikah'
                                                ? 'selected' : '' }}>Belum Menikah</option>
                                            <option value="Menikah" {{ old('marital_status')=='Menikah' ? 'selected'
                                                : '' }}>Menikah</option>
                                            <option value="Cerai" {{ old('marital_status')=='Cerai' ? 'selected' : ''
                                                }}>Cerai</option>
                                        </select>
                                        @error('marital_status') <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Pekerjaan</label>
                                        <input type="text" name="job"
                                            class="form-control @error('job') is-invalid @enderror"
                                            value="{{ old('job') }}">
                                        @error('job') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Nama Perusahaan</label>
                                        <input type="text" name="company_name"
                                            class="form-control @error('company_name') is-invalid @enderror"
                                            value="{{ old('company_name') }}">
                                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="col-md-6">
                                        <label class="form-label">Kota</label>
                                        <input type="text" name="city"
                                            class="form-control @error('city') is-invalid @enderror"
                                            value="{{ old('city') }}">
                                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Provinsi</label>
                                        <input type="text" name="province"
                                            class="form-control @error('province') is-invalid @enderror"
                                            value="{{ old('province') }}">
                                        @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" name="postcode" inputmode="numeric" pattern="\d*"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                            class="form-control @error('postcode') is-invalid @enderror"
                                            value="{{ old('postcode') }}" required>
                                        @error('postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}">
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}">
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">NPWP</label>
                                        <input type="text" name="npwp"
                                            class="form-control @error('npwp') is-invalid @enderror"
                                            value="{{ old('npwp') }}">
                                        @error('npwp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tipe Klien</label>
                                        <select name="type" class="form-select @error('type') is-invalid @enderror">
                                            <option value="" hidden>Pilih Tipe</option>
                                            <option value="personal" {{ old('type')=='personal' ? 'selected' : '' }}>
                                                Personal</option>
                                            <option value="company" {{ old('type')=='company' ? 'selected' : '' }}>
                                                Perusahaan</option>
                                        </select>
                                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            rows="3">{{ old('address') }}</textarea>
                                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label">Catatan</label>
                                        <textarea name="note" class="form-control @error('note') is-invalid @enderror"
                                            rows="3">{{ old('note') }}</textarea>
                                        @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-success">Kirim</button>
                                </div>
                            </form>
                            {{--
                            @if(session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection