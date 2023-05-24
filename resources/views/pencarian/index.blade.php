@extends('admin_templates.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pencarian</h6>
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
                                <th>No SK</th>
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
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            processing: true, 
            serverSide: true, 
            searching: true, 
            ajax: {
                url: "{{route('pencarian-data')}}"
            },
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

