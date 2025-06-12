@php
    $statusVerif = strtolower($laporan->status_verif ?? '');
    $isDitolak = ($statusVerif === 'ditolak');
    $colInfo = ($isDitolak && $laporan->foto_laporan) ? 'col-lg-8' : ($laporan->foto_laporan ? 'col-lg-6' : 'col-lg-12');
    $colDeskripsi = $isDitolak ? 'col-md-12' : 'col-md-6';
@endphp

<div id="modal-master" class="modal-dialog {{ $isDitolak ? 'modal-lg' : 'modal-xl' }}" role="document">
    <div class="modal-content border-0" style="overflow: hidden; border-radius: 12px;">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">
                        <i class="ri-file-text-line me-2"></i>Detail Laporan
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Informasi dan dokumentasi laporan kerusakan</p>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <div class="modal-body p-4">
            <div class="d-flex align-items-center mb-4">
                <div class="flex-shrink-0">
                    <span class="avatar avatar-lg bg-primary bg-opacity-10 text-primary rounded-circle">
                        <i class="ri-file-list-line fs-4"></i>
                    </span>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h4 class="mb-0">Laporan ID: {{ $laporan->laporan_id }}</h4>
                    <span class="text-muted"><i class="ri-calendar-line me-1 text-primary"></i> {{ $laporan->created_at->format('d M Y') }}</span>
                </div>
                <div>
                    @php
                        $status = $laporan->status_verif ?? '';
                        $statusClass = [
                            'belum diverifikasi' => 'bg-warning bg-opacity-10 text-warning',
                            'diverifikasi' => 'bg-success bg-opacity-10 text-success',
                            'ditolak' => 'bg-danger bg-opacity-10 text-danger'
                        ][$status] ?? 'bg-secondary bg-opacity-10 text-secondary';
                    @endphp
                    <span class="badge {{ $statusClass }} rounded-pill py-2 px-3">
                        <i class="ri-{{ $status === 'diverifikasi' ? 'check' : ($status === 'ditolak' ? 'close' : 'time') }}-line me-1"></i>
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </span>
                </div>
            </div>

            <div class="row align-items-stretch g-4">
                <div class="{{ $colInfo }} d-flex flex-column">
                    <div class="card flex-fill h-100">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-information-line me-2 text-primary"></i>Informasi Laporan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-building-2-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Fasilitas</label>
                                            <p class="mb-0 fw-bold">{{ $laporan->fasilitas->nama_fasilitas ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-community-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Unit</label>
                                            <p class="mb-0 fw-bold">{{ $laporan->unit->nama_unit ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-map-pin-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Tempat</label>
                                            <p class="mb-0 fw-bold">{{ $laporan->tempat->nama_tempat ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-inbox-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Barang</label>
                                            <p class="mb-0 fw-bold">{{ $laporan->barangLokasi->jenisBarang->nama_barang ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-error-warning-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Jumlah Rusak</label>
                                            <p class="mb-0 fw-bold">{{ $laporan->jumlah_barang_rusak ?? '0' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-alert-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Kategori Kerusakan</label>
                                            <p class="mb-0 fw-bold">{{ $laporan->kategoriKerusakan->nama_kategori ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-calendar-event-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Periode</label>
                                            <p class="mb-0 fw-bold">{{ $laporan->periode->nama_periode ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if(!$isDitolak)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-calendar-check-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Tanggal Ditugaskan</label>
                                            <p class="mb-0 fw-bold">{{ $isDitolak ? '-' : ($laporan->perbaikan->formatted_tanggal_ditugaskan ?? '-') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-tools-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Status Perbaikan</label>
                                            @php $statusPerbaikan = $laporan->perbaikan->status_perbaikan ?? ''; @endphp
                                            <p class="mb-0">
                                                <span class="badge rounded-pill py-2 px-3
                                                    {{ $statusPerbaikan === 'belum' ? 'bg-secondary bg-opacity-10 text-secondary' :
                                                        ($statusPerbaikan === 'sedang diperbaiki' ? 'bg-info bg-opacity-10 text-info' :
                                                        ($statusPerbaikan === 'selesai' ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary')) }}">
                                                    <i class="ri-{{ $statusPerbaikan === 'selesai' ? 'check' : ($statusPerbaikan === 'sedang diperbaiki' ? 'tools' : 'time') }}-line me-1"></i>
                                                    {{ $statusPerbaikan ? ucwords($statusPerbaikan) : '-' }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="ri-user-line text-primary me-2 mt-1"></i>
                                        <div>
                                            <label class="form-label text-muted small mb-1">Teknisi</label>
                                            <p class="mb-0 fw-bold">{{ $laporan->perbaikan->teknisi->user->name ?? '-' }} ( {{ $laporan->perbaikan->teknisi->jenis_teknisi->nama_jenis_teknisi ?? '-' }} )</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                @if ($laporan->foto_laporan)
                <div class="{{ $isDitolak ? 'col-lg-4' : 'col-lg-3' }} d-flex flex-column">
                    <div class="card flex-fill h-100">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-image-line me-2 text-primary"></i>Foto Laporan</h6>
                        </div>
                        <div class="card-body p-3 d-flex align-items-center justify-content-center">
                            <a href="{{ asset('storage/' . $laporan->foto_laporan) }}" data-lightbox="laporan">
                                <div class="image-wrapper position-relative">
                                    <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" class="img-fluid rounded shadow-sm" style="max-height: 220px; object-fit: contain;">
                                    <div class="image-overlay"><i class="ri-zoom-in-line"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if (!$isDitolak)
                <div class="col-lg-3 d-flex flex-column">
                    <div class="card flex-fill h-100">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-tools-line me-2 text-primary"></i>Foto Perbaikan</h6>
                        </div>
                        <div class="card-body p-3 d-flex align-items-center justify-content-center">
                            @if ($laporan->perbaikan && $laporan->perbaikan->foto_perbaikan)
                                <a href="{{ asset('storage/' . $laporan->perbaikan->foto_perbaikan) }}" data-lightbox="perbaikan">
                                    <div class="image-wrapper position-relative">
                                        <img src="{{ asset('storage/' . $laporan->perbaikan->foto_perbaikan) }}" class="img-fluid rounded shadow-sm" style="max-height: 220px; object-fit: contain;">
                                        <div class="image-overlay"><i class="ri-zoom-in-line"></i></div>
                                    </div>
                                </a>
                            @else
                                <div class="text-center text-muted">
                                    <i class="ri-alert-line fs-1 text-warning mb-2"></i>
                                    <p class="mb-0">Belum tersedia</p>
                                    <small>Akan tampil setelah perbaikan selesai</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="row mt-4 g-4">
                <div class="{{ $colDeskripsi }}">
                    <div class="card">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-file-text-line me-2 text-primary"></i>Deskripsi Laporan</h6>
                        </div>
                        <div class="card-body">
                            <div class="bg-light bg-opacity-25 rounded text-start">
                                {{ $laporan->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                            </div>
                        </div>
                    </div>
                </div>

                @if (!$isDitolak)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-tools-line me-2 text-primary"></i>Deskripsi Perbaikan</h6>
                        </div>
                        <div class="card-body">
                            <div class="bg-light bg-opacity-25 rounded text-start">
                                {{ $laporan->perbaikan->catatan_perbaikan ?? 'Tidak ada deskripsi tersedia.' }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="modal-footer">
            @if ($laporan->status_verif === 'diverifikasi')
                <button class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center"
                        onclick="showFeedback('{{ $laporan->laporan_id }}')"
                        style="background-color: #3b82f6;
                            border: none;
                            border-radius: 50px !important;
                            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
                            transition: all 0.2s ease;
                            font-weight: 500;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            min-width: 160px;">
                    <i class="ri-feedback-line me-2"></i> Lihat Feedback
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

    .image-preview-container {
        border-radius: 8px;
        overflow: hidden;
        min-height: 220px;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .image-wrapper {
        position: relative;
        transition: all 0.3s ease;
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
        border-radius: 0.5rem;
    }

    .image-overlay i {
        color: white;
        font-size: 2rem;
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

    .swal2-actions {
        display: flex !important;
        justify-content: flex-end !important;
        padding: 0 1.5rem 1rem;
    }

    .swal-btn-tutup {
        margin-left: auto;
        margin-right: 0;
        padding: 6px 20px;
        font-weight: 500;
        border-radius: 6px;
    }

    .btn-primary:hover {
        background-color: #2563eb !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(59, 130, 246, 0.4) !important;
    }

    .btn-primary:active {
        transform: translateY(1px);
    }

    .dark-mode .btn-primary {
        background-color: #1d4ed8 !important;
    }

    .dark-mode .btn-primary:hover {
        background-color: #1e40af !important;
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

    function showFeedback(laporanId) {
        $.get(`/riwayatverifikasi/${laporanId}/feedback`, function (html) {
            Swal.fire({
                title: `Feedback Laporan #${laporanId}`,
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

        /* Tambahkan gaya untuk modal di dark mode */
        .dark-mode .swal2-title {
            color: #fff; /* Ubah warna judul menjadi putih */
        }

        .dark-mode .swal2-html-container {
            color: #79858f; /* Ubah warna teks menjadi putih */
        }
    `;
    document.head.appendChild(style);
</script>
