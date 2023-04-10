@extends('admin_templates.app')
@push('css')
<link href="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Permohonan Baru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Agenda</th>
                                <th>Nomor Agenda</th>
                                <th>Nama Pemohon</th>
                                <th>Nomor Pemohon</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>  
                            @foreach (\App\Models\UserInformation::whereStatus(\App\Models\UserInformation::STATUS_KABID)->orderBy('created_at')->get() as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('Y-m-d', strtotime($item->agenda_date)) }}</td>
                                    <td>{{ $item->nomor_registration }}</td>
                                    <td>{{ $item->submitter }}</td>
                                    <td>{{ $item->submitter_phone }}</td>
                                    <td>{{ $item->district->name }}</td>
                                    <td>{{ $item->sub_district->name }}</td>
                                    <td>
                                        <a class="btn btn-sm bg-primary text-white" href="{{ route('kabid-detail', ['id' => $item->uuid]) }}">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
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
    
        <!-- Page level custom scripts -->
        <script src="{{ url('sb-admin') }}/js/demo/datatables-demo.js"></script>
@endpush
