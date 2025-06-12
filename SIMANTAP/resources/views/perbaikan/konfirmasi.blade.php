<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0" style="overflow: hidden; border-radius: 12px;">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">
                        <i class="ri-checkbox-circle-line me-2"></i>Input Biaya dan Catatan Perbaikan
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Konfirmasi penyelesaian perbaikan</p>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <form id="formKonfirmasi" class="modal-content" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="biaya" name="biaya" placeholder="Biaya Perbaikan" required>
                            <label for="biaya" class="text-muted">
                                <i class="ri-money-dollar-circle-line text-primary me-2"></i>Biaya Perbaikan
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" id="catatan_perbaikan" name="catatan_perbaikan"
                                placeholder="Catatan Perbaikan" style="height: 120px" required></textarea>
                            <label for="catatan_perbaikan" class="text-muted">
                                <i class="ri-file-text-line text-primary me-2"></i>Catatan Perbaikan
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="card-title mb-0">
                                    <i class="ri-image-line me-2 text-primary"></i>Foto Perbaikan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="file-upload-wrapper">
                                    <input type="file" name="foto_perbaikan" id="foto_perbaikan"
                                        class="form-control" accept="image/*" required>
                                    <small class="text-muted d-block mt-2">
                                        <i class="ri-information-line me-1"></i>Format yang didukung: JPG, PNG, GIF
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                    <i class="ri-check-line me-1"></i> Selesaikan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }

    /* .form-floating label {
        padding-left: 2.5rem;
    } */

    .form-floating .ri {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .file-upload-wrapper {
        position: relative;
    }

    .file-upload-wrapper input[type="file"] {
        padding: 1rem;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .card {
        border-radius: 0.5rem !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .btn-close-black {
        filter: brightness(0);
    }

    .btn {
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-outline-secondary {
        border: 1px solid #dee2e6;
    }

    .btn-primary {
        box-shadow: 0 2px 6px rgba(13, 110, 253, 0.2);
    }

    .btn-primary:hover {
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        transform: translateY(-1px);
    }

    .dark-mode .modal-content {
        background-color: #252b3b;
        color: #e9ecef;
    }

    .dark-mode .modal-header {
        border-bottom-color: #3a4155;
    }

    .dark-mode .modal-footer {
        border-top-color: #3a4155;
    }

    .dark-mode .text-muted {
        color: #8a93a2 !important;
    }

    .dark-mode .bg-light {
        background-color: #2a3042 !important;
    }

    .dark-mode .btn-close-black {
        filter: brightness(1);
    }

    .dark-mode .file-upload-wrapper input[type="file"] {
        background-color: #2a3042;
        border-color: #3a4155;
        color: #e9ecef;
    }

    .dark-mode .btn-outline-secondary {
        border-color: #3a4155;
        color: #e9ecef;
    }

    .dark-mode .btn-outline-secondary:hover {
        background-color: #3a4155;
    }
</style>
