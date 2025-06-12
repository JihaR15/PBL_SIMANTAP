<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header text-white bg-light">
            <h5 class="modal-title mb-0"><i class="ri-file-text-line me-2"></i>Detail Laporan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <span class="text-muted"><i class="ri-calendar-line me-1"></i> {{ $laporan->formatted_created_at }}</span>
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

            <div class="row align-items-stretch">
                <div class="{{ $laporan->foto_laporan ? 'col-lg-8 d-flex flex-column' : 'col-lg-12' }}">
                    <div class="card flex-fill mb-4">
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
                            </div>
                        </div>
                    </div>
                </div>

                @if ($laporan->foto_laporan)
                <div class="col-lg-4 d-flex flex-column">
                    <div class="card flex-fill h-100">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="card-title mb-0"><i class="ri-image-line me-2 text-primary"></i>Foto Laporan</h6>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="image-preview-container w-100">
                                <a href="{{ asset('storage/' . $laporan->foto_laporan) }}" data-lightbox="laporan" data-title="Foto Laporan">
                                    <div class="image-wrapper rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan" class="img-fluid w-100">
                                        <div class="image-overlay">
                                            <i class="ri-zoom-in-line"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="card mt-4">
                <div class="card-header bg-primary bg-opacity-10">
                    <h6 class="card-title mb-0"><i class="ri-file-text-line me-2 text-primary"></i>Deskripsi Laporan</h6>
                </div>
                <div class="card-body">
                    <div class="bg-light bg-opacity-25 rounded text-start" style="text-align: left !important;">
                        {!! $laporan->deskripsi ? nl2br(e($laporan->deskripsi)) : '<span class="text-muted">Tidak ada deskripsi tersedia.</span>' !!}
                    </div>
                </div>
            </div>
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

    .card.flex-fill {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .image-preview-container {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
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

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.5rem;
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
    }
</style>
