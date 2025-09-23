@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Laporan Pembayaran'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 pb-0">
            <div class="card-header pb-3 d-flex justify-content-between align-items-center">
                <h5>Laporan Pembayaran</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                <form method="GET" action="{{ route('report-payment.index') }}" class="row g-3 mb-4 px-3" class="no-spinner">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label text-sm">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label text-sm">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label text-sm">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="all" {{ request('status')=='all' ? 'selected' : '' }}>Semua</option>
                            <option value="lunas" {{ request('status')=='lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="dp" {{ request('status')=='dp' ? 'selected' : '' }}>DP</option>
                            <option value="belum" {{ request('status')=='belum' ? 'selected' : '' }}>Belum Bayar
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-1 flex-wrap">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">
                            <i class="bi bi-funnel"></i>
                            Tampilkan</button>
                        <a href="{{ route('report-payment.print', request()->all()) }}" target="_blank"
                            class="btn btn-danger mb-0 btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> PDF
                        </a>
                    </div>
                </form>
                <div class="table-responsive p-0">
                    <table class="table table-hover align-items-center mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Kode Pembayaran</th>
                                <th>Nama Klien</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($costs as $cost)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cost->payment_code }}</td>
                                <td>{{ $cost->client->fullname }}</td>
                                <td>{{ $cost->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $cost->payment_status == 'Lunas' ? 'success':'warning' }}">
                                        {{ $cost->payment_status }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($cost->total_cost, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-sm">Tidak ada data laporan pembayaran.</td>
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