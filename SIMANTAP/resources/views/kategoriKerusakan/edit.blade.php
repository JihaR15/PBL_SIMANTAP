@empty($kategoriKerusakan)
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark"><i class="fas fa-exclamation-triangle me-2 text-danger"></i>Kesalahan</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-ban fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Kesalahan!</h5>
                            <p class="mb-0">Data yang anda cari tidak ditemukan</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ url('/kategoriKerusakan') }}" class="btn btn-warning rounded-pill px-4 shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/kategoriKerusakan/' . $kategoriKerusakan->kategori_kerusakan_id . '/update') }}" method="POST" id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
                <div class="modal-header bg-light">
                    <div class="d-flex align-items-center w-100">
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0 text-dark">
                                <i class="fas fa-edit me-2"></i>Edit Kategori Kerusakan
                            </h5>
                            <p class="mb-0 small opacity-85 mt-1 text-muted">Memperbarui data kategori</p>
                        </div>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tag me-2 text-primary"></i>Kategori Kerusakan
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-tools text-muted"></i>
                            </span>
                            <input type="text" name="nama_kategori" id="nama_kategori"
                                   class="form-control rounded-end"
                                   placeholder="Contoh: Kerusakan Hardware"
                                   value="{{ $kategoriKerusakan->nama_kategori }}"
                                   required>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small id="error-nama_kategori" class="error-text form-text text-danger"></small>
                            {{-- <small class="text-muted text-end"><span id="char-count">{{ strlen($kategoriKerusakan->nama_kategori) }}</span>/100 karakter</small> --}}
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
        .alert-danger {
            background-color: #fef2f2;
            border-color: #fecaca;
            color: #b91c1c;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Character counter
            $('#nama_kategori').on('input', function() {
                const currentLength = $(this).val().length;
                $('#char-count').text(currentLength);

                if (currentLength > 100) {
                    $(this).addClass('is-invalid');
                    $('#error-nama_kategori').text('Maksimal 100 karakter');
                } else {
                    $(this).removeClass('is-invalid');
                    $('#error-nama_kategori').text('');
                }
            });

            $("#form-edit").validate({
                rules: {
                    nama_kategori: {
                        required: true,
                        minlength: 12,
                        maxlength: 100
                    }
                },
                messages: {
                    nama_kategori: {
                        required: "Nama kategori wajib diisi",
                        minlength: "Minimal 12 karakter",
                        maxlength: "Maksimal 100 karakter"
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
                                    if (typeof dataKategori !== 'undefined') {
                                        dataKategori.ajax.reload(null, false);
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
