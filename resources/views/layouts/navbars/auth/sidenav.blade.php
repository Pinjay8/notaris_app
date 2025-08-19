<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}" target="_blank">
            <img src="./img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Notaris App</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-100" id="sidenav-collapse-main">
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
                    class="nav-link {{ Route::currentRouteName() == 'subscriptions' ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-event-fill text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Subscriptions</span>
                </a>
                <a href="{{ route('products.index') }}"
                    class="nav-link {{ Route::currentRouteName() == 'products' ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Layanan</span>
                </a>
                <a href="{{ route('documents.index') }}"
                    class="nav-link  {{ Route::currentRouteName() == 'documents' ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-folder-fill text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Dokumen</span>
                </a>
                <a href="{{ route('products.documents.selectProduct') }}"
                    class="nav-link {{ Route::currentRouteName() == 'product-documents' ? 'active' : '' }}">
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
                        <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Dokumen</span>
                </a>
                <a href="{{ route('management-document.index') }}"
                    class="nav-link {{ request()->is('warkah*') ? 'active' : '' }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                    </div>
                    <span class="nav-link-text ms-1 mt-2">Warkah</span>
                </a>

            </li>
            <li class="nav-item" class="nav-link {{ request()->is('warkah*') ? 'active' : '' }}">
                <a href="#tablePartijAkta" data-bs-toggle="collapse" class="mb-0">
                    <div class="d-flex align-items-center justify-content-between px-4 py-2">
                        <!-- Kiri -->
                        <div class="d-flex align-items-center">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
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
                                    <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Jenis Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta-transactions.index') }}"
                                class="nav-link {{ request()->is('akta-transactions*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Transaksi Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta-documents.index') }}"
                                class="nav-link {{ request()->is('akta-documents*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Dokumen Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta-parties.index') }}"
                                class="nav-link {{ request()->is('warkah*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Pihak Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta_number.index') }}"
                                class="nav-link {{ request()->is('warkah*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Penomoran Akta</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('akta-logs.index') }}"
                                class="nav-link {{ request()->is('warkah*') ? 'active' : '' }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-calendar-days text-dark text-sm opacity-10 pb-0"></i>
                                </div>
                                <span class="nav-link-text ms-1 mt-2">Logs Akta</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>