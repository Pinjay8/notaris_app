@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Klien'])
<div class="row mt-4 mx-4 ">
    <div class="col-md-12">
        <div class="card mb-4 p-3 shadow-lg">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4 px-2 flex-wrap">
                <h6 class="mb-0">Klien</h6>
                <div class="d-flex gap-2 flex-wrap">
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
                    <div style="min-width: max-content;">
                        <div class="d-flex justify-content-end">
                            <form method="GET" action="{{ route('clients.index') }}"
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
                                    <th>
                                        Aksi
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
                                    <td class="text-center align-middle">

                                        @if($client->uuid != null)
                                        <button type="button" class="btn btn-dark btn-xs mb-0" data-bs-toggle="modal"
                                            data-bs-target="#qrModal{{ $client->id }}">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="qrModal{{ $client->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content p-3 text-center ">
                                                    <h5 class="modal-title w-100 text-center">QR Code Klien</h5>
                                                    <button type="button"
                                                        class="btn-close btn-close-white position-absolute end-0 me-4 p-2"
                                                        style="background-color: var(--bs-primary); border-radius: 50%;"
                                                        data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                    @php
                                                    $link = url("/clients/{$client->uuid}");
                                                    $dns2d = new \Milon\Barcode\DNS2D();

                                                    // true di sini artinya return base64 data langsung
                                                    $png = $dns2d->getBarcodePNG($link, 'QRCODE', 5, 5, [0,0,0], true);
                                                    @endphp
                                                    <img src="data:image/png;base64,{{ $png }}" alt="QR Code"
                                                        class="img-fluid w-50 mx-auto mt-3" />
                                                    {{-- Tampilkan link di bawah QR Code --}}
                                                    <h5 class="mt-3">Link Klien</h5>
                                                    <div class="input-group my-2" style="max-width: 600px;">

                                                        <input type="text" class="form-control" value="{{ $link }}"
                                                            readonly onclick="this.select()">
                                                        <button class="btn btn-info mb-0"
                                                            onclick="copyToClipboard('{{ $link }}')" title="Copy link">
                                                            <i class="fa-regular fa-clipboard fa-lg"></i>
                                                        </button>
                                                    </div>

                                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                                        <a href="data:image/png;base64,{{ $png }}"
                                                            download="qrcode-{{ $client->fullname }}.png"
                                                            class="btn btn-primary btn-sm">
                                                            Download
                                                        </a>
                                                        @php
                                                        // ubah no HP dari 08xxxx -> 628xxxx
                                                        $phone = !empty($client->phone) ? preg_replace('/^0/', '62',
                                                        $client->phone) : null;
                                                        @endphp

                                                        @if($phone)
                                                        <a href="https://wa.me/{{ $phone }}?text={{ urlencode('Halo ' . $client->fullname . ', silakan akses link berikut: ' . $link) }}"
                                                            target="_blank" class="btn btn-success btn-sm">
                                                            Share WhatsApp
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if($client->status == 'revisi')
                                        @php
                                        $encryptedClientId = encrypt($client->id); // Laravel encrypt helper
                                        $revisionLink = url("/client/{$encryptedClientId}");
                                        @endphp

                                        <button class="btn btn-xs btn-info mb-0"
                                            onclick="copyToClipboard('{{ $revisionLink }}')">
                                            <i class="fa fa-share-alt"></i>
                                        </button>

                                        @endif

                                        @if($client->status !== 'valid')
                                        <form action="{{ route('clients.markAsValid', $client->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-xs mb-0"><i
                                                    class="fa-solid fa-circle-check fa-3x"
                                                    style="font-size: 14px"></i></button>
                                        </form>
                                        @endif

                                        <a href="{{ route('clients.edit', $client->id) }}"
                                            class="btn btn-info btn-xs mb-0">
                                            <i class="fa-solid fa-pencil" style="font-size: 14px">
                                            </i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-xs mb-0" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $client->id }}">
                                            <i class="fas fa-trash"></i>
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