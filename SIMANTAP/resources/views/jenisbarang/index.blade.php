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
                                <div class="col-md-8">
                                    <h4 class="card-title">Data Barang</h4>
                                    <p class="card-title-desc">Daftar Barang yang tersedia dalam sistem. Anda dapat menambah, mengedit, atau menghapus data barang sesuai kebutuhan.</p>
                                </div>

                                <div class="col-md-4 text-end align-items-center d-flex justify-content-end">
                                    <button type="button" class="btn btn-success" onclick="modalAction('{{ url('jenisbarang/create') }}')"><i class="fas fa-plus"></i> Tambah Barang</button>
                                </div>
                            </div>

                            <table id="datatable" class="table table-sm table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Barang</th>
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

    var dataBarang;
    $(document).ready(function () {
        dataBarang = $('#datatable').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('jenisbarang/list') }}",
                "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.jenis_barang_id = $('#jenis_barang_id').val();
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nama_barang",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "action",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush
