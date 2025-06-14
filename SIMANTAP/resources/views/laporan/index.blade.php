@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    @include('layouts.breadcrumb')
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-exclamation-triangle text-warning me-2" style="font-size: 2rem;"></i>
                                        <h4 class="card-title mb-0">Laporkan Kerusakan Fasilitas</h4>
                                    </div>
                                    <div class="alert alert-info bg-info text-white border-0 bg-opacity-50  ">
                                        <i class="fas fa-info-circle me-2"></i> Silakan isi form berikut untuk melaporkan kerusakan yang terjadi. Pastikan semua data yang dimasukkan sudah benar sebelum disubmit.
                                    </div>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success d-flex align-items-center">
                                        <i class="fas fa-check-circle me-2"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger d-flex align-items-center">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>

                            <form id="form-laporan" class="custom-validation" action="{{ route('laporan.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-building me-2"></i> Informasi Fasilitas
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Pilih Jenis Fasilitas</label>
                                        {{-- <select name="fasilitas_id" id="fasilitas_id" class="form-select select2" required>
                                            @foreach($fasilitas as $f)
                                                <option value="{{ $f->fasilitas_id }}">{{ $f->nama_fasilitas }}</option>
                                            @endforeach
                                        </select> --}}
                                        <select name="fasilitas_id" id="fasilitas_id" class="form-select select2" required>
                                            <option value="" disabled selected>-- Pilih Jenis Fasilitas --</option>
                                            @foreach($fasilitas as $f)
                                                <option value="{{ $f->fasilitas_id }}">{{ $f->nama_fasilitas }}</option>
                                            @endforeach
                                        </select>
                                        <small id="error-fasilitas_id" class="error-text form-text text-danger"></small>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-semibold">Pilih Unit</label>
                                            <select name="unit_id" id="unit_id" class="form-select select2" required>
                                                @foreach($unit as $u)
                                                    <option value="{{ $u->unit_id }}">{{ $u->nama_unit }}</option>
                                                @endforeach
                                            </select>
                                            <small id="error-unit_id" class="error-text form-text text-danger"></small>
                                        </div>

                                        <div class="mb-3 col-md-8">
                                            <label class="form-label fw-semibold">Pilih Tempat/Ruangan</label>
                                            <select name="tempat_id" id="tempat_id" class="form-select select2" required>
                                                @foreach($tempat as $t)
                                                    <option value="{{ $t->tempat_id }}">{{ $t->nama_tempat }}</option>
                                                @endforeach
                                            </select>
                                            <small id="error-tempat_id" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-box-open me-2"></i> Informasi Barang Rusak
                                    </h5>

                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-semibold">Pilih Barang</label>
                                            <select name="barang_lokasi_id" id="barang_lokasi_id" class="form-select select2" required>
                                                @foreach($barangLokasi as $b)
                                                    <option value="{{ $b->barang_lokasi_id }}">{{ $b->jenisBarang->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="error-barang_id" class="error-text form-text text-danger"></small>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label fw-semibold">Pilih Kategori Kerusakan</label>
                                            <select name="kategori_kerusakan_id" id="kategori_kerusakan_id" class="form-select select2"
                                                required>
                                                @foreach($kategoriKerusakan as $k)
                                                    <option value="{{ $k->kategori_kerusakan_id }}">{{ $k->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="error-kategori-kerusakan_id"
                                                class="error-text form-text text-danger"></small>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="jumlah_barang_rusak" class="form-label fw-semibold">Jumlah Fasilitas yang Rusak</label>
                                            <div class="input-group">
                                                <input type="number" name="jumlah_barang_rusak" id="jumlah_barang_rusak"
                                                    class="form-control" required min="1">
                                                <span class="input-group-text">unit</span>
                                            </div>
                                            <div id="max-jumlah" class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i> Jumlah fasilitas yang tersedia: <span id="available-count">0</span>
                                            </div>
                                            <small id="error-jumlah_rusak" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-calendar-alt me-2"></i> Informasi Periode
                                    </h5>

                                    @php
                                        $periodeSekarang = $periode->firstWhere('nama_periode', date('Y'));
                                    @endphp
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Periode (Tahun Ini)</label>
                                        <select name="periode_id" id="periode_id" class="form-select" required readonly>
                                            @if($periodeSekarang)
                                                <option value="{{ $periodeSekarang->periode_id }}" selected>{{ $periodeSekarang->nama_periode }}</option>
                                            @else
                                                <option value="" disabled selected>Periode tahun ini tidak tersedia</option>
                                            @endif
                                        </select>
                                        <small id="error-periode_id" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>

                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-align-left me-2"></i> Deskripsi Kerusakan
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Deskripsi Kerusakan</label>
                                        <div>
                                            <textarea required name="deskripsi" class="form-control" rows="5"
                                                placeholder="Jelaskan secara detail tentang kerusakan yang terjadi..."></textarea>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-lightbulb me-1"></i> Deskripsi yang jelas akan membantu tim perbaikan memahami masalah dengan lebih baik.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-camera me-2"></i> Dokumentasi Kerusakan
                                    </h5>

                                    <div class="mb-3">
                                        <label for="foto_laporan" class="form-label fw-semibold">Foto Laporan</label>
                                        <div class="file-upload-wrapper">
                                            <input type="file" name="foto_laporan" id="foto_laporan" class="form-control"
                                                accept="image/jpeg,image/jpg,image/png,image/gif,application/pdf" required>
                                            <div class="form-text">
                                                <i class="fas fa-info-circle me-1"></i> Unggah foto kerusakan (format: JPG, PNG, maksimal 2MB)
                                            </div>
                                            <div id="file-preview" class="mt-2 text-center d-none">
                                                <img id="preview-image" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px; display: none;">
                                                <div id="file-info" class="mt-2"></div>
                                            </div>
                                        </div>
                                        <small id="error-foto-laporan" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-4 py-2" id="resetButton"
                                            style="border: 1px solid #dee2e6; transition: all 0.2s ease;">
                                        <i class="fas fa-undo me-2"></i> Reset Form
                                    </button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2"
                                            style="background-color: #3b82f6; border: none; box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3); transition: all 0.2s ease;">
                                        <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .file-upload-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .border {
            border: 1px solid #dee2e6 !important;
        }

        .rounded {
            border-radius: 0.375rem !important;
        }

        .progress {
            height: 10px;
            margin-top: 5px;
        }

        #preview-image {
            max-width: 100%;
            max-height: 200px;
        }

        .btn {
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 150px;
        }

        .btn-primary:hover {
            background-color: #2563eb !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.4) !important;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .btn:active {
            transform: translateY(1px);
        }

        .dark-mode .btn-primary {
            background-color: #1d4ed8 !important;
        }

        .dark-mode .btn-primary:hover {
            background-color: #1e40af !important;
        }

        .dark-mode .btn-outline-secondary {
            border-color: #3a4155;
            color: #e9ecef;
        }

        .dark-mode .btn-outline-secondary:hover {
            background-color: #2a3042;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const units = @json($unit);
            const tempat = @json($tempat);
            const barangLokasi = @json($barangLokasi);
            // console.log('Data Barang Lokasi:', barangLokasi);

            // 1. nonaktifkan semua field kecuali fasilitas awal
            disableAllFieldsExceptFasilitas();

            // 2. handler perubahan fasilitas
            $('#fasilitas_id').on('change', function() {
                const selectedFasilitas = $(this).val();
                resetDependentFields();

                if (selectedFasilitas == '2') { // FasUm
                    handleFasilitasUmum();
                } else if (selectedFasilitas) { // FasGed
                    handleFasilitasGedung(selectedFasilitas);
                }
            });

            // 3. handler perubahan unit (hanya untuk fasilitas gedung)
            $('#unit_id').on('change', function() {
                const selectedUnit = $(this).val();
                if (selectedUnit) {
                    filterTempat(selectedUnit);
                    $('#tempat_id').prop('disabled', false);
                }
            });

            // 4. handler perubahan tempat
            $('#tempat_id').on('change', function() {
                const selectedTempat = $(this).val();
                if (selectedTempat) {
                    filterBarangLokasi(selectedTempat);
                    $('#barang_lokasi_id').prop('disabled', false);
                }
            });

            // 5. handler perubahan barang
            $('#barang_lokasi_id').on('change', function() {
                const selectedBarang = $(this).val();
                if (selectedBarang) {
                    enableRemainingFields();
                    updateJumlahBarangTersedia(selectedBarang);
                }
            });

            $('#resetButton').on('click', function() {
                resetForm();
            });

            function disableAllFieldsExceptFasilitas() {
                $('#unit_id, #tempat_id, #barang_lokasi_id, #kategori_kerusakan_id, #periode_id, #jumlah_barang_rusak, #deskripsi, #foto_laporan')
                    .prop('disabled', true);
            }

            function resetDependentFields() {
                // mengosongkan dan nonaktifkan dropdown serta field lain
                $('#unit_id, #tempat_id, #barang_lokasi_id').empty().prop('disabled', true);
                $('#kategori_kerusakan_id, #periode_id, #jumlah_barang_rusak, #deskripsi, #foto_laporan')
                    .val('').prop('disabled', true);

                $('#unit_id, #tempat_id, #barang_lokasi_id').removeClass('is-valid is-invalid');

                $('#unit_id, #tempat_id, #barang_lokasi_id').prop('selectedIndex', 0);

                $('input, select').removeClass('is-valid is-invalid');
            }

            function resetForm() {
                $('#form-laporan')[0].reset(); // reset seluruh form

                // reset status validasi pada elemen select dan input lainnya
                $('#unit_id, #tempat_id, #barang_lokasi_id').removeClass('is-valid is-invalid');
                $('#unit_id, #tempat_id, #barang_lokasi_id').prop('selectedIndex', 0);  // mengosongkan atau pilih opsi default

                $('#barang_lokasi_id').find('option:selected').prop('selected', false);
                $('#barang_lokasi_id').removeClass('is-valid');

                disableAllFieldsExceptFasilitas();  // untuk nonaktifkan semua kecuali fasilitas

                $('#form-laporan').validate().resetForm(); // reset validasi form
                $('#form-laporan').removeClass('was-validated'); // menghapus class was-validated
                window.location.reload();
            }

            function handleFasilitasUmum() {
                $('#unit_id').append('<option value="1" selected>Umum</option>')
                    .prop('disabled', true);
                $('#unit_id').after('<input type="hidden" name="unit_id" value="1" />');
                filterTempat(1);
                $('#tempat_id').prop('disabled', false);
            }

            function handleFasilitasGedung(fasilitasId) {
                filterUnits(fasilitasId);
                $('#unit_id').prop('disabled', false);
            }

            function filterUnits(fasilitasId) {
                $('#unit_id').empty().append('<option value="" disabled selected>Pilih Unit</option>');
                const filteredUnits = units.filter(unit => unit.fasilitas_id == fasilitasId);

                filteredUnits.forEach(function(unit) {
                    $('#unit_id').append(`<option value="${unit.unit_id}">${unit.nama_unit}</option>`);
                });
            }

            function filterTempat(unitId) {
                $('#tempat_id').empty().append('<option value="" disabled selected>Pilih Tempat</option>');
                const filteredTempat = tempat.filter(t => t.unit_id == unitId);

                if (filteredTempat.length > 0) {
                    filteredTempat.forEach(function(t) {
                        $('#tempat_id').append(`<option value="${t.tempat_id}">${t.nama_tempat}</option>`);
                    });
                } else {
                    $('#tempat_id').append('<option value="" disabled>Tidak ada tempat tersedia</option>');
                }
            }

            function filterBarangLokasi(tempatId) {
                $('#barang_lokasi_id').empty().append('<option value="" disabled selected>Pilih Barang</option>');
                const filteredBarang = barangLokasi.filter(b => b.tempat_id == tempatId);

                if (filteredBarang.length > 0) {
                    filteredBarang.forEach(function(b) {
                        const namaBarang = b.jenis_barang ? b.jenis_barang.nama_barang : 'Barang Tidak Dikenal';
                        $('#barang_lokasi_id').append(
                            `<option value="${b.barang_lokasi_id}">${namaBarang}</option>`
                        );
                    });
                } else {
                    $('#barang_lokasi_id').append('<option value="" disabled>Tidak ada barang tersedia</option>');
                }
            }

            function enableRemainingFields() {
                $('#kategori_kerusakan_id, #periode_id, #jumlah_barang_rusak, #deskripsi, #foto_laporan')
                    .prop('disabled', false);
            }

            function updateJumlahBarangTersedia(barangLokasiId) {
                const selectedBarang = barangLokasi.find(b => b.barang_lokasi_id == barangLokasiId);

                if (selectedBarang) {
                    const maxJumlahRusak = selectedBarang.jumlah_barang || 0;
                    $('#jumlah_barang_rusak').attr('max', maxJumlahRusak);
                    $('#max-jumlah').text(`Jumlah fasilitas yang tersedia: ${maxJumlahRusak}`);
                }
            }

            // Validasi form
            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1024);
            }, 'Ukuran file terlalu besar.');

            $('#form-laporan').validate({
                rules: {
                    fasilitas_id: { required: true },
                    unit_id: { required: true },
                    tempat_id: { required: true },
                    barang_lokasi_id: { required: true },
                    kategori_kerusakan_id: { required: true },
                    periode_id: { required: true },
                    foto_laporan: {
                        required: true,
                        extension: "jpg|jpeg|png|gif",
                        filesize: 2048
                    },
                    deskripsi: {
                        required: true,
                        minlength: 5
                    },
                    jumlah_barang_rusak: {
                        required: true,
                        min: 1,
                        max: function() {
                            const maxRusak = $('#jumlah_barang_rusak').attr('max');
                            return parseInt(maxRusak);
                        }
                    }
                },
                messages: {
                    fasilitas_id: "Silakan pilih fasilitas.",
                    unit_id: "Silakan pilih unit.",
                    tempat_id: "Silakan pilih tempat.",
                    barang_lokasi_id: "Silakan pilih barang.",
                    kategori_kerusakan_id: "Silakan pilih kategori kerusakan.",
                    periode_id: "Silakan pilih periode.",
                    foto_laporan: {
                        required: "Silakan unggah foto laporan.",
                        extension: "Hanya file JPG, JPEG, PNG yang diperbolehkan.",
                        filesize: "Ukuran file tidak boleh lebih dari 2 MB."
                    },
                    deskripsi: {
                        required: "Silakan isi deskripsi kerusakan.",
                        minlength: "Deskripsi harus terdiri dari minimal 5 karakter."
                    },
                    jumlah_barang_rusak: {
                        required: "Silakan masukkan jumlah fasilitas yang rusak.",
                        min: "Jumlah fasilitas yang rusak harus lebih dari 0.",
                        max: "Jumlah fasilitas yang rusak tidak boleh melebihi jumlah fasilitas yang tersedia."
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "jumlah_barang_rusak") {
                        error.appendTo("#error-jumlah_rusak");
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                }
            });

            // Form submission with AJAX
            $('#form-laporan').on('submit', function(e) {
                e.preventDefault();

                if (!$(this).valid()) return;

                let formData = new FormData(this);

                Swal.fire({
                    title: 'Mengirim Laporan',
                    text: 'Sedang memproses laporan Anda...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            html: `<p>${response.message || 'Laporan berhasil dikirim!'}</p>
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Anda dapat melacak status laporan di menu Riwayat Laporan.
                                </div>`,
                            confirmButtonText: 'Ke Riwayat Laporan',
                            showCancelButton: true,
                            cancelButtonText: 'Tutup'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('riwayatlaporan') }}";
                            } else {
                                resetForm();
                                $('#file-preview').addClass('d-none');
                            }
                        });
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan saat mengirim laporan.';

                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).join('<br>');
                        } else if (xhr.responseJSON?.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: errorMsg
                        });
                    }
                });
            });
        });
    </script>
@endpush
