@extends('admin_templates.app')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.9/leaflet.draw.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #map {
            height: 500px;
        }

        td:first-child {
            width: 20%;
        }

        td:nth-child(2) {
            width: 2%;
        }

        #dataBerkas table tbody tr td:nth-child(2) {
            width: 10%;
        }

        #dataBerkas table tbody tr td:nth-child(3) {
            width: 40%;
        }

        #dataBerkas table tbody tr td:first-child {
            width: 20%;
        }
    </style>
@endpush
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <div class="row card">
            <div class="card-header">
                <div class="d-inline" style="left:10px">
                    <div class="d-sm-flex mb-4 justify-content-between">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Detail Agenda</h1>
                        </div>
                        <div>
                            @php
                                if (Route::is('agenda-detail')) {
                                    $route = route('agenda-approve');
                                    $role = \App\Models\UserInformation::STATUS_FILING;
                                } elseif (Route::is('selesai-detail')) {
                                    $route = route('selesai-approve');
                                    $role = \App\Models\UserInformation::STATUS_CEK;
                                } elseif (Route::is('subkor-detail')) {
                                    $route = route('subkor-approve');
                                    $role = \App\Models\UserInformation::STATUS_SUBKOR;
                                } elseif (Route::is('kabid-detail')) {
                                    $route = route('kabid-approve');
                                    $role = \App\Models\UserInformation::STATUS_KABID;
                                } elseif (Route::is('kadis-detail')) {
                                    $route = route('kadis-approve');
                                    $role = \App\Models\UserInformation::STATUS_KADIS;
                                }
                            @endphp
                            @if (isset($route))
                                {!! Form::open(['url' => $route, 'method' => 'post', 'id' => 'formNextProses']) !!}
                                {!! Form::hidden('uuid', $user_information->uuid) !!}
                                <select name="to" id="" class="form-control w-50 d-inline" required>
                                    <option value="">--PILIH--</option>
                                    @foreach (\App\Models\UserInformation::user_alur($role) as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary w-30" type="button" id="nextProses">Selanjutnya</button>
                                {!! Form::close() !!}
                            @endif
                            @if (Route::is('berkas-selesai-detail'))
                                <a  href="{{ route('generate-file') }}" class="btn btn-primary w-30">Generate File</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! Form::open(['url' => route('agenda-pemohon'), 'method' => 'post', 'id' => 'agenda-lokasi']) !!}
                {!! Form::hidden('uuid', $user_information->uuid) !!}
                <table class="table">
                    <tbody>

                        <tr>
                            <td>Pemohon</td>
                            <td>:</td>
                            <td>
                                {!! Form::text('submitter', $user_information->submitter, ['class' => 'form-control']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>No KTP</td>
                            <td>:</td>
                            <td>
                                {!! Form::text('nomor_ktp', $user_information->nomor_ktp, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>Telepon Pemohon</td>
                            <td>:</td>
                            <td>
                                {!! Form::text('submitter_phone', $user_information->submitter_phone, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>Email Pemohon</td>
                            <td>:</td>
                            <td>
                                {!! Form::text('email', $user_information->user->email, ['class' => 'form-control', 'disabled']) !!}</td>
                        </tr>
                        <tr>
                            <td>Alamat Pemohon</td>
                            <td>:</td>
                            <td>
                                {!! Form::textarea('address', $user_information->address, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>Kegiatan yang dimohon</td>
                            <td>:</td>
                            <td>
                                {!! Form::select(
                                    'activity_name',
                                    [\App\Models\Activity::get()->pluck('title', 'title')],
                                    $user_information->activity_name,
                                    ['class' => 'form-control', 'id' => 'activity_name', 'style' => 'width:100%'],
                                ) !!}</td>
                        </tr>
                        <tr>
                            <td>Luas Tanah</td>
                            <td>:</td>
                            <td>
                                {!! Form::text('land_area', $user_information->land_area, ['class' => 'form-control', 'id' => 'land_area']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat Lokasi</td>
                            <td>:</td>
                            <td> {!! Form::textarea('location_address', $user_information->location_address, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>:</td>
                            <td>
                                {!! Form::select(
                                    'district_id',
                                    [\App\Models\District::get()->pluck('name', 'id')],
                                    $user_information->district_id,
                                    ['class' => 'form-control input', 'id' => 'district_id'],
                                ) !!}</td>
                        </tr>
                        <tr>
                            <td>Desa / Kelurahan</td>
                            <td>:</td>
                            <td>
                                {!! Form::select(
                                    'sub_district_id',
                                    [\App\Models\SubDistrict::get()->pluck('name', 'id')],
                                    $user_information->sub_district_id,
                                    ['class' => 'form-control input', 'id' => 'sub_district_id'],
                                ) !!}</td>
                        </tr>
                        <tr>
                            <td>Status Tanah</td>
                            <td>:</td>
                            <td>
                                {!! Form::select(
                                    'land_status_id',
                                    [\App\Models\LandStatus::get()->pluck('name', 'id')],
                                    $user_information->land_status_id,
                                    ['class' => 'form-control input', 'id' => 'land_status_id'],
                                ) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>No Sertifikat</td>
                            <td>:</td>
                            <td>
                                {!! Form::text('nomor_hak', $user_information->nomor_hak, ['class' => 'form-control', 'id' => 'nomor_hak']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Koordinat</td>
                            <td>:</td>
                            <td>
                                <table class="table table-striped w-50" border="1">
                                    <thead>
                                        <tr>
                                            <th>X (Longitude)</th>
                                            <th>Y (Latitude)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user_information->polygons as $item)
                                            <tr>
                                                <td>{{ $item->latitude }}</td>
                                                <td>{{ $item->longitude }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr class="koordinattable">
                            <td class="d-none">Koordinat Baru</td>
                            <td class="d-none">:</td>
                            <td class="d-none">
                                <table class="table table-striped tablekoordinat w-50" border="1">
                                    <thead>
                                        <tr>
                                            <th>X (Longitude)</th>
                                            <th>Y (Latitude)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                        @foreach ($user_information->polygons as $item)
                                            <tr>
                                                <td>{{ $item->latitude }}</td>
                                                <td>{{ $item->longitude }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="map-wrapper" style="width: 100%;
                position: relative;">
                    <div class="mt-3 mb-3" id="map"></div>
                    <div id="button-wrapper" class="card d-inline p-2"
                        style="position: absolute; top: 10px; right:10px; z-index:1000;margin:10px;">
                        <button type="button" class="btn btn-primary" onclick="editButton()">Edit</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelButton()">Reset</button>
                        <div class="form-check">
                            <input class="form-check-input" id="viewPolygon" type="checkbox" onclick="viewPolygon()"
                                checked>
                            <label class="form-check-label" for="flexCheckChecked">
                                Lihat Polygon
                            </label>
                        </div>
                    </div>
                </div>
                @if (Auth::guard('administrator')->user()->role == 'FILING' || Auth::guard('administrator')->user()->role == 'CEK')
                    <button class="btn btn-primary float-right" type="submit">Submit</button>
                @endif
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row card mt-3">
            <div class="card-header">
                <ul class="nav nav-tabs d-flex m-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="agenda-tab" data-bs-toggle="tab" data-bs-target="#agenda"
                            type="button" role="tab" aria-controls="agenda" aria-selected="false">Buat
                            Agenda</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="berkas-tab" data-bs-toggle="tab" data-bs-target="#berkas"
                            type="button" role="tab" aria-controls="berkas" aria-selected="false">Berkas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gambar-tab" data-bs-toggle="tab" data-bs-target="#gambar"
                            type="button" role="tab" aria-controls="gambar" aria-selected="false">Upload
                            Gambar</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="krk-tab" data-bs-toggle="tab" data-bs-target="#krk" type="button"
                            role="tab" aria-controls="krk" aria-selected="false">Keterangan
                            Rencana</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button"
                            role="tab" aria-controls="riwayat" aria-selected="false">Riwayat</button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="agenda" role="tabpanel" aria-labelledby="agenda-tab">

                    <div class="card-body">
                        <form action="{{ route('agenda-post', $user_information->id) }}" method="post">
                            @csrf
                            @php
                                $nomor = \App\Models\UserInformation::orderBy('nomor', 'desc')->first()->nomor ?? 0;
                                $default = \App\Models\Setting::whereGroup('NO_REG')
                                    ->orderBy('id')
                                    ->get()
                                    ->pluck('value');
                                
                                $nomor = str_pad($nomor, 4, '0', STR_PAD_LEFT);
                                $nomor_registration_before = $default[0] . '/' . $nomor . '/' . date('n') . '/' . date('Y');
                                if (!$user_information->nomor_registration) {
                                    $nomor = $nomor + 1;
                                } else {
                                    $nomor = $nomor;
                                }
                                $nomor = str_pad($nomor, 4, '0', STR_PAD_LEFT);
                                $nomor_registration = $default[0] . '/' . $nomor . '/' . date('n') . '/' . date('Y');
                            @endphp
                            <label for="">Nomor Registrasi Sebelumnya</label>
                            <input type="text" class="form-control" name="nomor_registration_before"
                                value="{{ $nomor_registration_before }}" disabled>
                            <br>
                            <label for="">Nomor Registrasi</label>
                            <input type="text" class="form-control" name="nomor_registration"
                                value="{{ $nomor_registration }}">
                            <input type="hidden" name="nomor" id="" value="{{ $nomor }}">
                            <br>
                            @if (Auth::guard('administrator')->user()->role == 'FILING' || Auth::guard('administrator')->user()->role == 'CEK')
                                @if (!$user_information->nomor_registration)
                                    <button type="submit" class="btn btn-success m-auto">Save</button>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="berkas" role="tabpanel" aria-labelledby="berkas-tab">
                    @if (Auth::guard('administrator')->user()->role == 'FILING' || Auth::guard('administrator')->user()->role == 'CEK')
                        <a href="#" class="btn btn-success float-right m-3" data-toggle="modal"
                            data-target="#addReferensi"
                            onclick="add({{ $user_information->id }}, {{ \App\Models\ReferenceType::whereNotIn('id',\App\Models\ApplicantReference::where('user_information_id', $user_information->id)->get()->pluck('reference_type_id'))->get()->pluck('file_type', 'id') }})">Tambah</a>
                    @endif
                    <div class="card-body" id="dataBerkas">
                        <div class="section-title">
                            <h2>Data Berkas</h2>
                        </div>
                        <div class="col-lg-12 col-md-6 portfolio-item filter-web">
                            <table class="table table-striped">
                                <tr>
                                    <th>Jenis Berkas</th>
                                    <th>Penjelasan</th>
                                    <th>Aksi</th>
                                    <th>Keterangan</th>
                                </tr>
                                @foreach ($user_information->applicant_reference as $item)
                                    <tr>
                                        <td>{{ @$item->reference_type->file_type ?? '' }}</td>
                                        <td style="width: 40%">{!! @$item->reference_type->content ?? '' !!}</td>
                                        <td>
                                            <a href="{{ url('storage/' . $item->file) }}" class="btn btn-primary"
                                                target="_blank">Lihat</a>
                                            @if (Auth::guard('administrator')->user()->role == 'FILING' || Auth::guard('administrator')->user()->role == 'CEK')
                                                <a href="#" class="btn btn-info" data-toggle="modal"
                                                    data-target="#updateReferensi"
                                                    onclick="edit({{ $item->id }})">Edit</a>
                                            @endif
                                        </td>
                                        <td>{!! @$item->reference_type->note ?? '' !!}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="gambar" role="tabpanel" aria-labelledby="gambar-tab">
                    <div class="card-body">
                        <div>
                            <form action="{{ route('upload-file-sketch') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $user_information->id }}" name="user_information_id">
                                <input type="file" name="file" class="form-control" accept=".png, .jpg, .jpeg">
                                <br>
                                @if (@$user_information->sketch_file->file)
                                    <img src="{{ asset('storage/' . $user_information->sketch_file->file) }}"
                                        alt="" class="img-fluid rounded mx-auto d-block" width="500px">
                                @endif
                                <div class="float-right m-3 ">
                                    @if (Auth::guard('administrator')->user()->role == 'FILING' || Auth::guard('administrator')->user()->role == 'CEK')
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="krk" role="tabpanel" aria-labelledby="krk-tab">
                    <form action="{{ route('sketch-post') }}" method="post">
                        <input type="hidden" name="uuid" id="" value="{{ $user_information->uuid }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Fungsi Bangunan</label>
                                    <select name="building_function" id="" class="form-control" id="select2"
                                        required>
                                        <option value="">PILIH</option>
                                        @foreach (\App\Models\BuildingFunction::get() as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == @$user_information->krk->building_function ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="">Zona / SubZona</label>
                                    <select name="zona" id="" class="form-control" id="select2" required>
                                        <option value="">PILIH</option>
                                        @foreach (\App\Models\Zona::get() as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == @$user_information->krk->zona ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <center><label for="">KBG</label></center>
                                    <textarea name="kbg" id="" class="form-control">{{ @$user_information->krk->kbg }}</textarea>
                                    <center><label for="">KDB</label></center>
                                    <textarea name="kdb" id="" class="form-control">{{ @$user_information->krk->kdb }}</textarea>
                                    <center><label for="">KLB</label></center>
                                    <textarea name="klb" id="" class="form-control">{{ @$user_information->krk->klb }}</textarea>
                                    <center><label for="">KDH</label></center>
                                    <textarea name="kdh" id="" class="form-control">{{ @$user_information->krk->kdh }}</textarea>
                                    <center><label for="">PSU</label></center>
                                    <textarea name="psu" id="" class="form-control">{{ @$user_information->krk->psu }}</textarea>
                                    <center><label for="">KTB</label></center>
                                    <textarea name="ktb" id="" class="form-control">{{ @$user_information->krk->ktb }}</textarea>
                                </div>
                                <div class="col-3">
                                    <center><label for="">JAP</label></center>
                                    <textarea name="jap" id="" class="form-control">{{ @$user_information->gsb->jap }}</textarea>
                                    <center><label for="">JKP</label></center>
                                    <textarea name="jkp" id="" class="form-control">{{ @$user_information->gsb->jkp }}</textarea>
                                    <center><label for="">JKS</label></center>
                                    <textarea name="jks" id="" class="form-control">{{ @$user_information->gsb->jks }}</textarea>
                                    <center><label for="">JLP</label></center>
                                    <textarea name="jlp" id="" class="form-control">{{ @$user_information->gsb->jlp }}</textarea>
                                    <center><label for="">JLS</label></center>
                                    <textarea name="jls" id="" class="form-control">{{ @$user_information->gsb->jls }}</textarea>
                                    <center><label for="">Jling</label></center>
                                    <textarea name="jling" id="" class="form-control">{{ @$user_information->gsb->jling }}</textarea>
                                </div>
                                <div class="col-6">
                                    <label for="">Jaringan Utilitas (Bebas Bangunan)</label>
                                    <textarea name="jaringan_utilitas" id="" class="form-control">{{ @$user_information->krk->jaringan_utilitas }}</textarea>
                                    <label for="">Prasarana Jalan</label>
                                    <textarea name="prasarana_jalan" id="" class="form-control">{{ @$user_information->krk->prasarana_jalan }}</textarea>
                                    <label for="">Sungai Bertanggul</label>
                                    <input type="text" name="sungai_bertanggul" id="" class="form-control"
                                        value="{{ @$user_information->krk->sungai_bertanggul }}">
                                    <label for="">Sungai Tidak Bertanggul</label>
                                    <input type="text" name="sungai_tidak_bertanggul" id=""
                                        class="form-control"
                                        value="{{ @$user_information->krk->sungai_tidak_bertanggul }}">
                                    <label for="">Mata Air</label>
                                    <input type="text" name="mata_air" id="" class="form-control"
                                        value="{{ @$user_information->krk->mata_air }}">
                                    <label for="">Waduk (titik pasang tertinggi)</label>
                                    <input type="text" name="waduk" id="" class="form-control"
                                        value="{{ @$user_information->krk->waduk }}">
                                    <label for="">Tol (dari pagar)</label>
                                    <input type="text" name="tol" id="" class="form-control"
                                        value="{{ @$user_information->krk->tol }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer float-right">
                            @if (Auth::guard('administrator')->user()->role == 'FILING' || Auth::guard('administrator')->user()->role == 'CEK')
                                <button class="btn btn-primary" type="submit">Submit</button>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                    <div class="card-body" id="dataBerkas">
                        <div class="section-title">
                            <h2>Riwayat</h2>
                        </div>
                        <div class="col-lg-12 col-md-6 portfolio-item filter-web">
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Petugas</th>
                                    <th>Keterangan</th>
                                    <th>Petugas Selanjutnya</th>
                                </tr>
                                @foreach ($user_information->riwayat as $item)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td style="width: 10%">{{ $item->dari->name }}</td>
                                        <td style="width: 60%">{{ $item->note }}</td>
                                        <td style="width: 10%">{{ $item->keterangan_status }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
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
        $('#activity_name').select2({
            tags: true,
            width: 'resolve',
        });
    </script>
    <script>
        $('#nextProses').click(function(e) {
            e.preventDefault();
            swal({
                    title: "Kirimkan ?",
                    text: "Data Akan di Kirim ke proses selanjutnya",
                    icon: "warning",
                    buttons: true,
                    content: "input",
                })
                .then((willDelete) => {
                    if (!willDelete) {
                        swal("Cancel");
                    }
                    if (willDelete != '') {
                        if (willDelete == null) {
                            swal("Cancel");
                        } else {
                            swal("Berhasil!", {
                                icon: "success",
                            });
                            var formNextProses = $('#formNextProses');
                            var noteInput = document.createElement('input');
                            noteInput.setAttribute('name', "note");
                            noteInput.setAttribute('value', willDelete);
                            noteInput.setAttribute('type', 'hidden');
                            formNextProses.append(noteInput);
                            formNextProses.submit();
                        }
                    } else {
                        swal("Catatan Kosong");
                    }
                }).catch(err => {
                    if (err) {
                        console.log(err);
                        swal("Oh noes!", "The AJAX request failed!", "error");
                    } else {
                        swal.stopLoading();
                        swal.close();
                    }
                });
        });
    </script>

    <script>
        $('#select2').select2();
    </script>
    <script>
        $('#land_area').each(function(index) {
            n = parseInt($(this).val().toString().replace(/\D/g, ''), 10) || "";
            $(this).val(n.toLocaleString());
        });

        $("#land_area").on('keyup change', function() {
            val = $(this).val() || 0;
            var n = parseInt(val.replace(/\D/g, ''), 10);
            $(this).val(n.toLocaleString());
        });

        $("#land_status_id").change(function() {
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
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.9/leaflet.draw.js"></script>
    <script>
        var new_polygon = '';

        var array_polygons = {!! $user_information->polygons->pluck('longitude', 'latitude') !!};
        const entries = Object.entries(array_polygons);
        if (entries.length <= 0) {
            entries[0] = [-7.520530, 110.595023];
        }
        const map = L.map('map', {
            center: entries[0],
            zoom: 15
        });

        if (entries.length > 0) {
            var polyLayers = L.polygon(entries).setStyle({
                color: '#1CC88A'
            }).addTo(map);
        }

        const latitude = window.document.querySelector("#latitude");
        const longitude = window.document.querySelector("#longitude");
        var table = window.document.querySelector(".tablekoordinat");
        var DrawPolygon = new L.Draw.Polygon(map, new L.Control.Draw().options.polygon);

        L.tileLayer(
            "http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
                maxZoom: 20,
                subdomains: ["mt0", "mt1", "mt2", "mt3"],
            }
        ).addTo(map);

        // new L.Draw.Polygon(map, new L.Control.Draw().options.polygon).enable();

        map.on('draw:created', function(e) {
            new_polygon = L.polygon(e.layer._latlngs).addTo(map);
            $('td').removeClass('d-none');
            e.layer._latlngs[0].forEach(function callback(value, index) {
                $(".koordinattable .table-body").remove();
                var row = table.insertRow(table.rows.length);
                var celly = row.insertCell(0);
                var cellx = row.insertCell(1);
                var form = $('#agenda-lokasi');
                var inputlng = document.createElement('input');
                inputlng.setAttribute('name', "polygon[longitude][]");
                inputlng.setAttribute('value', value.lng);
                inputlng.setAttribute('id', "polygon_longitude");
                inputlng.setAttribute('type', 'hidden');
                var inputlat = document.createElement('input');
                inputlat.setAttribute('name', "polygon[latitude][]");
                inputlat.setAttribute('value', value.lat);
                inputlat.setAttribute('id', "polygon_latitude");
                inputlat.setAttribute('type', 'hidden')
                celly.innerHTML = value.lng;
                cellx.innerHTML = value.lat;

                form.append(inputlng);
                form.append(inputlat);
            });
        });


        $(document).ready(function() {
            $('#viewPolygon').click(function(e) {
                if ($(this).is(":checked")) {
                    map.addLayer(polyLayers);
                } else {
                    map.removeLayer(polyLayers);
                }
            });
        });

        function cancelButton() {
            if (new_polygon) {
                map.removeLayer(new_polygon);
                $('input[name="polygon[longitude][]"]').remove()
                $('input[name="polygon[latitude][]"]').remove()
            }
            $('.koordinattable').addClass('d-none');
            $('.koordinattable').find("tr:not(:first)").remove();
            DrawPolygon.disable();
        }

        function editButton() {
            if (new_polygon) {
                map.removeLayer(new_polygon);
                $('input[name="polygon[longitude][]"]').remove()
                $('input[name="polygon[latitude][]"]').remove()
            }
            $('.koordinattable').removeClass('d-none');
            $('.koordinattable').find("tr:not(:first)").remove();
            DrawPolygon.enable();
        }
    </script>
@endpush
