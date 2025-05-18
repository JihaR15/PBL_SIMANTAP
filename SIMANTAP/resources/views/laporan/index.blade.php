@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    @include('layouts.breadcrumb')
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h4 class="card-title">Laporkan Kerusakan anda Sedetail Mungkin</h4>
                                    <p class="card-title">Silakan isi form berikut untuk melaporkan kerusakan yang terjadi.
                                        Pastikan semua data yang dimasukkan sudah benar sebelum disubmit.</p>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>

                            <form id="form-laporan" class="custom-validation" action="{{ route('laporan.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label>Pilih Jenis Fasilitas</label>
                                    <select name="fasilitas_id" id="fasilitas_id" class="form-select" required>
                                        @foreach($fasilitas as $f)
                                            <option value="{{ $f->fasilitas_id }}">{{ $f->nama_fasilitas }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-fasilitas_id" class="error-text form-text text-danger"></small>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label>Pilih Unit</label>
                                        <select name="unit_id" id="unit_id" class="form-select" required>
                                            @foreach($unit as $u)
                                                <option value="{{ $u->unit_id }}">{{ $u->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                        <small id="error-unit_id" class="error-text form-text text-danger"></small>
                                    </div>

                                    <div class="mb-3 col-md-8">
                                        <label>Pilih Tempat/Ruangan</label>
                                        <select name="tempat_id" id="tempat_id" class="form-select" required>
                                            @foreach($tempat as $t)
                                                <option value="{{ $t->tempat_id }}">{{ $t->nama_tempat }}</option>
                                            @endforeach
                                        </select>
                                        <small id="error-tempat_id" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label>Pilih Barang</label>
                                        <select name="barang_lokasi_id" id="barang_lokasi_id" class="form-select" required>
                                            @foreach($barangLokasi as $b)
                                                <option value="{{ $b->barang_lokasi_id }}">{{ $b->jenisBarang->nama_barang }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small id="error-barang_id" class="error-text form-text text-danger"></small>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <label>Pilih Kategori Kerusakan</label>
                                        <select name="kategori_kerusakan_id" id="kategori_kerusakan_id" class="form-select"
                                            required>
                                            @foreach($kategoriKerusakan as $k)
                                                <option value="{{ $k->kategori_kerusakan_id }}">{{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small id="error-kategori-kerusakan_id"
                                            class="error-text form-text text-danger"></small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Pilih Periode</label>
                                    <select name="periode_id" id="periode_id" class="form-select" required>
                                        @foreach($periode as $p)
                                            <option value="{{ $p->periode_id }}">{{ $p->nama_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small id="error-periode_id" class="error-text form-text text-danger"></small>
                                </div>


                                <div class="mb-3">
                                    <label>Deskripsi Kerusakan</label>
                                    <div>
                                        <textarea required name="deskripsi" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>

                                {{-- <div class="mb-3">
                                    <label>Upload Foto Kerusakan</label>
                                    <div class="dropzone" id="my-dropzone">
                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                            </div>
                                            <h4>Drop files here or click to upload.</h4>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="mb-3">
                                    <label for="foto_laporan">Foto Laporan</label>
                                    <input type="file" name="foto_laporan" id="foto_laporan" class="form-control"
                                        accept="image/jpeg,image/jpg,image/png,image/gif,application/pdf" required>
                                    <small id="error-foto-laporan" class="error-text form-text text-danger"></small>
                                </div>

                                <div class="mb-0">
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div>

    </div>
    <!-- End Page-content -->
@endsection

@push('css')
@endpush

@push('js')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        const units = @json($unit); // Data unit dari controller
        const tempat = @json($tempat); // Data tempat dari controller
        const barangLokasi = @json($barangLokasi); // Data barang lokasi dari controller

        $(document).ready(function () {
            // Saat halaman dimuat, nonaktifkan dropdown tempat dan barang lokasi
            $('#tempat_id').prop('disabled', true);
            $('#barang_lokasi_id').prop('disabled', true);

            // Tampilkan default value saat halaman pertama kali dimuat
            const defaultFasilitas = $('#fasilitas_id').find('option:selected').val();
            filterUnits(defaultFasilitas);

            // Event listener untuk dropdown fasilitas
            $('#fasilitas_id').on('change', function () {
                const selectedFasilitas = $(this).val(); // Ambil ID fasilitas yang dipilih
                console.log('Fasilitas yang dipilih:', selectedFasilitas);

                // Jika fasilitas umum dipilih
                if (selectedFasilitas == '2') { // Ganti '1' dengan ID fasilitas umum
                    console.log('Fasilitas Umum dipilih, unit otomatis diatur ke Umum.');

                    // Atur unit ke Umum (ID 1) dan disable dropdown unit
                    $('#unit_id').empty().append('<option value="1" selected>Umum</option>');
                    $('#unit_id').after('<input type="hidden" name="unit_id" value="1" />');
                    $('#unit_id').prop('disabled', true);


                    // Filter tempat berdasarkan unit Umum
                    filterTempat(1);

                    // Aktifkan dropdown tempat
                    $('#tempat_id').prop('disabled', false);
                } else {
                    // Reset dropdown unit dan tempat jika fasilitas bukan umum
                    $('#unit_id').prop('disabled', false);
                    filterUnits(selectedFasilitas);

                    // Reset dropdown tempat dan barang lokasi
                    $('#tempat_id').empty().prop('disabled', true);
                    $('#barang_lokasi_id').empty().prop('disabled', true);
                }
            });

            // Event listener untuk dropdown unit
            $('#unit_id').on('change', function () {
                const selectedUnit = $(this).val(); // Ambil ID unit yang dipilih
                console.log('Unit yang dipilih:', selectedUnit);

                // Filter tempat berdasarkan unit_id
                filterTempat(selectedUnit);

                // Reset dropdown barang lokasi
                $('#barang_lokasi_id').empty().prop('disabled', true);
            });

            // Event listener untuk dropdown tempat
            $('#tempat_id').on('change', function () {
                const selectedTempat = $(this).val(); // Ambil ID tempat yang dipilih
                console.log('Tempat yang dipilih:', selectedTempat);

                // Filter barang lokasi berdasarkan tempat_id
                filterBarangLokasi(selectedTempat);
            });

            // Fungsi untuk memfilter unit
            function filterUnits(fasilitasId) {
                // Kosongkan dropdown unit_id
                $('#unit_id').empty();

                // Tambahkan opsi default
                $('#unit_id').append('<option value="" disabled selected>Pilih Unit</option>');

                // Filter data unit berdasarkan fasilitas_id
                const filteredUnits = units.filter(unit => unit.fasilitas_id == fasilitasId);

                // Tambahkan opsi unit yang sesuai
                filteredUnits.forEach(function (unit) {
                    $('#unit_id').append(`<option value="${unit.unit_id}">${unit.nama_unit}</option>`);
                });

                console.log('Unit yang ditampilkan:', filteredUnits);

                // Aktifkan dropdown unit jika ada data
                $('#unit_id').prop('disabled', filteredUnits.length === 0);
            }

            // Fungsi untuk memfilter tempat
            function filterTempat(unitId) {
                // Kosongkan dropdown tempat_id
                $('#tempat_id').empty();

                // Tambahkan opsi default
                $('#tempat_id').append('<option value="" disabled selected>Pilih Tempat</option>');

                // Filter data tempat berdasarkan unit_id
                const filteredTempat = tempat.filter(t => t.unit_id == unitId);

                // Tambahkan opsi tempat yang sesuai
                filteredTempat.forEach(function (t) {
                    $('#tempat_id').append(`<option value="${t.tempat_id}">${t.nama_tempat}</option>`);
                });

                console.log('Tempat yang ditampilkan:', filteredTempat);

                // Aktifkan dropdown tempat jika ada data
                $('#tempat_id').prop('disabled', filteredTempat.length === 0);
            }

            // Fungsi untuk memfilter barang lokasi
            function filterBarangLokasi(tempatId) {
                // Kosongkan dropdown barang_lokasi_id
                $('#barang_lokasi_id').empty();

                // Tambahkan opsi default
                $('#barang_lokasi_id').append('<option value="" disabled selected>Pilih Barang</option>');

                // Filter data barang lokasi berdasarkan tempat_id
                const filteredBarangLokasi = barangLokasi.filter(b => b.tempat_id == tempatId);

                // Tambahkan opsi barang lokasi yang sesuai
                filteredBarangLokasi.forEach(function (b) {
                    $('#barang_lokasi_id').append(`<option value="${b.barang_lokasi_id}">${b.jenis_barang.nama_barang}</option>`);
                });

                console.log('Barang lokasi yang ditampilkan:', filteredBarangLokasi);

                // Aktifkan dropdown barang lokasi jika ada data
                $('#barang_lokasi_id').prop('disabled', filteredBarangLokasi.length === 0);
            }

            $.validator.addMethod('filesize', function (value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1024);
            }, 'Ukuran file terlalu besar.');

            // Validasi form menggunakan jQuery Validation
            $('#form-laporan').validate({
                rules: {
                    fasilitas_id: {
                        required: true
                    },
                    unit_id: {
                        required: true
                    },
                    tempat_id: {
                        required: true
                    },
                    barang_lokasi_id: {
                        required: true
                    },
                    kategori_kerusakan_id: {
                        required: true
                    },
                    periode_id: {
                        required: true
                    },
                    foto_laporan: {
                        required: true,
                        extension: "jpg|jpeg|png|gif",
                        filesize: 2048 // 2MB in KB
                    },
                    deskripsi: {
                        required: true,
                        minlength: 5
                    }
                },
                // Messages should be outside the rules object
                messages: {
                    fasilitas_id: "Silakan pilih fasilitas.",
                    unit_id: "Silakan pilih unit.",
                    tempat_id: "Silakan pilih tempat.",
                    barang_lokasi_id: "Silakan pilih barang.",
                    kategori_kerusakan_id: "Silakan pilih kategori kerusakan.",
                    periode_id: "Silakan pilih periode.",
                    foto_laporan: {
                        required: "Silakan unggah foto laporan.",
                        extension: "Hanya file JPG, JPEG, PNG, dan PDF yang diperbolehkan.",
                        filesize: "Ukuran file tidak boleh lebih dari 2 MB."
                    },
                    deskripsi: {
                        required: "Silakan isi deskripsi kerusakan.",
                        minlength: "Deskripsi harus terdiri dari minimal 5 karakter."
                    }
                }
            });
            // Event saat form disubmit
            $('#form-laporan').on('submit', function (e) {
                e.preventDefault(); // cegah form submit standar
                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Laporan berhasil dikirim!'
                        }).then(() => {
                            location.reload(); // reload jika perlu, atau redirect
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengirim laporan.'
                        });
                    }
                });
            });

        });
    </script>
@endpush