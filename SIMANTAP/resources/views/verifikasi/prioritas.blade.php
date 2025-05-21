<style>
    .rating-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .rating-label-left, .rating-label-right {
        width: 80px;
        font-size: 0.85rem;
        color: #6c757d;
        user-select: none;
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
        font-weight: 700;
        font-size: 1.1rem;
    }
</style>

@php
    $ratingFields = [
        'tingkat_kerusakan' => [
            'label' => 'Tingkat Kerusakan',
            'left' => 'Ringan',
            'right' => 'Parah',
        ],
        'dampak_terhadap_aktivitas_akademik' => [
            'label' => 'Dampak Terhadap Aktivitas Akademik',
            'left' => 'Sedikit Gangguan',
            'right' => 'Sangat Mengganggu',
        ],
        'frekuensi_penggunaan_fasilitas' => [
            'label' => 'Frekuensi Penggunaan Fasilitas',
            'left' => 'Jarang',
            'right' => 'Sering',
        ],
        'ketersediaan_barang_pengganti' => [
            'label' => 'Ketersediaan Barang Pengganti',
            'left' => 'Sangat Sulit',
            'right' => 'Mudah Didapat',
        ],
        'tingkat_risiko_keselamatan' => [
            'label' => 'Tingkat Risiko Keselamatan',
            'left' => 'Rendah',
            'right' => 'Tinggi',
        ],
    ];
@endphp

<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-dialog modal-lg">
        <form id="formPrioritas" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalMasterLabel">Input Prioritas & Jenis Teknisi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <input type="hidden" name="laporan_id" value="{{ $laporan->laporan_id }}">

            <div class="col-md-12">
                <label for="teknisi_id" class="col-form-label">Pilih Teknisi</label>
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <select name="teknisi_id" class="form-select">
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
                </div>
            </div>

            @foreach ($ratingFields as $fieldName => $field)
            <div class="mb-3">
                <label class="form-label">{{ $field['label'] }}</label>
                <div class="rating-container">
                <div class="rating-label-left">{{ $field['left'] }}</div>
                <div class="rating-options">
                    @for ($i = 1; $i <= 5; $i++)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
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
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan & Hitung TOPSIS</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
        </form>
    </div>
</div>

@push('css')

@endpush
