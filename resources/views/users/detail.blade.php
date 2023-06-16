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

            <h1 class="logo me-auto"><a href="#" style="text-decoration: none;">{{ config('app.name') }}</a></h1>
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
                <h2>Detail Pemohon</h2>
                <h3>{{ $user_information->nomor_registration }}</h3>
            </div>
            <ul id="portfolio-flters" class="d-flex justify-content-left" data-aos="fade-up" data-aos-delay="100">
                <li data-filter="*" class="filter-active">Semua</li>
                <li data-filter=".filter-card">Data Pemohon</li>
                <li data-filter=".filter-web">Kelengkapan Berkas</li>
            </ul>
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-12 col-md-6 portfolio-item filter-card">
                    <div class="row content mb-3">
                        <div class="col-lg-6">
                            <ul class="list-group list-group-flush card mb-3">
                                <div class="card-header">
                                    <h2>Data Lokasi</h2>
                                </div>
                                <li class="list-group-item">Luas Tanah : <i>{{ $user_information->land_area ?? '-' }} m
                                        <sup>2</sup></i></li>
                                <li class="list-group-item">Kelurahan :
                                    <i>{{ $user_information->sub_district->name ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">Kecamatan :
                                    <i>{{ $user_information->district->name ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">Alamat Lokasi :
                                    <i>{{ $user_information->location_address ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">Status Tanah :
                                    <i>{{ $user_information->land_status->name ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">Nomor Sertifikat Tanah :
                                    <i>{{ $user_information->nomor_hak ?? '-' }}</i>
                                </li>
                            </ul>
                            <ul class="list-group list-group-flush card">
                                <div class="card-header">
                                    <h2>Data Pemohon</h2>
                                </div>
                                <li class="list-group-item">Nama Pemohon : <i>{{ $user_information->submitter ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">Telepon Pemohon :
                                    <i>{{ $user_information->submitter_phone ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">No. KTP : <i>{{ $user_information->nomor_ktp ?? '-' }}</i></li>
                                <li class="list-group-item">Alamat Pemohon : <i>{{ $user_information->address ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">Kegiatan : <i>{{ $user_information->activity_name ?? '-' }}</i>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6 pt-4 pt-lg-0">
                            {{-- <ul class="list-group list-group-flush card mb-3">
                                <div class="card-header">
                                    <h2>Data Kuasa</h2>
                                </div>
                                <li class="list-group-item">Nama Kuasa :
                                    <i>{{ $user_information->procuration->name ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">Telepon Kuasa :
                                    <i>{{ $user_information->procuration->phone ?? '-' }}</i>
                                </li>
                                <li class="list-group-item">Alamat Kuasa :
                                    <i>{{ $user_information->procuration->address ?? '-' }}</i>
                                </li>
                            </ul> --}}
                            <table class="table table-striped table-bordered " border="1">
                                <tr>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                </tr>
                                <tr>
                                    <td>{{ $user_information->latitude }}</td>
                                    <td>{{ $user_information->longitude }}</td>
                                </tr>
                            </table>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3>Lokasi</h3>
                                    {{-- <a href="https://google.com/maps/?q={{ $user_information->latitude }},{{ $user_information->longitude }}" target="_blank" class="btn btn-success"> Direct Location</a> --}}
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6 portfolio-item filter-web">
                    <table class="table table-striped">
                        <tr>
                            <th>Jenis Berkas</th>
                            <th>Penjelasan</th>
                            <th>Status Upload</th>
                            <th>Status Berkas</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                        </tr>
                        @foreach (\App\Models\ReferenceType::get() as $item)
                            <tr>
                                <td>{{ $item->file_type }}</td>
                                <td>{{ $item->content }}</td>
                                <td>
                                    <p href="#"
                                        class="badge bg-{{ @$item->user_information_reference($user_information->id)->is_upload == 1 ? 'success' : 'secondary' }}">
                                        {{ @$item->user_information_reference($user_information->id)->is_upload == 1 ? 'Sudah Upload' : 'Belum Upload' }}
                                    </p>
                                </td>
                                <td>{{ $item->user_information_reference($user_information->id)->status ?? '-' }}</td>
                                <td>
                                    @if ($user_information->status == \App\Models\UserInformation::STATUS_FILING)
                                        @if (!$item->user_information_reference($user_information->id))
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#upload" id="myModal" data-id="{{ $item->id }}"
                                                onclick="upload({{ $item->id }})">Upload</button>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $item->note }}</td>
                            </tr>
                        @endforeach
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
