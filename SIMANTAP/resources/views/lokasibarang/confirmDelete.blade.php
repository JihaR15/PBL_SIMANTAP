<div class="modal-dialog modal-md" role="document">
    <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0 text-dark">
                        <i class="fas fa-trash-alt me-2"></i>Konfirmasi Hapus Barang
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <div class="modal-body p-4">
            <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25 mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-3" style="font-size: 24px;"></i>
                    <div>
                        <h5 class="mb-1">Konfirmasi Penghapusan</h5>
                        <p class="mb-0">Anda akan menghapus data berikut:</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 bg-light" style="border-radius: 12px;">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                <i class="fas fa-box"></i>
                            </td>
                            <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Barang</td>
                            <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                {{ $barang->jenisBarang->nama_barang }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                <i class="fas fa-hashtag"></i>
                            </td>
                            <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Jumlah</td>
                            <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                {{ $barang->jumlah_barang }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                <i class="fas fa-map-marker-alt"></i>
                            </td>
                            <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Lokasi</td>
                            <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                {{ $tempat->nama_tempat }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <form id="form-delete" action="{{ url('/lokasibarang/' . $tempat->tempat_id . '/delete/' . $barang->jenis_barang_id) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                        <i class="fas fa-trash-alt me-2"></i>Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-content {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: none;
    }
    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }
    .modal-body {
        padding: 1.5rem;
    }
    .badge {
        padding: 0.35rem 0.65rem;
        border-radius: 50px;
        font-weight: 500;
    }
    .btn-outline-secondary {
        transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }
    .btn-danger {
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    .alert-warning {
        border-left: 4px solid #ffc107;
    }
</style>

<script>
    $(document).ready(function() {
        $('#form-delete').validate({
            submitHandler: function(form) {
                const submitBtn = $(form).find('button[type="submit"]');
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                                background: '#fff'
                            });
                            setTimeout(() => {
                                if (typeof refreshModalContent !== 'undefined') refreshModalContent();
                                if (typeof reloadTable !== 'undefined') reloadTable();
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message,
                                background: '#fff'
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="fas fa-trash-alt me-2"></i>Hapus');
                    }
                });
                return false;
            }
        });
    });
</script>
