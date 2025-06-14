@empty($role)
<div id="modal-master" class="modal-dialog" role="document">
    <div class="modal-content border-0" style="border-radius: 15px;">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">
                        <i class="ri-alert-line me-2"></i>Kesalahan
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Data tidak ditemukan</p>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
        <div class="modal-body p-4">
            <div class="alert alert-danger">
                <div class="d-flex align-items-center">
                    <i class="ri-error-warning-fill me-3" style="font-size: 24px;"></i>
                    <div>
                        <h5 class="mb-1">Kesalahan!!!</h5>
                        <p class="mb-0">Data yang anda cari tidak ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer border-0">
            <a href="{{ url('/role') }}" class="btn btn-warning waves-effect waves-light px-4" style="border-radius: 50px;">
                <i class="ri-arrow-left-line me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/role/' . $role->role_id.'/delete') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content border-0" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <div class="modal-header text-white bg-light">
                <div class="d-flex align-items-center w-100">
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0 text-dark">
                            <i class="ri-delete-bin-line me-2"></i>Hapus Data Role
                        </h5>
                        <p class="mb-0 small opacity-85 mt-1 text-muted">Konfirmasi penghapusan data</p>
                    </div>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="ri-alert-line me-3" style="font-size: 24px;"></i>
                        <div>
                            <h5 class="mb-1">Konfirmasi Penghapusan</h5>
                            <p class="mb-0">Apakah Anda yakin ingin menghapus data berikut?</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3 bg-light" style="border-radius: 12px;">
                        <h5 class="card-title d-flex align-items-center mb-3 text-danger">
                            <i class="ri-delete-bin-line me-2"></i>
                            Detail Role yang Akan Dihapus
                        </h5>

                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                    <i class="ri-fingerprint-line"></i>
                                </td>
                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">ID Role</td>
                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{ $role->role_id }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                    <i class="ri-barcode-line"></i>
                                </td>
                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Kode Role</td>
                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                    {{ $role->kode_role }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                    <i class="ri-shield-user-line"></i>
                                </td>
                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Nama Role</td>
                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                    {{ $role->nama_role }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-danger px-4 rounded-pill shadow-sm">
                    <i class="ri-delete-bin-line me-1"></i> Hapus
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
        padding: 1.25rem 1.5rem;
    }
    /* .card {
        border-radius: 12px;
        background-color: #f8f9fc;
    } */
    .table-sm td {
        padding: 0.5rem 0.5rem;
        vertical-align: middle;
    }
    .text-primary {
        color: #4e73df !important;
    }
    .badge {
        padding: 0.35rem 0.65rem;
        border-radius: 50px;
        font-weight: 500;
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
                submitBtn.html('<i class="ri-loader-4-line me-1"></i> Memproses...');

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
                            }).then(() => {
                                if (typeof dataUser !== 'undefined') {
                                    dataUser.ajax.reload();
                                } else {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonText: 'Mengerti'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                            confirmButtonText: 'Mengerti'
                        });
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="ri-delete-bin-line me-1"></i> Hapus');
                    }
                });
                return false;
            }
        });
    });
</script>
@endempty
