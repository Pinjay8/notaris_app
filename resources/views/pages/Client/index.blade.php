@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Layanan'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4 p-3">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4 px-2">
                <h6 class="mb-0">Klien</h6>
                <div class="d-flex gap-2">
                    @php
                    $encryptedId = Crypt::encrypt(auth()->user()->notaris_id);
                    $shareUrl = route('client.public.create', ['notaris_id' => $encryptedId]);
                    @endphp
                    <button class="btn btn-outline-primary btn-sm mb-0" onclick="copyToClipboard('{{ $shareUrl }}')">
                        <i class="fas fa-link"></i> Salin Link Form Klien
                    </button>
                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm mb-0">
                        + Tambah Klien
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <form method="GET" action="{{ route('clients.index') }}" class="d-flex flex-wrap gap-2 ms-auto mb-3"
                        style="max-width: 100%;">

                        <input type="text" name="search" placeholder="Cari Nama, NIK/No KTP"
                            value="{{ request('search') }}" class="form-control w-100 w-md-auto"
                            style="flex: 1 1 auto;">

                        <select name="status" class="form-select w-100 w-md-auto" style="flex: 1 1 auto;">
                            <option value="" hidden>Semua Status</option>
                            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="valid" {{ request('status')=='valid' ? 'selected' : '' }}>Valid</option>
                            <option value="revisi" {{ request('status')=='revisi' ? 'selected' : '' }}>Revisi</option>
                        </select>

                        <button type="submit" id="searchBtn"
                            class="btn btn-primary btn-sm mb-0 d-flex align-items-center justify-content-center"
                            style="width: 90px; height: 38px;">
                            <span id="searchBtnText">Cari</span>
                            <div id="searchSpinner" class="spinner-border spinner-border-sm text-light ms-2 d-none"
                                role="status" aria-hidden="true"></div>
                        </button>
                    </form>
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>
                                    Id
                                </th>
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
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $client)
                            <tr>
                                <td>
                                    <p class="text-sm mb-0 text-center">{{ $loop->iteration }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center"> {{
                                        $client->fullname
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $client->nik
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $client->npwp
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $client->company_name
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $client->address
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <span
                                        class="badge text-center d-block mx-auto bg-{{ $client->status == 'valid' ? 'success' : ($client->status == 'revisi' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($client->status) }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                    {{-- <form action="{{ route('products.deactivate', $product->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning btn-sm mb-0">Nonaktifkan</button>
                                    </form> --}}
                                    <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $client->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                    @include('pages.Client.modal.index')
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
@endsection

@push('js')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                if (window.notyf) {
                    window.notyf.success('Link berhasil disalin ke clipboard!');
                } else {
                    alert('Link berhasil disalin ke clipboard!');
                }
            })
            .catch(() => {
                if (window.notyf) {
                    window.notyf.error('Gagal menyalin link.');
                } else {
                    alert('Gagal menyalin link.');
                }
            });
    }
</script>
@endpush