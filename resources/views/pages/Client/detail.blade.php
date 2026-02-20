@extends('layouts.app')

@section('content')
    <div class="position-absolute w-100 min-height-300 top-0"
        style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
        <span class="mask bg-primary opacity-6"></span>
    </div>

    <div class="container mt-4">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
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

                    @if ($phone)
                        <a href="https://wa.me/{{ $phone }}?text={{ urlencode('Halo ' . $client->fullname . ', berikut link Anda: ' . $link) }}"
                            target="_blank" class="btn btn-success btn-md d-inline-flex align-items-center gap-2 mb-0">
                            <i class="fab fa-whatsapp fa-lg"></i>
                            <span>Hubungi via WA</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Nav Tabs --}}
            @php
                $tabs = [
                    'info' => ['label' => 'Info', 'icon' => 'id-card'],
                    'dokumen' => ['label' => 'Dokumen', 'icon' => 'file-alt'],
                    'tracking' => ['label' => 'Tracking', 'icon' => 'map-marker-alt'],
                    'biaya' => ['label' => 'Biaya', 'icon' => 'money-bill'],
                    'pajak' => ['label' => 'Pembayaran', 'icon' => 'chart-line'],
                ];
                $activeTab = request('tab') ?? 'info';
            @endphp

            <ul class="nav nav-pills gap-2 mb-3 bg-white mt-3 ms-3" id="info-tab" role="tablist">
                @foreach ($tabs as $key => $tab)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == $key ? 'active' : '' }} rounded-pill" data-bs-toggle="tab"
                            data-bs-target="#{{ $key }}" type="button" id="{{ $key }}-tab">
                            <i class="fas fa-{{ $tab['icon'] }} me-1"></i> {{ $tab['label'] }}
                        </button>
                    </li>
                @endforeach
            </ul>

            {{-- Tab Content --}}
            <div class="card-body tab-content p-4">
                {{-- Info Tab --}}
                <div class="tab-pane fade {{ $activeTab == 'info' ? 'show active' : '' }}" id="info">
                    <div class="row g-3">
                        <h5 class="fw-bold fs-5 text-primary mb-3 border-bottom pb-2">
                            <i class="fa-solid fa-user me-2"></i> Informasi Pribadi
                        </h5>

                        @php
                            $infoFields = [
                                ['label' => 'NIK', 'icon' => 'fa-id-card', 'value' => $client->nik ?? '-'],
                                ['label' => 'NPWP', 'icon' => 'fa-building', 'value' => $client->npwp ?? '-'],
                                [
                                    'label' => 'Alamat',
                                    'icon' => 'fa-location-dot',
                                    'value' =>
                                        ($client->address ?? '-') .
                                        ', ' .
                                        ($client->city ?? '') .
                                        ', ' .
                                        ($client->province ?? '') .
                                        ' ' .
                                        ($client->postcode ?? ''),
                                ],
                                ['label' => 'Telepon', 'icon' => 'fa-phone', 'value' => $client->phone ?? '-'],
                                ['label' => 'Email', 'icon' => 'fa-envelope', 'value' => $client->email ?? '-'],
                                [
                                    'label' => 'Gender',
                                    'icon' => 'fa-venus-mars',
                                    'value' => ucfirst($client->gender) ?? '-',
                                ],
                                ['label' => 'Pekerjaan', 'icon' => 'fa-briefcase', 'value' => $client->job ?? '-'],
                                [
                                    'label' => 'Status',
                                    'icon' => 'fa-user-check',
                                    'value' => ucfirst($client->marital_status) ?? '-',
                                ],
                                [
                                    'label' => 'Tipe',
                                    'icon' => 'fa-building-user',
                                    'value' => $client->type == 'company' ? 'Perusahaan' : 'Pribadi',
                                ],
                            ];
                        @endphp

                        @foreach ($infoFields as $field)
                            <div class="col-md-6">
                                <p class="mb-1 fw-bold text-black"><i class="fa-solid {{ $field['icon'] }} me-1"></i>
                                    {{ $field['label'] }}</p>
                                <p class="fs-6 fw-medium">{{ $field['value'] }}</p>
                            </div>
                        @endforeach

                        @if ($client->type == 'company')
                            <div class="col-md-6">
                                <p class="mb-1 fw-bold text-black"><i class="fa-solid fa-industry me-1"></i> Perusahaan</p>
                                <p class="fs-6 fw-medium">{{ $client->company_name ?? '-' }}</p>
                            </div>
                        @endif

                        <div class="col-md-12">
                            <p class="mb-1 fw-bold text-black"><i class="fa-solid fa-circle-info me-1"></i> Catatan</p>
                            <p class="fs-6 fw-medium">{{ $client->note ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Dokumen Tab --}}
                <div class="tab-pane fade {{ $activeTab == 'dokumen' ? 'show active' : '' }}" id="dokumen">
                    @include('pages.Client.partials.tab-dokumen', [
                        'documents' => $documents,
                        'clientDocuments' => $clientDocuments,
                        'client' => $client,
                    ])
                </div>

                {{-- Tracking Tab --}}
                <div class="tab-pane fade {{ $activeTab == 'tracking' ? 'show active' : '' }}" id="tracking">
                    <form action="{{ route('clients.showByUuid', $client->uuid) }}" method="GET" class="mb-3"
                        id="trackingForm">
                        <input type="hidden" name="tab" value="tracking" id="hiddenTab">
                        <div class="input-group">
                            <input type="text" name="client_code" value="{{ request('client_code') }}"
                                class="form-control form-control-md" placeholder="Masukkan Kode Klien" required>
                            <button type="submit" class="btn btn-primary mb-0 btn-sm">Cari</button>
                        </div>
                    </form>

                    @if (request()->filled('client_code'))
                        @if ($picDocuments->count() > 0)
                            @include('pages.Client.partials.tab-tracking', [
                                'picDocuments' => $picDocuments,
                            ])
                        @else
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                                <p>Data tidak ditemukan untuk Kode Klien ini.</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                            <p>Masukkan Kode Klien untuk melihat status</p>
                        </div>
                    @endif
                </div>

                {{-- Biaya Tab --}}
                <div class="tab-pane fade {{ $activeTab == 'biaya' ? 'show active' : '' }}" id="biaya">
                    @include('pages.Client.partials.tab-biaya', ['notaryCost' => $notaryCost])
                </div>

                {{-- Pajak Tab --}}
                <div class="tab-pane fade {{ $activeTab == 'pajak' ? 'show active' : '' }}" id="pajak">
                    @include('pages.Client.partials.tab-pajak', [
                        'notaryPayment' => $notaryPayment,
                        'notaryCost' => $notaryCost,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
            const hiddenTab = document.getElementById('hiddenTab');

            // Klik tab → update URL & hidden input
            tabButtons.forEach(tab => {
                tab.addEventListener("shown.bs.tab", function(e) {
                    const tabId = e.target.getAttribute("data-bs-target").replace('#', '');
                    const url = new URL(window.location.href);
                    url.searchParams.set("tab", tabId);
                    window.history.replaceState(null, null, url);
                    if (hiddenTab) hiddenTab.value = tabId;
                });
            });

            // Set active tab dari URL saat reload
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'info';
            const tabToShow = document.querySelector(`#${activeTab}-tab`);
            if (tabToShow) {
                new bootstrap.Tab(tabToShow).show();
            }
        });
    </script>
@endpush
