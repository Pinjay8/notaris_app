@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Penomoran akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center mb-0 pb-0">
                <h6>Penomoran Akta</h6>
            </div>
            <div class="card-body pt-1">

                {{-- Nomor Akta Terakhir --}}
                @if($lastAkta)
                <div class="mb-3 bg-warning p-3 rounded-3 text-white">

                    <h6 class="text-white"> Nomor Akta Terakhir: {{ $lastAkta->relaas_number }}</h6>
                    <h6 class="text-white">
                        Waktu Dibuat:
                        {{ $lastAkta->relaas_number_created_at?->format('d-m-Y H:i:s') ?? '-' }}
                    </h6>
                </div>
                @else
                <div class="alert alert-warning">Belum ada nomor akta tersimpan.</div>
                @endif

                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('relaas_akta.indexNumber') }}" class="mb-3" class="no-spinner">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Masukkan Kode Registrasi atau Nomor Akta" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </div>
                </form>

                {{-- Jika ada transaksi ditemukan --}}
                @if($aktaInfo)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0 text-white">Detail Akta Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Kode Registrasi</strong></h6>
                                <p class="text-muted text-sm">{{ $aktaInfo->registration_code }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Nomor Akta</strong></h6>
                                <p class="text-muted text-sm">{{ $aktaInfo->akta_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Jenis Akta</strong></h6>
                                <p class="text-muted text-sm">{{ $aktaInfo->akta_type->type ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1"><strong>Notaris</strong></h6>
                                <p class="text-muted text-sm">{{ $aktaInfo->notaris->display_name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Form Input Nomor Akta Baru --}}
                @if($aktaInfo)
                <div class="card">
                    <div class="card-header pb-0 text-bold">Input Penomoran Akta</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('relaas-akta.store') }}">
                            @csrf
                            <input type="hidden" name="relaas_id" value="{{ $aktaInfo->id }}">

                            <div class="mb-3">
                                <label for="year" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="year" name="year"
                                    value="{{ now()->year }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="relaas_number" class="form-label text-sm">Nomor Akta</label>
                                <input type="text" class="form-control @error('relaas_number') is-invalid @enderror"
                                    id="relaas_number" name="relaas_number" value="{{ old('relaas_number') }}" required>
                                @error('relaas_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection