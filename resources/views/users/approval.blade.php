@extends('layouts')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
        }
    </style>
@endpush
@section('header')
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top " style="background: rgba(40, 58, 90, 0.9);">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="#">{{ config('app.name') }}</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="#" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            @include('users.navbar')

        </div>
    </header><!-- End Header -->
@endsection
@section('content')
    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio mt-5">
        <div class="container" data-aos="fade-up">
            @include('users.alert')
            <div class="section-title">
                <h2>{{ config('app.name') }}</h2>
                <h3>{{ $user_information->nomor_registration }}</h3>
            </div>
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-12 col-md-6 portfolio-item filter-web">
                    <table class="table table-striped">
                        <tr>
                            <th>KRK</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>Nomor Agenda</td>
                            <td>{{ $user_information->nomor_registration }}</td>
                        </tr>
                        <tr>
                            <td>Nomor KRK</td>
                            <td>{{ $user_information->nomor_krk }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Permohonan</td>
                            <td>{{ date('d-m-Y', strtotime($user_information->agenda_date)) }}</td>
                        </tr>
                        <tr>
                            <td>Nama Pemohon</td>
                            <td>{{ $user_information->submitter }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Lokasi</td>
                            <td>{{ $user_information->location_address }}</td>
                        </tr>
                        <tr>
                            <td>Ditanda tangani oleh</td>
                            <td>{{ @$user_information->approval->approval_name }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal di tanda tangani</td>
                            <td>{{ date('d-m-Y', strtotime(@$user_information->approval->approval_date)) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section><!-- End Portfolio Section -->
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="uploadLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('upload') }}" method="POST" class="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="file" name="file" id="file" class="form-control">
                        <input type="hidden" name="reference_type_id" id="reference_type_id">
                        <input type="hidden" name="user_information_id" value="{{ $user_information->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        function upload(params) {
            $('#reference_type_id').val(params);
        }
    </script>

    <script>
        var array_polygons = {!! $user_information->polygons->pluck('longitude', 'latitude') !!};
        const entries = Object.entries(array_polygons);
        var polymarker = L.polygon(entries).getBounds().getCenter();
        const map = L.map('map', {
            center: [polymarker.lat, polymarker.lng],
            zoom: 16
        });
        L.tileLayer(
            "http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
                maxZoom: 20,
                subdomains: ["mt0", "mt1", "mt2", "mt3"],
            }
        ).addTo(map);
        var marker = new L.Marker([polymarker.lat, polymarker.lng]);
        marker.addTo(map);
        
    </script>
@endpush
