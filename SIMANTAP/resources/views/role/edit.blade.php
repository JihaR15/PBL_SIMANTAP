@empty($role)
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
                <a href="{{ url('/role') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/role/' . $role->role_id . '/update') }}" method="POST" id="form-edit"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-12">
                                <label>Kode Role</label>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input type="text" name="kode_role" id="kode_role" class="form-control"
                                            value="{{ $role->kode_role }}" required>
                                        <small id="error-kode-role" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nama Role</label>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input type="text" name="nama_role" id="nama_role" class="form-control"
                                            value="{{ $role->nama_role }}" required>
                                        <small id="error-nama" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
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

    <script>

        $(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    kode_role: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    nama_role: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
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