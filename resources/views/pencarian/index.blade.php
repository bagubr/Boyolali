@extends('admin_templates.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pencarian</h6>
                <form action="" method="GET" class="form-horizontal" role="form">
                    @csrf
                    <div class="input-group">
                        <input class="form-control input-mask-date" type="text" id="form-field-mask-1" placeholder="Nomor Agenda/ Nama Pemohon/ Alamat Lokasi/ Nomor KRK" name="keyword" />
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">
                                <i class="ace-icon fa fa-search bigger-110"></i>
                                Cari
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Agenda</th>
                                <th>Nama Pemohon</th>
                                <th>Alamat Lokasi</th>
                                <th>Nomor KRK</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($user_informations)
                            @foreach ($user_informations as $item)
                            <tr>
                                <td>{{ $item->iteration }}</td>
                                <td>{{ $item->nomor_registration }}</td>
                                <td>{{ $item->submitter }}</td>
                                <td>{{ $item->location_address }}</td>
                                <td>{{ $item->nomor_krk }}</td>
                                <td><a href={{route('pencarian-detail', ['id' => $item->id])}} class='badge bg-primary text-white'>Detail</a></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@push('js')
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            processing: true, 
            serverSide: false, 
            searching: true, 
            columns: [ 
                { data: 'id' }, 
                { data: 'nomor_registration' }, 
                { data: 'submitter' }, 
                { data: 'location_address' },
                { data: 'nomor_krk' },
                { data: 'action' },
            ]
        });
    });
</script>
@endpush

