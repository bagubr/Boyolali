@extends('admin_templates.app')
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
                                <th>Tanggal Permohonan</th>
                                <th>Nomor Agenda</th>
                                <th>Nama Pemohon</th>
                                <th>Nomor Pemohon</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>  
                            @foreach (\App\Models\UserInformation::whereNotNull('agenda_date')->whereStatus(\App\Models\UserInformation::STATUS_FILING)->orderBy('created_at', 'desc')->get() as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                    <td>{{ $item->nomor_registration }}</td>
                                    <td>{{ $item->submitter }}</td>
                                    <td>{{ $item->submitter_phone }}</td>
                                    <td>{{ $item->district->name }}</td>
                                    <td>{{ $item->sub_district->name }}</td>
                                    <td>
                                        <a class="badge bg-primary text-white" href="{{ route('agenda-detail', ['id' => $item->uuid]) }}">Detail</a>
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
