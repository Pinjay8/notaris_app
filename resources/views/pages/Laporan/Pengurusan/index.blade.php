@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Laporan Pengurusan'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 pb-0">
            <div class="card-header pb-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Laporan Pengurusan</h5>
            </div>

            <div class="card-body pt-0">
                {{-- Filter --}}
                <form method="GET" action="{{ route('report-progress.index') }}" class="row g-3 mb-4"
                    class="no-spinner">
                    <div class="col-xl-4">
                        <label for="start_date" class="form-label fw-semibold text-sm">Tanggal Mulai</label>
                        <input type="date" class="form-control form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-xl-4">
                        <label for="end_date" class="form-label fw-semibold text-sm">Tanggal Akhir</label>
                        <input type="date" class="form-control form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}">
                    </div>
                    <div class="col-xl-2">
                        <label for="status" class="form-label fw-semibold text-sm">Status</label>
                        <select class="form-select form-select" name="status" id="status">
                            <option value="all" {{ request('status')=='all' ? 'selected' : '' }}>Semua</option>
                            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="progress" {{ request('status')=='progress' ? 'selected' : '' }}>On Progress
                            </option>
                            <option value="done" {{ request('status')=='done' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-1 flex-wrap">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">
                            <i class="bi bi-funnel"></i>
                            Tampilkan</button>
                        <a href="{{ route('report-progress.print', request()->all()) }}" target="_blank"
                            class="btn btn-danger mb-0 btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> PDF
                        </a>
                    </div>
                </form>

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table class="table table-hover align-items-center mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Kode Proses</th>
                                <th>Pic</th>
                                <th>Nama Klien</th>
                                <th>Proses</th>
                                <th>Status</th>
                                <th>Tanggal Pengurusan</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($processes as $process)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $process->pic_document->pic_document_code }}
                                </td>
                                <td>{{ $process->pic_document->pic->full_name }}</td>
                                <td>{{ $process->pic_document->client->fullname ?? '-' }}</td>
                                <td>{{ $process->step_name ?? '-' }}</td>
                                <td>
                                    @php
                                    switch ($process->step_status) {
                                    case 'done':
                                    $statusText = 'Selesai';
                                    $statusColor = 'success';
                                    break;
                                    case 'in_progress':
                                    $statusText = 'Sedang Diproses';
                                    $statusColor = 'info';
                                    break;
                                    case 'pending':
                                    default:
                                    $statusText = 'Pending';
                                    $statusColor = 'warning';
                                    break;
                                    }
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>{{ $process->step_date->format('d-m-Y') }}</td>
                                <td>{{ $process->note }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-sm text-muted">Tidak ada data laporan pengurusan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (kalau pakai paginate) --}}
                {{-- <div class="mt-3 px-2">
                    {{ $processes->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection