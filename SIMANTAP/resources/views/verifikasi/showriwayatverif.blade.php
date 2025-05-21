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
                                <img src="{{ asset('storage/' . $laporan->foto_laporan) }}" alt="Foto Laporan" class="img-fluid" style="max-width: 100%;">
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
