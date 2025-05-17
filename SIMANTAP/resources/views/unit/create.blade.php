<form action="{{ url('unit/store') }}" method="POST" id="form-create" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <label>Jenis Fasilitas</label>
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    @if($fasumExist)
                                        <input type="text" class="form-control" value="Fasilitas Gedung" readonly>
                                        <input type="hidden" name="fasilitas_id" value="1">
                                    @else
                                        <select id="fasilitas_id" class="form-select" name="fasilitas_id" required>
                                            <option value="">- Semua -</option>
                                            @foreach($fasilitas as $f)
                                                @if($f->fasilitas_id != 2 || !$fasumExist)
                                                    <option value="{{ $f->fasilitas_id }}"
                                                        {{ old('fasilitas_id', isset($unit) ? $unit->fasilitas_id : '') == $f->fasilitas_id ? 'selected' : '' }}>
                                                        {{ $f->nama_fasilitas }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Nama Unit</label>
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <input type="text" name="nama_unit" id="nama_unit" class="form-control" required>
                                    <small id="error-kode-role" class="error-text form-text text-danger"></small>
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
        $("#form-create").validate({
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
                            dataUnit.ajax.reload();
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
