@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Klien'])
<div class="row mt-4 mx-4">
    <div class="col-md-12">
        <div class="card mb-4 p-3">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4 px-2 flex-wrap">
                <h6 class="mb-0">Klien</h6>
                <div class="d-flex gap-2 flex-wrap">
                    {{-- @php
                    $encryptedId = Crypt::encrypt(auth()->user()->notaris_id);
                    $shareUrl = route('client.public.create', ['notaris_id' => $encryptedId]);
                    @endphp
                    <button class="btn btn-outline-primary btn-sm mb-0" onclick="copyToClipboard('{{ $shareUrl }}')">
                        <i class="fas fa-link"></i> Salin Link Form Klien
                    </button> --}}
                    {{-- <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm mb-0">
                        + Tambah Klien
                    </a> --}}
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <div style="min-width: max-content;">
                        <div class="d-flex justify-content-end">
                            <form method="GET" action="{{ route('clients-info.index') }}"
                                class="d-flex flex-wrap gap-2 ms-auto mb-3 w-100 justify-content-end"
                                style="max-width: 500px;">

                                <input type="text" name="search" placeholder="Cari Nama, NIK/No KTP"
                                    value="{{ request('search') }}" class="form-control w-100 w-md-auto"
                                    style="flex: 1 1 auto;">

                                <select name="status" class="form-select w-100 w-md-auto" style="flex: 1 1 auto;">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="valid" {{ request('status')=='valid' ? 'selected' : '' }}>Valid
                                    </option>
                                    <option value="revisi" {{ request('status')=='revisi' ? 'selected' : '' }}>Revisi
                                    </option>
                                </select>

                                <button type="submit" id="searchBtn"
                                    class="btn btn-primary btn-sm mb-0 d-flex align-items-center justify-content-center"
                                    style="width: 90px; height: 38px;">
                                    <span id="searchBtnText">Cari</span>
                                    <div id="searchSpinner"
                                        class="spinner-border spinner-border-sm text-light ms-2 d-none" role="status"
                                        aria-hidden="true"></div>
                                </button>
                            </form>
                        </div>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>
                                        Id
                                    </th>
                                    {{-- <th>
                                        UUID
                                    </th> --}}
                                    <th>
                                        Nama Klien
                                    </th>
                                    <th>
                                        NIK
                                    </th>
                                    <th>
                                        NPWP
                                    </th>
                                    <th>
                                        Nama Perusahaan
                                    </th>
                                    <th>
                                        Alamat
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                <tr class="text-sm mb-0 text-center">
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    {{-- <td>
                                        <p class="text-sm mb-0 text-center">{{ $client->uuid }}</p>
                                    </td> --}}
                                    <td>
                                        {{
                                        $client->fullname
                                        }}

                                    </td>
                                    <td>
                                        {{
                                        $client->nik
                                        }}

                                    </td>
                                    <td>
                                        {{
                                        $client->npwp
                                        }}
                                    </td>
                                    <td>
                                        {{
                                        $client->company_name
                                        }}
                                    </td>
                                    <td>
                                        {{
                                        $client->address
                                        }}
                                    </td>
                                    <td>
                                        <span class="badge
                                        bg-{{
                                          $client->status == 'valid' ? 'success' :
                                          ($client->status == 'revisi' ? 'warning' : 'secondary')
                                        }}">
                                            {{ ucfirst($client->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data klien.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3 px-4">
                            {{ $clients->withQueryString()->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection