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
                                    <h4 class="card-title">Data Role Pengguna</h4>
                                    <p class="card-title-desc">Daftar role pengguna yang tersedia dalam sistem. Anda dapat menambah, mengedit, atau menghapus data role sesuai kebutuhan.</p>
                                </div>

                                {{-- <div class="col-md-4 text-end align-items-center d-flex justify-content-end">
                                    <button type="button" class="btn btn-success" onclick="modalAction('{{ url('role/create') }}')"><i class="fas fa-plus"></i> Tambah Role</button>
                                </div> --}}
                            </div>

                            <table id="datatable" class="table table-bordered table-striped table-sm dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kode Role</th>
                                        <th>Nama Role</th>
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

<script>
    function modalAction(url = ''){
        $('#myModal').load(url,function(){
            $('#myModal').modal('show');
        });
    }

    var dataUser;
    $(document).ready(function () {
        dataUser = $('#datatable').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('role/list') }}",
                "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.role_id = $('#role_id').val();
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
                    data: "kode_role",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "nama_role",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "action",
                    className: "text-center",
                    width: "15%",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
