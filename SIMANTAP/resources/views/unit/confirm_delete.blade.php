@empty($unit)
<div id="modal-master" class="modal-dialog" role="document">
    <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-danger fa-2x me-2"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">Kesalahan</h5>
                    <p class="mb-0 small opacity-75 text-muted">Data tidak ditemukan</p>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <div class="text-end">
                <a href="{{ url('/unit') }}" class="btn btn-warning rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@else
<form action="{{ url('/unit/' . $unit->unit_id.'/delete') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <div class="modal-header text-white bg-light">
                <div class="d-flex align-items-center w-100">
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0 text-dark">
                            <i class="fas fa-trash-alt me-2"></i>Hapus Data Unit
                        </h5>
                        <p class="mb-0 small opacity-85 mt-1 text-muted">Konfirmasi penghapusan data unit</p>
                    </div>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body p-4">
                <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-3" style="font-size: 24px;"></i>
                        <div>
                            <h5 class="mb-1">Konfirmasi Penghapusan</h5>
                            <p class="mb-0">Apakah Anda yakin ingin menghapus data berikut?</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3 bg-light" style="border-radius: 12px;">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                    <i class="fas fa-warehouse"></i>
                                </td>
                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Jenis Fasilitas</td>
                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                    {{ $unit->fasilitas->nama_fasilitas }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                    <i class="fas fa-building"></i>
                                </td>
                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Nama Unit</td>
                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                    {{ $unit->nama_unit }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                    <i class="fas fa-trash-alt me-2"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</form>

<style>
    .modal-content {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: none;
    }
    .modal-header {
        padding: 1.5rem;
        border-bottom: none;
    }
    .modal-body {
        padding: 1.5rem;
    }
    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 2rem;
    }
    /* .card {
        border-radius: 12px;
        background-color: #f8f9fc;
    } */
    .table-sm td {
        padding: 0.5rem 0.5rem;
        vertical-align: middle;
    }
    .btn-danger {
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
</style>

<script>
    $(document).ready(function() {
        $("#form-delete").validate({
            rules: {},
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
                                dataUnit.ajax.reload();
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
                        submitBtn.html('<i class="fas fa-trash-alt me-2"></i>Ya, Hapus');
                    }
                });
                return false;
            }
        });
    });
</script>
@endempty
