@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Konsultasi'])
<div class="container p-0">
    <div class="row mt-4">
        <div class="card mb-4 shadow-sm border-0 rounded-3">
            <div class="card-header px-3 pb-2 d-flex justify-content-between align-items-center bg-white border-0">
                <h4 class="mb-lg-1 fw-bold">Konsultasi</h4>
                {{-- search --}}
                <div class="w-md-25">
                    <form method="GET" action="{{ route('consultation.index') }}">
                        <div class="input-group mb-3">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari nama klien...">
                            <button class="btn btn-primary mb-0" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3 px-3 pb-3">
                @forelse ($clients as $client)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 rounded-3 hover-card">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width:60px; height:60px; font-size:20px; font-weight:600;">
                                {{ strtoupper(substr($client->fullname, 0, 1)) }}
                            </div>
                            <h5 class="fw-semibold mb-1 text-capitalize">{{ $client->fullname }}</h5>
                            <h6 class="text-muted mb-3 text-capitalize">{{ $client->company_name }}</h6>
                            <a href="{{ route('consultation.getConsultationByClient', $client->id) }}"
                                class="btn btn-outline-primary w-100 rounded-pill">Lihat Konsultasi</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted py-5">
                    <p class="mb-0">Belum ada data klien untuk konsultasi.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection