<header id="page-topbar">
    <div class="navbar-header bg-light text-dark">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

                <a href="index.html" class="logo logo-light d-flex" style="font-size: 1.5rem;">
                    <span class="logo-sm">
                        <div class="d-flex align-items-center">
                            <i class="ri-tools-line me-2 text-dark" style="font-size: 2rem;"></i>
                        </div>
                    </span>
                    <span class="logo-lg">
                        <div class="d-flex align-items-center">
                            <i class="ri-tools-line me-2 text-dark" style="font-size: 2rem;"></i>
                            <span class="logo-text fw-bold text-dark" style="font-size: 1.5rem;">SIMANTAP</span>
                        </div>
                    </span>
                </a>
            </div>

            {{-- <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <i class="ri-shield-user-line me-2 text-dark"></i>
                    <span class="logo-text fw-bold text-dark">SIMANTAP</span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <i class="ri-shield-user-line me-2 text-light"></i>
                    <span class="logo-text fw-bold text-light">SIMANTAP</span>
                </a>
            </div> --}}

            {{-- <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="logo-light" height="20">
                    </span>
                </a>
            </div> --}}

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle text-dark"></i>
            </button>

            <!-- App Search-->
            {{-- <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="ri-search-line"></span>
                </div>
            </form> --}}

        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-search-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="ri-search-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line text-dark"></i>
                    <span class="noti-dot"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small"> View All</a>
                            </div>
                        </div>
                    </div>

                    <div data-simplebar style="max-height: 230px;">
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="assets/images/users/avatar-4.jpg" class="me-3 rounded-circle avatar-xs"
                                    alt="user-pic">
                                <div class="flex-1">
                                    <h6 class="mb-1">Salena Layfield</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- View More --}}
                    {{-- <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                            </a>
                        </div>
                    </div> --}}
                </div>

            </div>

            <div class="d-flex align-items-center">
                <!-- Light/Dark Mode Toggle Button -->
                <button type="button" class="btn header-item noti-icon waves-effect btn-light-dark-toggle"
                    id="theme-toggle">
                    <i class="ri-sun-line text-dark" id="theme-icon"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block user-dropdown ">
                <button type="button" class="btn header-item waves-effect ms-2 d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user me-2" src="assets/images/users/avatar-1.jpg"
                        alt="Header Avatar" height="32">
                    <div class="d-none d-xl-block text-start" style="line-height: 1;">
                        <span class="d-block fw-bold text-dark" title="{{ Auth::user()->name }}">
                            {{ Str::limit(Auth::user()->name, 15, '...') }}
                        </span>
                        <small class="text-muted">
                            {{ Auth::user()->role->nama_role }}
                            @if (Auth::user()->role->nama_role === 'Teknisi')
                                ({{ Auth::user()->teknisi->jenis_teknisi->nama_jenis_teknisi }})
                            @endif
                        </small>
                    </div>
                    <i class="mdi mdi-chevron-down ms-2 text-dark"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item text-danger" href="{{ url('logout') }}"><i
                            class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>


            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line text-dark"></i>
                </button>
            </div>

        </div>
    </div>
</header>