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
                    target="_blank" class="btn btn-light btn-sm d-inline-flex align-items-center gap-1">
                    <i class="fab fa-whatsapp text-success" style="font-size: 16px"></i>
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
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#biaya">
                        <i class="fas fa-money-bill me-1"></i> Biaya
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tracking">
                        <i class="fas fa-map-marker-alt me-1"></i> Tracking
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pajak">
                        <i class="fas fa-chart-line me-1"></i> Pajak
                    </button>
                </li>
            </ul>
        </div>

        {{-- Tab Content --}}
        <div class="card-body tab-content p-4">
            {{-- Info --}}
            <div class="tab-pane fade show active" id="info">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="fw-bold text-muted">NIK</span>
                        <span>{{ $client->nik ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="fw-bold text-muted">NPWP</span>
                        <span>{{ $client->npwp ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="fw-bold text-muted">Alamat</span>
                        <span>{{ $client->address ?? '-' }}</span>
                    </li>
                </ul>
            </div>

            {{-- Dokumen --}}
            <div class="tab-pane fade" id="dokumen">
                <div class="text-center text-muted py-5">
                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                    <p>Belum ada dokumen yang diunggah</p>
                </div>
            </div>

            {{-- Biaya --}}
            <div class="tab-pane fade" id="biaya">
                <div class="text-center text-muted py-5">
                    <i class="fas fa-money-bill fa-2x mb-2"></i>
                    <p>Informasi biaya layanan akan tampil di sini</p>
                </div>
            </div>

            {{-- Tracking --}}
            <div class="tab-pane fade" id="tracking">
                <div class="text-center text-muted py-5">
                    <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                    <p>Status & progres pengerjaan belum tersedia</p>
                </div>
            </div>

            {{-- Pajak --}}
            <div class="tab-pane fade" id="pajak">
                <div class="text-center text-muted py-5">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <p>Perhitungan pajak belum ditambahkan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection