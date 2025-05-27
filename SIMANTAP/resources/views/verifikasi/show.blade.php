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
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%;">Fasilitas</th>
                                    <td>{{ $laporan->fasilitas->nama_fasilitas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Unit</th>
                                    <td>{{ $laporan->unit->nama_unit ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat</th>
                                    <td>{{ $laporan->tempat->nama_tempat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Barang</th>
                                    <td>{{ $laporan->barangLokasi->jenisBarang->nama_barang ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori Kerusakan</th>
                                    <td>{{ $laporan->kategoriKerusakan->nama_kategori ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Periode</th>
                                    <td>{{ $laporan->periode->nama_periode ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Verifikasi</th>
                                    <td>
                                        @if ($laporan->status_verif === 'belum diverifikasi')
                                            <span class="badge bg-warning" style="color: #fff; font-weight: 700;">Belum Diverifikasi</span>
                                        @elseif ($laporan->status_verif === 'diverifikasi')
                                            <span class="badge bg-success" style="color: #fff; font-weight: 700;">Terverifikasi</span>
                                        @elseif ($laporan->status_verif === 'ditolak')
                                            <span class="badge bg-danger" style="color: #fff; font-weight: 700;">Ditolak</span>
                                        @else
                                            <span>{{ ucfirst($laporan->status_verif) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>{{ $laporan->created_at->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>

                        @if ($laporan->foto_laporan)
                            <div class="col-md-4">
                                <p><strong>Foto Laporan:</strong></p>
                                <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan"
                                    class="img-fluid" style="max-width: 100%;">
                            </div>
                        @endif

                        <div class="col-md-12 mt-3">
                            <p><strong>Deskripsi:</strong></p>
                            <div class="border p-2 rounded" style="background-color: #f8f9fa;">
                                {{ $laporan->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <button id="btn-verify" class="btn btn-success">Verifikasi</button> --}}
            <button onclick="modalAction('{{ url('verifikasi/'.$laporan->laporan_id.'/prioritas') }}')" class="btn btn-primary" id="btn-verify">Verifikasi</button>
            {{-- <button id="btn-reject" class="btn btn-danger">Tolak</button> --}}
            <button id="btn-reject" class="btn btn-danger" data-laporan-id="{{ $laporan->laporan_id }}">Tolak</button>
        </div>
    </div>
</div>

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
            // console.log('Tombol Tolak diklik, laporanId:', laporanId);
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
