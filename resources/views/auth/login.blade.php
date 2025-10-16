@extends('layouts.app')

@section('title', 'Login | Notaris App')

@section('content')

<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100 d-flex align-items-center justify-content-center bg-light">
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center min-vh-100">
                    <div class="col-lg-10 col-md-10">
                        <div class="d-flex flex-lg-row flex-column shadow-lg rounded-5 rounded overflow-hidden"
                            style="border-radius: 25px !important;">
                            <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center text-white text-center p-5"
                                style="background: linear-gradient(200deg, #fb6240, #e0ba3d);">
                                <h2 class="fw-bold mb-3 text-white" data-aos="fade-up" data-aos-easing="ease-in-back"
                                    data-aos-delay="100">
                                    Selamat Datang!</h2>
                                <p class="opacity-75" style="max-width: 300px;" data-aos="fade-up"
                                    data-aos-easing="ease-in-back" data-aos-delay="200">
                                    Kelola data dan dokumen notaris Anda dengan mudah melalui Notaris App.
                                </p>

                                <div class="position-relative d-flex justify-content-center align-items-center mt-4">
                                    <div class="octagon-wrapper position-relative" style="width: 300px; height: 300px;">
                                        <img src="https://images.pexels.com/photos/8730981/pexels-photo-8730981.jpeg"
                                            alt="Notary Office" class="octagon-img position-absolute"
                                            style="top: 0; left: 40px;" data-aos="fade-up"
                                            data-aos-easing="ease-in-back" data-aos-delay="220">
                                        <img src="https://images.pexels.com/photos/8730981/pexels-photo-8730981.jpeg"
                                            alt="Notary Office" class="octagon-img position-absolute"
                                            style="top: 90px; left: 100px;" data-aos="fade-up"
                                            data-aos-easing="ease-in-back" data-aos-delay="200">
                                        {{-- <img
                                            src=" https://images.pexels.com/photos/8730981/pexels-photo-8730981.jpeg"
                                            alt="Notary Office" class="octagon-img position-absolute"
                                            style="top: 180px; left: 160px;"> --}}
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6 bg-white p-5 d-flex flex-column justify-content-center">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('img/logo-ct-dark.png') }}" alt="Logo"
                                        style="width: 60px; height: 60px;" class="mx-auto">
                                    <h4 class="fw-bold mt-3">Notaris App</h4>
                                    {{-- <p class="text-muted m-0">Masukkan akun anda</p> --}}
                                </div>

                                <form method="POST" action="{{ route('login.perform') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label text-sm">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            placeholder="Enter your email" required>
                                        @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label text-sm">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password"
                                                class="form-control form-control-lg border"
                                                placeholder="Enter your password" required>
                                            <span class="input-group-text border" id="togglePassword"
                                                style="cursor:pointer;">
                                                <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 btn-lg shadow-sm">
                                        Sign In
                                    </button>

                                    <div class="text-center mt-3">
                                        <small class="text-muted">Lupa Password?
                                            <a href="{{ route('alertForgotPassword') }}"
                                                class="text-primary fw-semibold">Contact admin</a>
                                        </small>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("togglePassword");
        const input = document.getElementById("password");
        const icon = document.getElementById("togglePasswordIcon");

        toggle.addEventListener("click", function () {
            input.type = input.type === "password" ? "text" : "password";
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        });
    });
</script>
@endpush