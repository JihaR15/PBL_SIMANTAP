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
                                    <h4 class="card-title">Tugas Perbaikan</h4>
                                    <p class="card-title">Berikut adalah daftar tugas perbaikan yang harus Anda Selesaikan. Klik tombol "Detail" untuk melihat dan menyelesaikan Tugas.</p>
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
                                        <th>Prioritas</th>
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
                    url: "{{ route('perbaikan.list2') }}",
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
                        data: 'nama_barang',
                        name: 'nama_barang',
                    },
                    {
                        data: 'nama_tempat',
                        name: 'nama_tempat'
                    },
                    {
                        data: 'nama_unit',
                        name: 'nama_unit'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'jumlah_barang_rusak',
                        name: 'jumlah_barang_rusak',
                        className: "text-center"
                    },
                    {
                        data: 'prioritas',
                        name: 'prioritas',
                        className: "text-center fw-bold"
                    },
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
                        const pathname = window.location.pathname;

                        if (pathname.includes('/perbaikan')) {
                            modalAction(`{{ url('/perbaikan') }}/${openId}/show`);
                        } else if (pathname.includes('/dikerjakan')) {
                            modalAction(`{{ url('dikerjakan') }}/${openId}/show`);
                        } else if (pathname.includes('/riwayatperbaikan')) {
                            modalAction(`{{ url('riwayatperbaikan') }}/${openId}/show`);
                        }

                        history.replaceState(null, null, window.location.pathname);
                    }
                }
            });
        });
    </script>
@endpush
