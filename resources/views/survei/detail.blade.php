@extends('admin_templates.app')
@push('css')
    <link href="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <style>
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

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Agenda</h1>
        </div>
        <div class="row">

            <div class="col-lg-6">
                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Pemohon</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nomor Registrasi</td>
                                    <td>:</td>
                                    <td>{{ $user_information->nomor_registration }}</td>
                                </tr>
                                <tr>
                                    <td>Pemohon</td>
                                    <td>:</td>
                                    <td>{{ $user_information->submitter }}</td>
                                </tr>
                                <tr>
                                    <td>No KTP</td>
                                    <td>:</td>
                                    <td>{{ $user_information->nomor_ktp }}</td>
                                </tr>
                                <tr>
                                    <td>Telepon Pemohon</td>
                                    <td>:</td>
                                    <td>{{ $user_information->submitter_phone }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat Pemohon</td>
                                    <td>:</td>
                                    <td>{{ $user_information->address }}</td>
                                </tr>
                                <tr>
                                    <td>Luas Tanah</td>
                                    <td>:</td>
                                    <td>{{ $user_information->land_area }}</td>
                                </tr>
                                <tr>
                                    <td>Status Tanah / No Sertifikat</td>
                                    <td>:</td>
                                    <td>{{ $user_information->land_status->name . ' / ' . $user_information->nomor_hak }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat Lokasi</td>
                                    <td>:</td>
                                    <td>{{ $user_information->location_address }}</td>
                                </tr>
                                <tr>
                                    <td>Desa / Kelurahan</td>
                                    <td>:</td>
                                    <td>{{ $user_information->sub_district->name }}</td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>:</td>
                                    <td>{{ $user_information->district->name }}</td>
                                </tr>
                                <tr>
                                    <td>Koordinat</td>
                                    <td>:</td>
                                    <td>({{ $user_information->latitude . ', ' . $user_information->longitude }})</td>
                                </tr>
                                <tr>
                                    <td>Kegiatan yang dimohon</td>
                                    <td>:</td>
                                    <td>{{ $user_information->activity_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Basic Card Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Data Kuasa</h6>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{ $user_information->procuration->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Telepon</td>
                                            <td>:</td>
                                            <td>{{ $user_information->procuration->phone ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>:</td>
                                            <td>{{ $user_information->procuration->address ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12">

                        <!-- Basic Card Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <a href="#" class="btn btn-primary float-right" data-toggle="modal"
                                    data-target="#addBAP"
                                    onclick="add({{ $user_information->id }}, {{ \App\Models\ReferenceType::whereNotIn('id',\App\Models\ApplicantReference::where('user_information_id', $user_information->id)->get()->pluck('reference_type_id'))->get()->pluck('file_type', 'id') }})">Formulir
                                    BAP</a>
                                <h6 class="m-0 font-weight-bold text-primary d-inline">Data Berita Acara Pemeriksaan</h6>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Kondisi Bangunan</td>
                                            <td>:</td>
                                            <td>{{ $user_information->interrogation_report->building_condition ?? '-' }} %
                                                Terbangun</td>
                                        </tr>
                                        <tr>
                                            <td>Peruntukan</td>
                                            <td>:</td>
                                            <td>{{ $user_information->interrogation_report->allocation ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Catatan</td>
                                            <td>:</td>
                                            <td>{{ $user_information->interrogation_report->note ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Jalan</td>
                                            <td>:</td>
                                            <td>
                                                @foreach (json_decode(@$user_information->interrogation_report->street_name) ?? [] as $key => $item)
                                                    {{ $item ?? '' }}
                                                    @if (count(json_decode(@$user_information->interrogation_report->street_name) ?? []) > $key + 1)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Petugas</td>
                                            <td>:</td>
                                            <td>
                                                @foreach (json_decode(@$user_information->interrogation_report->employee) ?? [] as $key => $item)
                                                    {{ \App\Models\AdminSurvei::find($item)->name ?? '' }}
                                                    @if (count(json_decode(@$user_information->interrogation_report->employee) ?? []) > $key + 1)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Action</td>
                                            <td>:</td>
                                            <td>
                                                @if ($user_information->interrogation_report)
                                                    <a href="" class="btn btn-primary">Download</a>
                                                    <a href="" class="btn btn-info">View</a>
                                                    {{-- <button class="btn btn-danger" onclick="delete_bap('{{ $user_information->uuid }}')">Delete</button> --}}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <div class="card-footer">
                                    <button class="btn btn-success float-right"
                                        onclick="approve('{{ $user_information->uuid }}')">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (count($user_information->revision->where('to', \App\Models\UserInformation::STATUS_SURVEI)) > 0)
                        <div class="col-lg-12">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Revisi Agenda</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            @foreach ($user_information->revision->where('to', \App\Models\UserInformation::STATUS_SURVEI) as $key => $item)
                                                <tr>
                                                    <td>Keterangan</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $item->note }}
                                                    </td>
                                                    <td>
                                                        @if (count($user_information->revision) == $key + 1)
                                                            <i class="btn btn-primary">New</i>
                                                        @else
                                                            <i class="btn btn-secondary">Done</i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
    <!-- addBAP Modal-->
    <div class="modal fade" id="addBAP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulir BAP</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('survei-bap') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @php
                            $interrogation_report = $user_information->interrogation_report;
                        @endphp
                        <input type="hidden" name="user_information_id" id="user_information_id">

                        <label for="">Kondisi Bangunan</label>
                        <div class="input-group">
                            <input type="number" max="100" min="0" name="building_condition"
                                class="form-control" value="{{ $interrogation_report->building_condition ?? '' }}"
                                required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                        <label for="">Peruntukan</label>
                        <input type="text" name="allocation" class="form-control"
                            value="{{ $interrogation_report->allocation ?? '' }}" required>
                        <label for="">Catatan</label>
                        <textarea name="note" class="form-control" style="height:200px;" required>{{ $interrogation_report->note ?? '' }}</textarea>
                        <label for="">Nama Petugas</label>
                        <div class="input-group">
                            <select class="selectpicker form-control" name="employee[]" data-live-search="true" multiple>
                                @foreach (\App\Models\AdminSurvei::whereIsCoordinator(false)->get() as $item)
                                    <option value="{{ $item->id }}"
                                        {{ in_array($item->id, json_decode(@$interrogation_report->employee) ?? []) ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="">Nama Jalan</label>
                        <div class="input-group">
                            <input id="streetInput" type="text" class="form-control">
                            <input name="street_name" type="hidden" id="streetValue" type="text"
                                class="form-control" value="{{ $interrogation_report->street_name ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="button" onclick="addStreetName()">Tambah</button>
                                <button class="btn btn-secondary" type="button" onclick="resetStreet()">Reset</button>
                            </div>
                        </div>
                        <pre>
                            <div id="streetView"> {{ @$interrogation_report->street_name }}</div>
                        </pre>
                        <br>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <!-- Page level plugins -->
    <script src="{{ url('sb-admin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('sb-admin') }}/js/demo/datatables-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function delete_bap(uuid) {
            swal({
                    title: "Yakin?",
                    text: "Data Akan di hapus!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Berhasil Di Hapus!", {
                            icon: "success",
                        });
                        location.replace(`{{ route('delete-bap') }}?id=` + uuid)
                    } else {
                        swal("Cancel!");
                    }
                });
        }
    </script>
    <script>
        function approve(uuid) {
            swal({
                    title: "Selesaikan ?",
                    text: "Data Akan di Kirim ke proses gambar",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Berhasil!", {
                            icon: "success",
                        });
                        location.replace(`{{ route('survei-approve') }}?id=` + uuid)
                    } else {
                        swal("Cancel");
                    }
                });
        }
    </script>

    <script>
        // Declare street_name array
        var street_names = [];
        // Button functions
        var street_name = '{{ @$interrogation_report->street_name ?? '' }}';
        // console.log(JSON.parse(street_name.replace(/&quot;/g,'"')));
        street_names = street_names.concat(JSON.parse(street_name.replace(/&quot;/g, '"')));

        function addStreetName() {
            street_name_input = document.getElementById("streetInput").value;
            street_names.push(street_name_input);
            console.log(street_name);
            console.log(street_name_input);
            console.log(street_names);
            document.getElementById("streetInput").value = "";
            document.getElementById("streetValue").value = JSON.stringify(street_names);
            document.getElementById("streetView").innerHTML = JSON.stringify(street_names);
        }

        function resetStreet() {
            street_names = [];
            document.getElementById("streetInput").value = "";
            document.getElementById("streetValue").value = "";
            document.getElementById("streetView").innerHTML = "";
        }
    </script>


    <script>
        $('select').selectpicker();
    </script>
@endpush
