@extends('admin_templates.app')
@push('css')
    <link href="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <style>
        .ui-datepicker-calendar {
            display: none;
        }

        .ui-datepicker-month {
            display: none;
        }

        .ui-datepicker-next,
        .ui-datepicker-prev {
            display: none;
        }
    </style>
@endpush
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Permohonan Selesai</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table border="0" cellspacing="5" cellpadding="5">
                        <tbody>
                            <tr>
                                <td>Minimum date:</td>
                                <td><input type="date" id="date_min" class="form-control" name="date_min"></td>
                                <td>Maximum date:</td>
                                <td><input type="date" id="date_max" class="form-control" name="date_max"></td>
                                <td>Tahun:</td>
                                <td><input type="text" id="year" class="form-control" name="year" autocomplete="off"></td>
                                <td>Bulan:</td>
                                <td>
                                    <select id='month' class="form-control">
                                        <option value=''>--Select Month--</option>
                                        <option value='1'>Janaury</option>
                                        <option value='2'>February</option>
                                        <option value='3'>March</option>
                                        <option value='4'>April</option>
                                        <option value='5'>May</option>
                                        <option value='6'>June</option>
                                        <option value='7'>July</option>
                                        <option value='8'>August</option>
                                        <option value='9'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>
                                </td>
                                <td><button id="cari" class="btn btn-primary">Cari</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered" id="dataTable2" width="100%" style="font-size:12px"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Agenda</th>
                                <th>Nomor Agenda</th>
                                <th>Nama Pemohon</th>
                                <th>Nomor Pemohon</th>
                                <th>Alamat Lokasi</th>
                                <th>Nomor KRK</th>
                                <th>Tanggal Pengesahan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
@push('js')
    <!-- Page level plugins -->
    <script src="{{ url('sb-admin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    {{-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('sb-admin') }}/js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            // Create date inputs
            var minDate, maxDate, table, year, month;
            // DataTables initialisation

            // Refilter the table

            $('#cari').on('click', function() {
                minDate = $('#date_min').val();
                maxDate = $('#date_max').val();
                year = $('#year').val();
                month = $('#month').val();
                console.log(month)
                if (table) {
                    table.clear().destroy();
                }
                table = $('#dataTable2').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    ajax: {
                        url: "{{ route('rekap-data') }}",
                        data: {
                            status: 'SELESAI',
                            min_date: minDate,
                            max_date: maxDate,
                            year: year,
                            month: month,
                        }
                    },
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'nomor_registration'
                        },
                        {
                            data: 'submitter'
                        },
                        {
                            data: 'submitter_phone'
                        },
                        {
                            data: 'location_address'
                        },
                        {
                            data: 'nomor_krk'
                        },
                        {
                            data: 'print_date'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'action'
                        },
                    ]
                });
            });

            $('#year').datepicker({
                changeYear: true,
                showButtonPanel: true,
                todayHighlight: false,
                dateFormat: 'yy',
                onClose: function(dateText, inst) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, 1));
                }
            });
        });
    </script>
@endpush
