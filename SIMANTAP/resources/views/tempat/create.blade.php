<form action="{{ url('/tempat/'.$unit->unit_id.'/store') }}" method="POST" id="form-create-tempat">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ruang di {{ $unit->nama_unit }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Nama Ruang</label>
                            <input type="text" name="nama_tempat" class="form-control" required>
                            <small id="error-nama_tempat" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal" onclick="modalAction('{{ url('/tempat/'.$unit->unit_id.'/popup') }}')">Batal</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="modalAction('{{ url('/tempat/'.$unit->unit_id.'/popup') }}')">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#form-create-tempat").validate({
            rules: {},
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
                            // reload datatable-tempat jika perlu
                            if (typeof dataTempat !== 'undefined') dataTempat.ajax.reload();
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