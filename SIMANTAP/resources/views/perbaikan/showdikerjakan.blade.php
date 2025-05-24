<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Perbaikan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    Perbaikan ID: {{ $perbaikan->perbaikan_id }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="{{ $perbaikan->laporan->foto_laporan ? 'col-md-8' : 'col-md-12' }}">
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Fasilitas</div>
                                <div class="col-sm-8">: {{ $perbaikan->laporan->fasilitas->nama_fasilitas ?? '-' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Unit</div>
                                <div class="col-sm-8">: {{ $perbaikan->laporan->unit->nama_unit ?? '-' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Tempat</div>
                                <div class="col-sm-8">: {{ $perbaikan->laporan->tempat->nama_tempat ?? '-' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Barang</div>
                                <div class="col-sm-8">
                                    : {{ $perbaikan->laporan->barangLokasi->jenisBarang->nama_barang ?? '-' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Kategori Kerusakan</div>
                                <div class="col-sm-8">:
                                    {{ $perbaikan->laporan->kategoriKerusakan->nama_kategori ?? '-' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Periode</div>
                                <div class="col-sm-8">: {{ $perbaikan->laporan->periode->nama_periode ?? '-' }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 fw-bold">Tanggal Dibuat</div>
                                <div class="col-sm-8">: {{ $perbaikan->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                        @if ($perbaikan->laporan->foto_laporan)
                            <div class="col-md-4">
                                <p><strong>Foto Laporan:</strong></p>
                                <a href="{{ asset('storage/' . $perbaikan->laporan->foto_laporan) }}"
                                    data-lightbox="laporan" data-title="Foto Laporan" class="img-hover-dark">
                                    <img src="{{ asset('storage/' . $perbaikan->laporan->foto_laporan) }}"
                                        alt="Foto Laporan">
                                    <i class="ri-search-line icon-search"></i>
                                </a>
                            </div>
                        @endif

                        <div class="col-md-12 mt-3">
                            <p><strong>Deskripsi:</strong></p>
                            <div class="card-header">
                                {{ $perbaikan->laporan->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="modalAction('{{ url('dikerjakan/' . $perbaikan->perbaikan_id . '/konfirmasi') }}')"
                class="btn btn-primary" id="btn-verify">Selesaikan</button>
            {{-- <button id="btn-verify" class="btn btn-success"
                data-id="{{ $perbaikan->perbaikan_id }}">Selesaikan</button> --}}
        </div>
    </div>
</div>

<style>
    .img-hover-dark {
        position: relative;
        display: inline-block;
        overflow: hidden;
    }

    .img-hover-dark img {
        display: block;
        transition: filter 0.3s ease;
        max-width: 100%;
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
</style>

<script>
    perbaikanId = null;

    function modalAction(url = '') {
        const parts = url.split('/');
        perbaikanId = parts[parts.length - 2];  // const di sini supaya set global

        $('#myModal').load(url, function () {
            $('#myModal').modal('show');

            $('#formKonfirmasi').off('submit').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: `/dikerjakan/${perbaikanId}/selesai`,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire(
                                'Sukses',
                                res.message || 'Perbaikan berhasil diselesaikan.',
                                'success'
                            ).then(() => {
                                $('#myModal').modal('hide');
                                $('#datatable').DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message || 'Gagal memproses data.', 'error');
                        }
                    },
                    error: function (xhr) {
                        let msg = 'Gagal memproses data.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });
    }

</script>