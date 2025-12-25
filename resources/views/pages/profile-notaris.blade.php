@extends('layouts.app')

@section('title', 'Profile | Notaris App')

@php
    use Carbon\Carbon;

    function v($val)
    {
        return filled($val) ? $val : '-';
    }

    function d($date)
    {
        return $date ? Carbon::parse($date)->format('d F Y') : '-';
    }
@endphp

@section('content')
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100 d-flex align-items-center justify-content-center bg-light">
                <div class="container py-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">

                            <div class="card shadow-lg border-0">
                                {{-- HEADER --}}
                                <div class="card-body text-center border-bottom">
                                    <div class="mx-auto mb-1"
                                        style="
                                        width:150px;
                                        height:150px;
                                        padding:0.5px;
                                        background-clip:padding-box;
                                    ">
                                        <img src="{{ $notaris->image
                                            ? (filter_var($notaris->image, FILTER_VALIDATE_URL)
                                                ? $notaris->image
                                                : asset('storage/' . $notaris->image))
                                            : asset('img/img_profile.png') }}"
                                            style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                                    </div>

                                    <h5 class="fw-bold mb-1">
                                        {{ v($notaris->display_name ?? '-') }}
                                    </h5>

                                    <div class="text-muted mb-2 text-capitalize">
                                        {{ v($notaris->office_name ?? '-') }}
                                    </div>
                                </div>

                                {{-- BODY --}}
                                <div class="card-body pt-3 pb-0">
                                    <div class="row g-3 small">

                                        {{-- IDENTITAS --}}
                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-person-fill text-primary"></i>
                                                Nama Lengkap
                                            </h6>
                                            <p class="fw-semibold mb-0">
                                                {{ v($notaris->first_name) }} {{ v($notaris->last_name ?? '-') }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-envelope-fill text-primary"></i>
                                                Alamat Email
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ v($notaris->email ?? '-') }}</p>
                                        </div>

                                        {{-- ALAMAT --}}
                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-geo-alt-fill text-primary"></i>
                                                Alamat Kantor
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ v($notaris->office_address ?? '-') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-telephone-fill text-primary"></i>
                                                Nomor Telepon
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ v($notaris->phone ?? '-') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-file-earmark-text-fill text-primary"></i>
                                                SK Notaris
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ v($notaris->sk_notaris ?? '-') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-calendar-event-fill text-primary"></i>
                                                Tanggal SK Notaris
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ d($notaris->sk_notaris_date ?? '-') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-file-earmark-check-fill text-primary"></i>
                                                SK PPAT
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ v($notaris->sk_ppat ?? '-') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-calendar-check-fill text-primary"></i>
                                                Tanggal SK PPAT
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ d($notaris->sk_ppat_date ?? '-') }}</p>
                                        </div>

                                        {{-- KEANGGOTAAN --}}
                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-patch-check-fill text-primary"></i>
                                                No KTA INI
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ v($notaris->no_kta_ini ?? '-') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="d-flex align-items-center gap-2">
                                                <i class="bi bi-patch-check text-primary"></i>
                                                No KTA IPPAT
                                            </h6>
                                            <p class="fw-semibold mb-0">{{ v($notaris->no_kta_ippat ?? '-') }}</p>
                                        </div>

                                    </div>

                                    @if ($notaris->phone)
                                        @php
                                            $phone = preg_replace('/^0/', '62', $notaris->phone);
                                        @endphp
                                        <div class="d-grid mt-4">
                                            <a href="https://wa.me/{{ $phone }}" target="_blank"
                                                class="btn btn-success">
                                                <i class="bi bi-whatsapp me-2 fa-1x"></i>
                                                Hubungi via WhatsApp
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
