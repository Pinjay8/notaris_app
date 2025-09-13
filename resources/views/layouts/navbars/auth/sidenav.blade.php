<aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 h-100"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-2 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}" target="_blank">
            <img src="./img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-center">Notaris App</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse h-100 " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{  Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                </div>
                <h6 class=" ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-1">Menu</h6>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile') }}"
                    class="nav-link {{  Route::currentRouteName() == 'profile' ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
                <a href="{{ route('subscriptions') }}"
                    class="nav-link {{ request()->is('subscriptions*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-event-fill text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Subscriptions</span>
                </a>
                <a href="{{ route('products.index') }}"
                    class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Layanan</span>
                </a>
                <a href="{{ route('documents.index') }}"
                    class="nav-link {{ request()->is('documents*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-folder-fill text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Dokumen</span>
                </a>
                <a href="{{ route('products.documents.selectProduct') }}"
                    class="nav-link {{ request()->is('product-documents*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-plus-fill text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Dokumen Layanan</span>
                </a>


            </li>
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                </div>
                <h6 class=" ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-1">CS</h6>
            </li>
            <li class="nav-item">
                <a href="{{ route('clients.index') }}"
                    class="nav-link {{ Route::currentRouteName() == 'clients' ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-add text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Klien</span>

                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('consultation.index') }}"
                    class="nav-link {{ request()->is('consultation*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-headset text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Konsultasi Klien</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('management-process.index') }}"
                    class="nav-link {{ request()->is('management-process*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Proses Pengurusan</span>
                </a>
            </li>

            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                </div>
                <h6 class=" ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-1">Back Office</h6>
            </li>
            <li class="nav-item">
                <a href="{{ route('management-document.index') }}"
                    class="nav-link {{ request()->is('mangement-document*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-folder-fill text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Dokumen</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('warkah.index') }}" class="nav-link {{ request()->is('warkah*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-folder-fill text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Warkah</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#tablePartijAkta" data-bs-toggle="collapse" class="mb-0">
                    <div class="d-flex align-items-center justify-content-between px-4 py-2">
                        <!-- Kiri -->
                        <div class="d-flex align-items-center">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-handshake text-dark text-sm opacity-10 pb-0"></i>
                            </div>
                            <span class="nav-link-text text-sm">Partij Akta</span>
                        </div>
                        <!-- Kanan -->
                        <i class="bi bi-caret-down-fill"></i>
                    </div>
                </a>
                <div class="collapse" id="tablePartijAkta">
                    <ul class="nav nav-collapse mb-0 pb-0">
                        <li>
                            <a href="{{ route('akta-types.index') }}"
                                class="nav-link {{ request()->is('akta-types*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-layer-group text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Jenis Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta-transactions.index') }}"
                                class="nav-link {{ request()->is('akta-transactions*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-exchange-alt text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Transaksi Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta-documents.index') }}"
                                class="nav-link {{ request()->is('akta-documents*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-file-contract text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Dokumen Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta-parties.index') }}"
                                class="nav-link {{ request()->is('akta-parties*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user-group text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Pihak Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta_number.index') }}"
                                class="nav-link {{ request()->is('akta_number*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-hashtag text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Penomoran Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta-logs.index') }}"
                                class="nav-link {{ request()->is('akta-logs*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-clock-rotate-left text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Logs Akta</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#collapseRelaasAkta" role="button" aria-expanded="false"
                    aria-controls="collapseRelaasAkta">
                    <div class="d-flex align-items-center justify-content-between px-4 py-2">
                        <!-- Kiri -->
                        <div class="d-flex align-items-center">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-scroll text-dark text-sm opacity-10 pb-0"></i>
                            </div>
                            <span class="nav-link-text text-sm">Relaas Akta</span>
                        </div>
                        <!-- Kanan -->
                        <i class="bi bi-caret-down-fill"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseRelaasAkta">
                    <ul class="nav nav-collapse mb-0 pb-0">
                        <li>
                            <a href="{{ route('relaas-aktas.index') }}"
                                class="nav-link {{ request()->is('relaas-aktas*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-exchange-alt text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Transaksi Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('relaas-parties.index') }}"
                                class="nav-link {{ request()->is('relaas-parties*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user-group text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Pihak Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('relaas-documents.index') }}"
                                class="nav-link {{ request()->is('relaas-document*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-file-contract text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Dokumen Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('relaas_akta.indexNumber') }}"
                                class="nav-link {{ request()->is('relaas_akta*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-hashtag text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Penomoran Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('relaas-logs.index') }}"
                                class="nav-link {{ request()->is('relaas-logs*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-clock-rotate-left text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Logs Akta</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('notary-legalisasi.index') }}"
                    class="nav-link {{ request()->is('notary-legalisasi*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-stamp text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Legalisasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('notary-waarmerking.index') }}"
                    class="nav-link {{ request()->is('notary-waarmerking*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-file-signature text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Waarmarking</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('laporan-akta.index') }}"
                    class="nav-link {{ request()->is('laporan-akta*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-chart-bar text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Laporan Akta</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('notary-letters.index') }}"
                    class="nav-link {{ request()->is('notary-letters*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-envelope-open-text text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Surat Keluar</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#collapsePic" role="button" aria-expanded="false"
                    aria-controls="collapsePic">
                    <div class="d-flex align-items-center justify-content-between px-4 py-2">
                        <!-- Kiri -->
                        <div class="d-flex align-items-center">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-user-tie text-dark text-sm opacity-10 pb-0"></i>
                            </div>
                            <span class="nav-link-text text-sm">PIC</span>
                        </div>
                        <!-- Kanan -->
                        <i class="bi bi-caret-down-fill"></i>
                    </div>
                </a>

                <div class="collapse" id="collapsePic">
                    <ul class="nav nav-collapse mb-0 pb-0">
                        <li>
                            <a href="{{ route('pic_staff.index') }}"
                                class="nav-link {{ request()->is('pic_staff*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-users-gear text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Staff</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pic_documents.index') }}"
                                class="nav-link {{ request()->is('pic_documents*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-file-lines text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Dokumen</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pic_process.index') }}"
                                class="nav-link {{ request()->is('pic_process*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-gears text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Proses Pengurusan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pic_handovers.index') }}"
                                class="nav-link {{ request()->is('pic_handovers*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-envelope-open-text text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Surat Terima Dokumen</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#collapseBiaya" role="button" aria-expanded="false"
                    aria-controls="collapseBiaya">
                    <div class="d-flex align-items-center justify-content-between px-4 py-2">
                        <!-- Kiri -->
                        <div class="d-flex align-items-center">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-sack-dollar text-dark text-sm opacity-10 pb-0"></i>
                            </div>
                            <span class="nav-link-text text-sm">Biaya</span>
                        </div>
                        <!-- Kanan -->
                        <i class="bi bi-caret-down-fill"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseBiaya">
                    <ul class="nav nav-collapse mb-0 pb-0">
                        <li>
                            <a href="{{ route('notary_costs.index') }}"
                                class="nav-link {{ request()->is('notary_costs*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-file-invoice-dollar text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Total Biaya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('notary_payments.index') }}"
                                class="nav-link {{ request()->is('notary_payments*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-credit-card text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Pembayaran</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </li>
            <li class="nav-item">
                <a href="{{ route('report-payment.index') }}"
                    class="nav-link {{ request()->is('report-payment*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-envelope-open-text text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Laporan Pembayaran</span>
                </a>
            </li>
        </ul>
    </div>
</aside>