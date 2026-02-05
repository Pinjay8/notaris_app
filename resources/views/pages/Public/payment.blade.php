{{-- @extends('layouts.app')

@section('content')
    <main class="main-content mt-0">
        <section class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
            <div class="position-absolute w-100 min-height-250 top-0"
                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
                <span class="mask bg-primary opacity-6"></span>
            </div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0 text-white">Informasi Pembayaran</h4>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="30%" class="text-capitalize">Kode Pembayaran</th>
                                            <td>{{ $cost->payment_code }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-capitalize">Notaris</th>
                                            <td>{{ $cost->notaris->display_name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-capitalize">Nama Klien</th>
                                            <td>{{ $cost->client->fullname }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-capitalize">Total Biaya</th>
                                            <td>
                                                Rp {{ number_format($cost->total_cost, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-capitalize">Telah Dibayar</th>
                                            <td>
                                                Rp {{ number_format($cost->amount_paid, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-capitalize">Sisa Pembayaran</th>
                                            <td>
                                                Rp {{ number_format($cost->total_cost - $cost->amount_paid, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-capitalize">Status</th>
                                            <td>
                                                @if ($cost->payment_status === 'unpaid')
                                                    <span class="badge bg-danger text-capitalize">
                                                        Belum Dibayar
                                                    </span>
                                                @elseif ($cost->payment_status === 'partial')
                                                    <span class="badge bg-warning text-white text-capitalize">
                                                        Bayar Sebagian
                                                    </span>
                                                @elseif ($cost->payment_status === 'paid')
                                                    <span class="badge bg-success text-capitalize">
                                                        Lunas
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        -
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection --}}


@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
    <main class="main-content mt-0">
        <section class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
            <div class="position-absolute w-100 min-height-250 top-0"
                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
                <span class="mask bg-primary opacity-6"></span>
            </div>
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        {{-- HEADER --}}
                        <div class="card shadow-sm mb-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Detail Pembayaran</h5>
                                    <small class="text-muted">Kode: {{ $cost->payment_code }}</small>
                                </div>
                                <span
                                    class="badge text-capitalize
                                @if ($cost->payment_status === 'paid') bg-success
                                @elseif ($cost->payment_status === 'partial') bg-warning
                                @else bg-danger @endif
                            ">
                                    @if ($cost->payment_status === 'paid')
                                        Lunas
                                    @elseif ($cost->payment_status === 'partial')
                                        Bayar Sebagian
                                    @else
                                        Belum Dibayar
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- INFO --}}
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Informasi</h6>
                                <hr>
                                <div class="row text-sm">
                                    <div class="col-md-6 mb-2">
                                        <strong>Klien</strong><br>
                                        {{ $cost->client->fullname ?? '-' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Notaris</strong><br>
                                        {{ $cost->notaris->display_name ?? '-' }}
                                    </div>
                                    <div class="col-md-6 mb-2 text-black">
                                        <strong>Jatuh Tempo</strong><br>
                                        {{ $cost->due_date ? \Carbon\Carbon::parse($cost->due_date)->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Catatan</strong><br>
                                        {{ $cost->note ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RINGKASAN BIAYA --}}
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Ringkasan Biaya</h6>
                                <hr>
                                <table class="table table-bordered text-sm mb-0">
                                    <tr>
                                        <td class="fw-bold text-black">Biaya Produk / Jasa</td>
                                        <td class="text-end">Rp {{ number_format($cost->product_cost, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Biaya Administrasi</td>
                                        <td class="text-end">Rp {{ number_format($cost->admin_cost, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Biaya Lain-lain</td>
                                        <td class="text-end">Rp {{ number_format($cost->other_cost, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="table-light fw-bold">
                                        <td>Total Biaya</td>
                                        <td class="text-end">Rp {{ number_format($cost->total_cost, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sudah Dibayar</td>
                                        <td class="text-end text-success">Rp
                                            {{ number_format($cost->amount_paid, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Sisa Pembayaran</td>
                                        <td class="text-end text-danger">
                                            Rp {{ number_format($cost->total_cost - $cost->amount_paid, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- RINCIAN PEMBAYARAN --}}
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="mb-3">Rincian Pembayaran</h6>
                                <hr>
                                <table class="table table-striped text-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            {{-- <th>Jenis</th> --}}
                                            <th>Metode</th>
                                            <th class="text-end">Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cost->payments as $payment)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                                                </td>
                                                {{-- <td class="text-capitalize">{{ $payment->payment_type }}</td> --}}
                                                <td class="text-capitalize">{{ $payment->payment_method }}</td>
                                                <td class="text-end">
                                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    @if ($payment->is_valid)
                                                        <span class="badge bg-success text-capitalize">Valid</span>
                                                    @else
                                                        <span class="badge bg-warning text-capitalize">Menunggu</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
                                                    Belum ada pembayaran
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
