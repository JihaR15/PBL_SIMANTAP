<style>
    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .checkbox-item {
        width: calc(20% - 20px);
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 10px;
    }

    @media (max-width: 768px) {
        .checkbox-item {
            width: calc(50% - 20px);
        }
    }

    @media (max-width: 480px) {
        .checkbox-item {
            width: 100%;
        }
    }

    /* Style untuk input jumlah dan tombol simpan */
    .jumlah-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .jumlah-container input {
        width: 80px;
    }

    .btn-simpan-jumlah {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .swal2-popup {
        text-align: center;
    }

    .spinner-border {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        vertical-align: text-bottom;
        border: .25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border .75s linear infinite;
    }

    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }
</style>

<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0 text-dark">
                        <i class="fas fa-list me-2"></i>Daftar Fasilitas di {{ $tempat->nama_tempat }}
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Manajemen fasilitas lokasi</p>
                </div>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <div class="modal-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div></div>
                <button type="button" id="btn-tambah" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Fasilitas
                </button>
            </div>

            <!-- dropdown -->
            <div id="dropdown-container" class="mb-3" style="display: none;">
                <form action="{{ route('lokasibarang.store', $tempat_id) }}" method="POST">
                    @csrf
                    <label for="jenis_barang_id" class="form-label">Pilih Jenis Barang</label>

                    <!-- checkbox -->
                    <div class="checkbox-container">
                        @foreach($semuaJenisBarang as $jenis)
                            @if(!in_array($jenis->jenis_barang_id, $barangLokasi->pluck('jenis_barang_id')->toArray()))
                                <div class="form-check checkbox-item">
                                    <input type="checkbox" class="form-check-input" id="jenis_barang_{{ $jenis->jenis_barang_id }}" name="jenis_barang_id[]" value="{{ $jenis->jenis_barang_id }}">
                                    <label class="form-check-label" for="jenis_barang_{{ $jenis->jenis_barang_id }}">{{ $jenis->nama_barang }}</label>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="button" id="btn-batal" class="btn btn-sm btn-secondary ms-2">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-sm mt-4">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Barang</th>
                            <th style="width: 15%;">Jumlah Barang</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangLokasi as $key => $barang)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $barang->jenisBarang->nama_barang }}</td>
                                <td>
                                    <form action="{{ url('lokasibarang/' . $barang->barang_lokasi_id . '/updateJumlah') }}" method="POST" class="form-edit-jumlah">
                                        @csrf
                                        @method('PUT')
                                        <div class="jumlah-container">
                                            <input type="number" name="jumlah_barang" value="{{ $barang->jumlah_barang }}"
                                                   class="form-control form-control-sm"
                                                   min="0"
                                                   required
                                                   data-original-value="{{ $barang->jumlah_barang }}">
                                            <button type="submit" class="btn btn-sm btn-success btn-simpan-jumlah" style="display: none;">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="modalAction('{{ url('/lokasibarang/' . $tempat_id . '/confirmDelete/' . $barang->jenis_barang_id) }}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btn-tambah').addEventListener('click', function() {
        document.getElementById('dropdown-container').style.display = "block";
        this.style.display = "none";
    });

    document.getElementById('btn-batal')?.addEventListener('click', function() {
        document.getElementById('dropdown-container').style.display = "none";
        document.getElementById('btn-tambah').style.display = "block";
    });

    // submit form tambah fasilitas
    document.querySelector('#dropdown-container form')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;

        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
        submitButton.disabled = true;

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;

            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    html: data.message,
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'center'
                    }).then(() => {
                    if (typeof refreshModalContent !== 'undefined') {
                        refreshModalContent();
                    } else {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message || 'Gagal menambahkan fasilitas',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500,
                    position: 'center'
                });
            }
        })
        .catch(error => {
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;

            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengirim data',
                icon: 'error',
                confirmButtonText: 'OK',
                position: 'center'
            });
        });
    });

    document.querySelectorAll('.form-edit-jumlah input').forEach(input => {
        input.addEventListener('input', function() {
            const form = this.closest('form');
            const originalValue = this.getAttribute('data-original-value');
            const saveButton = form.querySelector('.btn-simpan-jumlah');

            saveButton.style.display = (this.value !== originalValue) ? "block" : "none";
        });
    });

    document.querySelectorAll('.form-edit-jumlah').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const input = this.querySelector('input[name="jumlah_barang"]');
                    input.setAttribute('data-original-value', input.value);
                    this.querySelector('.btn-simpan-jumlah').style.display = 'none';

                    Swal.fire({
                        title: 'Berhasil',
                        text: data.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'center'
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'center'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengirim data',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500,
                    position: 'center'
                });
            });
        });
    });

    // Inisialisasi Toast
    // const Toast = Swal.mixin({
    //     toast: true,
    //     position: 'top-end',
    //     showConfirmButton: false,
    //     timer: 3000,
    //     timerProgressBar: true,
    //     didOpen: (toast) => {
    //         toast.addEventListener('mouseenter', Swal.stopTimer)
    //         toast.addEventListener('mouseleave', Swal.resumeTimer)
    //     }
    // });
</script>
