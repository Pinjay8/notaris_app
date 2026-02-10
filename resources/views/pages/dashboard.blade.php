@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Dashboard')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-md mb-0 text-capitalize font-weight-bold">Total Klien</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalClients }}
                                </h5>
                                {{-- <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+55%</span>
                                    since yesterday
                                </p> --}}
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-md mb-0 text-capitalize font-weight-bold">Pembayaran</p>
                                <h5 class="font-weight-bolder">
                                    {{ $paymentsCount }}
                                </h5>
                                {{-- <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+3%</span>
                                    since last week
                                </p> --}}
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="fa fa-credit-card text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-md mb-0 text-capitalize font-weight-bold">Dokumen Klien</p>
                                <h5 class="font-weight-bolder">
                                    {{ $doneDocs }}
                                </h5>
                                {{-- <p class="mb-0">
                                    <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                    since last quarter
                                </p> --}}
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="fa fa-check-circle text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-md mb-0 text-capitalize font-weight-bold">Konsultasi</p>
                                <h5 class="font-weight-bolder">
                                    {{ $activeConsultations }}
                                </h5>
                                {{-- <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                                </p> --}}
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="fa fa-comments text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Klien</h6>
                    <p class="text-sm mb-0">
                        {{-- <i class="fa fa-arrow-up text-success"></i>
                        <span class="font-weight-bold">4% more</span> in 2021 --}}
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="card ">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Klien Terbaru</h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Perusahaan</th>
                                <th>Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestClients as $client)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $client->fullname }}</td>
                                <td>{{ $client->company_name ?? '-' }}</td>
                                <td>{{ $client->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr></tr>
                            <td colspan="4" class="text-center text-sm text-muted">Tidak ada data klien terbaru
                            </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Pembayaran</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="paymentPieChart" style="max-height:350px; width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('layouts.footers.auth.footer') --}}
</div>
@endsection

@push('js')
<script src="./assets/js/plugins/chartjs.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("paymentPieChart").getContext("2d");

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Lunas', 'Belum Lunas'],
                datasets: [{
                    data: [{{ $paidCount }}, {{ $pendingCount }}],
                    backgroundColor: ['#28a745', '#ffc107'],
                    borderColor: ['#fff', '#fff'],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

        new Chart(ctx1, {
            type: "line",
            data: {
                labels: @json($labels),
                datasets: [{
                    label: "Klien",
                    tension: 0.4,
                    pointRadius: 4,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: @json($data),
                    maxBarThickness: 6
                }],
            },
            options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: true }
    },
    interaction: { intersect: false, mode: 'index' },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                stepSize: 10, // 👈 tampilkan interval 5, bisa kamu sesuaikan
                callback: function(value) {
                    return value; // bisa juga format misalnya return value + " org";
                }
            },
            grid: { drawBorder: false, borderDash: [5, 5] }
        },
        x: {
            grid: { drawBorder: false, display: false },
            ticks: { padding: 20 }
        }
    },
}

        });
    });
</script>
@endpush