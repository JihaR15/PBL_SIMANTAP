<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled mm-show" id="side-menu">
                {{-- <li class="menu-title">Menu</li> --}}

                <li class="{{ $activeMenu == 'dashboard' ? 'mm-active' : '' }}">
                    <a href="{{ url('/dashboard') }}" class="waves-effect " >
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(auth()->check() && auth()->user()->role->kode_role === 'ADM')
                    <li class="menu-title">Pengguna</li>

                    <li>
                        <a href="{{ url('/role') }}" class="waves-effect">
                            <i class="ri-shield-user-line"></i>
                            <span>Role Pengguna</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/user') }}" class="waves-effect">
                            <i class="ri-team-line"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/jenisteknisi') }}" class="waves-effect">
                            <i class="ri-user-settings-line"></i>
                            <span>Jenis Teknisi</span>
                        </a>
                    </li>

                    <li class="menu-title">Master Data</li>

                    <li>
                        <a href="{{ url('/unit') }}" class="waves-effect">
                            <i class="ri-building-2-line"></i>
                            <span>Data Gedung & Area</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/jenisbarang') }}" class="waves-effect">
                            <i class="ri-airplay-line"></i>
                            <span>Data Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/lokasibarang') }}" class="waves-effect">
                            <i class="ri-building-line"></i>
                            <span>Data Fasilitas Ruangan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/bobot') }}" class="waves-effect">
                            <i class="ri-building-line"></i>
                            <span>Data Prioritas Perbaikan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/periode') }}" class="waves-effect">
                            <i class="ri-calendar-line"></i>
                            <span>Data Periode</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/kategoriKerusakan') }}" class="waves-effect">
                            <i class="ri-tools-line"></i>
                            <span>Data Kategori Kerusakan</span>
                        </a>
                    </li>
                @endif

                {{-- @if(auth()->check() && auth()->user()->role->kode_role === 'SRN') --}}
                @if(auth()->check() && in_array(auth()->user()->role->kode_role, ['ADM','SRN']))

                <li class="menu-title">LAYANAN PELAPORAN</li>
                <li>
                    <a href="{{ url('/verifikasi') }}" class="waves-effect">
                        <i class="ri-checkbox-circle-line"></i>
                        <span>Verifikasi & Prioritas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/riwayatverifikasi') }}" class="waves-effect">
                        <i class="ri-history-line"></i>
                        <span>Riwayat Verifikasi</span>
                    </a>
                </li>
                @endif


                @if(auth()->check() && in_array(auth()->user()->role->kode_role, ['MHS', 'DSN', 'TDK']))
                    <li class="menu-title">Laporan</li>

                    <li>
                        <a href="{{ url('/laporan') }}" class="waves-effect">
                            <i class="ri-file-paper-2-line"></i>
                            <span>Buat Laporan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/riwayatlaporan') }}" class="waves-effect">
                            <i class="ri-history-line"></i>
                            <span>Riwayat Laporan</span>
                        </a>
                    </li>
                    
                    <li class="menu-title">Status</li>

                    <li>
                        <a href="{{ url('/statusperbaikan') }}" class="waves-effect">
                            <i class="ri-search-eye-line"></i>
                            <span>Status Perbaikan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/feedback') }}" class="waves-effect">
                            <i class="ri-star-smile-line"></i>
                            <span>Feedback Perbaikan</span>
                        </a>
                    </li>
                @endif

                @if(auth()->check() && auth()->user()->role->kode_role === 'TKS')
                    <li class="menu-title">Perbaikan</li>

                    <li>
                        <a href="{{ url('/perbaikan') }}" class="waves-effect">
                            <i class="ri-inbox-line"></i>
                            <span>Tugas Perbaikan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/dikerjakan') }}" class="waves-effect">
                            <i class="ri-tools-line"></i>
                            <span>Sedang Dikerjakan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/riwayatperbaikan') }}" class="waves-effect">
                            <i class="ri-history-line"></i>
                            <span>Riwayat Perbaikan</span>
                        </a>
                    </li>
                @endif

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Riwayat Laporan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html">Starter Page</a></li>
                        <li><a href="pages-timeline.html">Timeline</a></li>
                        <li><a href="pages-directory.html">Directory</a></li>
                        <li><a href="pages-invoice.html">Invoice</a></li>
                        <li><a href="pages-404.html">Error 404</a></li>
                        <li><a href="pages-500.html">Error 500</a></li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>