<div class="modal-dialog modal-lg">
    <div class="modal-content border-0" style="overflow: hidden; border-radius: 12px;">
        <div class="modal-header text-white bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0">
                        <i class="fas fa-user-circle me-2"></i>Profil Pengguna
                    </h5>
                    <p class="mb-0 small opacity-85 mt-1 text-muted">Detail informasi akun pengguna</p>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <div class="modal-body p-0">
            <div class="row g-0">
                <div class="col-md-4 bg-light" style="background-color: #f8f9fe;">
                    <div class="d-flex flex-column align-items-center justify-content-center p-4 h-100">
                        <div class="position-relative mb-3" style="cursor: pointer;" onclick="showProfilePhoto()">
                            <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}"
                                alt="Foto Profil"
                                class="img-thumbnail rounded-circle shadow profile-photo"
                                style="width: 180px; height: 180px; object-fit: cover; border: 4px solid white;">
                            <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 border border-3 border-white shadow-sm">
                                <i class="fas fa-expand text-white"></i>
                            </div>
                        </div>

                        <h4 class="mt-3 mb-1 text-center">{{ $user->name }}</h4>

                        <div class="d-flex flex-column align-items-center mt-2">
                            <span class="badge bg-gradient-info rounded-pill px-3 py-1 mb-1">
                                <i class="fas fa-user-tag me-1"></i>
                                {{ $user->role->nama_role ?? 'Tidak ada role' }}
                            </span>

                            @if ($user->role->nama_role === 'Teknisi')
                            <span class="badge bg-gradient-success rounded-pill px-3 py-1">
                                <i class="fas fa-tools me-1"></i>
                                {{ $user->teknisi->jenis_teknisi->nama_jenis_teknisi }}
                            </span>
                            @endif
                        </div>

                        {{-- <div class="mt-4 text-center">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Bergabung {{ $user->created_at->diffForHumans() }}
                            </small>
                        </div> --}}
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                        <i class="fas fa-info-circle text-primary"></i>
                                    </div>
                                    <h5 class="mb-0 text-primary">Informasi Akun</h5>
                                </div>
                                <hr class="my-2">
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <p class="mb-1 text-muted small">Username</p>
                                                <p class="mb-0 fw-bold">{{ $user->username }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                <i class="fas fa-lock text-primary"></i>
                                            </div>
                                            <div>
                                                <p class="mb-1 text-muted small">Password</p>
                                                <p class="mb-0 fw-bold">••••••••</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($user->role->nama_role === 'Teknisi')
                            <div class="col-12 mb-3 mt-2">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                        <i class="fas fa-tools text-success"></i>
                                    </div>
                                    <h5 class="mb-0 text-success">Informasi Teknisi</h5>
                                </div>
                                <hr class="my-2">
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                                <i class="fas fa-cog text-success"></i>
                                            </div>
                                            <div>
                                                <p class="mb-1 text-muted small">Spesialisasi</p>
                                                <p class="mb-0 fw-bold">{{ $user->teknisi->jenis_teknisi->nama_jenis_teknisi }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button onclick="modalAction('{{ url('profile/edit') }}')"
                    class="btn btn-primary px-4 rounded-pill shadow-sm"
                    data-dismiss="modal"
                    id="btn-edit-profile">
                <i class="fas fa-edit me-2"></i>Edit Profil
            </button>
            <button class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">
                <i class="fas fa-times me-2"></i>Tutup
            </button>
        </div>
    </div>
</div>

<!-- Photo Viewer Modal -->
<div class="modal fade" id="photoViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-header border-0 bg-transparent position-absolute top-0 end-0 z-1">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0 position-relative">
                <!-- Blurred Background -->
                <div class="position-absolute top-0 start-0 w-100 h-100" style="
                    background: url('{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}') center/cover;
                    filter: blur(15px) brightness(0.6);
                    z-index: -1;
                "></div>

                <!-- Actual Photo -->
                <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
                    <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}"
                        alt="Foto Profil Besar"
                        class="img-fluid shadow-lg"
                        style="max-height: 80vh; max-width: 90%; border-radius: 12px; border: 3px solid rgba(255,255,255,0.2);">
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0 bg-transparent pb-4">
                <button type="button" class="btn btn-light rounded-pill me-2 shadow-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary rounded-pill shadow-sm" onclick="downloadProfilePhoto()">
                    <i class="fas fa-download me-2"></i>Unduh Foto
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #17ead9 0%, #6078ea 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #43e695 0%, #3bb2b8 100%);
    }

    .card {
        transition: all 0.3s ease;
        border-radius: 10px !important;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .profile-photo {
        transition: all 0.3s ease;
    }
    .profile-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    #photoViewerModal {
        backdrop-filter: blur(5px);
    }
    #photoViewerModal .modal-content {
        background: transparent;
        box-shadow: none;
        border: none;
    }
    #photoViewerModal img {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }
    #photoViewerModal img:hover {
        transform: scale(1.02);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(106, 17, 203, 0.4);
    }

    /* Text Styles */
    /* .text-primary {
        color: #6a11cb !important;
    }
    .text-success {
        color: #43e695 !important;
    } */
</style>

<script>
    function showProfilePhoto() {
        const photoViewerModal = new bootstrap.Modal(document.getElementById('photoViewerModal'), {
            backdrop: 'static',
            keyboard: true
        });
        photoViewerModal.show();

        // Close when clicking outside the image
        document.getElementById('photoViewerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                photoViewerModal.hide();
            }
        });
    }

    function downloadProfilePhoto() {
        const photoUrl = "{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}";
        const link = document.createElement('a');
        link.href = photoUrl;
        link.download = 'profile-{{ $user->username }}-' + new Date().toISOString().slice(0,10) + '.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Show download confirmation
        Toastify({
            text: "Download foto profil dimulai",
            duration: 3000,
            close: true,
            gravity: "bottom",
            position: "right",
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            stopOnFocus: true
        }).showToast();
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.getElementById('photoViewerModal').classList.contains('show')) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('photoViewerModal'));
            modal.hide();
        }
    });
</script>
