<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">
                        <i class="fas fa-building me-2"></i>Data Unit
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Detail informasi unit</p>
                </div>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <div class="modal-body p-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 bg-light" style="border-radius: 12px;">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                <i class="fas fa-id-card"></i>
                            </td>
                            <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">ID Unit</td>
                            <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $unit->unit_id }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                <i class="fas fa-warehouse"></i>
                            </td>
                            <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Jenis Fasilitas</td>
                            <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                {{ $unit->fasilitas->nama_fasilitas }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                <i class="fas fa-building"></i>
                            </td>
                            <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Nama Unit</td>
                            <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                {{ $unit->nama_unit }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- <div class="modal-footer bg-light">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                <i class="fas fa-times me-2"></i>Tutup
            </button>
        </div> --}}
    </div>
</div>

<style>
    .modal-content {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: none;
    }
    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }
    .modal-body {
        padding: 1.5rem;
    }
    /* .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
    }
    .card {
        border-radius: 12px;
        background-color: #f8f9fc;
    } */
    /* .table-sm td {
        padding: 0.5rem 0.5rem;
        vertical-align: middle;
    } */
    .badge {
        padding: 0.35rem 0.65rem;
        border-radius: 50px;
        font-weight: 500;
    }
    .btn-outline-secondary {
        transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }
</style>
