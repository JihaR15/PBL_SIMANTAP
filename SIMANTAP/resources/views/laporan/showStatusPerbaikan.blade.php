@php
    $statusVerif = strtolower($laporan->status_verif ?? '');
    $isDitolak = ($statusVerif === 'ditolak');
    $colInfo = ($isDitolak && $laporan->foto_laporan) ? 'col-md-8' : ($laporan->foto_laporan ? 'col-md-6' : 'col-md-12');
@endphp

<div id="modal-master" class="modal-dialog {{ $isDitolak ? 'modal-lg' : 'modal-xl' }}" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Laporan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    Laporan ID: {{ $laporan->laporan_id }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="{{ $colInfo }}">
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
                                <div class="col-sm-8">: {{ $laporan->barangLokasi->jenisBarang->nama_barang ?? '-' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Kategori Kerusakan</div>
                                <div class="col-sm-8">: {{ $laporan->kategoriKerusakan->nama_kategori ?? '-' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Periode</div>
                                <div class="col-sm-8">: {{ $laporan->periode->nama_periode ?? '-' }}</div>
                            </div>

                            {{-- <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Status Verifikasi</div>
                                <div class="col-sm-8">:
                                    @php
                                        $status = $laporan->status_verif ?? '';
                                    @endphp
                                    @if ($status === 'belum diverifikasi')
                                        <span class="badge bg-warning" style="color: #fff; font-weight: 700;">Belum Diverifikasi</span>
                                    @elseif ($status === 'diverifikasi')
                                        <span class="badge bg-success" style="color: #fff; font-weight: 700;">Terverifikasi</span>
                                    @elseif ($status === 'ditolak')
                                        <span class="badge bg-danger" style="color: #fff; font-weight: 700;">Ditolak</span>
                                    @else
                                        <span>{{ ucfirst($status) }}</span>
                                    @endif
                                </div>
                            </div> --}}

                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Status Perbaikan</div>
                                <div class="col-sm-8">:
                                    @php
                                        $statusPerbaikan = $laporan->perbaikan->status_perbaikan ?? '';
                                    @endphp
                                    @if ($statusPerbaikan === 'belum')
                                        <span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                            Belum dikerjakan
                                        </span>
                                    @elseif ($statusPerbaikan === 'sedang diperbaiki')
                                        <span class="badge rounded-pill bg-opacity-25 bg-info text-info" style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                            Sedang dikerjakan
                                        </span>
                                    @elseif ($statusPerbaikan === 'selesai')
                                        <span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                            {{ ucfirst($statusPerbaikan) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Tanggal Dibuat</div>
                                <div class="col-sm-8">: {{ $laporan->created_at->format('d M Y') }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Tanggal Ditugaskan ke Teknisi</div>
                                <div class="col-sm-8">: {{ $laporan->perbaikan->formatted_tanggal_ditugaskan }}</div>
                            </div>
                        </div>

                        @if (!$isDitolak)
                            @if ($laporan->foto_laporan || ($laporan->perbaikan && $laporan->perbaikan->foto_perbaikan))
                                <div class="col-md-6 d-flex align-items-start" style="gap: 2rem;">
                                    @if ($laporan->foto_laporan)
                                        <div style="flex: 1;">
                                            <p><strong>Foto Laporan</strong></p>
                                            <div class="img-hover-dark mb-3" style="height: 180px;">
                                                <a href="{{ asset('storage/' . $laporan->foto_laporan) }}" data-lightbox="laporan" data-title="Foto Laporan">
                                                    <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                                                    <i class="ri-search-line icon-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <div style="flex: 1;">
                                        <p><strong>Foto Perbaikan</strong></p>
                                        @if ($laporan->perbaikan && $laporan->perbaikan->foto_perbaikan)
                                            <div class="img-hover-dark" style="height: 180px;">
                                                <a href="{{ asset('storage/' . $laporan->perbaikan->foto_perbaikan) }}" data-lightbox="perbaikan" data-title="Foto Perbaikan">
                                                    <img src="{{ asset('storage/' . $laporan->perbaikan->foto_perbaikan) }}" alt="Foto Perbaikan" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                                                    <i class="ri-search-line icon-search"></i>
                                                </a>
                                            </div>
                                        @else
                                            <p><em>Foto perbaikan belum tersedia (perbaikan belum selesai).</em></p>
                                        @endif
                                    </div>
                                </div>
                            @endif
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
                        @else
                            @if ($laporan->foto_laporan)
                                <div class="col-md-4">
                                    <p><strong>Foto Laporan</strong></p>
                                    <div class="img-hover-dark" style="max-width: 200px; height: auto;">
                                        <a href="{{ asset('storage/' . $laporan->foto_laporan) }}" data-lightbox="laporan" data-title="Foto Laporan">
                                            <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan" class="img-fluid" style="width: 100%; height: auto; object-fit: contain;">
                                            <i class="ri-search-line icon-search"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 mt-3">
                                <p><strong>Deskripsi Laporan:</strong></p>
                                <div class="border p-2 rounded bg-light">
                                    {{ $laporan->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div> --}}
    </div>
</div>

<style>
    .img-hover-dark {
        position: relative;
        display: inline-block;
        overflow: hidden;
        width: 100%;
        height: 180px;
    }

    .img-hover-dark img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: filter 0.3s ease;
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
</style>
