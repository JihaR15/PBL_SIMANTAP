@empty($user)
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header text-white bg-light">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-dark fa-2x me-2"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0">Kesalahan</h5>
                        <p class="mb-0 small opacity-75 text-muted">Data tidak ditemukan</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <div class="text-end">
                    <a href="{{ url('/user') }}" class="btn btn-warning rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/user/' . $user->user_id . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0"
                style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
                <div class="modal-header bg-light">
                    <div class="d-flex align-items-center w-100">
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0 text-dark">
                                <i class="fas fa-trash-alt me-2"></i>Hapus Data Pengguna
                            </h5>
                            <p class="mb-0 small opacity-85 mt-1 text-muted">Konfirmasi penghapusan data pengguna</p>
                        </div>
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body p-0">
                    {{-- <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25 m-4">
                        <h5 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i>Konfirmasi!</h5>
                        Apakah Anda yakin ingin menghapus data pengguna berikut?
                    </div> --}}

                    <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25 m-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-3" style="font-size: 24px;"></i>
                            <div>
                                <h5 class="mb-1">Konfirmasi Penghapusan</h5>
                                <p class="mb-0">Apakah Anda yakin ingin menghapus data berikut?</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-0 mx-4 mb-4">
                        <div class="col-md-4">
                            <div class="d-flex flex-column align-items-center justify-content-center p-2 h-100">
                                <div class="position-relative">
                                    <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}"
                                        alt="Foto Profil" class="img-thumbnail rounded-circle shadow"
                                        style="width: 180px; height: 180px; object-fit: cover; border: 4px solid white;">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="p-4">
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body p-3 bg-light" style="border-radius: 12px">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;"
                                                    class="text-primary">
                                                    <i class="fas fa-id-card"></i>
                                                </td>
                                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;"
                                                    class="text-muted small">ID Pengguna</td>
                                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                                    <span
                                                        class="badge bg-primary bg-opacity-10 text-primary">{{ $user->user_id }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;"
                                                    class="text-primary">
                                                    <i class="fas fa-user-tag"></i>
                                                </td>
                                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;"
                                                    class="text-muted small">Role Pengguna</td>
                                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                                    {{ $user->role->nama_role ?? 'Tidak ada role' }}
                                                </td>
                                            </tr>
                                            @if ($user->role->nama_role === 'Teknisi')
                                                <tr>
                                                    <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;"
                                                        class="text-primary">
                                                        <i class="fas fa-tools"></i>
                                                    </td>
                                                    <td style="width: 120px; padding: 0.5rem; vertical-align: middle;"
                                                        class="text-muted small">Spesialisasi</td>
                                                    <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                                        {{ $user->teknisi->jenis_teknisi->nama_jenis_teknisi }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;"
                                                    class="text-primary">
                                                    <i class="fas fa-at"></i>
                                                </td>
                                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;"
                                                    class="text-muted small">Username</td>
                                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                                    {{ $user->username }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;"
                                                    class="text-primary">
                                                    <i class="fas fa-user"></i>
                                                </td>
                                                <td style="width: 120px; padding: 0.5rem; vertical-align: middle;"
                                                    class="text-muted small">Nama Lengkap</td>
                                                <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                                    {{ $user->name }}
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="card border-0 shadow-sm mt-2 mx-4 mb-4">
                                            <div
                                                class="card-body p-3 bg-warning bg-opacity-10 border-warning border-opacity-25 rounded">
                                                <h6 class="mb-3 text-danger">
                                                    <i class="fas fa-database me-2"></i>Data yang akan ikut dihapus:
                                                </h6>
                                                <ul class="list-group list-group-flush small">
                                                    @if(in_array($user->role->kode_role, ['MHS', 'DSN', 'TDK']))
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span><i class="fas fa-file-alt me-2 text-primary"></i>Total
                                                                Laporan</span>
                                                            <span>{{ $laporan_count }}</span>
                                                        </li>
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span><i class="fas fa-comments me-2 text-success"></i>Total
                                                                Feedback</span>
                                                            <span>{{ $feedback_count }}</span>
                                                        </li>
                                                    @endif

                                                    @if($user->role->kode_role === 'SRN')
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span><i class="fas fa-check-circle me-2 text-info"></i>Laporan yang
                                                                Diverifikasi</span>
                                                            <span>{{ $laporan_diverifikasi }}</span>
                                                        </li>
                                                    @endif

                                                    @if($user->role->kode_role === 'TKS')
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span><i class="fas fa-tools me-2 text-danger"></i>Perbaikan yang
                                                                Ditangani</span>
                                                            <span>{{ $perbaikan_count }}</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                                <p class="mt-3 mb-0 text-muted small">
                                                    <i class="fas fa-exclamation-triangle text-danger me-1"></i>Data di atas
                                                    akan ikut terhapus secara permanen.
                                                </p>
                                                
                                                @if($user->role->kode_role === 'ADM')
                                                    <p class="mt-2 mb-0 text-danger small fw-semibold">
                                                        <i class="fas fa-lock me-1"></i>
                                                        Anda tidak akan bisa mengakses halaman ini lagi setelah akun admin dihapus.
                                                    </p>
                                                @endif

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                        <i class="fas fa-trash-alt me-2"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </form>

    <style>
        .modal-content {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: none;
        }

        .modal-body {
            padding: 0;
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            /* padding: 1.25rem 2rem; */
        }

        .table-sm td {
            padding: 0.5rem 0.5rem;
            vertical-align: middle;
        }
    </style>

    <script>
        $(document).ready(function () {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function (form) {
                    Swal.fire({
                        title: 'Yakin ingin menghapus user ini?',
                        text: "Semua data terkait seperti laporan, notifikasi, perbaikan, dan prioritas juga akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const submitBtn = $(form).find('button[type="submit"]');
                            submitBtn.prop('disabled', true);
                            submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');

                            $.ajax({
                                url: form.action,
                                type: form.method,
                                data: $(form).serialize(),
                                success: function (response) {
                                    if (response.status) {
                                        $('#myModal').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 1500,
                                            background: '#fff'
                                        });
                                        setTimeout(() => {
                                            dataUser.ajax.reload();
                                        }, 1500);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Terjadi Kesalahan',
                                            text: response.message,
                                            background: '#fff'
                                        });
                                    }
                                },
                                complete: function () {
                                    submitBtn.prop('disabled', false);
                                    submitBtn.html('<i class="fas fa-trash-alt me-2"></i>Ya, Hapus');
                                }
                            });
                        }
                    });

                    return false; // tetap return false untuk mencegah form submit default
                }
            });
        });
    </script>
@endempty