<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Ruang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row align-items-center">
                <div class="col-12 col-md">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td style="width: 150px;"><strong>Nama Unit</strong></td>
                            <td>: {{ $unit->nama_unit }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Ruang</strong></td>
                            <td>: {{ $tempat->nama_tempat }}</td>
                        </tr>
                        {{-- Tambahkan detail lain jika ada --}}
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal" onclick="modalAction('{{ url('/tempat/'.$unit->unit_id.'/popup') }}')">Tutup</button>
        </div>
    </div>
</div>