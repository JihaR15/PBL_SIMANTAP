@empty($tempat)
    <!-- Error State -->
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content border-0" style="border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Data Tidak Ditemukan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-ban fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Kesalahan!</h5>
                            <p class="mb-0">Data ruang yang diminta tidak ditemukan dalam sistem.</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-warning rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Edit Form -->
    <form action="{{ url('/tempat/'.$unit->unit_id.'/update/'.$tempat->tempat_id) }}" method="POST" id="form-edit-tempat" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content border-0" style="border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div class="modal-header bg-light text-white">
                    <div class="d-flex w-100 align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-1">
                                <i class="fas fa-edit me-2"></i>Edit Ruang
                            </h5>
                            <p class="mb-0 small opacity-85 text-muted">Unit: {{ $unit->nama_unit }}</p>
                        </div>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body p-4">
                    {{-- <div class="alert alert-info border-0 mb-4">
                        <i class="fas fa-info-circle me-2"></i> Perbarui informasi ruang berikut
                    </div> --}}

                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-door-closed me-2 text-primary"></i>Nama Ruang
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-font text-muted"></i>
                            </span>
                            <input type="text" name="nama_tempat" id="nama_tempat"
                                   class="form-control rounded-end"
                                   placeholder="Contoh: Ruang Meeting Lantai 2"
                                   value="{{ old('nama_tempat', $tempat->nama_tempat) }}"
                                   required>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small id="error-nama_tempat" class="error-text form-text text-danger"></small>
                            {{-- <small class="text-muted">Max. 50 karakter</small> --}}
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
            border: none;
            overflow: hidden;
        }
        .modal-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .modal-body {
            padding: 1.5rem;
        }
        .modal-footer {
            border-top: 1px solid rgba(0,0,0,0.05);
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
        }
        .btn-outline-secondary {
            transition: all 0.3s ease;
        }
        .btn-primary {
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
        }
        .btn-primary:active {
            transform: translateY(0);
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
        .alert-info {
            background-color: #f0f9ff;
            border-color: #bae6fd;
            color: #0369a1;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#form-edit-tempat").validate({
                rules: {
                    nama_tempat: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    }
                },
                messages: {
                    nama_tempat: {
                        required: "Nama ruang wajib diisi",
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
                    $(element).closest('.input-group').find('.input-group-text').addClass('border-danger text-danger');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest('.input-group').find('.input-group-text').removeClass('border-danger text-danger');
                },
                submitHandler: function(form) {
                    const submitBtn = $(form).find('button[type="submit"]');
                    const originalContent = submitBtn.html();

                    // Disable button and show loading state
                    submitBtn.prop('disabled', true);
                    submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

                    // Submit form via AJAX
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    background: '#fff',
                                    backdrop: 'rgba(0,0,0,0.5)'
                                }).then(() => {
                                    $('#myModal').modal('hide');
                                    if (typeof dataTempat !== 'undefined') {
                                        dataTempat.ajax.reload(null, false);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan saat menyimpan data',
                                    background: '#fff',
                                    backdrop: 'rgba(0,0,0,0.5)'
                                });

                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix.replace('.', '-')).text(val[0]);
                                    });
                                }
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
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

            // Prevent form submission on Enter key
            $('#form-edit-tempat').on('keyup keypress', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endempty
