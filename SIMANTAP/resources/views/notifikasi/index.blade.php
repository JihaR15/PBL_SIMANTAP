<div class="modal fade" id="modalNotifikasi" tabindex="-1" aria-labelledby="modalNotifikasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Notifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                @if($notifikasis->count() > 0)
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Isi Notifikasi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifikasis as $notif)
                            <tr class="{{ $notif->is_read ? '' : 'table-info' }}">
                                <td>{{ $notif->isi_notifikasi }}</td>
                                <td>{{ $notif->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($notif->is_read)
                                        <span class="badge bg-success">Sudah Dibaca</span>
                                    @else
                                        <span class="badge bg-warning">Belum Dibaca</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('laporan.show', $notif->laporan_id) }}" class="btn btn-primary btn-sm">Lihat Laporan</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $notifikasis->links() }}
                    </div>
                @else
                    <p>Tidak ada notifikasi.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
