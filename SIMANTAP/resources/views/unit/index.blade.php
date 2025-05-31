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
                            <h3 class="card-title">Data Unit</h3>
                            <p class="card-title-desc mb-2">Daftar Unit yang tersedia dalam sistem. Anda dapat menambah,
                                mengedit, atau menghapus data unit sesuai kebutuhan.</p>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="fasilitas_id" class="form-label">Filter: </label>
                                    <select id="fasilitas_id" class="form-select" name="fasilitas_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach($fasilitas as $f)
                                            <option value="{{ $f->fasilitas_id }}">{{ $f->nama_fasilitas }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Jenis Fasilitas</small>
                                </div>
                                <div class="col-md-8 text-end align-items-center d-flex justify-content-end">
                                    <button type="button" class="btn btn-success"
                                        onclick="modalAction('{{ url('unit/create') }}')">
                                        <i class="fas fa-plus"></i> Tambah Unit
                                    </button>
                                </div>
                            </div>


                            <table id="datatable" class="table table-bordered table-striped table-sm dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Jenis Fasilitas</th>
                                        <th>Nama Unit</th>
                                        <th>Aksi</th>
                                        <th>Tempat</th>
                                    </tr>
                                </thead>
                            </table>

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
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        var dataUnit;
        $(document).ready(function () {
            dataUnit = $('#datatable').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('unit/list') }}",
                    "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.fasilitas_id = $('#fasilitas_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "fasilitas.nama_fasilitas",
                        className: "",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_unit",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "action",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "tempat",
                        className: "text-center",
                        width: "10%",
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#fasilitas_id').on('change', function () {
                dataUnit.ajax.reload();
            });
        });
    </script>
@endpush