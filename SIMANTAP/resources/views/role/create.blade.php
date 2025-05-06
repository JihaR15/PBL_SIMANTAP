<form action="{{ url('/role/store') }}" method="POST" id="form-create" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <label>Kode Role</label>
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <input type="text" name="kode_role" id="kode_role" class="form-control" required>
                                    <small id="error-kode-role" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nama Role</label>
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <input type="text" name="nama_role" id="nama_role" class="form-control" required>
                                    <small id="error-nama-role" class="error-text form-text text-danger"></small>
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
        $("#form-create").validate({
            rules: {
                kode_role: {
                    required: true,
                    minlength: 3,
                    maxlength: 10
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
            }
        });
    });
</script>