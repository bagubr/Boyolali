@extends('admin_templates.app')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.9/leaflet.draw.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easyprint@2.1.9/libs/leaflet.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />

    <style>
        select {
            font-family: fontAwesome
        }

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
        .select2 {
            width:100%!important;
        }
        .card-body{
            width:100%;
            height:auto;
        }
    </style>
@endpush
@section('content')
    @php
        function cekstatus()
        {
            if (Auth::guard('administrator')->user()->role == 'FILING' || Auth::guard('administrator')->user()->role == 'CEK' || Auth::guard('administrator')->user()->role == 'ADMIN') {
                if (Route::is('pencarian-detail', 'rekap-detail')) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }
    @endphp
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
                                } elseif (Route::is('berkas-selesai-detail')) {
                                    $route = route('berkas-selesai');
                                    $role = \App\Models\UserInformation::STATUS_CETAK;
                                }
                            @endphp
                            @if (isset($route))
                                {!! Form::open(['url' => $route, 'method' => 'post', 'id' => 'formNextProses']) !!}
                                {!! Form::hidden('uuid', $user_information->uuid) !!}
                                <select name="to" id="formNextProsesto" class="form-control w-50 d-inline" required>
                                    <option value="">--PILIH--</option>
                                    @foreach (\App\Models\UserInformation::user_alur($role) as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary w-30" type="button" id="nextProses">Selanjutnya</button>
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (Route::is('subkor-cek-detail') ||
                        Route::is('subkor-detail') ||
                        Route::is('kabid-cek-detail') ||
                        Route::is('kabid-detail') ||
                        Route::is('kadis-cek-detail') ||
                        Route::is('kadis-detail') ||
                        Route::is('berkas-selesai-detail') ||
                        Route::is('selesai-detail'))
                    <a href="{{ route('view-file', ['id' => $user_information->uuid]) }}"
                        class="btn btn-primary w-30 float-right mr-2 mb-2 ml-2" target="_blank">View</a>
                @endif
                @if (@$user_information->nomor_krk)
                    <a href="#" class="btn btn-success w-30 float-right mb-2" data-toggle="modal"
                        data-target="#exampleModal">Generate File</a>
                    @if (file_exists(public_path('storage/krks/' . $user_information->uuid . '.pdf')))
                        @php
                            $namefile = str_replace('/', '_', $user_information->nomor_registration);
                            header('Content-Disposition: inline; filename="' . $namefile . '.pdf"');
                        @endphp
                        <a href="{{ asset('storage/krks/' . $user_information->uuid . '.pdf') }}"
                            class="btn btn-primary w-30 float-right mr-2"
                            download="{{ str_replace('/', '_', $user_information->nomor_registration) }}">Download</a>
                        <form action="{{ route('generate-file', ['id' => $user_information->uuid]) }}" method="post">
                            @csrf
                            <button type="submit" name="kirim_email" value="true"
                                class="btn btn-success w-30 float-right mr-2">Kirim Email</button>
                        </form>
                    @endif
                @endif
                {!! Form::open(['url' => route('agenda-pemohon'), 'method' => 'post', 'id' => 'agenda-lokasi']) !!}
                {!! Form::hidden('uuid', $user_information->uuid) !!}
                <table class="table">
                    <tbody>

                        <tr>
                            <td>Nama Pemohon</td>
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
                            {{-- <td>{!! Form::text('activity_name', $user_information->activity_name, ['class' => 'form-control', 'disabled']) !!}</td> --}}
                            <td>
                                @php
                                    $data = array_merge(
                                        \App\Models\Activity::where('title', '!=', $user_information->activity_name)
                                            ->get()
                                            ->pluck('title', 'title')
                                            ->toArray(),
                                        [$user_information->activity_name => $user_information->activity_name],
                                    );
                                @endphp
                                {!! Form::select('activity_name', $data, $user_information->activity_name, [
                                    'class' => 'form-control',
                                    'id' => 'activity_name',
                                    'style' => 'width:100%',
                                    'label' => 'oke',
                                ]) !!}</td>
                        </tr>
                        <tr>
                            <td>Luas Tanah</td>
                            <td>:</td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        {{-- <input type="text" class="form-control input" name="land_area"
                                            data-mask='#,##0.00' required> --}}
                                        {!! Form::text('land_area', $user_information->land_area, [
                                            'class' => 'form-control',
                                            'id' => 'land_area',
                                            'data-mask' => '#,##0.00',
                                            'required',
                                        ]) !!}
                                        <div class="input-group-text">
                                            <span>m <sup>2</sup></span>
                                        </div>
                                    </div>
                                </div>
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
                    </tbody>
                </table>
                <div class="row">
                    <div id="map-wrapper" style="width: 60%;
                    position: relative;">
                        <div class="mt-3 mb-3" id="map"></div>
                        <div id="button-wrapper" class="card d-inline p-2"
                            style="position: absolute; top: 10px; right:10px; z-index:1000;margin:10px;">
                            {{-- <button type="button" class="btn btn-primary" onclick="editButton()">Edit</button> --}}
                            {{-- <button type="button" class="badge bg-secondary text-white" onclick="cancelButton()">Reset</button> --}}
                            <div class="form-check">
                                <input class="form-check-input" id="viewPolygon" type="checkbox" onclick="viewPolygon()"
                                    checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Bidang
                                </label>
                            </div>
                        </div>
                    </div>
                    <table style="width: 40%;float:right;vertical-align: top;">
                        <tr style="vertical-align:top; text-align:center">
                            <td>Koordinat</td>
                        </tr>   
                        <tr style="vertical-align: top;">
                            <td style=" padding:10px;">
                                <center>
                                    <table class="table table-striped w-50" border="1">
                                        <thead>
                                            <tr>
                                                <th>Y (Latitude)</th>
                                                <th>X (Longitude)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user_information->polygons as $item)
                                                <tr>
                                                    <td>
                                                        <input type="text" id="" value="{{ $item->latitude }}" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="" value="{{ $item->longitude }}" disabled>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </center>
                            </td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td style=" padding:10px;">
                                Metode Pengukuran
                                <select name="measurement_type" id="measurement_type" onchange="measurementType(this)"
                                    class="form-control input" required>
                                    <option value="">PILIH</option>
                                    <option value="POLYGON"
                                        {{ $user_information->measurement_type == 'POLYGON' ? 'selected' : '' }}>GAMBAR BIDANG
                                    </option>
                                    <option value="INPUT"
                                        {{ $user_information->measurement_type == 'INPUT' ? 'selected' : '' }}>INPUT KOORDINAT
                                    </option>
                                </select>
                                <br>
                                <button type="button" class="btn btn-secondary" onclick="cancelButton()">Reset</button>
                                <button type="button" class="btn btn-success" style="float: right;display:none;"
                                    id="btnCoor" onclick="addCoorButton()">Tambah Koordinat</button>
                            </td>
                        </tr>
                        <tr style="vertical-align:top; text-align:center">
                            <td class="d-none">Koordinat Baru</td>
                        </tr>
                        <tr class="koordinattable" style="vertical-align:top; text-align:center">
                            <td align="center" style=" padding:10px;">
                                <table class="table table-striped tablekoordinat w-50" border="1">
                                    <thead>
                                        <tr>
                                            <th>Y (Latitude)</th>
                                            <th>X (Longitude)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">

                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                @if (cekstatus())
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
                        <button class="nav-link" id="krk-tab" data-bs-toggle="tab" data-bs-target="#krk"
                            type="button" role="tab" aria-controls="krk" aria-selected="false">Keterangan
                            Rencana</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat"
                            type="button" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat</button>
                    </li>
                    @if (Route::is('berkas-selesai-detail', 'rekap-detail', 'pencarian-detail'))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nomorsk-tab" data-bs-toggle="tab" data-bs-target="#nomorsk"
                                type="button" role="tab" aria-controls="nomorsk" aria-selected="false">Nomor
                                SK</button>
                        </li>
                    @endif
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
                                $nomor_registration_before = $default[0] . '/' . str_pad($nomor, 4, '0', STR_PAD_LEFT) . '/' . date('n') . '/' . date('Y');
                                if (!$user_information->nomor_registration) {
                                    $nomor = $nomor + 1;
                                } else {
                                    $nomor = $nomor;
                                }
                                $nomor_registration = $default[0] . '/' . str_pad($nomor, 4, '0', STR_PAD_LEFT) . '/' . date('n') . '/' . date('Y');
                            @endphp
                            <label for="">Nomor Registrasi Sebelumnya</label>
                            <input type="text" class="form-control" name="nomor_registration_before"
                                value="{{ $nomor_registration_before }}" disabled>
                            <br>
                            <label for="">Nomor Registrasi</label>
                            @if (!$user_information->nomor_registration)
                                <input type="text" class="form-control" name="nomor_registration"
                                    value="{{ $nomor_registration }}">
                                <input type="hidden" name="nomor" id="" value="{{ $nomor }}">
                            @else
                                <input type="text" class="form-control" name="nomor_registration"
                                    value="{{ $user_information->nomor_registration }}" readonly>
                                <input type="hidden" name="nomor" id="" value="{{ $nomor }}">
                            @endif
                            <br>
                            @if (cekstatus())
                                @if (!$user_information->nomor_registration)
                                    <button type="submit" class="btn btn-success m-auto">Save</button>
                                @else
                                    <button type="submit" name="kirim_email" value="true"
                                        class="btn btn-success m-auto">Kirim Email</button>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="berkas" role="tabpanel" aria-labelledby="berkas-tab">
                    @if (cekstatus())
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
                                            @if (cekstatus())
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
                                    @if (cekstatus())
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
                                    <label for="">Pola Ruang / SubZona</label>
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
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <span>Maks.</span>
                                        </div>
                                        <input name="kbg" id="" class="form-control"
                                            value="{{ @$user_information->krk->kbg }}">
                                        <div class="input-group-text">
                                            <span>Lantai</span>
                                        </div>
                                    </div>
                                    <center><label for="">KDB</label></center>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <span>Maks.</span>
                                        </div>
                                        <input name="kdb" id="" class="form-control"
                                            value="{{ @$user_information->krk->kdb }}">
                                        <div class="input-group-text">
                                            <span>%</span>
                                        </div>
                                    </div>
                                    <center><label for="">KLB</label></center>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <span>Maks.</span>
                                        </div>
                                        <input name="klb" id="" class="form-control"
                                            value="{{ @$user_information->krk->klb }}">
                                    </div>
                                    @if (@$user_information->activity_name === \App\Models\Activity::find(4)->title)
                                        <center><label for="">PSU</label></center>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <span>Min.</span>
                                            </div>
                                            <input name="psu" id="" class="form-control"
                                                value="{{ @$user_information->krk->psu }}">
                                        </div>
                                    @else
                                        <center><label for="">KDH</label></center>
                                        <div class="input-group">
                                            <input name="kdh" id="" class="form-control"
                                                value="{{ @$user_information->krk->kdh }}">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if (@$user_information->activity_name != \App\Models\Activity::find(4)->title)
                                        <center><label for="">KTB</label></center>
                                        <div class="input-group">
                                            <input name="ktb" id="" class="form-control"
                                                value="{{ @$user_information->krk->ktb }}">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-3">
                                    <center><label for="">JAP</label></center>
                                    <div class="input-group">
                                        <input name="jap" id="" class="form-control"
                                            value="{{ @$user_information->gsb->jap }}">
                                        <div class="input-group-text">
                                            <span>meter</span>
                                        </div>
                                    </div>
                                    <center><label for="">JKP</label></center>
                                    <div class="input-group">
                                        <input name="jkp" id="" class="form-control"
                                            value="{{ @$user_information->gsb->jkp }}">
                                        <div class="input-group-text">
                                            <span>meter</span>
                                        </div>
                                    </div>
                                    <center><label for="">JKS</label></center>
                                    <div class="input-group">
                                        <input name="jks" id="" class="form-control"
                                            value="{{ @$user_information->gsb->jks }}">
                                        <div class="input-group-text">
                                            <span>meter</span>
                                        </div>
                                    </div>
                                    <center><label for="">JLP</label></center>
                                    <div class="input-group">
                                        <input name="jlp" id="" class="form-control"
                                            value="{{ @$user_information->gsb->jlp }}">
                                        <div class="input-group-text">
                                            <span>meter</span>
                                        </div>
                                    </div>
                                    <center><label for="">JLS</label></center>
                                    <div class="input-group">
                                        <input name="jls" id="" class="form-control"
                                            value="{{ @$user_information->gsb->jls }}">
                                        <div class="input-group-text">
                                            <span>meter</span>
                                        </div>
                                    </div>
                                    <center><label for="">Jling</label></center>
                                    <div class="input-group">
                                        <input name="jling" id="" class="form-control"
                                            value="{{ @$user_information->gsb->jling }}">
                                        <div class="input-group-text">
                                            <span>meter</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <center><label for="">Sungai Bertanggul</label></center>
                                    <div class="input-group">
                                        <input type="text" name="sungai_bertanggul" id=""
                                            class="form-control"
                                            value="{{ @$user_information->krk->sungai_bertanggul }}">
                                        <div class="input-group-text">
                                            <span>meter</span>
                                        </div>
                                    </div>
                                    <center><label for="">Sungai Tidak Bertanggul</label></center>
                                    <div class="input-group">
                                        <input type="text" name="sungai_tidak_bertanggul" id=""
                                            class="form-control"
                                            value="{{ @$user_information->krk->sungai_tidak_bertanggul }}">
                                        <div class="input-group-text">
                                            <span>meter</span>
                                        </div>
                                    </div>
                                    <center><label for="">Mata Air</label></center>
                                    <input type="text" name="mata_air" id="" class="form-control"
                                        value="{{ @$user_information->krk->mata_air }}">
                                    <center><label for="">Waduk (titik pasang tertinggi)</label></center>
                                    <input type="text" name="waduk" id="" class="form-control"
                                        value="{{ @$user_information->krk->waduk }}">
                                    <center><label for="">Tol (dari pagar)</label></center>
                                    <input type="text" name="tol" id="" class="form-control"
                                        value="{{ @$user_information->krk->tol }}">
                                </div>
                                <div class="col-3">
                                    <center><label for="">SRP</label></center>
                                    <input type="text" name="srp" id="" class="form-control"
                                        value="{{ @$user_information->krk->srp }}">
                                    <center><label for="">KKOP</label></center>
                                    <input type="text" name="kkop" id="" class="form-control"
                                        value="{{ @$user_information->krk->kkop }}">
                                    <center><label for="">Tambahan</label></center>
                                    @if (@$user_information->krk->tambahan)
                                        <textarea name="tambahan" style="height:250px" id="" class="form-control">{{ @$user_information->krk->tambahan }}</textarea>
                                    @else
                                        @if (@$user_information->activity_name === \App\Models\Activity::find(4)->title)
                                            <textarea name="tambahan" style="height:250px" id="" class="form-control">1. KDH berbasis luasan kavling sesuai ketentuan yang berlaku.
2. GSB terhadap Jalan Lingkungan Perumahan 1/2 RUMIJA + 1.
3. Luas kavling untuk hunian minimal 60 m2.</textarea>
                                        @else
                                            <textarea name="tambahan" style="height:250px" id="" class="form-control">Harus ditanami sekurang-kurangnya 1 (satu) pohon pelindung dan ditanami tanaman berupa perdu, semak hias, serta penutup tanah/rumput dengan jumlah yang cukup.</textarea>
                                        @endif
                                    @endif
                                </div>
                                <br>
                                <div class="col-12">
                                    <label for="">Jaringan Utilitas (Bebas Bangunan)</label>
                                    @if (@$user_information->krk->jaringan_utilitas)
                                        <textarea name="jaringan_utilitas" id="" class="form-control" style="height: 150px;">{{ @$user_information->krk->jaringan_utilitas }}</textarea>
                                    @else
                                        <textarea name="jaringan_utilitas" id="" class="form-control" style="height: 150px;">a. Sesuai dengan Lampiran II pada Permen ESDM No. 13 Tahun 2021 (Jarak Bebas Minimum Vertikal dari Konduktor pada Jaringan Transmisi Tenaga Listrik).
b. Sesuai dengan Lampiran II pada Permen ESDM No. 13 Tahun 2021 (Jarak Bebes Minimum Horizontal dari Sumbu Vertikal Menara/Tiang pada Jaringan Transmisi Tenaga Listrik).</textarea>
                                    @endif
                                    @if (@$user_information->activity_name === \App\Models\Activity::find(4)->title)
                                        <label for="">Prasarana Jalan</label>
                                        @if (@$user_information->krk->prasarana_jalan)
                                            <textarea name="prasarana_jalan" id="" class="form-control" style="height: 150px;">{{ @$user_information->krk->prasarana_jalan }}</textarea>
                                        @else
                                            <textarea name="prasarana_jalan" id="" class="form-control" style="height: 150px;">Sesuai dengan Lampiran pada Peraturan Pemerintah No. 12 Tahun 2021 Tentang Penyelenggaraan Perumahan dan Kawasan Permukiman. Jika total luas lahan yang diperuntukkan bagi pembangunan Prasarana Jalan kurang dari 20% (dua puluh persen) dari luas total seluruh area Permukiman, maka dimensi harus disesuaikan agar syarat 20% (dua puluh persen) luas lahan untuk Prasarana Jalan terpenuhi, dengan memperhatikan fungsi jalan dan volume lalu lintas yang akan ditampung oleh jalan.</textarea>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer float-right">
                            @if (cekstatus())
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
                <div class="tab-pane fade" id="nomorsk" role="tabpanel" aria-labelledby="nomorsk-tab">

                    <div class="card-body">
                        @php
                            $nomor = @\App\Models\UserInformation::orderBy('nomor_krk', 'desc')->first()?->nomor_krk ?? 0;
                            $nomor = @explode('/', $nomor)[1] ?? 0;
                            $sebelumnya = @implode('/', ['650', str_pad($nomor, 4, '0', STR_PAD_LEFT), '4.3', date('Y')]);
                            $nomor_krk = @implode('/', ['650', str_pad($nomor + 1, 4, '0', STR_PAD_LEFT), '4.3', date('Y')]);
                        @endphp
                        <form action="{{ route('nomorsk-post', $user_information->id) }}" method="post">
                            @csrf
                            <label for="">Nomor KRK Sebelumnya</label>
                            <input type="text" class="form-control" name="nomor_krk_sebelumnya"
                                value="{{ $sebelumnya }}" readonly>
                            @if (!$user_information->nomor_krk)
                                <label for="">Nomor KRK</label>
                                <input type="text" class="form-control" name="nomor_krk"
                                    value="{{ $nomor_krk }}">
                            @else
                                <label for="">Nomor KRK</label>
                                <input type="text" class="form-control" name="nomor_krk"
                                    value="{{ $user_information->nomor_krk }}">
                            @endif
                            <br>
                            @if (cekstatus())
                                <button type="submit" class="btn btn-success m-auto">Save</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dasar Hukum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('generate-file', ['id' => $user_information->uuid]) }}" method="post">
                        @csrf
                        @foreach (\App\Models\DasarHukum::get() as $item)
                            <input type="text" name="dasar_hukum[]" id="" value="{{ $item->content }}"
                                class="form-control mb-2">
                        @endforeach
                        <div class="form-group input-create">
                            <input type="text" name="dasar_hukum[]" id="" class="form-control mb-2">
                        </div>
                        <button type="button" class="btn btn-success" id="create">Add</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Generate</button>
                    </form>
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
        const nomor_registration = {!! $user_information !!};
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
                            if ($('#formNextProsesto').val() != `{!! \App\Models\UserInformation::STATUS_TOLAK !!}` && nomor_registration
                                .nomor_registration === null) {
                                swal("Nomor Agenda blm di buat!");
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
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easyprint@2.1.9/dist/bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet-simple-map-screenshoter"></script>
    <script>
        var new_polygon = '';

        var array_polygons = {!! $user_information->polygons->pluck('longitude', 'latitude') !!};
        const entries = Object.entries(array_polygons);
        if (entries.length <= 0) {
            entries[0] = [-7.520530, 110.595023];
        }
        var getCentroid = function(arr) {
            return arr.reduce(function(x, y) {
                return [x[0] + y[0] / arr.length, x[1] + y[1] / arr.length]
            }, [0, 0])
        }
        const map = L.map('map', {
            center: getCentroid(entries),
            zoom: 18
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
        if (`{{ $user_information->measurement_type }}` == 'POLYGON') {
            DrawPolygon.enable();
        }

        L.simpleMapScreenshoter().addTo(map)
        L.tileLayer(
            "https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
                maxZoom: 20,
                subdomains: ["mt0", "mt1", "mt2", "mt3"],
            }
        ).addTo(map);
        // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 19,
        //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        // }).addTo(map);


        // new L.Draw.Polygon(map, new L.Control.Draw().options.polygon).enable();

        map.on('draw:created', function(e) {
            new_polygon = L.polygon(e.layer._latlngs).addTo(map);
            $('.tdkoordinattable').removeClass('d-none');
            e.layer._latlngs[0].forEach(function callback(value, index) {
                $(".koordinattable .table-body").remove();
                var row = table.insertRow(table.rows.length);
                var celly = row.insertCell(0);
                var cellx = row.insertCell(1);
                var longitude = String(value.lng).substr(0, 10);
                var latitude = String(value.lat).substr(0, 10);

                celly.innerHTML = '<input type="hidden" name="polygon[latitude][]" id="" value="'+latitude+'"> <input value="'+latitude+'" disabled>';
                cellx.innerHTML = '<input type="hidden" name="polygon[longitude][]" id="" value="'+longitude+'"> <input value="'+longitude+'" disabled>';
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
            }
            $('.koordinattable').find("tr:not(:first)").remove();
            DrawPolygon.enable();
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

        function measurementType(e) {
            if (new_polygon) {
                map.removeLayer(new_polygon);
            }
            if (e.value == 'INPUT') {
                DrawPolygon.disable();
                document.getElementById("btnCoor").style.display = "block";
                $('.koordinattable').find("tr:not(:first)").remove();
            } else if (e.value == 'POLYGON') {
                DrawPolygon.enable();
                document.getElementById("btnCoor").style.display = "none";
                $('.koordinattable').find("tr:not(:first)").remove();
            }
        }

        function addCoorButton() {
            var row = table.insertRow(table.rows.length);
            var celly = row.insertCell(0);
            var cellx = row.insertCell(1);
            celly.innerHTML = '<input type="text" name="polygon[latitude][]" id="" value="">';
            cellx.innerHTML = '<input type="text" name="polygon[longitude][]" id="" value="">';
        }
    </script>
    <script>
        $('#create').on('click', function() {
            $('.input-create').append(`<input type="text" name="dasar_hukum[]" id="" class="form-control mb-2">`);
        })
    </script>
@endpush
