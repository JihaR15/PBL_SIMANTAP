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
                            <div class="row mb-2">
                                <div class="col-md-8">
                                    <h4 class="card-title">Data Fasilitas</h4>
                                    <p class="card-title-desc mb-0">Daftar fasilitas yang tersedia dalam sistem. Anda dapat mengelola data fasilitas sesuai kebutuhan.</p>
                                </div>
                                @if(session('success'))
                                        <div class="alert alert-success" id="alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger" id="alert-error">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="unit_id" class="form-label">Filter: </label>
                                <select id="unit_id" class="form-select" name="unit_id" required>
                                    <option value="">- Semua -</option>
                                    @foreach($unit as $data)
                                        <option value="{{ $data->unit_id }}">{{ $data->nama_unit }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Filter berdasarkan Unit</small>
                            </div>

                            <table id="datatable" class="table table-sm table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Unit</th>
                                        <th>Nama Tempat</th>
                                        <th>Aksi</th>
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
    function modalAction(url = ''){
        $('#myModal').load(url,function(){
            $('#myModal').modal('show');
        });
    }

    var dataTempat;
    $(document).ready(function () {
        dataTempat = $('#datatable').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('lokasibarang/list') }}",
                "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.unit_id = $('#unit_id').val();
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "unit.nama_unit",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "nama_tempat",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "action",
                    className: "text-center",
                    width: "10%",
                    orderable: false,
                    searchable: false
                }
            ]
        });

            $('#unit_id').change(function () {
            dataTempat.ajax.reload();
        });
    });
</script>
@endpush
