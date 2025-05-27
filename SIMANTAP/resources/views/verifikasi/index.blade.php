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
                                    <h4 class="card-title">Laporan Kerusakan</h4>
                                    <p class="card-title">Berikut adalah daftar laporan kerusakan. Anda dapat memverifikasi laporan kerusakan dengan mengklik tombol "Detail".</p>
                                </div>
                            </div>
                            <table id="datatable" class="table table-bordered table-striped table-sm dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fasilitas</th>
                                        <th>Unit</th>
                                        <th>Tempat</th>
                                        <th>Barang</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('css')

@endpush

@push('js')
    <script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('verifikasi.list') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center"
                    },
                    {
                        data: 'fasilitas.nama_fasilitas',
                        name: 'fasilitas.nama_fasilitas'
                    },
                    {
                        data: 'unit.nama_unit',
                        name: 'unit.nama_unit'
                    },
                    {
                        data: 'tempat.nama_tempat',
                        name: 'tempat.nama_tempat' },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang' },
                    {
                        data: 'created_at',
                        name: 'created_at' },
                    {
                        data: 'status_verif',
                        name: 'status_verif',
                        className: "text-center" },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        className: "text-center",
                        searchable: false
                    }
                ],
                drawCallback: function () {
                    const urlParams = new URLSearchParams(window.location.search);
                    const openId = urlParams.get('open_id');
                    if (openId) {
                        modalAction(`{{ url('/verifikasi') }}/${openId}/show`);
                        history.replaceState(null, null, window.location.pathname);
                    }
                }
            });
        });
    </script>
@endpush
