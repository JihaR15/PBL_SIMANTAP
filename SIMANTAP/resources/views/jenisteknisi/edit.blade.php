@empty($jenisteknisi)
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <div class="modal-header text-white bg-danger">
                <div class="d-flex align-items-center w-100">
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0 text-white">
                            <i class="fas fa-exclamation-triangle me-2"></i>Kesalahan
                        </h5>
                        <p class="mb-0 small opacity-85 mt-1 text-white">Data tidak ditemukan</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger border-0 bg-light-danger">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-ban fa-2x text-danger me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Kesalahan!</h5>
                            <p class="mb-0">Data yang anda cari tidak ditemukan</p>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ url('/jenisteknisi') }}" class="btn btn-warning rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/jenisteknisi/' . $jenisteknisi->jenis_teknisi_id . '/update') }}" method="POST" id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
                <div class="modal-header text-white bg-light">
                    <div class="d-flex align-items-center w-100">
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0 text-dark">
                                <i class="fas fa-user-edit me-2"></i>Edit Data Jenis Teknisi
                            </h5>
                            <p class="mb-0 small opacity-85 mt-1 text-muted">Memperbarui data jenis teknisi</p>
                        </div>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tools me-2 text-primary"></i>Nama Jenis Teknisi
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-font text-muted"></i>
                            </span>
                            <input type="text" name="nama_jenis_teknisi" id="nama_jenis_teknisi"
                                   class="form-control rounded-end"
                                   placeholder="Contoh: Teknisi Listrik, Teknisi AC"
                                   value="{{ $jenisteknisi->nama_jenis_teknisi }}"
                                   required>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small id="error-nama_jenis_teknisi" class="error-text form-text text-danger"></small>
                            {{-- <small class="text-muted">Min. 3 karakter, Max. 50 karakter</small> --}}
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    nama_jenis_teknisi: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    }
                },
                messages: {
                    nama_jenis_teknisi: {
                        required: "Nama jenis teknisi wajib diisi",
                        minlength: "Minimal 3 karakter",
                        maxlength: "Maksimal 50 karakter"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').find('.error-text').html(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    $(element).closest('.input-group').find('.input-group-text').css({
                        'border-color': '#dc3545',
                        'color': '#dc3545'
                    });
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest('.input-group').find('.input-group-text').css({
                        'border-color': '#ced4da',
                        'color': '#6c757d'
                    });
                },
                submitHandler: function(form) {
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
                                    timer: 1500,
                                    background: '#fff',
                                    backdrop: 'rgba(0,0,0,0.5)'
                                }).then(() => {
                                    if (typeof dataUser !== 'undefined') {
                                        dataUser.ajax.reload(null, false);
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
                                    text: response.message || 'Terjadi kesalahan saat menyimpan data',
                                    background: '#fff',
                                    backdrop: 'rgba(0,0,0,0.5)'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server',
                                background: '#fff',
                                backdrop: 'rgba(0,0,0,0.5)'
                            });
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false);
                            submitBtn.html(originalContent);
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty
