@empty($tempat)
<div id="modal-master" class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/tempat/'.$unit_id.'/popup') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/tempat/' . $unit_id . '/delete/' . $tempat->tempat_id) }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Ruang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                    Apakah Anda ingin menghapus data berikut?
                </div>
                <div class="d-flex align-items-start align-items-center">
                    <div class="flex-grow-1">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th class="text-nowrap" style="width: 150px;">Nama Ruang</th>
                                <td>{{ $tempat->nama_tempat }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Unit</th>
                                <td>{{ $tempat->unit->nama_unit ?? '' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-delete").validate({
            rules: {},
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            if (typeof dataTempat !== 'undefined') dataTempat.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
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
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endempty