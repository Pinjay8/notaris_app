@extends('layouts.app')

@section('title', 'Laporan Akta')


@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Laporan Akta'])

<div class="row mt-4 mx-4">
    <div class="col md-12">
        <div class="card mb-4">
            <div class="card-header mb-0 pb-0">
                <h6>Laporan Akta</h6>
            </div>
            <div class="card-body pt-1">
                <form method="GET" action="{{ route('laporan-akta.index') }}" class="no-spinner">
                    <div class="row g-3 align-items-end">
                        {{-- Pilih Type --}}
                        <div class="col-md-3">
                            <label for="type" class="form-label">Jenis Akta</label>
                            <select name="type" id="type" class="form-select">
                                <option value="" hidden>Pilih Jenis</option>
                                <option value="partij" {{ request('type')=='partij' ? 'selected' : '' }}>Partij</option>
                                <option value="relaas" {{ request('type')=='relaas' ? 'selected' : '' }}>Relaas</option>
                            </select>
                        </div>

                        {{-- Start Date --}}
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                value="{{ request('start_date') }}">
                        </div>

                        {{-- End Date --}}
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                value="{{ request('end_date') }}">
                        </div>

                        {{-- Tombol Filter --}}
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100 mb-0">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="card ">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>{{ ucfirst($queryType) }}</h6>
                @if($data->isNotEmpty())
                <a href="{{ route('laporan-akta.export-pdf', [
        'type' => $queryType,
        'start_date' => $startDate,
        'end_date' => $endDate
    ]) }}" class="btn btn-danger mb-3" target="_blank">
                    Export PDF
                </a>
                @endif
            </div>
            <div class="card-body pt-0">
                @if($data->isNotEmpty())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nomor Akta</th>
                            <th>Kode Registrasi</th>
                            <th>Nama Klien / Pihak</th>
                            <th>Tanggal Dibuat</th>
                            <th>Jenis Akta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $row)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->akta_number ?? $row->relaas_number ?? '-' }}</td>
                            <td>{{ $row->registration_code ?? '-' }}</td>
                            <td>{{ $row->client->fullname ?? '-' }}</td>
                            <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ ucfirst($queryType) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center text-muted">Tidak ada data untuk ditampilkan.</div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection