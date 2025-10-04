@extends('layouts.app')

@section('content')
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container d-flex justify-content-center align-items-center min-vh-100">
                <div class="row justify-content-center w-100">
                    <div class="col-xl-6  col-lg-5 col-md-12 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-header pb-0 text-start">
                                <div class="text-center mb-2 ">
                                    <img src="{{ asset('img/logo-ct-dark.png') }}" alt="" class="mx-auto"
                                        style="width: 60px; height: 60px">
                                </div>
                                <h4 class="font-weight-bolder text-center mt-3">Notaris App</h4>
                                {{-- <p class="mb-0 text-center">Masukkan email dan password anda.</p> --}}
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login.perform') }}">
                                    @csrf
                                    <div class="flex flex-col mb-3">
                                        <label for="email" class="form-label text-md m-0 mb-2">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            aria-label="Email">
                                        @error('email')
                                        <p class="text-danger"> {{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <label for="email" class="form-label text-md m-0 mb-2">Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group border-end">
                                            <input type="password" name="password" id="password"
                                                class="form-control form-control-lg" aria-label="Password">
                                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                        <p class="text-danger"> {{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="remember" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0 text-sm">Masuk</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 text-sm mx-auto">
                                    Anda lupa password? Hubungi admin dengan klik
                                    {{-- <a href="{{ route('reset-password') }}"
                                        class="text-primary text-gradient font-weight-bold">here</a> --}}
                                    <a href="{{ route('alertForgotPassword') }}"
                                        class="text-primary text-gradient font-weight-bold">disini</a>
                                </p>
                            </div>
                            {{-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Don't have an account?
                                    <a href="{{ route('register') }}"
                                        class="text-primary text-gradient font-weight-bold">Sign up</a>
                                </p>
                            </div> --}}
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
        const type = input.type === "password" ? "text" : "password";
        input.type = type;

        // Ganti ikon
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
    });
});
</script>
@endpush