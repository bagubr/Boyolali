@extends('layouts')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('header')
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top " style="background: rgba(40, 58, 90, 0.9);">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="#" style="text-decoration: none;">{{ config('app.name') }}</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="#" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            
            @include('users.navbar')

        </div>
    </header><!-- End Header -->
@endsection
@section('content')
    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg mt-5">
        <div class="container" data-aos="fade-up">
            
            <div class="section-title">
                <h2>Daftar KRK Proses</h2>
            </div>
            <a class="btn btn-success" style="right: 1%;position: absolute;" href="{{ route('daftar') }}"> <i class="fa-solid fa-plus"></i> Pendaftaran KRK Baru</a>
            <div class="row justify-content-center">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nomor Agenda</th>
                            <th>Nama Pemohon</th>
                            <th>Telpon Pemohon</th>
                            <th>Alamat Lokasi</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </section><!-- End Services Section -->
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            processing: true, 
            serverSide: true, 
            searching: false, 
            ajax: {
                url: "{{route('data')}}",
                data:{
                    status:'FILING'
                }
            },
            columns: [ 
                { data: 'id' }, 
                { data: 'created_at' },
                { data: 'nomor_registration' }, 
                { data: 'submitter' }, 
                { data: 'submitter_phone' }, 
                { data: 'location_address' },
                { data: 'status' },
                { data: 'action' },
            ]
        });
    });
</script>
@endpush
