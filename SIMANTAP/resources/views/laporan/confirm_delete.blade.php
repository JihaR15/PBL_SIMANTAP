@empty($laporan)
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
                <a href="{{ url('/laporan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/laporan/' . $laporan->laporan_id . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5 class="alert-heading"><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data seperti di bawah ini?
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="{{ $laporan->foto_laporan ? 'col-md-8' : 'col-md-12' }}">
                                <table class="table table-bordered table-striped table-hover table-sm">
                                    <tr>
                                        <th class="text-nowrap" style="width: 150px;">Laporan ID:</th>
                                        <td>{{ $laporan->laporan_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unit</th>
                                        <td>{{ $laporan->unit->nama_unit ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat</th>
                                        <td>{{ $laporan->tempat->nama_tempat ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Barang</th>
                                        <td>{{ $laporan->barangLokasi->jenisBarang->nama_barang ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori Kerusakan</th>
                                        <td>{{ $laporan->kategoriKerusakan->nama_kategori ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode</th>
                                        <td>{{ $laporan->periode->nama_periode ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Verifikasi</th>
                                        <td>{{ $laporan->status_verif }}</td>
                                    </tr>
                                </table>
                            </div>
                            @if ($laporan->foto_laporan)
                                <div class="col-md-4">
                                    <p><strong>Foto Laporan:</strong></p>
                                    <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan"
                                        class="img-fluid" style="max-width: 100%;">
                                </div>
                            @endif
                            <div class="col-md-12">
                                <p><strong>Deskripsi:</strong></p>
                                <div class="border p-2 rounded" style="background-color: #f8f9fa; margin-top: 0.5rem;">
                                    {{ $laporan->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                                </div>
                            </div>
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
        $(document).ready(function () {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                $('#datatable').DataTable().ajax.reload();
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