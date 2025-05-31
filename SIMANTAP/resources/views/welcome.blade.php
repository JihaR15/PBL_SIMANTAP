@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    @include('layouts.breadcrumb')
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <h3 class="mb-1">Selamat datang, {{ Auth::user()->name }}!</h3>
                            <p class="mt-2 mb-0">
                                @if(Auth::user()->role->kode_role == 'ADM')
                                    Anda login sebagai <strong>Admin</strong>. Silakan gunakan menu di sebelah kiri untuk
                                    mengelola sistem dan pengguna.
                                @elseif(Auth::user()->role->kode_role == 'SRN')
                                    Anda login sebagai <strong>Sarpras</strong>. Silakan gunakan menu di sebelah kiri untuk
                                    mengelola sarana dan prasarana.
                                @elseif(Auth::user()->role->kode_role == 'TKS')
                                    Anda login sebagai <strong>Teknisi</strong>. Silakan gunakan menu di sebelah kiri untuk
                                    melihat dan menangani laporan.
                                @else
                                    Ini adalah tampilan awal dari pelapor. Silakan gunakan menu di sebelah kiri untuk mengakses
                                    fitur-fitur yang tersedia.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                {{-- @if(Auth::user()->role->kode_role == 'ADM') --}}
                @if(auth()->check() && in_array(auth()->user()->role->kode_role, ['ADM', 'SRN']))
                    @if(Auth::user()->role->kode_role == 'ADM')
                        <div class="col-md-4">
                            <div class="card shadow-sm rounded-lg">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total User</p>
                                            <h4 class="mb-2">{{ $userCount }}</h4>
                                            <p class="text-muted mb-0">
                                                <span class="text-success fw-bold font-size-12 me-2">
                                                    <i class="ri-user-3-line me-1 align-middle"></i>
                                                    {{ $user::latest()->first()?->created_at->diffForHumans() ?? '-' }}
                                                </span>
                                                Pengguna terbaru terdaftar
                                            </p>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                <i class="ri-user-3-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm rounded-lg">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Gedung</p>
                                            <h4 class="mb-2">{{ $unitCount - 1 }}</h4>
                                            <p class="text-muted mb-0">
                                                <span class="text-success fw-bold font-size-12 me-2">
                                                    <i class="ri-building-line me-1 align-middle"></i>
                                                    {{ $unitTerbaru?->created_at->diffForHumans() ?? '-' }}
                                                </span>
                                                Gedung terbaru terdaftar
                                            </p>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-info rounded-3">
                                                <i class="ri-building-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm rounded-lg">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Tempat & Ruangan</p>
                                            <h4 class="mb-2">{{ $tempatCount }}</h4>
                                            <p class="text-muted mb-0">
                                                <span class="text-success fw-bold font-size-12 me-2">
                                                    <i class="ri-map-pin-line me-1 align-middle"></i>
                                                    {{ $tempatTerbaru?->created_at->diffForHumans() ?? '-' }}
                                                </span>
                                                Tempat terbaru terdaftar
                                            </p>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-info rounded-3">
                                                <i class="ri-map-pin-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-4">
                        <div class="card shadow-sm rounded-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Total Teknisi</p>
                                        <h4 class="mb-2">{{ $teknisiCount }}</h4>
                                        <p class="text-muted mb-0">
                                            <span class="text-success fw-bold font-size-12 me-2">
                                                <i class="ri-user-settings-line me-1 align-middle"></i>
                                                {{ $teknisiTerbaru?->created_at->diffForHumans() ?? '-' }}
                                            </span>
                                            Teknisi terbaru terdaftar
                                        </p>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-secondary rounded-3">
                                            <i class="ri-user-settings-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm rounded-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Total Laporan Masuk</p>
                                        <h4 class="mb-2">{{ $laporan }}</h4>
                                        <p class="text-muted mb-0">
                                            <span class="text-success fw-bold font-size-12 me-2">
                                                <i class="ri-file-list-3-line me-1 align-middle"></i>
                                                {{ $laporanTerbaru?->created_at->diffForHumans() ?? '-' }}
                                            </span>
                                            Laporan terbaru masuk
                                        </p>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-success rounded-3">
                                            <i class="ri-file-list-3-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm rounded-lg">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Total Perbaikan</p>
                                        <h4 class="mb-2">{{ $perbaikan }}</h4>
                                        <p class="text-muted mb-0">
                                            <span class="text-success fw-bold font-size-12 me-2">
                                                <i class="ri-tools-line me-1 align-middle"></i>
                                                {{ $perbaikanTerbaru?->created_at->diffForHumans() ?? '-' }}
                                            </span>
                                            Perbaikan terbaru dilakukan
                                        </p>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-warning rounded-3">
                                            <i class="ri-tools-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(Auth::user()->role->kode_role == 'ADM' || Auth::user()->role->kode_role == 'SRN')
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <form id="periodeForm" method="GET">
                                        <select class="form-select shadow-none form-select-sm" name="tahun" id="periodeSelect">
                                            <option value="all" {{ $tahunDipilih == 'all' ? 'selected' : '' }}>Semua</option>
                                            @foreach($periodeTahun as $tahun)
                                                <option value="{{ $tahun }}" {{ $tahunDipilih == $tahun ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <h4 class="card-title mb-4">Data Laporan</h4>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="text-center mt-4">
                                            <h5 id="laporan-total">{{ $laporanCount }}</h5>
                                            <p class="mb-2 text-truncate">Total</p>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-center mt-4">
                                            <h5 id="laporan-belum">{{ $laporanBelumDiverifikasiCount }}</h5>
                                            <p class="mb-2 text-truncate">Belum Diverifikasi</p>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-center mt-4">
                                            <h5 id="laporan-verif">{{ $laporanDiverifikasiCount }}</h5>
                                            <p class="mb-2 text-truncate">Diverifikasi</p>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-center mt-4">
                                            <h5 id="laporan-tolak">{{ $laporanDitolakCount }}</h5>
                                            <p class="mb-2 text-truncate">Ditolak</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div id="laporanChart"></div>

                            </div>
                        </div><!-- end card -->
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <form id="periodeForm" method="GET">
                                        <select class="form-select shadow-none form-select-sm" name="tahun" id="periodeSelect2">
                                            <option value="all" {{ $tahunDipilih == 'all' ? 'selected' : '' }}>Semua</option>
                                            @foreach($periodeTahun as $tahun)
                                                <option value="{{ $tahun }}" {{ $tahunDipilih == $tahun ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <h4 class="card-title mb-4">Data Perbaikan</h4>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="text-center mt-4">
                                            <h5 id="perbaikan-total">{{ $perbaikanCount }}</h5>
                                            <p class="mb-2 text-truncate">Total</p>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-center mt-4">
                                            <h5 id="perbaikan-belum">{{ $perbaikanBelumCount }}</h5>
                                            <p class="mb-2 text-truncate">Belum</p>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-center mt-4">
                                            <h5 id="perbaikan-berjalan">{{ $perbaikanBerjalanCount }}</h5>
                                            <p class="mb-2 text-truncate">Berjalan</p>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-center mt-4">
                                            <h5 id="perbaikan-selesai">{{ $perbaikanSelesaiCount }}</h5>
                                            <p class="mb-2 text-truncate">Selesai</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div id="perbaikanChart"></div>

                            </div>
                        </div><!-- end card -->
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow-sm rounded-lg">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Top 3 Fasilitas Terlapor</h4>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0 table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%;">No.</th>
                                                <th>Nama Fasilitas</th>
                                                <th class="text-center" style="width: 30%;">Jumlah Laporan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($topBarang as $i => $item)
                                                <tr>
                                                    <td class="text-center">{{ $i + 1 }}</td>
                                                    <td>{{ $item->nama_barang }}</td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info">{{ $item->jumlah_laporan ?? 0 }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow-sm rounded-lg">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Top 3 Tempat Terlapor, Nomer 4 Bikin Kaget!!!</h4>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0 table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%;">No.</th>
                                                <th>Nama Unit</th>
                                                <th>Nama Tempat</th>
                                                <th class="text-center" style="width: 30%;">Jumlah Laporan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($topTempat as $i => $item)
                                                <tr>
                                                    <td class="text-center">{{ $i + 1 }}</td>
                                                    <td>{{ $item->unit->nama_unit ?? '-' }}</td>
                                                    <td>{{ $item->tempat->nama_tempat ?? '-' }}</td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info">{{ $item->jumlah_laporan ?? 0 }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
                @if(auth()->check() && in_array(auth()->user()->role->kode_role, ['MHS', 'DSN','TDK']))

                    <div class="col-xl-4">
                        <div class="card shadow-sm rounded-lg d-flex flex-row align-items-center h-75" style="min-height: 100px;">
                            <div class="ms-4 d-flex align-items-center">
                                <a href="{{ route('laporan.index') }}" class="btn bg-success bg-opacity-50 text-dark btn-lg">
                                    <i class="ri-add-line me-1" style="font-size: 2rem;"></i>
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Laporan Baru</p>
                                <h4 class="mb-2">Buat Laporan</h4>
                                <p class="text-muted mb-0">
                                    <span class="text-secondary fw-bold font-size-12 me-2">
                                        <i class="ri-file-list-3-line me-1 align-middle"></i>
                                        Laporkan Kerusakan Sedetail Mungkin!
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card shadow-sm rounded-lg d-flex flex-row align-items-center h-75" style="min-height: 100px;">
                            <div class="ms-4 d-flex align-items-center ">
                                <a href="{{ route('riwayatlaporan') }}" class="btn bg-info bg-opacity-50 text-dark btn-lg">
                                    <i class="ri-article-line me-1" style="font-size: 2rem;"></i>
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Laporan Anda</p>
                                <h4 class="mb-2">{{ $laporanUserCount }}</h4>
                                <p class="text-muted mb-0">
                                    <span class="text-success fw-bold font-size-12 me-2">
                                        <i class="ri-article-line me-1 align-middle"></i>
                                        {{ $laporanUserTerbaru?->created_at->diffForHumans() ?? '-' }}
                                        <span class="text-secondary"> Laporan terbaru Anda</span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card shadow-sm rounded-lg d-flex flex-row align-items-center h-75" style="min-height: 100px;">
                            <div class="ms-4 d-flex align-items-center ">
                                <a href="{{ route('statusperbaikan') }}" class="btn bg-warning bg-opacity-50 text-dark btn-lg">
                                    <i class="ri-tools-line me-1" style="font-size: 2rem;"></i>
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Perbaikan Anda</p>
                                <h4 class="mb-2">{{ $perbaikanUserCount }}</h4>
                                <p class="text-muted mb-0">
                                    <span class="text-success fw-bold font-size-12 me-2">
                                        <i class="ri-tools-line me-1 align-middle"></i>
                                        {{ $perbaikanUserTerbaru?->created_at->diffForHumans() ?? '-' }}
                                        <span class="text-secondary"> Perbaikan terbaru Anda</span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card shadow-sm rounded-lg mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Status Laporan Anda</h4>
                                <div id="laporanUserChart"></div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var userChartOptions = {
                                    chart: {
                                        type: 'bar',
                                        height: 220
                                    },
                                    series: [{
                                        name: 'Jumlah',
                                        data: [
                                            {{ $laporanUserBelumDiverifikasiCount ?? 0 }},
                                            {{ $laporanUserDiverifikasiCount ?? 0 }},
                                            {{ $laporanUserDitolakCount ?? 0 }}
                                        ]
                                    }],
                                    xaxis: {
                                        categories: ['Belum Diverifikasi', 'Diverifikasi', 'Ditolak']
                                    },
                                    colors: ['#ffbb44', '#6fd088', '#ff4d4f'],
                                    plotOptions: {
                                        bar: {
                                            distributed: true,
                                            borderRadius: 6,
                                            columnWidth: '40%'
                                        }
                                    },
                                    dataLabels: {
                                        enabled: true
                                    },
                                    fill: {
                                        type: 'gradient',
                                        gradient: {
                                            shade: 'light',
                                            type: "vertical",
                                            shadeIntensity: 0.5,
                                            gradientToColors: ['#ffe29e', '#a8eec1', '#ffb3b3'],
                                            inverseColors: false,
                                            opacityFrom: 0.9,
                                            opacityTo: 1,
                                            stops: [0, 100]
                                        }
                                    }
                                };
                                if (typeof ApexCharts !== 'undefined') {
                                    var userChart = new ApexCharts(document.querySelector("#laporanUserChart"), userChartOptions);
                                    userChart.render();
                                }
                            });
                        </script>
                    </div>

                    <div class="col-xl-6">
                        <div class="card shadow-sm rounded-lg mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Status Perbaikan Anda</h4>
                                <div id="perbaikanUserChart"></div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var perbaikanUserChartOptions = {
                                    chart: {
                                        type: 'bar',
                                        height: 220
                                    },
                                    series: [{
                                        name: 'Jumlah',
                                        data: [
                                            {{ $perbaikanUserBelumCount ?? 0 }},
                                            {{ $perbaikanUserBerjalanCount ?? 0 }},
                                            {{ $perbaikanUserSelesaiCount ?? 0 }}
                                        ]
                                    }],
                                    xaxis: {
                                        categories: ['Belum', 'Berjalan', 'Selesai']
                                    },
                                    colors: ['#ff4d4f', '#ffbb44', '#6fd088'],
                                    plotOptions: {
                                        bar: {
                                            distributed: true,
                                            borderRadius: 6,
                                            columnWidth: '40%'
                                        }
                                    },
                                    dataLabels: {
                                        enabled: true
                                    },
                                    fill: {
                                        type: 'gradient',
                                        gradient: {
                                            shade: 'light',
                                            type: "vertical",
                                            shadeIntensity: 0.5,
                                            gradientToColors: ['#ffb3b3', '#ffe29e', '#a8eec1'],
                                            inverseColors: false,
                                            opacityFrom: 0.9,
                                            opacityTo: 1,
                                            stops: [0, 100]
                                        }
                                    }
                                };
                                if (typeof ApexCharts !== 'undefined') {
                                    var perbaikanUserChart = new ApexCharts(document.querySelector("#perbaikanUserChart"), perbaikanUserChartOptions);
                                    perbaikanUserChart.render();
                                }
                            });
                        </script>
                    </div>



                @endif



            </div>
            <!-- end row -->
        </div>

    </div>
    <!-- End Page-content -->
@endsection

@push('js')
    {{--
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
    <script>
        // Submit form saat periode diganti
        document.getElementById('periodeSelect').addEventListener('change', function () {
            var tahun = this.value;
            fetch("{{ route('dashboard.chartData') }}?tahun=" + tahun)
                .then(response => response.json())
                .then(data => {
                    chart.updateSeries([{
                        name: 'Jumlah',
                        data: [
                            data.laporanBelumDiverifikasiCount,
                            data.laporanDiverifikasiCount,
                            data.laporanDitolakCount
                        ]
                    }]);

                    document.getElementById('laporan-total').textContent = data.laporanCount;
                    document.getElementById('laporan-belum').textContent = data.laporanBelumDiverifikasiCount;
                    document.getElementById('laporan-verif').textContent = data.laporanDiverifikasiCount;
                    document.getElementById('laporan-tolak').textContent = data.laporanDitolakCount;
                });
        });

        document.getElementById('periodeSelect2').addEventListener('change', function () {
            var tahun = this.value;
            fetch("{{ route('dashboard.chartData2') }}?tahun=" + tahun)
                .then(response => response.json())
                .then(data => {
                    chart2.updateSeries([{
                        name: 'Jumlah',
                        data: [
                            data.perbaikanBelumCount,
                            data.perbaikanBerjalanCount,
                            data.perbaikanSelesaiCount
                        ]
                    }]);

                    document.getElementById('perbaikan-total').textContent = data.perbaikanCount;
                    document.getElementById('perbaikan-belum').textContent = data.perbaikanBelumCount;
                    document.getElementById('perbaikan-berjalan').textContent = data.perbaikanBerjalanCount;
                    document.getElementById('perbaikan-selesai').textContent = data.perbaikanSelesaiCount;
                });
        });

        var options = {
            chart: {
                type: 'bar',
                height: 320
            },
            series: [{
                name: 'Jumlah',
                data: [
                                {{ $laporanBelumDiverifikasiCount }},
                                {{ $laporanDiverifikasiCount }},
                    {{ $laporanDitolakCount }}
                ]
            }],
            xaxis: {
                categories: ['Belum Diverifikasi', 'Diverifikasi', 'Ditolak']
            },
            colors: ['#ffbb44', '#6fd088', '#ff4d4f'],
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 6,
                    columnWidth: '40%'
                }
            },
            dataLabels: {
                enabled: true
            }
        };

        var options2 = {
            chart: {
                type: 'bar',
                height: 320
            },
            series: [{
                name: 'Jumlah',
                data: [
                        {{ $perbaikanBelumCount }},
                        {{ $perbaikanBerjalanCount }},
                    {{ $perbaikanSelesaiCount }}
                ]
            }],
            xaxis: {
                categories: ['Belum', 'Berjalan', 'Selesai']
            },
            colors: ['#ff4d4f', '#ffbb44', '#6fd088'],
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 6,
                    columnWidth: '40%'
                }
            },
            dataLabels: {
                enabled: true
            }
        };



        var chart = new ApexCharts(document.querySelector("#laporanChart"), options);
        var chart2 = new ApexCharts(document.querySelector("#perbaikanChart"), options2);
        chart.render();
        chart2.render();
    </script>
@endpush