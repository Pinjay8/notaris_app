@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Pembayaran'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pembayaran</h5>
            </div>

            {{-- Cari PIC Document --}}
            <div class="card-body">
                <form method="GET" action="{{ route('notary_payments.index') }}">
                    <div class="input-group">
                        <input type="text" name="pic_document_code" class="form-control"
                            placeholder="Masukkan Kode Dokumen" value="{{ request('pic_document_code') }}">
                        <button type="submit" class="btn btn-primary mb-0">Cari</button>
                    </div>
                </form>
            </div>

            @if($cost)
            <div class="card-body pt-1">
                <h5 class="mb-3">Detail Biaya</h5>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th style="width: 25%">Kode Pembayaran</th>
                        <td>{{ $cost->payment_code }}</td>
                    </tr>
                    <tr>
                        <th>Total Biaya</th>
                        <td>Rp {{ number_format($cost->total_cost,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <th>Telah Dibayar</th>
                        <td>Rp {{ number_format($cost->amount_paid,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($cost->payment_status === 'unpaid')
                            <span class="badge bg-danger">Belum Dibayar</span>
                            @elseif ($cost->payment_status === 'partial')
                            <span class="badge bg-warning text-white">Bayar Sebagian</span>
                            @elseif ($cost->payment_status === 'paid')
                            <span class="badge bg-success">Lunas</span>
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- Tombol buka modal --}}
                <button type="button" class="btn btn-info mt-2" data-bs-toggle="modal"
                    data-bs-target="#paymentFilesModal">
                    <i class="fa-solid fa-file"></i> Lihat File Pembayaran
                </button>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="paymentFilesModal" tabindex="-1" aria-labelledby="paymentFilesModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentFilesModalLabel">Daftar File Pembayaran</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">#</th>
                                        <th>Bukti Pembayaran</th>
                                        <th style="width: 20%">Status</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cost->payments as $index => $file)
                                    <tr class="text-center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset('storage/' . $file->payment_file) }}"
                                                    class="img-fluid" style="max-width: 150px">
                                            </div>
                                        </td>
                                        <td>
                                            @if($file->is_valid)
                                            <span class="badge bg-success">Valid</span>
                                            @else
                                            <span class="badge bg-danger">Belum Valid</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$file->is_valid)
                                            <form action="{{ route('notary_payments.valid', $file->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-primary mb-0">
                                                    Valid
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada file pembayaran</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Tabs --}}
            <div class="card-body pt-0">
                <div class="row">
                    <!-- Nav kiri -->
                    <div class="col-lg-2">
                        <ul class="nav nav-pills flex-lg-column flex-row flex-wrap mb-3 gap-2 rounded" id="pills-tab"
                            role="tablist" style="background: none !important">
                            <!-- Pembayaran Penuh Awal -->
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link active d-flex align-items-center gap-2 px-3 py-2 shadow-sm btn-primary text-white"
                                    id="pills-full-tab" data-bs-toggle="pill" data-bs-target="#pills-full" type="button"
                                    role="tab">
                                    <i class="fa-solid fa-sack-dollar"></i>
                                    <span class="text-sm">Lunas Dimuka</span>
                                </button>
                            </li>

                            <!-- DP -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center gap-2 px-3 py-2 shadow-sm"
                                    id="pills-dp-tab" data-bs-toggle="pill" data-bs-target="#pills-dp" type="button"
                                    role="tab">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                    <span class="text-sm">DP</span>
                                </button>
                            </li>

                            <!-- Kekurangan -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center gap-2 px-3 py-2 shadow-sm"
                                    id="pills-remaining-tab" data-bs-toggle="pill" data-bs-target="#pills-partial"
                                    type="button" role="tab">
                                    <i class="fa-solid fa-wallet"></i>
                                    <span class="text-sm">Kekurangan</span>
                                </button>
                            </li>

                            <!-- Cetak -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center gap-2 px-3 py-2 shadow-sm"
                                    id="pills-print-tab" data-bs-toggle="pill" data-bs-target="#pills-print"
                                    type="button" role="tab">
                                    <i class="fa-solid fa-print"></i>
                                    <span class="text-sm">Cetak</span>
                                </button>
                            </li>
                        </ul>

                    </div>

                    <!-- Konten kanan -->
                    <div class=" col-lg-10">
                        <div class="tab-content" id="pills-tabContent">
                            {{-- Lunas --}}
                            <div class="tab-pane fade show active" id="pills-full" role="tabpanel">
                                @include('pages.Biaya.Pembayaran.form', ['type' => 'full', 'cost' =>
                                $cost])
                            </div>

                            {{-- DP --}}
                            <div class="tab-pane fade" id="pills-dp" role="tabpanel">
                                @include('pages.Biaya.Pembayaran.form', ['type' => 'dp', 'cost' =>
                                $cost])
                            </div>

                            {{-- Kekurangan --}}
                            <div class="tab-pane fade" id="pills-partial" role="tabpanel">
                                <div class="d-flex align-items-center gap-2">
                                    <p class="mb-2">Sisa yang harus dibayar:
                                        <strong>
                                            Rp {{ number_format($cost->total_cost -
                                            $cost->amount_paid,0,',','.') }}
                                        </strong>
                                    </p>
                                    <p class="mb-2">Jatuh Tempo:
                                        <strong>
                                            {{ $cost->due_date ?
                                            \Carbon\Carbon::parse($cost->due_date)->format('d/m/Y')
                                            : '-' }}
                                        </strong>
                                    </p>
                                </div>
                                @include('pages.Biaya.Pembayaran.form', ['type' => 'remaining', 'cost' =>
                                $cost])
                            </div>

                            {{-- Cetak --}}
                            <div class="tab-pane fade" id="pills-print" role="tabpanel">
                                <a href="{{ route('notary_payments.print', $cost->payment_code) }}"
                                    class="btn btn-danger" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i> Cetak Detail Pembayaran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
</div>
@endsection