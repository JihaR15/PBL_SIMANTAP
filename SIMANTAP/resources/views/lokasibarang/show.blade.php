<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Daftar Fasilitas di {{ $tempat->nama_tempat }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form action="javascript:void(0);" id="tambah-barang-form" style="float: right; margin-bottom: 15px;">
                <button type="button" id="btn-tambah" class="btn btn-sm btn-primary">Tambah Fasilitas</button>
            </form>
            <!-- Dropdown -->
            <div id="dropdown-container" class="mb-3" style="display: none;">
                <form action="{{ route('lokasibarang.store', $tempat_id) }}" method="POST">
                    @csrf
                    <label for="jenis_barang_id" class="form-label">Pilih Jenis Barang</label>
                    <select class="form-control" id="jenis_barang_id" name="jenis_barang_id" required>
                        @foreach($semuaJenisBarang as $jenis)
                            @if(!in_array($jenis->jenis_barang_id, $barangLokasi->pluck('jenis_barang_id')->toArray()))
                                <option value="{{ $jenis->jenis_barang_id }}">{{ $jenis->nama_barang }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary mt-2">Tambah</button>
                </form>
            </div>

            <!-- Daftar barang -->
            <table class="table table-bordered table-sm mt-4">
                <thead>
                    <tr class="text-bold">
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangLokasi as $key => $barang)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $barang->jenisBarang->nama_barang }}</td>
                            <td class="text-center">
                                <form action="javascript:void(0);" id="hapus-barang-form" style="display:inline;">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="modalAction('{{ url('/lokasibarang/' . $tempat_id . '/confirmDelete/' . $barang->jenis_barang_id) }}')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('btn-tambah').addEventListener('click', function() {
        var dropdown = document.getElementById('dropdown-container');
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";
        } else {
            dropdown.style.display = "none";
        }
    });
</script>
