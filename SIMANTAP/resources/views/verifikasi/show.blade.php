<div id="modal-master" class="modal-dialog modal-lg" role="document">
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
                        <div class="{{ $laporan->foto_laporan ? 'col-md-8' : 'col-md-12' }}">
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

                            {{-- Status Verifikasi --}}
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold">Status Verifikasi</div>
                                <div class="col-sm-8">:
                                    @php
                                        $status = $laporan->status_verif ?? '';
                                    @endphp
                                    @if ($status === 'belum diverifikasi')
                                        <span class="badge rounded-pill bg-opacity-25 bg-warning text-warning" style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                            Belum Diverifikasi
                                        </span>
                                    @elseif ($status === 'diverifikasi')
                                        <span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                            Terverifikasi
                                        </span>
                                    @elseif ($status === 'ditolak')
                                        <span class="badge rounded-pill bg-opacity-25 bg-danger text-danger" style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 4px 8px; font-weight: 700;">
                                            {{ ucfirst($status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 fw-bold">Tanggal Dibuat</div>
                                <div class="col-sm-8">: {{ $laporan->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                        @if ($laporan->foto_laporan)
                            <div class="col-md-4">
                                <p><strong>Foto Laporan</strong></p>
                                <div class="img-hover-dark">
                                    <a href="{{ asset('storage/' . $laporan->foto_laporan) }}" data-lightbox="laporan" data-title="Foto Laporan">
                                        <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan" class="img-fluid" style="max-width: 100%;">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="modalAction('{{ url('verifikasi/'.$laporan->laporan_id.'/prioritas') }}')" class="btn btn-primary" id="btn-verify">Verifikasi</button>
            <button id="btn-reject" class="btn btn-danger" data-laporan-id="{{ $laporan->laporan_id }}">Tolak</button>
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
    let laporanId = null;

    function modalAction(url = '') {
        const parts = url.split('/');
        laporanId = parts[parts.length - 2];  // const di sini supaya set global

        $('#myModal').load(url, function () {
            $('#myModal').modal('show');

            $('#formPrioritas').off('submit').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: `/verifikasi/${laporanId}/verify`,
                    method: 'POST',
                    data: formData + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        if(res.success) {
                            Swal.fire(
                                'Sukses',
                                res.message +
                                (res.klasifikasi_urgensi ? `<br>Klasifikasi urgensi: <b>${res.klasifikasi_urgensi}</b>` : ''),
                                'success'
                            ).then(() => {
                                $('#myModal').modal('hide');
                                $('#datatable').DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message || 'Gagal memproses data.', 'error');
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Gagal memproses data.';
                        if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });
    }

    $(document).ready(function() {
        $(document).on('click', '#btn-reject', function() {
            let laporanId = $(this).data('laporan-id');
            if (!laporanId) {
                Swal.fire('Error', 'ID laporan tidak ditemukan', 'error');
                return;
            }

            Swal.fire({
                title: 'Yakin menolak laporan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: `/verifikasi/${laporanId}/reject`,
                        method: 'POST',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function(response) {
                            if(response.success) {
                                Swal.fire('Berhasil', response.message, 'success').then(() => {
                                    $('#myModal').modal('hide');
                                    $('#datatable').DataTable().ajax.reload();
                                });
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan saat menolak laporan.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
