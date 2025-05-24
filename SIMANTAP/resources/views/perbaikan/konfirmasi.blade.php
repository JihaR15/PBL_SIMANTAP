<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-dialog modal-lg">
        <form id="formKonfirmasi" class="modal-content" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="modalMasterLabel">Input Prioritas & Jenis Teknisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="biaya" class="form-label">Biaya</label>
                    <input type="number" class="form-control" id="biaya" name="biaya" required>
                </div>
                <div class="mb-3">
                    <label for="catatan_perbaikan" class="form-label">Catatan Perbaikan</label>
                    <textarea class="form-control" id="catatan_perbaikan" name="catatan_perbaikan" rows="3"
                        required></textarea>
                </div>
                <div class="mb-3">
                    <label for="foto_perbaikan" class="form-label">Foto Perbaikan</label>
                    <input type="file" name="foto_perbaikan" id="foto_perbaikan" class="form-control"
                        accept="image/jpeg,image/jpg,image/png,image/gif,application/pdf" required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Selesaikan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>