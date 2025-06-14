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
                            <h3 class="card-title">Data Pengguna</h3>
                            <p class="card-title-desc">Berikut adalah daftar pengguna yang terdaftar dalam sistem. Anda
                                dapat mengelola data pengguna seperti menambah, mengedit, atau menghapus pengguna sesuai
                                kebutuhan.</p>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="role_id" class="form-label">Filter: </label>
                                    <select id="role_id" class="form-select" name="role_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach($role as $r)
                                            <option value="{{ $r->role_id }}">{{ $r->nama_role }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Role Pengguna</small>
                                </div>
                                <div class="col-md-8 text-end align-items-center d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary me-2" onclick="modalAction('{{ route('user.import') }}')">
                                        <i class="fas fa-file-import"></i> Import Pengguna
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="modalAction('{{ url('user/create') }}')">
                                        <i class="fas fa-plus"></i> Tambah Pengguna
                                    </button>
                                </div>
                            </div>

                            <table id="datatable" class="table table-bordered table-striped table-sm dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Role</th>
                                        <th>Status</th>
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
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <!-- End Page-content -->
@endsection

@push('css')
@endpush

@push('js')
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    var dataUser;
    $(document).ready(function () {
        dataUser = $('#datatable').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('user/list') }}",
                "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },
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
                    data: "username",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "name",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "role.nama_role",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "status_switch",
                    className: "text-center",
                    width: "6%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "action",
                    className: "text-center",
                    width: "15%",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#role_id').on('change', function () {
            dataUser.ajax.reload();
        });
    });

    $(document).on('change', '.toggle-status', function () {
        const userId = $(this).data('id');
        const isChecked = $(this).is(':checked');

        $.ajax({
            url: 'user/toggle-status',
            type: 'POST',
            data: {
                id: userId,
                _token: $('meta[name="csrf_token"]').attr('content')
            },
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Status berhasil diperbarui menjadi ' + (response.new_status == 1 ? 'Aktif' : 'Nonaktif')
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat memperbarui status.'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat memperbarui status.'
                });
            }
        });
    });
</script>
