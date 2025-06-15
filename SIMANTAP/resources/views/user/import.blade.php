<form action="{{ route('user.importAjax') }}" method="POST" id="form-import" enctype="multipart/form-data"> 
    @csrf 
    <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden;"> 
            <div class="modal-header text-white bg-light">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-plus text-dark fa-2x me-2"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0">Import Data Pengguna</h5>
                        <p class="mb-0 small opacity-75 text-muted">Import pengguna baru ke sistem</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="pe-lg-4">
                            <div class="form group mb-4">
                                <label>Download Template</label>
                                <div class="mb-4">
                                    <a href="{{ asset('/templates/template_user_import.xlsx') }}" class="btn btn-info btn-sm" download>
                                        <i class="fa fa-file-excel me-2"></i>Download
                                    </a> 
                                </div>
                                <small class="d-block mt-2 text-muted">
                                    Format Kolom :
                                    <ul class="mb-0">
                                        <li>A1: role_id (1 = Admin, 2 = Mahasiswa, 3 = Dosen, 4 = Tendik, 5 = Sarpras, 6 = Teknisi)</li>
                                        <li>B1: username</li>
                                        <li>C1: name</li>
                                        <li>D1: password (minimal 5 karakter)</li>
                                        <li>E1: status (1 = aktif, 0 = nonaktif)</li>
                                    </ul>
                                </small> 
                            </div>
                            <small id="error-user_id" class="error-text form-text text-danger"></small>
                            <div class="form group mb-4">
                                <label>Pilih File</label> 
                                <input type="file" name="file_user" id="file_user" class="form-control" required> 
                                <small id="error-file_user" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Batal</button> 
                <button type="submit" class="btn btn-primary">Upload</button> 
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
        padding: 2rem;
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 2rem;
    }

    .form-label {
        color: #495057;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .btn-outline-primary:hover {
        background-color: rgba(118, 75, 162, 0.1);
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .shadow {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#form-import').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Memproses...',
                html: 'Mohon tunggu, data sedang diimport.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('user.importAjax') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        $('#modal-master').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataUser.ajax.reload();
                    } else {
                        $('#error-file_user').text('');
                        if (response.errors) {
                            if (response.errors.file_user) {
                                $('#error-file_user').text(response.errors.file_user[0]);
                            }

                            if (response.errors.general) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    html: '<pre style="text-align:left;">' + response.errors.general.join("\n") + '</pre>'
                                });
                            }
                        }
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let response = xhr.responseJSON;
                    let htmlMsg = '';
                    if (response && response.errors && response.errors.general) {
                        // Cek apakah ada error duplikat username
                        let duplikat = response.errors.general.filter(msg => msg.includes("Username"));
                        if (duplikat.length > 0) {
                            htmlMsg = '<b>Data username yang duplikat :</b><ul style="text-align:left;">';
                            duplikat.forEach(function(msg) {
                                htmlMsg += `<li>${msg}</li>`;
                            });
                            htmlMsg += '</ul>';
                        } else {
                            htmlMsg = response.errors.general.join('<br>');
                        }
                    } else if (response && response.message) {
                        htmlMsg = response.message;
                    } else {
                        htmlMsg = 'Terjadi kesalahan sistem. Silakan coba lagi.';
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Import',
                        html: htmlMsg
                    });
                }
            });
        });
    });
</script>