@extends('layouts')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.9/leaflet.draw.css" />
    <style>
        .leaflet-div-icon {
            width: 10px !important;
            height: 10px !important;
            margin: auto !important;
            margin-left: -5px !important;
            margin-top: -5px !important;
        }

        #map {
            height: 500px;
        }

        #regForm {
            background-color: #ffffff;
            margin: 100px auto;
            font-family: Raleway;
            padding: 40px;
            width: 70%;
            min-width: 300px;
        }

        /* Mark input boxes that gets an error on validation: */
        .form-control.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        button {
            background-color: #04AA6D;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }

        #resetButton {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px;
            z-index: 400;
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
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact mt-5">
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center">

                <div class="col-lg-12 mt-5 mt-lg-0">
                    @include('users.alert')
                    <form action="{{ route('user_information') }}" method="post" role="form" class="php-email-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tab">
                            <div class="section-title">
                                <h2>Data Lokasi</h2>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Luas Tanah</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input" name="land_area"
                                            data-mask='#,##0.00' required>
                                        <div class="input-group-text">
                                            <span>m <sup>2</sup></span>
                                        </div>
                                    </div>
                                    <small>* Luas Tanah Sesuai Dengan Luas Pada Surat Tanah</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Alamat Lokasi</label>
                                <textarea type="text" class="form-control input" name="location_address" id="" required></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="activity">Kecamatan</label>
                                <select name="district_id" id="district_id" class="form-control input">
                                    <option value="">PILIH</option>
                                    @foreach (\App\Models\District::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="activity">Kelurahan</label>
                                <select name="sub_district_id" id="sub_district_id" class="form-control input">
                                    <option value="">PILIH</option>
                                    @foreach (\App\Models\SubDistrict::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="">Draw Polygon</label>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <div class="mb-3" id="map"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    Metode Pengukuran
                                    <select name="measurement_type" id="measurement_type" onchange="measurementType(this)" class="form-control input" required>
                                        <option value="">PILIH</option>
                                        <option value="POLYGON">GAMBAR BIDANG</option>
                                        <option value="INPUT">INPUT KOORDINAT</option>
                                    </select>
                                    <br>
                                    <button type="button" class="btn btn-secondary" onclick="resetButton()">Reset</button>
                                    <button type="button" class="btn btn-success" style="float: right;display:none;" id="btnCoor" onclick="addCoorButton()">Tambah Koordinat</button>
                                    <table class="table koordinattable">
                                        <thead>
                                            <tr>
                                                <th>Y (Latitude)</th>
                                                <th>X (Longitude)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="activity">Status Tanah</label>
                                <select name="land_status_id" id="status_tanah" class="form-control input">
                                    <option value="">PILIH</option>
                                    @foreach (\App\Models\LandStatus::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name">Nomor Setifikat </label>
                                <input type="text" class="form-control input" name="nomor_hak" id="nomor_hak" required>
                                <small>Contoh : HM.12345 ( HM = Hak Milik, HGB = Hak Guna Bangunan )</small>
                            </div>
                        </div>

                        <div class="tab">
                            <div class="section-title">
                                <h2>Data Pemohon</h2>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="submitter">Nama Pemohon</label>
                                <input type="text" class="form-control input" name="submitter" id="submitter" required style="text-transform: uppercase;">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="submitter_optional">Nama Perusahaan</label>
                                <input type="text" class="form-control" name="submitter_optional"
                                    id="submitter_optional" style="text-transform: uppercase;">
                                <small class="text-danger">* apabila bukan perorangan</small>
                            </div>
                            <div class="form-group">
                                <label for="nomor_ktp">NO KTP</label>
                                <input type="text" class="form-control input" name="nomor_ktp" id="nomor_ktp"
                                    required minlength="16" maxlength="16">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="submitter_phone">Telepon Pemohon</label>
                                <input type="text" class="form-control input" name="submitter_phone"
                                    id="submitter_phone" id="submitter_phone" required minlength="11" maxlength="13">
                                <small>* Contoh : 0851234567890</small>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Alamat Pemohon</label>
                                <textarea type="text" class="form-control input" name="address" id="" required></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">Email Pemohon</label>
                                <input type="text" class="form-control input" name="email" id=""
                                    value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="activity">Kegiatan yang dimohon</label>
                                <br>
                                <select name="activity_name" style="width: 100%;" class="col-12 form-control input"
                                    id="activity_name" required>
                                    <option value="">PILIH</option>
                                    @foreach (\App\Models\Activity::get() as $item)
                                        <option value="{{ $item->title }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="tab">
                            <div class="section-title">
                                <h2>Data Pendukung</h2>
                            </div>
                            <div class="col-lg-12 col-md-6 portfolio-item filter-web">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Jenis Berkas</th>
                                        <th>Penjelasan</th>
                                        <th>Aksi</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    @foreach (\App\Models\ReferenceType::orderBy('id')->get() as $item)
                                        <tr>
                                            <td>{{ $item->file_type }}</td>
                                            <td style="width: 40%">{!! $item->content !!}</td>
                                            <td>
                                                <input type="file" name="{{ $item->id }}" id="" class="form-control {{ ($item->note == 'Wajib Upload')?'input':'' }}" onChange="validateAndUpload(this,{{ $item->max_upload }});" {{ ($item->note == 'Wajib Upload')?'required':'' }} accept="application/pdf">
                                                <small style="color:red;">* Max Upload {{ $item->max_upload }} mb</small>
                                            </td>
                                            <td>{!! $item->note !!}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div style="text-align:center;margin-top:40px;">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="button" id="prevBtn" class="btn btn-secondary"
                                    onclick="nextPrev(-1)">Previous</button>
                                <button type="button" id="nextBtn" class="btn btn-success"
                                    onclick="nextPrev(1)">Next</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->
@endsection

@push('js')
    @include('nextBtnprevBtn')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.9/leaflet.draw.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>

    @include('validateInput')
    <script>
        var polygon = '';

        const map = L.map('map', {
            center: [-7.520530, 110.595023],
            zoom: 13
        });


        const latitude = window.document.querySelector("#latitude");
        const longitude = window.document.querySelector("#longitude");
        var table = window.document.querySelector(".koordinattable");

        L.tileLayer(
            "http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
                maxZoom: 20,
                subdomains: ["mt0", "mt1", "mt2", "mt3"],
            }
        ).addTo(map);

        const draw = new L.Draw.Polygon(map, new L.Control.Draw().options.polygon);

        map.on('draw:created', function(e) {
            polygon = e.layer;
            console.log(polygon);
            map.addLayer(polygon);
            var form = $('.php-email-form'); //retrieve the form as a DOM element
            var polymarker = L.polygon(e.layer._latlngs[0]).getBounds().getCenter();
            var centerlat = document.createElement('input'); 
            centerlat.setAttribute('name', "latitude"); //set the param name
            centerlat.setAttribute('value',  String(polymarker.lat).substr(0, 10)); //set the value
            centerlat.setAttribute('type', 'hidden') //set the type, like "hidden" or other
            form.append(centerlat); //append the input to the form

            var centerlong = document.createElement('input'); 
            centerlong.setAttribute('name', "longitude"); //set the param name
            centerlong.setAttribute('value',  String(polymarker.lng).substr(0, 10)); //set the value
            centerlong.setAttribute('type', 'hidden') //set the type, like "hidden" or other
            form.append(centerlong); //append the input to the form
            e.layer._latlngs[0].forEach(function callback(value, index) {
                var row = table.insertRow(table.rows.length);
                var celly = row.insertCell(0);
                var cellx = row.insertCell(1);
                
                var longitude = String(value.lng).substr(0, 10);
                var latitude = String(value.lat).substr(0, 10);
                celly.innerHTML = '<input type="hidden" name="polygon[latitude][]" onchange="checkCoordinate(this)" id="" value="'+latitude+'"> <input value="'+latitude+'" disabled>';
                cellx.innerHTML = '<input type="hidden" name="polygon[longitude][]" onchange="checkCoordinate(this)" id="" value="'+longitude+'"> <input value="'+longitude+'" disabled>';
            });
        });

        function resetButton() {
            if(polygon){
                map.removeLayer(polygon);
            }
            $('.koordinattable').find("tr:not(:first)").remove();
        }
        function addCoorButton() {
            var row = table.insertRow(table.rows.length);
            var celly = row.insertCell(0);
            var cellx = row.insertCell(1);
                
            celly.innerHTML = '<input type="text" name="polygon[latitude][]" onchange="checkCoordinate(this)" id="" value="">';
            cellx.innerHTML = '<input type="text" name="polygon[longitude][]" onchange="checkCoordinate(this)" id="" value="">';
        }

        function measurementType(e){
            if(polygon){
                map.removeLayer(polygon);
            }
            console.log()
            if (e.value == 'INPUT') {
                draw.disable();
                document.getElementById("btnCoor").style.display = "block";
                $('.koordinattable').find("tr:not(:first)").remove();
            } else if (e.value == 'POLYGON') {
                draw.enable();
                document.getElementById("btnCoor").style.display = "none";
                $('.koordinattable').find("tr:not(:first)").remove();
            }
        }
    </script>
@endpush
