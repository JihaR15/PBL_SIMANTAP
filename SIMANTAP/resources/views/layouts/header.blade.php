<header id="page-topbar">
    <div class="navbar-header bg-light text-dark">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

                <a href="{{ route('dashboard') }}" class="logo logo-light d-flex" style="font-size: 1.5rem;">
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

            {{-- <div class="dropdown d-inline-block d-lg-none ms-2">
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
            </div> --}}

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line text-dark"></i>
                    @if($unreadCount > 0)
                        <span class="noti-dot"></span>
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">

                    <div class="p-3 border-bottom">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifications ({{ $unreadCount }}) </h6>
                            </div>
                            {{-- <div class="col-auto">
                                <a href="{{ route('notifikasi.index') }}" class="small">View All</a>
                            </div> --}}
                        </div>
                    </div>

                    <div data-simplebar style="max-height: 230px;">
                        @forelse ($notifikasis as $notif)
                        @php
                            $statusVerif = $notif->laporan->status_verif ?? null;
                            $statusPerbaikan = $notif->laporan->perbaikan->status_perbaikan ?? null;
                            $userRole = auth()->user()->role->kode_role ?? null;
                            $laporanId = $notif->laporan_id ?? null;
                            $teknisiId = auth()->user()->teknisi->teknisi_id ?? null;
                            $perbaikanId = null;

                            if ($userRole === 'TKS' && $teknisiId) {
                                $perbaikan = \App\Models\PerbaikanModel::where('laporan_id', $laporanId)->where('teknisi_id', $teknisiId)->first();
                                if ($perbaikan) {
                                    $perbaikanId = $perbaikan->perbaikan_id;
                                }
                            }

                            $notifIsi = strtolower($notif->isi_notifikasi);
                            $isVerifikasiNotif = str_contains($notifIsi, 'verifikasi') || str_contains($notifIsi, 'menunggu verifikasi');
                            $isPerbaikanNotif = str_contains($notifIsi, 'perbaikan') || str_contains($notifIsi, 'sedang dalam proses') || str_contains($notifIsi, 'telah selesai');

                            if (in_array($userRole, ['ADM', 'SRN']) && $statusVerif === 'belum diverifikasi') {
                                $routeLink = route('verifikasi.index', ['open_id' => $laporanId]);
                            } elseif (in_array($userRole, ['ADM', 'SRN'])) {
                                $routeLink = route('riwayatverifikasi', ['open_id' => $laporanId]);
                            } elseif ($userRole === 'TKS' && $teknisiId) {
                                if ($statusPerbaikan === 'belum dikerjakan') {
                                    $routeLink = route('perbaikan.index', ['open_id' => $perbaikanId ?? $laporanId]);
                                } elseif ($statusPerbaikan === 'sedang diperbaiki') {
                                    $routeLink = route('dikerjakan', ['open_id' => $perbaikanId ?? $laporanId]);
                                } elseif ($statusPerbaikan === 'selesai') {
                                    $routeLink = route('riwayatperbaikan', ['open_id' => $perbaikanId ?? $laporanId]);
                                } else {
                                    $routeLink = route('perbaikan.index', ['open_id' => $perbaikanId ?? $laporanId]);
                                }
                            } elseif (in_array($userRole, ['MHS', 'DSN', 'TDK'])) {
                                if ($isPerbaikanNotif) {
                                    $routeLink = route('statusperbaikan', ['open_id' => $laporanId]);
                                } else {
                                    $routeLink = route('riwayatlaporan', ['open_id' => $laporanId]);
                                }
                            } else {
                                $routeLink = route('riwayatlaporan', ['open_id' => $laporanId]);
                            }
                        @endphp

                        <a href="{{ $routeLink }}" class="text-reset notification-item notif-link" data-id="{{ $notif->notifikasi_id }}">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h6 class="mb-1">
                                        dari {{ $notif->sender->role->nama_role ?? 'User' }}
                                    </h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $notif->isi_notifikasi }}</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> {{ $notif->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @if (!$notif->is_read)
                                    <span class="badge bg-primary align-self-center ms-2">New</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <p class="text-center p-3 mb-0">Tidak ada notifikasi baru.</p>
                    @endforelse
                    </div>

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
                <button type="button" class="btn header-item waves-effect ms-1 d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img id="header-profile" class="rounded-circle header-profile-user me-2"
                            src="{{ Auth::user()->foto_profile ? asset('images/' . Auth::user()->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}"
                            alt="Header Avatar">
                    <div class="d-none d-lg-block text-start lh-sm" >
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
                    <button onclick="modalAction('{{ url('profile') }}')" class="dropdown-item">
                        <i class="ri-user-line align-middle me-1"></i> Profile
                    </button>
                    <a class="dropdown-item text-danger" href="{{ url('logout') }}"><i
                            class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>
