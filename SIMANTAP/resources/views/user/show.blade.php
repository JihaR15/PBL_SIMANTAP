<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
        <div class="modal-header bg-light">
            <div class="d-flex align-items-center w-100">
                <div class="flex-grow-1">
                    <h5 class="modal-title mb-0 text-dark">
                        <i class="fas fa-user-circle me-2"></i>Detail Pengguna
                    </h5>
                    <p class="mb-0 small text-muted">Informasi lengkap pengguna sistem</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <div class="modal-body p-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-auto text-center mb-4 mb-md-0">
                    <div class="position-relative d-inline-block" style="cursor: pointer;" onclick="showProfilePhoto()">
                        <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}"
                            alt="Foto Profil"
                            class="img-thumbnail rounded-circle shadow profile-photo"
                            style="width: 160px; height: 160px; object-fit: cover; border: 4px solid white;">
                        <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 border border-3 border-white shadow-sm">
                            <i class="fas fa-expand text-white" style="font-size: 0.8rem;"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Klik foto untuk memperbesar</small>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-3 bg-light" style="border-radius: 12px">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                        <i class="fas fa-id-card"></i>
                                    </td>
                                    <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">ID Pengguna</td>
                                    <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $user->user_id }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                        <i class="fas fa-user-tag"></i>
                                    </td>
                                    <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Role</td>
                                    <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                        {{ $user->role->nama_role }}
                                    </td>
                                </tr>
                                @if ($user->role->nama_role === 'Teknisi')
                                <tr>
                                    <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                        <i class="fas fa-tools"></i>
                                    </td>
                                    <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Jenis Teknisi</td>
                                    <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                        {{ $user->teknisi->jenis_teknisi->nama_jenis_teknisi }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                        <i class="fas fa-at"></i>
                                    </td>
                                    <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Username</td>
                                    <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                        {{ $user->username }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                        <i class="fas fa-user"></i>
                                    </td>
                                    <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Nama Lengkap</td>
                                    <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                        {{ $user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40px; padding: 0.5rem; vertical-align: middle; text-align: center;" class="text-primary">
                                        <i class="fas fa-lock"></i>
                                    </td>
                                    <td style="width: 120px; padding: 0.5rem; vertical-align: middle;" class="text-muted small">Password</td>
                                    <td style="padding: 0.5rem; vertical-align: middle;" class="fw-bold">
                                        ********
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between small text-muted">
                        <div>
                            <i class="fas fa-calendar-alt me-1"></i> Dibuat: {{ $user->created_at->format('d M Y') }}
                        </div>
                        <div>
                            <i class="fas fa-sync-alt me-1"></i> Diperbarui: {{ $user->updated_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Viewer Modal -->
<div class="modal fade" id="photoViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-header border-0 position-absolute top-0 end-0 z-3">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center position-relative">
                <!-- Blurred Background -->
                <div class="position-absolute top-0 start-0 w-100 h-100" style="
                    background: url('{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}') center/cover;
                    filter: blur(10px) brightness(0.7);
                    z-index: -1;
                "></div>
                
                <!-- Photo Container -->
                <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
                    <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}"
                        alt="Foto Profil Besar"
                        class="img-fluid shadow-lg"
                        style="max-height: 80vh; max-width: 90%; border-radius: 8px; border: 2px solid rgba(255,255,255,0.3);">
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0 bg-transparent pb-4 position-absolute bottom-0 start-0 w-100 z-3">
                <button type="button" class="btn btn-light rounded-pill px-4 me-2 shadow-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <a href="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}" 
                   class="btn btn-primary rounded-pill px-4 shadow-sm" download>
                    <i class="fas fa-download me-1"></i>Unduh
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-photo {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .profile-photo:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }
    
    #photoViewerModal {
        backdrop-filter: blur(5px);
    }
    #photoViewerModal .modal-content {
        background: transparent;
        box-shadow: none;
    }
    #photoViewerModal img {
        transition: transform 0.3s ease;
    }
    #photoViewerModal img:hover {
        transform: scale(1.02);
    }
    
    .badge {
        padding: 0.35rem 0.65rem;
        border-radius: 50px;
        font-weight: 500;
    }
</style>

<script>
    function showProfilePhoto() {
        const modal = new bootstrap.Modal(document.getElementById('photoViewerModal'));
        modal.show();
    }
    
    document.getElementById('photoViewerModal').addEventListener('click', function(e) {
        if (e.target === this) {
            const modal = bootstrap.Modal.getInstance(this);
            modal.hide();
        }
    });
</script>