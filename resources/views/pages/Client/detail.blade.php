@extends('layouts.app')

@section('content')
{{-- @include('layouts.navbars.auth.topnav', ['title' => 'Detail Klien']) --}}

<div class="container mt-4">
    <h4>{{ $client->fullname }}</h4>
    <ul class="nav nav-tabs mt-3" id="clientTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info">Info Client</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dokumen">Dokumen</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#biaya">Biaya</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tracking">Tracking</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pajak">Perhitungan Pajak</button>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="info">
            <p>NIK: {{ $client->nik }}</p>
            <p>NPWP: {{ $client->npwp }}</p>
            <p>Alamat: {{ $client->address }}</p>
        </div>
        <div class="tab-pane fade" id="dokumen">
            <p>📄 Daftar dokumen klien di sini...</p>
        </div>
        <div class="tab-pane fade" id="biaya">
            <p>💰 Informasi biaya layanan...</p>
        </div>
        <div class="tab-pane fade" id="tracking">
            <p>📍 Status & progres pengerjaan...</p>
        </div>
        <div class="tab-pane fade" id="pajak">
            <p>📊 Perhitungan pajak...</p>
        </div>
    </div>
</div>
@endsection