@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Settings')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Settings'])
    <div class="card shadow-lg  mt-5 border-0 w-75 w-lg-50 mx-auto ">
        <div class="card-body p-4">
            <div class=" mb-4">
                <h5 class="fw-bold mb-1">🔐 Unlock Akses Penuh</h5>
                <p class="text-muted text-sm mb-0">
                    Masukkan kode akses untuk membuka seluruh menu sistem.
                </p>
            </div>

            <form method="POST" action="{{ route('profile.unlock') }}">
                @csrf

                <div class="row justify-content-center ">
                    <div class="col-md-12">

                        <div class="input-group input-group-outline mb-3">
                            <input type="password" name="access_code"
                                class="form-control @error('access_code') is-invalid @enderror"
                                placeholder="Masukkan kode akses" required>
                        </div>

                        @error('access_code')
                            <div class="text-danger text-sm mb-2">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger">
                                Unlock Sekarang
                            </button>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
