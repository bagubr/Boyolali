@extends('layouts')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #map {
            height: 300px;
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
        .form-control.invalid { background-color: #ffdddd; }

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
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact mt-5">
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center">

                <div class="col-lg-12 mt-5 mt-lg-0">
                    @include('users.alert')
                    <form action="{{ route('user_information') }}" method="post" role="form" class="php-email-form">
                        @csrf
                        <div class="tab">
                            <div class="section-title">
                                <h2>Data Lokasi</h2>
                            </div>
                            <div class="form-group">
                                <label for="name">Alamat Lokasi</label>
                                <textarea type="text" class="form-control input" name="location_address" id="" required></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="activity">Kecamatan</label>
                                <select name="district_id" id="district_id" class="form-control input select2">
                                    <option value="">PILIH</option>
                                    @foreach (\App\Models\District::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="activity">Kelurahan</label>
                                <select name="sub_district_id" id="sub_district_id" class="form-control input select2">
                                    <option value="">PILIH</option>
                                    @foreach (\App\Models\SubDistrict::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Luas Tanah</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control input" name="land_area" id="land_area" required>
                                        <div class="input-group-text">
                                            <span>m <sup>2</sup></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" id="map"></div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control input" id="latitude" aria-describedby="latitude"
                                        name="latitude" required value="{{ old('latitude') }}" readonly="readonly">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control input" id="longitude" aria-describedby="longitude"
                                        name="longitude" required value="{{ old('longitude') }}" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="activity">Status Tanah</label>
                                <select name="land_status_id" id="status_tanah" class="form-control input select2">
                                    <option value="">PILIH</option>
                                    @foreach (\App\Models\LandStatus::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name">Nomor Setifikat </label>
                                <input type="text" class="form-control input" name="nomor_hak" id="nomor_hak" required>
                            </div>
                        </div>
                        
                        <div class="tab">
                            <div class="section-title">
                                <h2>Data Pemohon</h2>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="submitter">Nama Pemohon</label>
                                <input type="text" class="form-control input" name="submitter" id="submitter" required>
                            </div>
                            <div class="form-group">
                                <label for="nomor_ktp">NO KTP</label>
                                <input type="text" class="form-control input" name="nomor_ktp" id="" required
                                    minlength="16" maxlength="16">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="submitter_phone">Telepon Pemohon</label>
                                <input type="text" class="form-control input" name="submitter_phone" id="submitter_phone"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat Pemohon</label>
                                <textarea type="text" class="form-control input" name="address" id="" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Pemohon</label>
                                <input type="text" class="form-control input" name="email" id=""
                                    value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="activity">Kegiatan yang dimohon</label>
                                <input type="text" list="activity" name="activity_name" class="form-control input" />
                                <datalist id="activity">
                                    @foreach (\App\Models\Activity::get() as $item)
                                        <option value="{{ $item->title }}">{{ $item->title }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        
                        <div class="tab">
                            <div class="section-title">
                                <h2>Data Kuasa (Optional)</h2>
                            </div>
                            <div class="form-group">
                                <label for="name_procuration">Nama Kuasa</label>
                                <input type="text" class="form-control" name="name_procuration" id="">
                            </div>
                            <div class="form-group">
                                <label for="phone_procuration">Telepon Kuasa</label>
                                <input type="text" class="form-control" name="phone_procuration" id="">
                            </div>
                            <div class="form-group">
                                <label for="address_procuration">Alamat Kuasa</label>
                                <textarea type="text" class="form-control" name="address_procuration" id=""></textarea>
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
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                // console.log(document.getElementById("regForm"))
                // document.getElementById("regForm").submit();
                document.getElementById("prevBtn").style.display = "none";
                document.getElementById("nextBtn").style.display = "none";
                document.getElementById("nextBtn").type = "submit";
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByClassName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script>
        $('#district_id').on('input', function(e) {
            $("#sub_district_id").removeAttr('disabled');
            $("#sub_district_id").html('<option value="">--PILIH--</option>');
        });
        $('#district_id').select2({
            ajax: {
                url: "{{ url('users/district?') }}",
                type: 'GET',
                dataType: 'json',
                delay: 300,
                data: function(params) {
                    var queryParameters = {
                        name: params.term,
                    }
                    return queryParameters;
                },
                processResults: function(params) {
                    return {
                        results: $.map(params.data.districts, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('#sub_district_id').select2({
            ajax: {
                url: "{{ url('users/sub-district?') }}",
                dataType: 'json',
                type: 'GET',
                delay: 300,
                data: function(params) {
                    var queryParameters = {
                        name: params.term,
                        district_id: $("#district_id").val(),
                    }
                    return queryParameters;
                },
                processResults: function(params) {
                    return {
                        results: $.map(params.data.sub_districts, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $(document).ready(function() {

            if (!$("#district_id").val()) {
                $("#sub_district_id").prop('disabled', true);
            }
            $(document).on('change', '#district_id', function(e) {
                if (!$("#district_id").val()) {
                    $("#sub_district_id").prop('disabled', true);
                } else {
                    $("#sub_district_id").prop('disabled', false);
                }
                $("#sub_district_id").val('').trigger('change');
            });
        });
    </script>
    <script>
        // var map = L.map('map').setView([51.505, -0.09], 13);
        const map = L.map('map', {
            center: [-7.520530,110.595023],
            zoom: 13
        });

        // const currentLoc = L.marker([-7.520530,110.595023]);
        // currentLoc.addTo(map);

        const latitude = window.document.querySelector("#latitude");
        const longitude = window.document.querySelector("#longitude");

        L.tileLayer(
            "http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
                maxZoom: 20,
                subdomains: ["mt0", "mt1", "mt2", "mt3"],
            }
        ).addTo(map);

        const currentLoc = L.marker();
        map.on('click', e => {
            currentLoc.setLatLng([e.latlng.lat, e.latlng.lng]);
            currentLoc.addTo(map);
            latitude.value = e.latlng.lat;
            longitude.value = e.latlng.lng;
        });
    </script>
    <script>
        $("#status_tanah").change(function() {
            var val = $(this).val();
            console.log(val);
            if (val == 1) {
                $('#nomor_hak').val('HM.');
            } else if (val == 2) {
                $('#nomor_hak').val('HGB.');
            } else if (val == 3) {
                $('#nomor_hak').val('HGU.');
            } else if (val == 4) {
                $('#nomor_hak').val('HP.');
            } else if (val == 5) {
                $('#nomor_hak').val('HPL.');
            } else if (val == 6) {
                $('#nomor_hak').val('HSRS.');
            } else if (val == 8) {
                $('#nomor_hak').val('TN.');
            } else {
                $('#nomor_hak').val('No.');
            }
        });
    </script>
@endpush
