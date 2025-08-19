@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Consultation'])
<div class="container">
    <div class="row mt-4 mx-4">
        <div class="card mb-4">
            <div class="card-header px-2 pb-0 d-flex justify-content-between align-items-center mb-1">
                <h4 class="mb-0">Konsultasi</h4>
            </div>
            <div class="row mt-3">
                {{-- <div class="mx-2 mb-3">
                    <h6 class="fw-medium">Pilih Layanan yang ingin ditambahkan ke dokumen</h6>
                </div> --}}
                @foreach ($clients as $client)
                <div class="col-md-4 mb-3">
                    <div class="card p-4">
                        <h5 class="text-capitalize">{{ $client->fullname }}</h5>
                        <h6 class="text-capitalize text-secondary">{{ $client->company_name }}</h6>
                        <a href="{{ route('consultation.getConsultationByClient', $client->id) }}"
                            class="btn btn-primary mt-2">Lihat</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection