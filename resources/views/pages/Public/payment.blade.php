@extends('layouts.app')

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
@endsection
