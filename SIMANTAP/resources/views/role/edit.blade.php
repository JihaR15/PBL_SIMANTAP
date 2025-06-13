@empty($role)
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <div class="modal-header text-white bg-light">
                <div class="d-flex align-items-center w-100">
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0 text-dark">
                            <i class="fas fa-exclamation-triangle me-2"></i>Kesalahan
                        </h5>
                        <p class="mb-0 small opacity-85 mt-1 text-muted">Data tidak ditemukan</p>
                    </div>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger" style="border-radius: 10px;">
                    <h5><i class="fas fa-exclamation-circle me-2"></i> Kesalahan!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
            </div>
            <div class="modal-footer bg-light">
                <a href="{{ url('/role') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/role/' . $role->role_id . '/update') }}" method="POST" id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
                <div class="modal-header text-white bg-light">
                    <div class="d-flex align-items-center w-100">
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0 text-dark">
                                <i class="fas fa-user-cog me-2"></i>Edit Data Role
                            </h5>
                            <p class="mb-0 small opacity-85 mt-1 text-muted">Formulir perubahan data role</p>
                        </div>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ri-barcode-line me-2 text-primary"></i>Kode Role
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-code text-muted"></i>
                            </span>
                            <input type="text" name="kode_role" id="kode_role"
                                   class="form-control rounded-end"
                                   value="{{ $role->kode_role }}"
                                   placeholder="Contoh: ADM"
                                   required>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small id="error-kode-role" class="error-text form-text text-danger"></small>
                            {{-- <small class="text-muted">Huruf besar, angka, underscore</small> --}}
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ri-shield-user-line me-2 text-primary"></i>Nama Role
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-user-tag text-muted"></i>
                            </span>
                            <input type="text" name="nama_role" id="nama_role"
                                   class="form-control rounded-end"
                                   value="{{ $role->nama_role }}"
                                   placeholder="Contoh: Administrator"
                                   required>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small id="error-nama-role" class="error-text form-text text-danger"></small>
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
            border-radius: 10px;
            border: none;
            background-color: #f8d7da;
        }
    </style>

    <script>
    $(document).ready(function () {
        $('#form-edit').on('submit', function (e) {
            e.preventDefault();

            const form = this;
            const kodeRole = $('#kode_role').val().trim();
            const namaRole = $('#nama_role').val().trim();

            $('.error-text').text('');
            $('#kode_role, #nama_role').removeClass('is-invalid');
            $('.input-group-text').css({ 'border-color': '#ced4da', 'color': '#6c757d' });

            let isValid = true;

            if (!kodeRole) {
                isValid = false;
                $('#kode_role').addClass('is-invalid');
                $('#error-kode-role').text('Kode role wajib diisi');
                $('#kode_role').closest('.input-group').find('.input-group-text').css({
                    'border-color': '#dc3545',
                    'color': '#dc3545'
                });
            } else if (kodeRole.length < 2) {
                isValid = false;
                $('#kode_role').addClass('is-invalid');
                $('#error-kode-role').text('Minimal 2 karakter');
                $('#kode_role').closest('.input-group').find('.input-group-text').css({
                    'border-color': '#dc3545',
                    'color': '#dc3545'
                });
            } else if (kodeRole.length > 10) {
                isValid = false;
                $('#kode_role').addClass('is-invalid');
                $('#error-kode-role').text('Maksimal 10 karakter');
                $('#kode_role').closest('.input-group').find('.input-group-text').css({
                    'border-color': '#dc3545',
                    'color': '#dc3545'
                });
            } else if (!/^[A-Z0-9_]+$/i.test(kodeRole)) {
                isValid = false;
                $('#kode_role').addClass('is-invalid');
                $('#error-kode-role').text('Hanya boleh huruf, angka dan underscore');
                $('#kode_role').closest('.input-group').find('.input-group-text').css({
                    'border-color': '#dc3545',
                    'color': '#dc3545'
                });
            }

            if (!namaRole) {
                isValid = false;
                $('#nama_role').addClass('is-invalid');
                $('#error-nama-role').text('Nama role wajib diisi');
                $('#nama_role').closest('.input-group').find('.input-group-text').css({
                    'border-color': '#dc3545',
                    'color': '#dc3545'
                });
            } else if (namaRole.length < 3) {
                isValid = false;
                $('#nama_role').addClass('is-invalid');
                $('#error-nama-role').text('Minimal 3 karakter');
                $('#nama_role').closest('.input-group').find('.input-group-text').css({
                    'border-color': '#dc3545',
                    'color': '#dc3545'
                });
            } else if (namaRole.length > 50) {
                isValid = false;
                $('#nama_role').addClass('is-invalid');
                $('#error-nama-role').text('Maksimal 50 karakter');
                $('#nama_role').closest('.input-group').find('.input-group-text').css({
                    'border-color': '#dc3545',
                    'color': '#dc3545'
                });
            }

            if (!isValid) return;

            const submitBtn = $(form).find('button[type="submit"]');
            const originalContent = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

            $.ajax({
                url: form.action,
                type: form.method,
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function (response) {
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
                        if (response.msgField) {
                            $.each(response.msgField, function (prefix, val) {
                                const fieldId = prefix.replace('.', '-');
                                $('#error-' + fieldId).text(val[0]);
                                $('#' + fieldId).addClass('is-invalid');
                                $('#' + fieldId).closest('.input-group').find('.input-group-text').css({
                                    'border-color': '#dc3545',
                                    'color': '#dc3545'
                                    });
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
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server',
                            background: '#fff',
                            backdrop: 'rgba(0,0,0,0.5)'
                        });
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).html(originalContent);
                    }
                });
            });
        });
    </script>
@endempty
