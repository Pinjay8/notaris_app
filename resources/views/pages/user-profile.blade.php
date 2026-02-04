@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Profile')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-1">
            <div class="row gx-4 p-2 px-4">
                <div class=" d-flex gap-3 align-items-center justify-content-between flex-column flex-md-row w-100">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:130px; height:130px;">
                            <img src="{{ $notaris && $notaris->image
                                ? (filter_var($notaris->image, FILTER_VALIDATE_URL)
                                    ? $notaris->image
                                    : asset('storage/' . $notaris->image))
                                : asset('img/img_profile.png') }}"
                                alt="profile_image"
                                style="width:100%;
                                height:100%;
                                object-fit:cover;
                                object-position: center;
                                border-radius:50%;
                                background:#fff;
                                ">
                        </div>

                        <div>
                            <h4 class="mb-1 mt-2 text-capitalize">
                                {{ $notaris->display_name ?? '-' }}
                            </h4>
                            <h5 class="mb-0 font-semibold  text-capitalize">
                                {{ $notaris->office_name ?? '-' }}
                            </h5>
                        </div>
                    </div>
                    @if (isset($notaris) && $notaris->id)
                        @php
                            $encryptedId = \Illuminate\Support\Facades\Crypt::encryptString($notaris->id);
                            $link = url('/notaris/verify/' . $encryptedId);

                            $dns2d = new \Milon\Barcode\DNS2D();
                            $png = $dns2d->getBarcodePNG($link, 'QRCODE', 6, 6, [0, 0, 0], true);
                        @endphp



                        <div class="mt-1 text-center">
                            <img src="data:image/png;base64,{{ $png }}" alt="QR Code"
                                style="
                                width:150px;
                                background:#fff;
                                padding:14px;
                                border-radius:14px;
                                box-shadow: 0 10px 25px rgba(251,98,64,0.35);
                            ">

                            <div class="mt-3">
                                <a href="data:image/png;base64,{{ $png }}"
                                    download="qr-profile-{{ $notaris->display_name }}.png"
                                    class="btn btn-outline-primary btn-sm mb-0">
                                    <i class="bi bi-download fs-6 "></i>
                                    Download QR
                                </a>
                            </div>
                        </div>
                    @else
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <form method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header pb-0 rounded-top">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Edit Profile</h5>
                                <button type="submit" class="btn btn-primary btn-md ms-auto">Simpan Perubahan</button>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <h6 class="text-capitalize mb-3 d-inline-block bg-primary text-white px-3 py-2"
                                style="border-radius:20px;">
                                Informasi Pribadi
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Nama
                                            Depan</label>
                                        <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                            name="first_name" value="{{ old('first_name', $notaris->first_name ?? '') }}">
                                        @error('first_name')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Nama
                                            Belakang</label>
                                        <input class="form-control @error('last_name') is-invalid @enderror" type="text"
                                            name="last_name" value="{{ old('last_name', $notaris->last_name ?? '') }}">
                                        @error('last_name')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Nama
                                            Tampilan</label>
                                        <input class="form-control @error('display_name') is-invalid @enderror"
                                            type="text" name="display_name"
                                            value="{{ old('display_name', $notaris->display_name ?? '') }}">
                                        @error('display_name')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Nama
                                            Perusahaan</label>
                                        <input class="form-control @error('office_name') is-invalid @enderror"
                                            type="text" name="office_name"
                                            value="{{ old('office_name', $notaris->office_name ?? '') }}">
                                        @error('office_name')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Alamat
                                            Perusahaan / Kantor</label>
                                        <input class="form-control @error('office_address') is-invalid @enderror"
                                            type="text" name="office_address"
                                            value="{{ old('office_address', $notaris->office_address ?? '') }}">
                                        @error('office_address')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Foto</label>
                                        <input class="form-control @error('image') is-invalid @enderror" type="file"
                                            name="image">
                                        <small>Maksimal ukuran foto 2MB (Format: JPG,JPEG, PNG)</small>
                                        @error('image')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-sm">Tanggal Pendaftaran</label>
                                        <input class="form-control" type="text" name="signup_at"
                                            value="{{ $user->signup_at ? \Carbon\Carbon::parse($user->signup_at)->format('d F Y H:i:s') : '' }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-sm">Waktu Aktif</label>
                                        <input class="form-control" type="text" name="active_at"
                                            value="{{ $user->active_at ? \Carbon\Carbon::parse($user->active_at)->format('d F Y H:i:s') : '' }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-capitalize mb-3 d-inline-block bg-primary text-white px-3 py-2"
                                style="border-radius:20px;">
                                Informasi Kontak
                            </h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Alamat</label>
                                        <input class="form-control @error('address') is-invalid @enderror" type="text"
                                            name="address" value="{{ old('address', $notaris->address ?? '') }}">
                                        @error('address')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="provinsi_name" id="provinsi_name"
                                    value="{{ old('provinsi_name', $notaris->provinsi_name ?? '') }}">

                                <input type="hidden" name="kota_name" id="kota_name"
                                    value="{{ old('kota_name', $notaris->kota_name ?? '') }}">

                                <input type="hidden" name="kecamatan_name" id="kecamatan_name"
                                    value="{{ old('kecamatan_name', $notaris->kecamatan_name ?? '') }}">

                                <input type="hidden" name="kelurahan_name" id="kelurahan_name"
                                    value="{{ old('kelurahan_name', $notaris->kelurahan_name ?? '') }}">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label text-sm">Provinsi</label>
                                        <select id="provinsi" name="provinsi_id" class="form-select">
                                            <option value="">Pilih Provinsi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label text-sm">Kota / Kabupaten</label>
                                        <select id="kota" name="kota_id" class="form-select">
                                            <option value="">Pilih Kota</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label text-sm">Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan_id" class="form-select">
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label text-sm">Kelurahan / Desa</label>
                                        <select id="kelurahan" name="kelurahan_id" class="form-select">
                                            <option value="">Pilih Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">SMS/WA
                                        </label>
                                        <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                            name="phone" value="{{ old('phone', $notaris->phone ?? '') }}">
                                        @error('phone')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">No.
                                            Telp</label>
                                        <input class="form-control @error('no_telp') is-invalid @enderror" type="text"
                                            name="no_telp" value="{{ old('no_telp', $notaris->no_telp ?? '') }}">
                                        @error('no_telp')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                            name="email" value="{{ old('email', $notaris->email ?? '') }}">
                                        @error('email')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Jenis
                                            Kelamin</label>
                                        {{-- select option --}}
                                        <select name="gender" id=""
                                            class="form-select @error('gender') is-invalid @enderror">
                                            <option value="Laki-laki"
                                                {{ old('gender', $notaris->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}
                                                class="form-control">Laki-laki</option>
                                            <option value="Perempuan"
                                                {{ old('gender', $notaris->gender ?? '') == 'Perempuan' ? 'selected' : '' }}
                                                class="form-control">Perempuan</option>
                                            @error('gender')
                                                <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                            @enderror
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Latar
                                            Belakang</label>
                                        <input class="form-control @error('background') is-invalid @enderror"
                                            type="text" name="background"
                                            value="{{ old('background', $notaris->background ?? '') }}">
                                        @error('background')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">SK PPAT</label>
                                        <input class="form-control @error('sk_ppat') is-invalid @enderror" type="text"
                                            name="sk_ppat" value="{{ old('sk_ppaat', $notaris->sk_ppat ?? '') }}">
                                        @error('sk_ppat')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Tanggal SK
                                            PPAT</label>
                                        <input class="form-control @error('sk_ppat_date') is-invalid @enderror"
                                            type="date" name="sk_ppat_date"
                                            value="{{ old('sk_ppat_date', $notaris->sk_ppat_date ?? '') }}">
                                        @error('sk_ppat_date')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">SK
                                            Notaris</label>
                                        <input class="form-control @error('sk_notaris') is-invalid @enderror"
                                            type="text" name="sk_notaris"
                                            value="{{ old('sk_notaris', $notaris->sk_notaris ?? '') }}">
                                        @error('sk_notaris')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">Tanggal SK
                                            Notaris</label>
                                        <input class="form-control @error('sk_notaris_date') is-invalid @enderror"
                                            type="date" name="sk_notaris_date"
                                            value="{{ old('sk_notaris_date', $notaris->sk_notaris_date ?? '') }}">
                                        @error('sk_notaris_date')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">
                                            No KTA INI</label>
                                        <input class="form-control @error('no_kta_ini') is-invalid @enderror"
                                            type="text" name="no_kta_ini"
                                            value="{{ old('no_kta_ini', $notaris->no_kta_ini ?? '') }}">
                                        @error('no_kta_ini')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-sm">
                                            No KTA IPPAT</label>
                                        <input class="form-control @error('no_kta_ippat') is-invalid @enderror"
                                            type="text" name="no_kta_ippat"
                                            value="{{ old('no_kta_ippat', $notaris->no_kta_ippat ?? '') }}">
                                        @error('no_kta_ippat')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input"
                                            class="form-control-label text-sm">Informasi</label>
                                        <input class="form-control @error('information') is-invalid @enderror"
                                            type="text" name="information"
                                            value="{{ old('information', $notaris->information ?? '') }}">
                                        @error('information')
                                            <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-3">

                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- @include('layouts.footers.auth.footer') --}}
    </div>

@endsection
@push('js')
    <script>
        const selectedProvinsi = "{{ $notaris->provinsi_id ?? '' }}";
        const selectedKota = "{{ $notaris->kota_id ?? '' }}";
        const selectedKecamatan = "{{ $notaris->kecamatan_id ?? '' }}";
        const selectedKelurahan = "{{ $notaris->kelurahan_id ?? '' }}";
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const provinsi = document.getElementById('provinsi');
            const kota = document.getElementById('kota');
            const kecamatan = document.getElementById('kecamatan');
            const kelurahan = document.getElementById('kelurahan');

            const provinsiName = document.getElementById('provinsi_name');
            const kotaName = document.getElementById('kota_name');
            const kecamatanName = document.getElementById('kecamatan_name');
            const kelurahanName = document.getElementById('kelurahan_name');

            // ===== LOAD PROVINSI =====
            fetch('/api/provinsi')
                .then(res => res.json())
                .then(data => {
                    data.forEach(i => {
                        provinsi.innerHTML +=
                            `<option value="${i.id}" ${i.id == selectedProvinsi ? 'selected' : ''}>${i.name}</option>`;
                    });

                    if (selectedProvinsi) {
                        provinsiName.value = provinsi.options[provinsi.selectedIndex].text;
                        loadKota(selectedProvinsi);
                    }
                });

            function loadKota(provinsiId) {
                fetch(`/api/kota/${provinsiId}`)
                    .then(res => res.json())
                    .then(data => {
                        kota.innerHTML = '<option value="">Pilih Kota</option>';
                        data.forEach(i => {
                            kota.innerHTML +=
                                `<option value="${i.id}" ${i.id == selectedKota ? 'selected' : ''}>${i.name}</option>`;
                        });

                        if (selectedKota) {
                            kotaName.value = kota.options[kota.selectedIndex].text;
                            loadKecamatan(selectedKota);
                        }
                    });
            }

            function loadKecamatan(kotaId) {
                fetch(`/api/kecamatan/${kotaId}`)
                    .then(res => res.json())
                    .then(data => {
                        kecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
                        data.forEach(i => {
                            kecamatan.innerHTML +=
                                `<option value="${i.id}" ${i.id == selectedKecamatan ? 'selected' : ''}>${i.name}</option>`;
                        });

                        if (selectedKecamatan) {
                            kecamatanName.value = kecamatan.options[kecamatan.selectedIndex].text;
                            loadKelurahan(selectedKecamatan);
                        }
                    });
            }

            function loadKelurahan(kecamatanId) {
                fetch(`/api/kelurahan/${kecamatanId}`)
                    .then(res => res.json())
                    .then(data => {
                        kelurahan.innerHTML = '<option value="">Pilih Kelurahan</option>';
                        data.forEach(i => {
                            kelurahan.innerHTML +=
                                `<option value="${i.id}" ${i.id == selectedKelurahan ? 'selected' : ''}>${i.name}</option>`;
                        });

                        if (selectedKelurahan) {
                            kelurahanName.value = kelurahan.options[kelurahan.selectedIndex].text;
                        }
                    });
            }

            // ===== CHANGE EVENTS =====
            provinsi.addEventListener('change', function() {
                provinsiName.value = this.options[this.selectedIndex].text;
                kota.innerHTML = kecamatan.innerHTML = kelurahan.innerHTML = '';
                loadKota(this.value);
            });

            kota.addEventListener('change', function() {
                kotaName.value = this.options[this.selectedIndex].text;
                kecamatan.innerHTML = kelurahan.innerHTML = '';
                loadKecamatan(this.value);
            });

            kecamatan.addEventListener('change', function() {
                kecamatanName.value = this.options[this.selectedIndex].text;
                kelurahan.innerHTML = '';
                loadKelurahan(this.value);
            });

            kelurahan.addEventListener('change', function() {
                kelurahanName.value = this.options[this.selectedIndex].text;
            });

        });
    </script>
@endpush
