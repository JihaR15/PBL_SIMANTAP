<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Periode</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="d-flex align-items-start align-items-center">

                <div class="flex-grow-1">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td style="width: 150px;"><strong>ID</strong></td>
                            <td>: {{ $periode->periode_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Role</strong></td>
                            <td>: {{ $periode->nama_periode }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>