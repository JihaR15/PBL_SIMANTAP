@php
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

<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0" style="border-radius: 12px;">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">
                        <i class="ri-tools-line me-2"></i>Detail Perbaikan
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Informasi lengkap laporan perbaikan</p>
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
                    <span class="text-muted"><i class="ri-calendar-line me-1"></i> {{ $perbaikan->created_at->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill py-2 px-3">
                        <i class="ri-tools-line me-1"></i>
                        Dalam Proses
                    </span>
                </div>
            </div>

            <div class="row align-items-stretch g-4">
                <div class="col-lg-8 d-flex flex-column">
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
                    </div>
                </div>
                @if ($perbaikan->laporan->foto_laporan)
                    <div class="col-lg-4 d-flex flex-column">
                        <div class="card flex-fill h-100">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="card-title mb-0"><i class="ri-image-line me-2 text-primary"></i>Foto Laporan</h6>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="image-preview-container w-100">
                                    <a href="{{ asset('storage/' . $perbaikan->laporan->foto_laporan) }}" data-lightbox="laporan" data-title="Foto Laporan">
                                        <div class="image-wrapper rounded overflow-hidden">
                                            <img src="{{ asset('storage/' . $perbaikan->laporan->foto_laporan) }}" alt="Foto Laporan" class="img-fluid" style="max-width: 100%;">
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

            <div class="card mt-2">
                <div class="card-header bg-primary bg-opacity-10">
                    <h6 class="card-title mb-0"><i class="ri-file-text-line me-2 text-primary"></i>Deskripsi Laporan</h6>
                </div>
                <div class="card-body">
                    <div class="bg-opacity-25 rounded text-start">
                        {!! $perbaikan->laporan->deskripsi ? nl2br(e($perbaikan->laporan->deskripsi)) : '<span class="text-muted">Tidak ada deskripsi tersedia.</span>' !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 50px !important">Tutup</button> --}}
            <button onclick="modalAction('{{ url('dikerjakan/' . $perbaikan->perbaikan_id . '/konfirmasi') }}')"
                class="btn btn-primary" id="btn-verify" style="border-radius: 50px !important">
                <i class="ri-check-line me-1"></i> Selesaikan
            </button>
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

    .image-wrapper {
        position: relative;
        display: inline-block;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .image-wrapper img {
        display: block;
        width: 100%;
        height: auto;
        object-fit: contain;
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

    .image-wrapper:hover .image-overlay {
        opacity: 1;
    }

    .image-overlay i {
        color: white;
        font-size: 2rem;
    }

    .card:last-of-type {
        margin-bottom: 0 !important;
    }

    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .card {
        border-radius: 0.5rem !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>

<script>
    function modalAction(url = '') {
        const btn = $('#btn-verify');
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Memuat...');

        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
            btn.prop('disabled', false);
            btn.html('<i class="ri-check-line me-1"></i> Selesaikan');

            $('#formKonfirmasi').off('submit').on('submit', function(e) {
                e.preventDefault();
                const formBtn = $(this).find('button[type="submit"]');
                formBtn.prop('disabled', true);
                formBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Memproses...');

                const formData = new FormData(this);
                formData.append('_method', 'PUT');
                const perbaikanId = url.split('/')[url.split('/').length - 2];

                $.ajax({
                    url: `/dikerjakan/${perbaikanId}/selesai`,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Sukses',
                                text: res.message || 'Perbaikan berhasil diselesaikan.',
                                icon: 'success',
                                confirmButtonColor: '#198754',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#myModal').modal('hide');
                                $('#datatable').DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: res.message || 'Gagal memproses data.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                            formBtn.prop('disabled', false);
                            formBtn.html('<i class="ri-check-line me-1"></i> Simpan');
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Gagal memproses data.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error',
                            text: msg,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                        formBtn.prop('disabled', false);
                        formBtn.html('<i class="ri-check-line me-1"></i> Simpan');
                    }
                });
            });
        });
    }
</script>
