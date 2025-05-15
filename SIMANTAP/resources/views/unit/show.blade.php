<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Unit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row align-items-center">
                <div class="col-12 col-md">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td style="width: 150px;"><strong>ID</strong></td>
                            <td>: {{ $unit->unit_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Fasilitas</strong></td>
                            <td>: {{ $unit->fasilitas->nama_fasilitas }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Unit</strong></td>
                            <td>: {{ $unit->nama_unit }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>