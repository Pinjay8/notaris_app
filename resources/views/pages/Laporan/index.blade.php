@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Laporan Pembayaran'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 pb-0">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5>Laporan Pembayaran</h5>
                    <a href="{{ route('report-payment.print', request()->all()) }}" target="_blank"
                        class="btn btn-danger mb-0 btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                </div>
                <hr>
                <div class="card-body px-2 pt-0 pb-2">
                    <form method="GET" action="{{ route('report-payment.index') }}" class="row g-3 mb-4 px-3 no-spinner">
                        <div class="col-md-4 col-xl-5">
                            <label for="start_date" class="form-label text-sm">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class=" col-md-4 col-xl-5">
                            <label for="end_date" class="form-label text-sm">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ request('end_date') }}">
                        </div>

                        <div class=" col-md-2 col-xl-1">
                            <label for="status" class="form-label text-sm">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="full" {{ request('status') == 'full' ? 'selected' : '' }}>Lunas</option>
                                <option value="dp" {{ request('status') == 'dp' ? 'selected' : '' }}>DP</option>
                                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Bayar
                                    Sebagian</option>
                                {{-- <option value="belum" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar --}}
                                </option>
                            </select>
                        </div>

                        <div class=" col-md-2 col-xl-1 d-lg-flex align-items-end py-2">
                            <button type="submit" class="btn btn-primary btn-sm w-100 mb-0">
                                <i class="bi bi-funnel"></i> Cari
                            </button>
                        </div>
                    </form>
                    <div class="table-responsive p-0">
                        <table class="table table-hover align-items-center mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Kode Pembayaran</th>
                                    <th>Nama Klien</th>
                                    <th>Tanggal Pelunasan</th>
                                    <th>Total Biaya</th>
                                    <th>Total Pembayaran</th>
                                    <th>Piutang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr class="text-center text-sm">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payment->payment_code }}</td>
                                        <td>{{ $payment->client->fullname ?? '-' }}</td>
                                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>Rp
                                            {{ number_format(($payment->cost->total_cost ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td>Rp {{ number_format($payment->cost->amount_paid, 0, ',', '.') }}</td>
                                        <td>Rp {{  number_format($payment->cost->total_cost - $payment->cost->amount_paid, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $status = $payment->payment_type;
                                                $badgeColor = match ($status) {
                                                    'full' => 'success',
                                                    'partial' => 'warning',
                                                    'dp' => 'info',
                                                    default => 'secondary',
                                                };
                                                $statusText = match ($status) {
                                                    'full' => 'Lunas',
                                                    'partial' => 'Bayar sebagian',
                                                    'dp' => 'DP',
                                                    default => $status,
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $badgeColor }} text-capitalize">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-sm">Tidak ada data laporan pembayaran.
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
@endsection
