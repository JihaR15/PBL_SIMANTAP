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
                                    <h4 class="card-title">Status Perbaikan Laporan</h4>
                                    <p class="card-title">Berikut adalah daftar status perbaikan laporan kerusakan yang telah Anda buat. Klik tombol "Detail" untuk melihat informasi lengkap.</p>
                                </div>
                            </div>
                            <table id="datatable" class="table table-bordered table-striped table-sm dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Barang</th>
                                        <th>Tempat</th>
                                        <th>Unit</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Fasilitas yang rusak</th>
                                        <th>Status Perbaikan</th>
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

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

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
                    url: "{{ route('statusperbaikan') }}",
                    type: "GET"
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", width: "5%" },
                    { data: 'barang', name: 'barang' },
                    { data: 'tempat', name: 'tempat' },
                    { data: 'unit', name: 'unit' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'jumlah_barang_rusak', name: 'jumlah_barang_rusak', className: "text-center", width: "10%"},
                    { data: 'status_perbaikan', name: 'status_perbaikan', className: "text-center" },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center", width: "8%" }
                ],
                order: [[0, 'desc']],

                drawCallback: function () {
                    const urlParams = new URLSearchParams(window.location.search);
                    const openId = urlParams.get('open_id');
                    if (openId) {
                        modalAction(`{{ url('/statusperbaikan') }}/${openId}/show`);
                        history.replaceState(null, null, window.location.pathname);
                    }
                }
            });
        });
    </script>
@endpush
