<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-circle text-dark fa-2x me-2"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">Edit Profil Pengguna</h5>
                    <p class="mb-0 small opacity-75 text-muted">Perbarui informasi profil Anda</p>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="{{ url('profile') }}" method="POST" id="form-edit" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="pe-lg-4">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Role Pengguna</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-user-tag text-primary"></i>
                                    </span>
                                    <span class="form-control bg-light" style="border-radius: 0 10px 10px 0;">{{ $user->role->nama_role }}</span>
                                    <input type="hidden" name="role_id" value="{{ $user->role->role_id }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-at text-primary"></i>
                                    </span>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="{{ $user->username }}" style="border-radius: 0 10px 10px 0;" required>
                                </div>
                                <small id="error-username" class="error-text form-text text-danger"></small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $user->name }}" style="border-radius: 0 10px 10px 0;" required>
                                </div>
                                <small id="error-nama" class="error-text form-text text-danger"></small>
                            </div>

                            <div class="mb-4" id="jenis-teknisi-container" @if($user->role->nama_role != 'Teknisi') hidden @endif>
                                <label class="form-label fw-semibold">Jenis Teknisi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-tools text-primary"></i>
                                    </span>
                                    <select name="jenis_teknisi_id" id="jenis_teknisi_id" class="form-select" style="border-radius: 0 10px 10px 0;" required>
                                        @foreach($jenis_teknisi as $jt)
                                            <option value="{{ $jt->jenis_teknisi_id }}"
                                                {{ (isset($user->teknisi) && $user->teknisi->jenis_teknisi_id == $jt->jenis_teknisi_id) ? 'selected' : '' }}>
                                                {{ $jt->nama_jenis_teknisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <small id="error-teknisi_id" class="error-text form-text text-danger"></small>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-lock text-primary"></i>
                                    </span>
                                    <input type="password" name="password" id="password" class="form-control" style="border-radius: 0;">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-radius: 0 10px 10px 0;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                <small id="error-password" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex flex-column h-100">
                            <div class="text-center mb-3">
                                <h6 class="fw-semibold">Foto Profil</h6>
                                <hr class="mx-auto" style="width: 50%; border-top: 2px dashed #e9ecef;">
                            </div>

                            <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1">
                                <div class="position-relative mb-3">
                                    <label for="foto_profile" class="d-block cursor-pointer position-relative">
                                        <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}"
                                            alt="Profile Picture"
                                            class="rounded-circle shadow"
                                            style="width: 180px; height: 180px; object-fit: cover; border: 5px solid #f8f9fa;">
                                        <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 border border-3 border-white shadow-sm">
                                            <i class="fas fa-camera text-white"></i>
                                        </div>
                                    </label>
                                    <input type="file" name="foto_profile" id="foto_profile" class="d-none"
                                        accept="image/jpeg, image/jpg, image/png"
                                        onchange="document.querySelector('label[for=\'foto_profile\'] img').src = window.URL.createObjectURL(this.files[0])">
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mt-2 px-3"
                                    onclick="document.getElementById('foto_profile').click()">
                                    <i class="fas fa-upload me-2"></i>Unggah Foto
                                </button>
                                <small class="text-muted mt-2 text-center">Format: JPG/PNG (max 2MB)</small>
                                <small id="error-foto-profile" class="error-text form-text text-danger text-center"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

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
        padding: 2rem;
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 2rem;
    }

    .form-label {
        color: #495057;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .input-group-text {
        transition: all 0.3s ease;
    }

    .form-control, .form-select {
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #764ba2;
        box-shadow: 0 0 0 0.25rem rgba(118, 75, 162, 0.25);
    }

    .rounded-circle {
        transition: transform 0.3s ease;
    }

    .rounded-circle:hover {
        transform: scale(1.03);
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .btn-outline-primary:hover {
        background-color: rgba(118, 75, 162, 0.1);
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .shadow {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // password visibility toggle
        $('#togglePassword').click(function(){
            const passwordField = $('#password');
            const icon = $(this).find('i');

            passwordField.attr('type', passwordField.attr('type') === 'password' ? 'text' : 'password');

            $(this).toggleClass('btn-outline-secondary btn-primary');
            icon.toggleClass('fa-eye fa-eye-slash');

            $(this).addClass('animate__animated animate__bounceIn');
            setTimeout(() => {
                $(this).removeClass('animate__animated animate__bounceIn');
            }, 1000);
        });

        // Form validation
        const teknisiRoleId = "6";

        function toggleJenisTeknisi() {
            var roleName = "{{ $user->role->nama_role }}";

            if (roleName === 'Teknisi') {
                $('#jenis-teknisi-container').prop('hidden', false).hide().fadeIn(300);
                $('#jenis_teknisi_id').prop('required', true);
            } else {
                $('#jenis-teknisi-container').prop('hidden', true);
                $('#jenis_teknisi_id').prop('required', false);
            }
        }

        toggleJenisTeknisi();

        $(document).on('change', '#role_id2', function () {
            toggleJenisTeknisi();
        });

        $("#form-edit").validate({
            rules: {
                role_id: {
                    required: true,
                    number: true
                },
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                password: {
                    minlength: 5,
                    maxlength: 20
                },
                foto_profile: {
                    required: false,
                    accept: 'image/jpeg, image/jpg, image/png',
                    filesize: 2048
                }
            },
            messages: {
                role_id: {
                    required: "Harap pilih peran pengguna",
                    number: "Harap pilih peran pengguna dengan benar"
                },
                username: {
                    required: "Harap masukkan username",
                    minlength: "Username minimal 3 karakter",
                    maxlength: "Username maksimal 20 karakter"
                },
                name: {
                    required: "Harap masukkan nama lengkap",
                    minlength: "Nama minimal 3 karakter",
                    maxlength: "Nama maksimal 100 karakter"
                },
                password: {
                    minlength: "Password minimal 5 karakter",
                    maxlength: "Password maksimal 20 karakter"
                },
                foto_profile: {
                    accept: "Hanya file JPG, JPEG, atau PNG yang diperbolehkan",
                    filesize: "Ukuran file maksimal 2MB"
                }
            },
            submitHandler: function (form) {
                const submitBtn = $(form).find('button[type="submit"]');
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // console.log(response);
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                                background: '#fff',
                                backdrop: `
                                    url("/images/nyan-cat.gif")
                                    left top
                                    no-repeat
                                `
                            });
                            setTimeout(() => {
                                location.reload();
                                dataUser.ajax.reload();
                            }, 1500);
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
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
                        submitBtn.html('<i class="fas fa-save me-2"></i>Simpan Perubahan');
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).closest('.input-group').find('.input-group-text').css({
                    'border-color': '#dc3545',
                    'background-color': 'rgba(220, 53, 69, 0.1)'
                });
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).closest('.input-group').find('.input-group-text').css({
                    'border-color': '#e9ecef',
                    'background-color': '#f8f9fa'
                });
            }
        });
    });
</script>
