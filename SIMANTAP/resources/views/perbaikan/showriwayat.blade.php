@php
    $statusPerbaikan = strtolower($perbaikan->status_perbaikan ?? '');
    $statusClass = [
        'selesai' => 'bg-success bg-opacity-10 text-success',
        'sedang diperbaiki' => 'bg-info bg-opacity-10 text-info',
        'belum diperbaiki' => 'bg-secondary bg-opacity-10 text-secondary'
    ][$statusPerbaikan] ?? 'bg-secondary bg-opacity-10 text-secondary';

    $urgensi = $perbaikan->laporan->prioritas->klasifikasi_urgensi ?? '-';
    $urgensiClass = 'bg-secondary bg-opacity-10 text-secondary';
    $urgensiIcon = 'ri-information-line';
    $urgensiText = 'Belum Ditentukan';

    if ($urgensi === 'Tidak Mendesak') {
        $urgensiClass = 'bg-secondary bg-opacity-10 text-secondary';
        $urgensiIcon = 'ri-time-line';
        $urgensiText = 'Tidak Urgent';
    } elseif ($urgensi === 'Biasa') {
        $urgensiClass = 'bg-success bg-opacity-10 text-success';
        $urgensiIcon = 'ri-check-line';
        $urgensiText = 'Biasa';
    } elseif ($urgensi === 'Mendesak') {
        $urgensiClass = 'bg-danger bg-opacity-10 text-danger';
        $urgensiIcon = 'ri-alarm-warning-line';
        $urgensiText = 'Urgent';
    }
@endphp

<div id="modal-master" class="modal-dialog modal-xl" role="document">
    <div class="modal-content border-0" style="overflow: hidden; border-radius: 12px;">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">
                        <i class="ri-tools-line me-2"></i>Detail Perbaikan
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Informasi dan dokumentasi perbaikan kerusakan</p>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <div class="modal-body p-4">
            <div class="d-flex align-items-center mb-4">
                <div class="flex-shrink-0">
                    <span class="avatar avatar-lg bg-primary bg-opacity-10 text-primary rounded-circle">
                        <i class="ri-tools-fill fs-4 text-primary"></i>
                    </span>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4 class="mb-0">Perbaikan ID: {{ $perbaikan->perbaikan_id }}</h4>
                    <span class="text-muted"><i class="ri-calendar-line me-1 text-primary"></i> {{ $perbaikan->ditugaskan_pada_formatted }}</span>
                </div>
                <div>
                    <span class="badge {{ $statusClass }} rounded-pill py-2 px-3">
                        <i class="ri-{{ $statusPerbaikan === 'selesai' ? 'check' : ($statusPerbaikan === 'sedang diperbaiki' ? 'refresh' : 'time') }}-line me-1"></i>
                        {{ ucfirst($statusPerbaikan) }}
                    </span>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-primary bg-opacity-10 p-0 border-0">
                            <ul class="nav nav-tabs nav-tabs-card" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-laporan" role="tab">
                                        <i class="ri-information-line me-1"></i> Informasi Laporan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab-perbaikan" role="tab">
                                        <i class="ri-tools-line me-1"></i> Informasi Perbaikan
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body tab-content">
                            <div class="tab-pane fade show active" id="tab-laporan" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-building-2-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Fasilitas</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->laporan->fasilitas->nama_fasilitas ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-community-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Unit</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->laporan->unit->nama_unit ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-map-pin-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Tempat</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->laporan->tempat->nama_tempat ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-inbox-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Barang</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->laporan->barangLokasi->jenisBarang->nama_barang ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-error-warning-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Jumlah Rusak</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->laporan->jumlah_barang_rusak ?? '0' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-alert-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Kategori Kerusakan</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->laporan->kategoriKerusakan->nama_kategori ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-calendar-event-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Periode</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->laporan->periode->nama_periode ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-flashlight-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1"> Tingkat Urgensi</label>
                                                <p class="mb-0">
                                                    <span class="badge {{ $urgensiClass }} rounded-pill py-2 px-3">
                                                        <i class="{{ $urgensiIcon }} me-1"></i>
                                                        {{ $urgensiText }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-perbaikan" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-calendar-check-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Tanggal Ditugaskan</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->ditugaskan_pada ? \Carbon\Carbon::parse($perbaikan->ditugaskan_pada)->format('d M Y H:i') : '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-calendar-todo-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Tanggal Selesai</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->selesai_pada_formatted ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-money-dollar-circle-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Biaya Perbaikan</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->biaya ? 'Rp ' . number_format($perbaikan->biaya, 0, ',', '.') : '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-user-settings-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Ditugaskan Oleh</label>
                                                <p class="mb-0 fw-bold">{{ $perbaikan->laporan->verifikator->name ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-image-line me-2 text-primary"></i>Dokumentasi Foto</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="h-100">
                                        <h6 class="small text-muted mb-2"><i class="ri-image-line me-1"></i> Foto Laporan</h6>
                                        @if ($perbaikan->laporan->foto_laporan)
                                            <a href="{{ asset('storage/' . $perbaikan->laporan->foto_laporan) }}" data-lightbox="laporan" data-title="Foto Laporan">
                                                <div class="image-wrapper position-relative">
                                                    <img src="{{ asset('storage/' . $perbaikan->laporan->foto_laporan) }}" class="img-fluid rounded shadow-sm" style="height: 200px; width: 100%; object-fit: cover;">
                                                    <div class="image-overlay">
                                                        <i class="ri-zoom-in-line text-white"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            <div class="bg-light bg-opacity-25 rounded p-4 w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="height: 200px;">
                                                <i class="ri-alert-line fs-1 text-warning mb-2"></i>
                                                <p class="mb-0 text-muted small">Foto laporan tidak tersedia</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="h-100">
                                        <h6 class="small text-muted mb-2"><i class="ri-tools-line me-1"></i> Foto Perbaikan</h6>
                                        @if ($perbaikan->foto_perbaikan)
                                            <a href="{{ asset('storage/' . $perbaikan->foto_perbaikan) }}" data-lightbox="perbaikan" data-title="Foto Perbaikan">
                                                <div class="image-wrapper position-relative">
                                                    <img src="{{ asset('storage/' . $perbaikan->foto_perbaikan) }}" class="img-fluid rounded shadow-sm" style="height: 200px; width: 100%; object-fit: cover;">
                                                    <div class="image-overlay">
                                                        <i class="ri-zoom-in-line text-white"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            <div class="bg-light bg-opacity-25 rounded p-4 w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="height: 200px;">
                                                <i class="ri-alert-line fs-1 text-warning mb-2"></i>
                                                <p class="mb-0 text-muted small">Foto perbaikan belum tersedia</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 g-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-file-text-line me-2 text-primary"></i>Deskripsi Laporan</h6>
                        </div>
                        <div class="card-body">
                            <div class="bg-opacity-25 rounded">
                                {!! $perbaikan->laporan->deskripsi ? nl2br(e($perbaikan->laporan->deskripsi)) : '<span class="text-muted">Tidak ada deskripsi tersedia.</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-tools-line me-2 text-primary"></i>Catatan Perbaikan</h6>
                        </div>
                        <div class="card-body">
                            <div class="bg-opacity-25 rounded">
                                {!! $perbaikan->catatan_perbaikan ? nl2br(e($perbaikan->catatan_perbaikan)) : '<span class="text-muted">Belum ada catatan perbaikan.</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            @if ($perbaikan->status_perbaikan === 'selesai')
                <button class="btn btn-primary"
                        onclick="showFeedback({{ $perbaikan->perbaikan_id }})"
                        style="box-shadow: 0 2px 6px rgba(13, 110, 253, 0.2); border-radius: 50px !important; padding: 0.5rem 1.5rem; font-weight: 500; transition: all 0.2s ease; display: inline-flex; align-items: center;">
                    <i class="ri-feedback-line me-1"></i> Lihat Feedback
                </button>
            @endif
        </div>
    </div>
</div>

<style>
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
    }

    .image-wrapper {
        position: relative;
        transition: all 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .image-overlay i {
        color: white;
        font-size: 1.5rem;
    }

    .image-wrapper:hover .image-overlay {
        opacity: 1;
    }

    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }

    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .card {
        border-radius: 0.5rem !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .btn {
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-primary:hover {
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        transform: translateY(-1px);
    }

    /* Style untuk tab */
    .nav-tabs-card {
        border-bottom: none;
        padding: 0 1rem;
    }

    .nav-tabs-card .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1rem;
        border-radius: 0;
        position: relative;
    }

    .nav-tabs-card .nav-link.active {
        color: var(--bs-primary);
        background-color: transparent;
    }

    .nav-tabs-card .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background-color: var(--bs-primary);
    }

    .nav-tabs-card .nav-link:hover:not(.active) {
        color: #495057;
    }

    .dark-mode .btn-primary {
        background-color: #3a7bd5;
        border-color: #3a7bd5;
    }

    .dark-mode .btn-primary:hover {
        background-color: #2c65b4;
        border-color: #2c65b4;
    }
</style>

<script>
    function setTheme(theme) {
        if (theme === 'dark') {
            document.body.classList.add('dark-mode');
            document.body.classList.remove('light-mode');
            localStorage.setItem('theme', 'dark');
        } else {
            document.body.classList.add('light-mode');
            document.body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
        }
    }

    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    const savedTheme = localStorage.getItem('theme');

    if (savedTheme) {
        setTheme(savedTheme);
    } else {
        setTheme(systemPrefersDark ? 'dark' : 'light');
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        setTheme(e.matches ? 'dark' : 'light');
    });

    function showFeedback(perbaikanId) {
        $.get(`/riwayatperbaikan/${perbaikanId}/feedback`, function(html) {
            Swal.fire({
                title: 'Feedback Pelapor',
                html: html,
                width: '500px',
                showConfirmButton: false,
                confirmButtonText: 'Tutup',
                showCancelButton: false,
                showCloseButton: true,
                focusConfirm: false,
                buttonsStyling: false,
                customClass: {
                    popup: 'swal-left-align',
                    confirmButton: 'btn btn-primary swal-btn-tutup'
                }
            });
        }).fail(function () {
            Swal.fire('Gagal', 'Gagal memuat feedback.', 'error');
        });
    }

    const style = document.createElement('style');
    style.innerHTML = `
        .light-mode .swal-left-align {
            background-color: #fff;
            color: #000;
        }

        .dark-mode .swal-left-align {
            background-color: #252b3b;
            color: #fff;
        }

        .dark-mode .swal2-title {
            color: #fff;
        }

        .dark-mode .swal2-html-container {
            color: #79858f;
        }
    `;
    document.head.appendChild(style);
</script>
