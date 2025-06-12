@php
    $statusPerbaikan = strtolower($laporan->perbaikan->status_perbaikan ?? '');
    $perbaikanClass = 'bg-secondary bg-opacity-10 text-secondary';
    $perbaikanIcon = 'ri-time-line';
    $perbaikanText = 'Belum Diperbaiki';

    switch ($statusPerbaikan) {
        case 'selesai':
            $perbaikanClass = 'bg-success bg-opacity-10 text-success';
            $perbaikanIcon = 'ri-check-line';
            $perbaikanText = 'Selesai';
            break;
        case 'sedang diperbaiki':
            $perbaikanClass = 'bg-info bg-opacity-10 text-info';
            $perbaikanIcon = 'ri-refresh-line';
            $perbaikanText = 'Sedang dikerjakan';
            break;
        case 'belum diperbaiki':
            $perbaikanClass = 'bg-secondary bg-opacity-10 text-secondary';
            $perbaikanIcon = 'ri-time-line';
            $perbaikanText = 'Belum dikerjakan';
            break;
    }
@endphp

<div id="modal-master" class="modal-dialog modal-xl" role="document">
    <div class="modal-content border-0 shadow-lg">
        <div class="modal-header bg-light text-white">
            <h5 class="modal-title"><i class="ri-feedback-line me-2"></i>Beri Feedback</h5>
            <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
            <div class="card border-0 shadow-sm mb-4">
                {{-- <div class="card-header bg-light bg-opacity-50">
                    <h6 class="card-title mb-0"><i class="ri-edit-2-line me-2"></i>Formulir Feedback</h6>
                </div> --}}
                <div class="card-body">
                    <form action="{{ isset($existingFeedback) ? url('feedback/' . $laporan->laporan_id . '/update') : url('feedback/' . $laporan->laporan_id . '/store') }}" method="POST">
                        @csrf
                        @if (isset($existingFeedback))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Rating Kepuasan</label>
                            <div class="d-flex justify-content-center">
                                @php
                                    $emotes = [
                                        1 => ['icon' => 'ri-emotion-unhappy-line', 'label' => 'Tidak Puas', 'color' => 'danger'],
                                        2 => ['icon' => 'ri-emotion-sad-line', 'label' => 'Kurang Puas', 'color' => 'warning'],
                                        3 => ['icon' => 'ri-emotion-normal-line', 'label' => 'Biasa Saja', 'color' => 'secondary'],
                                        4 => ['icon' => 'ri-emotion-happy-line', 'label' => 'Puas', 'color' => 'info'],
                                        5 => ['icon' => 'ri-emotion-laugh-line', 'label' => 'Sangat Puas', 'color' => 'success'],
                                    ];
                                @endphp
                                <div class="rating-container">
                                    <div class="d-flex justify-content-between w-100" id="rating-group">
                                        @foreach ($emotes as $value => $emote)
                                            <input type="radio" class="btn-check" name="rating_id" id="rating-{{ $value }}" value="{{ $value }}" autocomplete="off" {{ isset($existingFeedback) && $existingFeedback->rating_id == $value ? 'checked' : '' }} required>
                                            <label class="rating-label" for="rating-{{ $value }}" data-index="{{ $value }}">
                                                <div class="rating-card card border-0 shadow-sm">
                                                    <div class="card-body text-center py-3">
                                                        <i class="{{ $emote['icon'] }} rating-icon text-{{ $emote['color'] }}"></i>
                                                        <div class="mt-2 small fw-medium">{{ $emote['label'] }}</div>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="laporan_id" value="{{ $laporan->laporan_id }}">

                        <div class="mb-4">
                            <label for="komentar" class="form-label fw-bold text-primary">Komentar Tambahan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ri-chat-3-line text-muted"></i></span>
                                <textarea class="form-control border-start-0" id="komentar" name="komentar" rows="4" placeholder="Bagaimana pengalaman Anda dengan layanan perbaikan ini?" required>{{ $existingFeedback->komentar ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-{{ isset($existingFeedback) ? 'primary' : 'success' }} rounded-pill px-4 py-2">
                                <i class="ri-send-plane-{{ isset($existingFeedback) ? 'fill' : 'line' }} me-2"></i>
                                {{ isset($existingFeedback) ? 'Update Feedback' : 'Kirim Feedback' }}
                            </button>

                            <a class="btn btn-outline-secondary rounded-pill px-4 py-2" data-bs-toggle="collapse" href="#detaillaporan" aria-expanded="false" aria-controls="collapseExample">
                                <i class="ri-arrow-down-s-line me-1"></i> Lihat Detail Laporan
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="collapse" id="detaillaporan">
                <div class="row align-items-stretch g-4">
                    <div class="col-lg-6 d-flex flex-column">
                        <div class="card flex-fill h-100">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="card-title mb-0"><i class="ri-information-line text-primary me-2"></i>Informasi Laporan</h6>
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
                                            <i class="ri-calendar-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Tanggal Dibuat</label>
                                                <p class="mb-0 fw-bold">{{ $laporan->created_at->format('d M Y') }}</p>
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
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-calendar-check-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Tanggal Ditugaskan</label>
                                                <p class="mb-0 fw-bold">{{ $laporan->perbaikan->formatted_tanggal_ditugaskan ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-tools-line text-primary me-2 mt-1"></i>
                                            <div>
                                                <label class="form-label text-muted small mb-1">Status Perbaikan</label>
                                                <p class="mb-0 fw-bold">
                                                    <span class="badge {{ $perbaikanClass }} rounded-pill py-2 px-3">
                                                        <i class="{{ $perbaikanIcon }} me-1"></i>
                                                        {{ $perbaikanText }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($laporan->foto_laporan)
                    <div class="col-lg-3 d-flex flex-column">
                        <div class="card flex-fill h-100">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="card-title mb-0"><i class="ri-image-line text-primary me-2"></i>Foto Laporan</h6>
                            </div>
                            <div class="card-body p-0 d-flex flex-column">
                                <div class="image-preview-container flex-grow-1 d-flex align-items-center justify-content-center p-3">
                                    <a href="{{ asset('storage/' . $laporan->foto_laporan) }}" data-lightbox="laporan" data-title="Foto Laporan">
                                        <div class="image-wrapper position-relative">
                                            <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" class="img-fluid rounded shadow-sm" style="max-height: 220px; width: auto; object-fit: contain;">
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

                    <div class="col-lg-3 d-flex flex-column">
                        <div class="card flex-fill h-100">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="card-title mb-0"><i class="ri-tools-line text-primary me-2"></i>Foto Perbaikan</h6>
                            </div>
                            <div class="card-body p-0 d-flex flex-column">
                                @if ($laporan->perbaikan && $laporan->perbaikan->foto_perbaikan)
                                    <div class="image-preview-container flex-grow-1 d-flex align-items-center justify-content-center p-3">
                                        <a href="{{ asset('storage/' . $laporan->perbaikan->foto_perbaikan) }}" data-lightbox="perbaikan" data-title="Foto Perbaikan">
                                            <div class="image-wrapper position-relative">
                                                <img src="{{ asset('storage/' . $laporan->perbaikan->foto_perbaikan) }}" class="img-fluid rounded shadow-sm" style="max-height: 220px; width: auto; object-fit: contain;">
                                                <div class="image-overlay">
                                                    <i class="ri-zoom-in-line"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @else
                                    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center p-4 text-center">
                                        <div class="bg-light bg-opacity-25 rounded p-4 w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                            <i class="ri-alert-line fs-1 text-warning mb-2"></i>
                                            <p class="mb-0 text-muted">Foto perbaikan belum tersedia</p>
                                            <small class="text-muted mt-1">Akan muncul setelah perbaikan selesai</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 g-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="card-title mb-0"><i class="ri-file-text-line text-primary me-2"></i>Deskripsi Laporan</h6>
                            </div>
                            <div class="card-body">
                                <div class="bg-light bg-opacity-25 rounded text-start">
                                    {!! $laporan->deskripsi ? nl2br(e($laporan->deskripsi)) : '<span class="text-muted">Tidak ada deskripsi tersedia.</span>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="card-title mb-0"><i class="ri-tools-line text-primary me-2"></i>Deskripsi Perbaikan</h6>
                            </div>
                            <div class="card-body">
                                <div class="bg-light bg-opacity-25 rounded text-start">
                                    {!! $laporan->perbaikan->catatan_perbaikan ? nl2br(e($laporan->perbaikan->catatan_perbaikan)) : '<span class="text-muted">Belum ada catatan perbaikan.</span>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rating-container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }

    .rating-card {
        transition: all 0.3s ease;
        width: 100px;
        cursor: pointer;
    }

    .rating-label:hover .rating-card {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .btn-check:checked + .rating-label .rating-card {
        border: 2px solid var(--bs-success);
        background-color: rgba(40, 167, 69, 0.05);
    }

    .rating-icon {
        font-size: 2.5rem;
        transition: all 0.3s ease;
    }

    .image-wrapper {
        position: relative;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        overflow: hidden;
        height: 250px;
    }

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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

    .icon-container {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
    }

    .card {
        border-radius: 0.75rem;
    }

    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        padding: 1rem 1.5rem;
    }
</style>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Mengirim Feedback...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        var form = this;
        var formData = new FormData(form);
        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message || 'Feedback berhasil dikirim!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        })
        .catch(() => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat mengirim feedback.'
            });
        });
    });

    // highlight selected rating
    document.querySelectorAll('#rating-group input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('#rating-group .rating-card').forEach(card => {
                card.style.borderColor = '';
                card.style.backgroundColor = '';
            });

            if (this.checked) {
                const label = document.querySelector(`label[for="${this.id}"]`);
                label.querySelector('.rating-card').style.borderColor = 'var(--bs-success)';
                label.querySelector('.rating-card').style.backgroundColor = 'rgba(40, 167, 69, 0.05)';
            }
        });
    });
</script>
