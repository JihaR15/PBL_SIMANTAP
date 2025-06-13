<form action="{{ url('/periode/store') }}" method="POST" id="form-create" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <div class="modal-header bg-light">
                <div class="d-flex align-items-center w-100">
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0 text-dark">
                            <i class="fas fa-calendar-plus me-2"></i>Tambah Data Periode
                        </h5>
                        <p class="mb-0 small opacity-85 mt-1 text-muted">Formulir penambahan periode baru</p>
                    </div>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body p-4">
                <div class="form-group mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Tahun Periode
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-hashtag text-muted"></i>
                        </span>
                        <input type="text" name="nama_periode" id="nama_periode"
                               class="form-control rounded-end"
                               placeholder="Contoh: 2024"
                               required>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small id="error-nama-periode" class="error-text form-text text-danger"></small>
                        {{-- <small class="text-muted text-end"><span id="char-count">0</span>/10 karakter</small> --}}
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save me-2"></i>Simpan
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
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }
    .modal-body {
        padding: 1.5rem;
    }
    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
    }
    .input-group-text {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    .form-control {
        transition: all 0.3s ease;
        border-left: 0;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    .form-control:focus + .input-group-text {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .btn-outline-secondary {
        transition: all 0.3s ease;
    }
    .btn-primary {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
    }
    .btn-primary:active:after {
        width: 200%;
        padding-top: 200%;
        transition: width .4s ease-out, padding-top .4s ease-out;
    }
    .btn-primary:after {
        content: "";
        display: block;
        position: absolute;
        left: 50%;
        top: 50%;
        width: 0;
        padding-top: 0;
        border-radius: 100%;
        background-color: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .is-invalid + .input-group-text {
        border-color: #dc3545 !important;
    }
</style>

<script>
    $(document).ready(function () {
        $('#nama_periode').on('input', function () {
            const currentLength = $(this).val().length;
            $('#char-count').text(currentLength);

            if (currentLength > 10) {
                $(this).addClass('is-invalid');
                $('#error-nama-periode').text('Maksimal 10 karakter');
            } else {
                $(this).removeClass('is-invalid');
                $('#error-nama-periode').text('');
            }
        });

        $('#nama_periode').on('blur', function () {
            const value = $(this).val();
            if (value.length > 0 && !/^(\d{4}-\d{4}|\d{4})$/.test(value)) {
                $(this).addClass('is-invalid');
                $('#error-nama-periode').text('Format tahun tidak valid. Gunakan format YYYY atau YYYY-YYYY');
            }
        });

        $('#form-create').on('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = $(form).find('button[type="submit"]');
            const originalContent = submitBtn.html();

            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            if (typeof dataPeriode !== 'undefined') {
                                dataPeriode.ajax.reload();
                            }
                        });
                    } else {
                        $('.error-text').text('');
                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix.replace('.', '-')).text(val[0]);
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server'
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                    submitBtn.html(originalContent);
                }
            });
        });
    });
</script>
