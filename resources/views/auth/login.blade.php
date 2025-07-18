@extends('layouts.app')

@section('content')
{{-- <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            @include('layouts.navbars.guest.navbar')
        </div>
    </div>
</div> --}}
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Sign In</h4>
                                <p class="mb-0">Enter your email and password to sign in</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login.perform') }}">
                                    @csrf
                                    <div class="flex flex-col mb-3">
                                        <label for="email" class="form-label text-sm">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            aria-label="Email">
                                        @error('email')
                                        <p class="text-danger"> {{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <label for="email" class="form-label text-sm">Password <span
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
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign
                                            in</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 text-sm mx-auto">
                                    Forgot you password? Reset your password
                                    {{-- <a href="{{ route('reset-password') }}"
                                        class="text-primary text-gradient font-weight-bold">here</a> --}}
                                    <a href="{{ route('alertForgotPassword') }}"
                                        class="text-primary text-gradient font-weight-bold">here</a>
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
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
              background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new
                                currency"</h4>
                            <p class="text-white position-relative">The more effortless the writing looks, the more
                                effort the writer actually put into the process.</p>
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