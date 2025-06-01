<div id="modal-master" class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Beri Feedback</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card mb-4">
                <div class="card-header">
                    Berikan Feedback Anda
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($existingFeedback) ? url('feedback/' . $laporan->laporan_id . '/update') : url('feedback/' . $laporan->laporan_id . '/store') }}"
                        method="POST">
                        @csrf
                        @if (isset($existingFeedback))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating</label>
                            <div class="d-flex align-items-center">
                                @php
                                    $emotes = [
                                        1 => ['icon' => 'ri-emotion-unhappy-line', 'label' => 'Tidak Puas'],
                                        2 => ['icon' => 'ri-emotion-sad-line', 'label' => 'Kurang Puas'],
                                        3 => ['icon' => 'ri-emotion-normal-line', 'label' => 'Biasa Saja'],
                                        4 => ['icon' => 'ri-emotion-happy-line', 'label' => 'Puas'],
                                        5 => ['icon' => 'ri-emotion-laugh-line', 'label' => 'Sangat Puas'],
                                    ];
                                @endphp
                                <div class="mb-2">
                                    <div class="d-flex gap-3 align-items-center text-center" id="rating-group">
                                        @foreach ($emotes as $value => $emote)
                                            <input type="radio" class="btn-check" name="rating_id" id="rating-{{ $value }}"
                                                value="{{ $value }}" autocomplete="off" {{ isset($existingFeedback) && $existingFeedback->rating_id == $value ? 'checked' : '' }} required>
                                            <label class="rating-label" for="rating-{{ $value }}" data-index="{{ $value }}">
                                                <i class="{{ $emote['icon'] }} rating-icon"></i>
                                                <div style="font-size: 0.8rem;">{{ $emote['label'] }}</div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="laporan_id" value="{{ $laporan->laporan_id }}">
                        <div class="mb-3">
                            <label for="komentar" class="form-label fw-bold">Komentar</label>
                            <textarea class="form-control" id="komentar" name="komentar" rows="3"
                                placeholder="Tulis komentar Anda..."
                                required>{{ $existingFeedback->komentar ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-{{ isset($existingFeedback) ? 'primary' : 'success' }}">
                            {{ isset($existingFeedback) ? 'Update Feedback' : 'Kirim Feedback' }}
                        </button>

                        <a class="btn btn-light me-2" data-bs-toggle="collapse" href="#detaillaporan"
                            aria-expanded="true" aria-controls="collapseExample">
                            <i class="ri-arrow-down-s-line"></i> Lihat Detail Laporan
                        </a>
                    </form>
                </div>
            </div>

            <div class="collapse" id="detaillaporan" style="">
                <div class="card">
                    <div class="card-header">
                        Detail Laporan ID: {{ $laporan->laporan_id }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="{{ $laporan->foto_laporan ? 'col-md-6' : 'col-md-12' }}">
                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Fasilitas</div>
                                    <div class="col-sm-8">: {{ $laporan->fasilitas->nama_fasilitas ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Unit</div>
                                    <div class="col-sm-8">: {{ $laporan->unit->nama_unit ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Tempat</div>
                                    <div class="col-sm-8">: {{ $laporan->tempat->nama_tempat ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Barang</div>
                                    <div class="col-sm-8">:
                                        {{ $laporan->barangLokasi->jenisBarang->nama_barang ?? '-' }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Kategori Kerusakan</div>
                                    <div class="col-sm-8">: {{ $laporan->kategoriKerusakan->nama_kategori ?? '-' }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Periode</div>
                                    <div class="col-sm-8">: {{ $laporan->periode->nama_periode ?? '-' }}</div>
                                </div>

                                @php
                                    $statusPerbaikan = $laporan->perbaikan->status_perbaikan ?? '';
                                @endphp
                                @if ($statusPerbaikan === 'selesai')
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">Status Perbaikan</div>
                                        <div class="col-sm-8">:
                                            <span class="badge rounded-pill bg-opacity-25 bg-success text-success"
                                                style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                                Selesai
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Tanggal Dibuat</div>
                                    <div class="col-sm-8">: {{ $laporan->created_at->format('d M Y') }}</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Tanggal Ditugaskan ke Teknisi</div>
                                    <div class="col-sm-8">: {{ $laporan->perbaikan->formatted_tanggal_ditugaskan }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <p><strong>Foto Laporan:</strong></p>
                                <a href="{{ asset('storage/' . $laporan->foto_laporan) }}" data-lightbox="laporan"
                                    data-title="Foto Laporan" class="img-hover-dark">
                                    <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan">
                                    <i class="ri-search-line icon-search"></i>
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <p><strong>Foto Perbaikan:</strong></p>
                                <a href="{{ asset('storage/' . $laporan->perbaikan->foto_perbaikan) }}"
                                    data-lightbox="laporan" data-title="Foto Laporan" class="img-hover-dark">
                                    <img src="{{ asset('storage/' . $laporan->perbaikan->foto_perbaikan) }}"
                                        alt="Foto Laporan">
                                    <i class="ri-search-line icon-search"></i>
                                </a>
                            </div>

                            <div class="col-md-6 mt-3">
                                <p><strong>Deskripsi Laporan:</strong></p>
                                <div class="border p-2 rounded bg-light">
                                    {{ $laporan->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <p><strong>Deskripsi Perbaikan:</strong></p>
                                <div class="border p-2 rounded bg-light">
                                    {{ $laporan->perbaikan->catatan_perbaikan ?? 'Tidak ada deskripsi tersedia.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .img-hover-dark {
        width: 100%;
        position: relative;
        display: inline-block;
        overflow: hidden;
    }

    .img-hover-dark img {
        display: block;
        transition: filter 0.3s ease;
        max-width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        width: 100%;
        height: auto;
    }

    .img-hover-dark:hover img {
        filter: brightness(60%);
        cursor: pointer;
    }

    .img-hover-dark .icon-search {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 2rem;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .img-hover-dark:hover .icon-search {
        opacity: 1;
    }

    .lb-image {
        max-width: 90vw !important;
        max-height: 90vh !important;
        width: auto !important;
        height: auto !important;
    }

    .rating-label {
        cursor: pointer;
    }

    .rating-icon {
        font-size: 4rem;
        color: #ccc;
        transition: color 0.3s ease, transform 0.2s ease;
    }

    .btn-check:checked+.rating-label .rating-icon {
        color: #28a745;
        transform: scale(1.2);
    }

    .rating-label:hover .rating-icon {
        color: #ffc107;
        transform: scale(1.1);
    }
</style>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Mengirim Feedback...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        var form = this;
        var formData = new FormData(form);
        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message || 'Feedback berhasil dikirim!'
            }).then(() => {
                location.reload();
            });
        })
        .catch(() => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat mengirim feedback.'
            });
        });
    });
</script>