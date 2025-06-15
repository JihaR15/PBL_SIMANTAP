<!-- filepath: resources/views/tempat/index.blade.php -->
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Daftar Ruang di {{ $unit->nama_unit }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-success" onclick="modalAction('{{ url('/tempat/'.$unit->unit_id.'/create') }}')">
                    <i class="fas fa-plus"></i> Tambah Ruang
                </button>
            </div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tempat as $i => $t)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $t->nama_tempat }}</td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-sm" onclick="modalAction('{{ url('/tempat/'.$unit->unit_id.'/show/'.$t->tempat_id) }}')" title="Detail">
                                <i class="bi bi-info-circle"></i> Detail
                            </button>
                            <button class="btn btn-warning btn-sm" onclick="modalAction('{{ url('/tempat/'.$unit->unit_id.'/edit/'.$t->tempat_id) }}')" title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="modalAction('{{ url('/tempat/'.$unit->unit_id.'/delete/'.$t->tempat_id) }}')" title="Hapus">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>