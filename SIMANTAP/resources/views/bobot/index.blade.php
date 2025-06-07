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
                                <h4 class="card-title">Data Prioritas Perbaikan</h4>
                                <p class="card-title-desc">
                                    Daftar bobot setiap parameter. Anda dapat mengubah nilai bobot.
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="button" class="btn btn-warning" onclick="modalAction('{{ route('bobot.edit') }}')">
                                    <i class="mdi mdi-tune"></i> Edit Bobot
                                </button>
                            </div>
                        </div>

                        <table id="datatable" class="table table-sm table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Parameter</th>
                                    <th>Bobot</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        <!-- Container untuk modal edit (akan diisi via AJAX) -->
        <div id="modal-edit-bobot-container"></div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script>
    function modalAction(url = ''){
            $('#modal-edit-bobot-container').load(url, function() {
                $('#modalEditBobot').modal('show');
        });
    }

    $(document).ready(function () {
        dataBobot = $('#datatable').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ route('bobot.list') }}",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                dataType: "json",
                data: function (d) {
                    d.bobot_id = $('#bobot_id').val();
                },
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
                    data: "nama_parameter", 
                    orderable: false, 
                    searchable: true 
                },
                { 
                    data: "bobot", 
                    className: "text-center", 
                    orderable: false, 
                    searchable: false 
                }
            ]
        });
    });

    $('#bobot_id').on('change', function() {
        dataBobot.ajax.reload();
    });

    // Inisialisasi slider, validasi, dan submit pada modal
    function initBobotModal() {
        function updateTotal() {
            let total = 0;
            $('.bobot-slider').each(function() {
                total += parseFloat($(this).val());
            });
            $('#total-bobot').text(total.toFixed(2));
            $('.bobot-slider').each(function() {
                $(this).closest('.mb-4').find('.bobot-value').text(parseFloat($(this).val()).toFixed(2));
            });
            if (Math.abs(total - 1) < 0.001) {
                $('#btn-simpan-bobot').prop('disabled', false);
                $('#bobot-warning').hide();
            } else {
                $('#btn-simpan-bobot').prop('disabled', true);
                $('#bobot-warning').show();
            }
        }

        updateTotal();

        $(document).off('input change', '.bobot-slider').on('input change', '.bobot-slider', function() {
            updateTotal();
        });

        $(document).off('submit', '#form-edit-bobot').on('submit', '#form-edit-bobot', function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            $('#btn-simpan-bobot').prop('disabled', true);

            $.ajax({
                url: "{{ route('bobot.updateAll') }}",
                type: "POST",
                data: data,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                success: function(res) {
                    if(res.status) {
                        Swal.fire('Berhasil', res.message, 'success');
                        $('#modalEditBobot').modal('hide');
                        $('#datatable').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal', 'Terjadi kesalahan server.', 'error');
                },
                complete: function() {
                    $('#btn-simpan-bobot').prop('disabled', false);
                }
            });
        });
    }
</script>
@endpush