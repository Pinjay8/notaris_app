@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto">
                <img src="{{ filter_var($notaris->image, FILTER_VALIDATE_URL)
                ? $notaris->image
                : asset('storage/' . $notaris->image) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm"
                    style="width:80px; height: 80px">
            </div>
        </div>
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    {{ $notaris->display_name }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    {{ $notaris->office_name }}
                </p>
            </div>
        </div>
        {{-- <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center "
                            data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                            <i class="ni ni-app"></i>
                            <span class="ms-2">App</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                            data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                            <i class="ni ni-email-83"></i>
                            <span class="ms-2">Messages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                            data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                            <i class="ni ni-settings-gear-65"></i>
                            <span class="ms-2">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div> --}}
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
                            <button type="submit" class="btn btn-primary btn-md ms-auto">Ubah</button>
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
                                    <label for="example-text-input" class="form-control-label text-sm">
                                        Tanggal Pendaftaran</label>
                                    <input class="form-control type=" text" name="first_name"
                                        value="{{ old('signup_at', \Carbon\Carbon::parse($user->signup_at)->format('d-m-Y')) }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">
                                        Waktu Aktif</label>
                                    <input class="form-control type=" text" name="first_name"
                                        value="{{ old('active_at', \Carbon\Carbon::parse($user->active_at)->format('d-m-Y H:i:s')) }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">
                                        Waktu Aktif Berakhir</label>
                                    <input type="text" class="form-control" id="active_at" name="active_at" value=""
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Nama
                                        Depan</label>
                                    <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                        name="first_name" value="{{ old('first_name', $notaris->first_name) }}">
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
                                        name="last_name" value="{{ old('last_name', $notaris->last_name) }}">
                                    @error('last_name')
                                    <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Nama
                                        Tampilan</label>
                                    <input class="form-control @error('display_name') is-invalid @enderror" type="text"
                                        name="display_name" value="{{ old('display_name', $notaris->display_name) }}">
                                    @error('display_name')
                                    <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Nama
                                        Perusahaan</label>
                                    <input class="form-control @error('office_name') is-invalid @enderror" type="text"
                                        name="office_name" value="{{ old('office_name', $notaris->office_name) }}">
                                    @error('office_name')
                                    <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Alamat
                                        Perusahaan</label>
                                    <input class="form-control @error('office_address') is-invalid @enderror"
                                        type="text" name="office_address"
                                        value="{{ old('office_address',$notaris->office_address) }}">
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
                                    @error('image')
                                    <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <h6 class="text-capitalize mb-3 d-inline-block bg-primary text-white px-3 py-2"
                            style="border-radius:20px;">
                            Informasi Kontak
                        </h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Alamat</label>
                                    <input class="form-control @error('address') is-invalid @enderror" type="text"
                                        name="address" value="{{ old('address', $notaris->address) }}">
                                    @error('address')
                                    <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Nomor
                                        Telepon</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                        name="phone" value="{{ old('phone', $notaris->phone) }}">
                                    @error('phone')
                                    <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" value="{{ old('email', $notaris->email) }}">
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
                                        <option value="Laki-laki" {{ old('gender', $notaris->gender) == 'Laki-laki' ?
                                            'selected' : '' }} class="form-control">Laki-laki</option>
                                        <option value="Perempuan" {{ old('gender', $notaris->gender) == 'Perempuan' ?
                                            'selected' : '' }} class="form-control">Perempuan</option>
                                        @error('gender')
                                        <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Informasi</label>
                                    <input class="form-control @error('information') is-invalid @enderror" type="text"
                                        name="information" value="{{ old('information', $notaris->information) }}">
                                    @error('information')
                                    <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">Latar
                                        Belakang</label>
                                    <input class="form-control @error('background') is-invalid @enderror" type="text"
                                        name="background" value="{{ old('background', $notaris->background) }}">
                                    @error('background')
                                    <p class="text-danger mt-1 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        {{-- <p class="text-uppercase text-sm">About me</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label text-sm">About me</label>
                                    <input class="form-control" type="text" name="about"
                                        value="{{ old('about', $notaris->about) }}">
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="card card-profile">
                <img src="/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="javascript:;">
                                <img src="/img/team-2.jpg"
                                    class="rounded-circle img-fluid border border-2 border-white">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                    <div class="d-flex justify-content-between">
                        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block">Connect</a>
                        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i
                                class="ni ni-collection"></i></a>
                        <a href="javascript:;"
                            class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Message</a>
                        <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i
                                class="ni ni-email-83"></i></a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-center">
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">22</span>
                                    <span class="text-sm opacity-8">Friends</span>
                                </div>
                                <div class="d-grid text-center mx-4">
                                    <span class="text-lg font-weight-bolder">10</span>
                                    <span class="text-sm opacity-8">Photos</span>
                                </div>
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">89</span>
                                    <span class="text-sm opacity-8">Comments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <h5>
                            Mark Davis<span class="font-weight-light">, 35</span>
                        </h5>
                        <div class="h6 font-weight-300">
                            <i class="ni location_pin mr-2"></i>Bucharest, Romania
                        </div>
                        <div class="h6 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>University of Computer Science
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    {{-- @include('layouts.footers.auth.footer') --}}
</div>
@endsection