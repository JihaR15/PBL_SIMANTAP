@empty($laporan)
<div id="modal-master" class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan.
            </div>
            <a href="{{ url('/laporan') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/laporan/' . $laporan->laporan_id . '/delete') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0" style="border-radius: 12px;">
            <div class="modal-header text-white bg-light">
                <div class="d-flex align-items-center w-100">
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0">
                            <i class="ri-delete-bin-line me-2"></i>Hapus Data Laporan
                        </h5>
                        <p class="mb-0 small opacity-85 mt-1 text-muted">Konfirmasi penghapusan data laporan kerusakan</p>
                    </div>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning mb-4">
                    <h5 class="alert-heading mb-1"><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi</h5>
                    Apakah Anda yakin ingin menghapus data berikut ini?
                </div>
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
                <div class="row align-items-stretch g-4">
                    <div class="col-lg-8 d-flex flex-column">
                        <div class="card flex-fill h-100">
                            <div class="card-header bg-light bg-opacity-50">
                                <h6 class="card-title mb-0"><i class="ri-information-line me-2"></i>Informasi Laporan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach([
                                        ['ri-building-2-line', 'Fasilitas', $laporan->fasilitas->nama_fasilitas ?? '-'],
                                        ['ri-community-line', 'Unit', $laporan->unit->nama_unit ?? '-'],
                                        ['ri-map-pin-line', 'Tempat', $laporan->tempat->nama_tempat ?? '-'],
                                        ['ri-box-3-line', 'Barang', $laporan->barangLokasi->jenisBarang->nama_barang ?? '-'],
                                        ['ri-error-warning-line', 'Jumlah Rusak', $laporan->jumlah_barang_rusak ?? '0'],
                                        ['ri-alert-line', 'Kategori Kerusakan', $laporan->kategoriKerusakan->nama_kategori ?? '-'],
                                        ['ri-calendar-event-line', 'Periode', $laporan->periode->nama_periode ?? '-'],
                                    ] as [$icon, $label, $value])
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-start">
                                                <i class="{{ $icon }} text-muted me-2 mt-1"></i>
                                                <div>
                                                    <label class="form-label text-muted small mb-1">{{ $label }}</label>
                                                    <p class="mb-0 fw-bold">{!! $value !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($laporan->foto_laporan)
                        <div class="col-lg-4 d-flex flex-column">
                            <div class="card flex-fill h-100">
                                <div class="card-header bg-light bg-opacity-50">
                                    <h6 class="card-title mb-0"><i class="ri-image-line me-2"></i>Foto Laporan</h6>
                                </div>
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <div class="image-preview-container w-100">
                                        <a href="{{ asset('storage/' . $laporan->foto_laporan) }}" data-lightbox="laporan" data-title="Foto Laporan">
                                            <div class="image-wrapper rounded overflow-hidden">
                                                <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan" class="img-fluid" style="max-width: 100%;">
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
                    <div class="card-header bg-light bg-opacity-50">
                        <h6 class="card-title mb-0"><i class="ri-file-text-line me-2"></i>Deskripsi Laporan</h6>
                    </div>
                    <div class="card-body">
                        <div class="bg-light bg-opacity-25 rounded text-start">
                            {!! $laporan->deskripsi ? nl2br(e($laporan->deskripsi)) : '<span class="text-muted">Tidak ada deskripsi tersedia.</span>' !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </div>
</form>
@endempty

<style>
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
</style>

<script>
        $(document).ready(function () {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus data.'
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
</script>
