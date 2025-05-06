@empty($user)
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/user/' . $user->user_id . '/update') }}" method="POST" id="form-edit"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <label class="col-form-label">Role Pengguna</label>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <select name="role_id" id="role_id2" class="form-select" required>
                                            @foreach($role as $l)
                                                <option value="{{ $l->role_id }}" {{ $l->role_id == $user->role_id ? 'selected' : '' }}>{{ $l->nama_role }}</option>
                                            @endforeach
                                        </select>
                                        <small id="error-role_id" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>Username</label>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input type="text" name="username" id="username" class="form-control"
                                            value="{{ $user->username }}" required>
                                        <small id="error-username" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nama</label>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ $user->name }}" required>
                                        <small id="error-nama" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>

                            @if($user->role && $user->role->kode_role == 'TKS')
                                <div class="form-group" id="jenis-teknisi-container" hidden>
                                    <label class="col-form-label">Jenis Teknisi</label>
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <select name="jenis_teknisi_id" id="jenis_teknisi_id" class="form-select" required>
                                                @foreach($jenis_teknisi as $jt)
                                                    <option value="{{ $jt->jenis_teknisi_id }}" {{ (isset($user->teknisi) && $user->teknisi->jenis_teknisi_id == $jt->jenis_teknisi_id) ? 'selected' : '' }}>{{ $jt->nama_jenis_teknisi }}</option>
                                                @endforeach
                                            </select>
                                            <small id="error-teknisi_id" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                                <small class="form-text text-muted">Abaikan jika tidak ingin mengubah password</small>
                                <small id="error-password" class="error-text form-text text-danger"></small>
                            </div>
                        </div>


                        <div class="col-md-4 text-center">
                            <label for="foto_profile" class="position-relative d-block mx-auto"
                                style="width: 150px; height: 150px; clip-path: circle(50% at 50% 50%); cursor: pointer;">
                                <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}"
                                    alt="Profile Picture" class="rounded-circle w-100">
                                <div class="overlay rounded-circle" style="opacity: 0; transition: opacity 0.15s;"
                                    onmouseover="this.style.opacity = 1;" onmouseout="this.style.opacity = 0;">
                                    <i class="fas fa-upload position-absolute text-white"
                                        style="top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                </div>
                            </label>
                            <p class="mt-2 mb-1 text-muted" style="font-size: 14px;">Upload Foto Profil</p>
                            <input type="file" name="foto_profile" id="foto_profile" class="d-none"
                                accept="image/jpeg, image/jpg, image/png"
                                onchange="this.parentNode.querySelector('label').querySelector('img').src = window.URL.createObjectURL(this.files[0]);">
                            <small id="error-foto-profile" class="error-text form-text text-danger"></small>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <style>
        .overlay {
            opacity: 0;
            transition: opacity 0.15s ease-in-out;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    
        label:hover .overlay {
            opacity: 1;
        }
    </style>

    <script>

        $(document).ready(function () {
            const teknisiRoleId = "6"; // id teknisi

            function toggleJenisTeknisi() {
                var selectedRoleId = $('#role_id2').val(); // ambil nilai dari dropdown
                console.log('Selected Role ID:', selectedRoleId); // Debugging
                if (selectedRoleId === teknisiRoleId) {
                    $('#jenis-teknisi-container').prop('hidden', false).prop('required', true);
                } else {
                    $('#jenis-teknisi-container').prop('hidden', true).prop('required', false).val('');
                }
            }

            $(document).on('change', '#role_id2', function () {
                console.log('Event change terpicu');
                toggleJenisTeknisi();
            });

            toggleJenisTeknisi();


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
                submitHandler: function (form) {
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
                                    text: response.message
                                });
                                dataUser.ajax.reload();
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
@endempty