<style>
    .rating-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
    }
    .rating-label-left, .rating-label-right {
        width: 100px;
        font-size: 0.85rem;
        color: #64748b;
        user-select: none;
        font-weight: 500;
    }
    .rating-label-right {
        text-align: right;
    }
    .rating-options {
        display: flex;
        gap: 12px;
        flex-grow: 1;
        justify-content: center;
    }
    .form-label {
        font-weight: 600;
        font-size: 1rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.1em;
    }
    .form-check-label {
        font-weight: 500;
        color: #475569;
    }
    .modal-header {
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
    }
    .modal-title {
        font-weight: 500; /* Slightly bolder */
        color: #1e293b;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .modal-body {
        padding: 1.5rem;
    }
    .modal-footer {
        border-top: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
    }
    .form-select {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        border: 1px solid #cbd5e1;
        transition: all 0.2s ease;
    }
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
    }
    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
        box-shadow: 0 1px 2px rgba(59, 130, 246, 0.2);
    }
    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
    }
    .btn-primary:active {
        transform: translateY(0);
    }
    .btn-secondary {
        background-color: #64748b;
        border-color: #64748b;
        color: white;
        box-shadow: 0 1px 2px rgba(100, 116, 139, 0.2);
    }
    .btn-secondary:hover {
        background-color: #475569;
        border-color: #475569;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(100, 116, 139, 0.3);
        color: white;
    }
    .btn-secondary:active {
        transform: translateY(0);
    }
    .form-check-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    /* Loading spinner */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }
    .btn-loading .spinner {
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -0.5em;
        margin-top: -0.5em;
        width: 1em;
        height: 1em;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }
    .btn-loading .btn-text {
        opacity: 0;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    /* Icon styles */
    .modal-title i {
        color: #000; /* Black color for title icon */
    }
    .teknisi-icon i {
        color: #3b82f6; /* Blue color for teknisi icon */
    }
</style>

@php
    $ratingFields = [
        'tingkat_kerusakan' => [
            'label' => 'Tingkat Kerusakan',
            'left' => 'Ringan',
            'right' => 'Parah',
            'icon' => 'ri-alert-line'
        ],
        'dampak_terhadap_aktivitas_akademik' => [
            'label' => 'Dampak Terhadap Aktivitas Akademik',
            'left' => 'Sedikit Gangguan',
            'right' => 'Sangat Mengganggu',
            'icon' => 'ri-book-line'
        ],
        'frekuensi_penggunaan_fasilitas' => [
            'label' => 'Frekuensi Penggunaan Fasilitas',
            'left' => 'Jarang',
            'right' => 'Sering',
            'icon' => 'ri-calendar-event-line'
        ],
        'ketersediaan_barang_pengganti' => [
            'label' => 'Ketersediaan Barang Pengganti',
            'left' => 'Sangat Sulit',
            'right' => 'Mudah Didapat',
            'icon' => 'ri-store-line'
        ],
        'tingkat_risiko_keselamatan' => [
            'label' => 'Tingkat Risiko Keselamatan',
            'left' => 'Rendah',
            'right' => 'Tinggi',
            'icon' => 'ri-shield-line'
        ],
    ];
@endphp

<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-dialog modal-lg">
        <form id="formPrioritas" class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMasterLabel">
                    <i class="ri-settings-5-line"></i> Input Prioritas & Jenis Teknisi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="laporan_id" value="{{ $laporan->laporan_id }}">

                <div class="mb-4">
                    <label for="teknisi_id" class="form-label teknisi-icon">
                        <i class="ri-user-settings-line"></i> Pilih Teknisi
                    </label>
                    <select name="teknisi_id" class="form-select shadow-sm">
                        <option value="">Pilih Teknisi</option>
                        @foreach ($teknisi as $t)
                            <option value="{{ $t->teknisi_id }}">
                                {{ $t->user->name ?? 'Nama teknisi tidak tersedia' }}
                                ({{ $t->jenis_teknisi->nama_jenis_teknisi ?? 'Jenis teknisi tidak diketahui' }})
                            </option>
                        @endforeach
                    </select>
                    <small id="error-teknisi_id" class="error-text form-text text-danger"></small>
                </div>

                @foreach ($ratingFields as $fieldName => $field)
                <div class="mb-4">
                    <label class="form-label">
                        {{ $field['label'] }}
                    </label>
                    <div class="rating-container">
                        <div class="rating-label-left">{{ $field['left'] }}</div>
                        <div class="rating-options">
                            @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input shadow-sm" type="radio"
                                    name="{{ $fieldName }}"
                                    id="{{ $fieldName . $i }}"
                                    value="{{ $i }}" required>
                                <label class="form-check-label" for="{{ $fieldName . $i }}">{{ $i }}</label>
                            </div>
                            @endfor
                        </div>
                        <div class="rating-label-right">{{ $field['right'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="modal-footer bg-slate-50">
                <button type="submit" id="submitBtn" class="btn btn-primary rounded-pill px-4 py-2">
                    <span class="btn-text">
                        <i class="ri-save-line me-1"></i> Simpan & Hitung TOPSIS
                    </span>
                    <span class="spinner d-none"></span>
                </button>
                <button type="button" class="btn btn-secondary rounded-pill px-4 py-2 me-2" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('formPrioritas').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const originalHtml = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;

        setTimeout(() => {
            // Restore original button state
            submitBtn.innerHTML = originalHtml;
            submitBtn.disabled = false;
        }, 2000);
    });
</script>

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
