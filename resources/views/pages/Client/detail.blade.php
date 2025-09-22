@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
        {{-- Card Header --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-white text-primary fw-bold d-flex align-items-center justify-content-center me-3"
                    style="width:45px; height:45px; font-size:18px;">
                    {{ strtoupper(substr($client->fullname, 0, 1)) }}
                </div>
                <h4 class="mb-0 text-white">{{ $client->fullname }}</h4>
            </div>
            <div>
                @php
                $phone = !empty($client->phone) ? preg_replace('/^0/', '62', $client->phone) : null;
                $link = url("/clients/{$client->uuid}");
                @endphp

                @if($phone)
                <a href="https://wa.me/{{ $phone }}?text={{ urlencode('Halo ' . $client->fullname . ', berikut link Anda: ' . $link) }}"
                    target="_blank" class="btn btn-success btn-md d-inline-flex align-items-center gap-2 mb-0">
                    <i class="fab fa-whatsapp fa-lg"></i>
                    <span>Hubungi via WA</span>
                </a>
                @endif
            </div>
        </div>

        {{-- Nav Tabs --}}
        <div class="bg-light border-bottom">
            <ul class="nav nav-tabs px-3" id="clientTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info">
                        <i class="fas fa-id-card me-1"></i> Info
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dokumen">
                        <i class="fas fa-file-alt me-1"></i> Dokumen
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tracking">
                        <i class="fas fa-map-marker-alt me-1"></i> Tracking
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#biaya">
                        <i class="fas fa-money-bill me-1"></i> Biaya
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pajak">
                        <i class="fas fa-chart-line me-1"></i> Pembayaran
                    </button>
                </li>
            </ul>
        </div>

        {{-- Tab Content --}}
        <div class="card-body tab-content p-4">
            {{-- Info --}}
            <div class="tab-pane fade show active" id="info">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-regular fa-id-card me-2"></i> NIK</p>
                        <p>{{ $client->nik ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-building me-2"></i> NPWP</p>
                        <p>{{ $client->npwp ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-location-dot me-2"></i> Alamat</p>
                        <p>{{ $client->address ?? '-' }}, {{ $client->city ?? '' }}, {{ $client->province ?? '' }} {{
                            $client->postcode ?? '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-phone me-2"></i> Telepon</p>
                        <p>{{ $client->phone ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-regular fa-envelope me-2"></i> Email</p>
                        <p>{{ $client->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-venus-mars me-2"></i> Gender</p>
                        <p>{{ ucfirst($client->gender) ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-briefcase me-2"></i> Pekerjaan</p>
                        <p>{{ $client->job ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-user-check me-2"></i> Status</p>
                        <p>{{ ucfirst($client->marital_status) ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-building-user me-2"></i> Tipe</p>
                        <p>{{ $client->type == 'company' ? 'Perusahaan' : 'Pribadi' }}</p>
                    </div>

                    @if($client->type == 'company')
                    <div class="col-md-6">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-industry me-2"></i> Nama Perusahaan</p>
                        <p>{{ $client->company_name ?? '-' }}</p>
                    </div>
                    @endif

                    <div class="col-md-12">
                        <p class="mb-1 fw-bold text-muted"><i class="fa-solid fa-circle-info me-2"></i> Catatan</p>
                        <p>{{ $client->note ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Dokumen --}}
            <div class="tab-pane fade" id="dokumen">
                {{-- documents --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Dokumen yang harus dikirim</label>
                    @if($documents->isEmpty())
                    <p class="text-muted">Tidak ada dokumen yang harus dikirim.</p>
                    @else
                    <ul class="list-group">
                        @foreach($documents as $doc)
                        <li class="list-group-item list-group-item-secondary">
                            {{ $doc->name }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                {{-- Form Upload Dokumen --}}
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Upload Dokumen</h6>
                    </div>
                    <div class="card-body pt-1">
                        <form action="{{ route('client.uploadDocument', $client->uuid) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="mb-3">
                                <label class="form-label">Nama Dokumen</label>
                                <input type="text" name="document_name" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kode Dokumen</label>
                                <input type="text" name="document_code" class="form-control" required />
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label">Jenis Dokumen</label>
                                <select name="document_code" class="form-select" required>
                                    <option value="" hidden>Pilih Dokumen</option>
                                    @foreach($documents as $doc)
                                    <option value="{{ $doc->code }}">{{ $doc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">File Dokumen</label>
                                <input type="file" name="document_link" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan</label>
                                <input type="text" name="note" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>

                {{-- Daftar Dokumen yang Sudah Diupload --}}
                @if($clientDocuments->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                    <p>Belum ada dokumen yang diunggah</p>
                </div>
                @else
                <ul class="list-group">
                    <div class="mb-2 fw-bold">Dokumen yang sudah diupload</div>
                    @foreach($clientDocuments as $doc)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $doc->document_name }}
                        @if($doc->status == 'new')
                        <span class="badge bg-warning">Menunggu Validasi</span>
                        @elseif($doc->status == 'valid')
                        <span class="badge bg-success">Valid</span>
                        @elseif($doc->status == 'invalid')
                        <span class="badge bg-danger">Invalid - Upload Ulang</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>




            {{-- Tracking --}}
            <div class="tab-pane fade" id="tracking">
                <h6 class="mb-3">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                    Tracking
                </h6>
                @php
                $hasDone = $picDocuments->flatMap->processes->contains('step_status', 'done');
                @endphp

                {{-- Highlight jika ada yang selesai --}}
                @if ($hasDone)
                <div class="alert alert-success text-center mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    Pengurusan <strong>selesai</strong>.
                </div>
                @endif

                @if($picDocuments->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                    <p>Status & progres pengerjaan belum tersedia</p>
                </div>
                @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kode Registrasi</th>
                            <th>Jenis Pengurusan</th>
                            <th>Status Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($picDocuments as $doc)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $doc->pic_document_code }}</td>
                            <td class="text-capitalize">{{ $doc->document_type ?? '-' }}</td>
                            <td class="text-capitalize">
                                {{ optional($doc->processes->last())->step_status ?? 'Belum ada progres' }}
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#processModal-{{ $doc->id }}">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                @foreach($picDocuments as $doc)
                <div class="modal fade" id="processModal-{{ $doc->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Detail Proses - {{ $doc->pic_document_code }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($doc->processes->isEmpty())
                                <p class="text-muted mb-0">Belum ada history proses</p>
                                @else
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Notaris</th>
                                            <th>Tanggal</th>
                                            <th>Nama Proses</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($doc->processes as $process)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $process->notaris->display_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($process->step_date)->format('Y-m-d') }}</td>
                                            <td>{{ $process->step_name }}</td>
                                            <td>
                                                @if($process->step_status == 'done')
                                                <span class="badge bg-success">Done</span>
                                                @else
                                                <span class="badge bg-secondary">{{
                                                    ucfirst($process->step_status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $process->note ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            {{-- Biaya --}}
            <div class="tab-pane fade" id="biaya">
                <h6 class="mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Untuk melakukan pembayaran, silakan hubungi Admin.
                </h6>
                @if($notaryCost->isNotEmpty())
                <div class=" table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                {{-- <th>Deskripsi Biaya</th> --}}
                                <th>Kode Pembayaran</th>
                                <th>Tanggal Bayar</th>
                                {{-- <th>Status</th> --}}
                                <th>Jumlah Bayar</th>
                                {{-- <th>Total Biaya</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notaryCost as $cost)
                            <tr class="text-center">
                                <td>{{ $loop->iteration}}</td>
                                {{-- <td>{{ $cost->description ?? '-' }}</td> --}}
                                <td>{{ $cost->payment_code ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($cost->created_at)->format('d-m-Y') }}</td>
                                {{-- <td>
                                    @if($cost->status == 'paid')
                                    <span class="badge bg-success text-white">Lunas</span>
                                    @elseif($cost->status == 'partial')
                                    <span class="badge bg-warning text-dark">Bayar Sebagian</span>
                                    @else
                                    <span class="badge bg-danger text-white">Belum Lunas</span>
                                    @endif
                                </td> --}}
                                <td>Rp {{ number_format($cost->amount_paid, 0, ',', '.') }}</td>
                                {{-- <td>Rp {{ number_format($cost->total_cost, 0, ',', '.') }}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>

                                <td colspan="3" class="text-end fw-bold">Sisa Pembayaran</td>
                                <td colspan="3" class="text-center fw-bold">
                                    Rp {{ number_format(
                                    $notaryCost->sum('total_cost') - $notaryCost->sum('amount_paid'),
                                    0, ',', '.'
                                    ) }}
                                </td>
                            </tr>
                            <tr>

                                <td colspan="3" class="text-end fw-bold">Total Tagihan</td>
                                <td colspan="3" class="text-center fw-bold">
                                    Rp {{ number_format($notaryCost->sum('total_cost'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-money-bill fa-2x mb-2"></i>
                    <p>Belum ada data biaya untuk klien ini</p>
                </div>
                @endif
            </div>



            {{-- Pajak --}}
            <div class="tab-pane fade" id="pajak">
                <h6 class="mb-3">
                    <i class="fas fa-chart-line me-2 text-primary"></i>
                    Riwayat Pembayaran
                </h6>

                @if($notaryPayment->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Metode</th>

                                <th>Status</th>
                                <th>Bukti</th>
                                <th>Jumlah Dibayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notaryPayment as $pay)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pay->payment_code }}</td>
                                <td>{{ \Carbon\Carbon::parse($pay->payment_date)->format('d-m-Y') }}</td>
                                <td>
                                    @switch($pay->payment_type)
                                    @case('full')
                                    Lunas
                                    @break
                                    @case('partial')
                                    Bayar Sebagian
                                    @break
                                    @case('dp')
                                    Uang Muka (DP)
                                    @break
                                    @default
                                    {{ ucfirst($pay->payment_type) }}
                                    @endswitch
                                </td>
                                <td>{{ ucfirst($pay->payment_method) }}</td>
                                <td>
                                    @if($pay->is_valid)
                                    <span class="badge bg-success text-center">Tervalidasi</span>
                                    @else
                                    <span class="badge bg-warning text-white">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $pay->payment_file) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary mb-0">
                                        Lihat
                                    </a>
                                </td>
                                <td>Rp {{ number_format($pay->amount, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-end fw-bold">Sisa Pembayaran</td>
                                <td colspan="3" class="text-center fw-bold">
                                    Rp {{ number_format(
                                    $notaryCost->sum('total_cost') - $notaryPayment->where('is_valid',
                                    true)->sum('amount'),
                                    0, ',', '.'
                                    ) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Ringkasan --}}
                {{-- <div class="mt-3">
                    <p><strong>Total Tagihan:</strong> Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                    <p><strong>Total Dibayar:</strong> Rp {{ number_format($totalDibayar, 0, ',', '.') }}</p>
                    <p><strong>Sisa Pembayaran:</strong> Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</p>
                </div> --}}
                @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-money-check-alt fa-2x mb-2"></i>
                    <p>Belum ada pembayaran untuk klien ini</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection