@extends('admin_templates.app')
@push('css')
    <link href="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                                <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#add"
                                    onclick="add({{ $user_information->id }}, {{ \App\Models\ReferenceType::whereNotIn('id',\App\Models\ApplicantReference::where('user_information_id', $user_information->id)->get()->pluck('reference_type_id'))->get()->pluck('file_type', 'id') }})">Keterangan
                                    Rencana</a>
                                <h6 class="m-0 font-weight-bold text-primary d-inline">File Gambar</h6>
                            </div>
                            <div class="card-body">

                                <div class="card-footer">
                                    <form action="{{ route('upload-file-sketch') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ $user_information->id }}"
                                            name="user_information_id">
                                        <input type="file" name="file" class="form-control">
                                        <br>
                                        @if (@$user_information->sketch_file->file)
                                            <img src="{{ asset('storage/' . $user_information->sketch_file->file) }}"
                                                alt="" class="img-thumbnail" width="200px">
                                        @endif
                                        <div class="float-right">
                                            <button class="btn btn-primary" type="submit">Upload</button>
                                            <button class="btn btn-success" type="button"
                                                onclick="approve('{{ $user_information->uuid }}')">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (count($user_information->revision->where('to', \App\Models\UserInformation::STATUS_SKETCH)) > 0)
                        <div class="col-lg-12">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Revisi Agenda</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            @foreach ($user_information->revision->where('to', \App\Models\UserInformation::STATUS_SKETCH) as $key => $item)
                                                <tr>
                                                    <td>Keterangan</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $item->note }}
                                                    </td>
                                                    <td>
                                                        @if (count($user_information->revision->where('to', \App\Models\UserInformation::STATUS_SKETCH)) == $key + 1)
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
    <!-- add Modal-->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulir Keterangan Rencana</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Fungsi Bangunan yang di mohon</label>
                            <select name="building_function" id="" class="form-control" id="select2" required>
                                @foreach (\App\Models\BuildingFunction::get() as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <center><label for="">KBG</label></center>
                            <textarea name="kbg" id="" class="form-control"></textarea>
                            <center><label for="">KDB</label></center>
                            <textarea name="kdb" id="" class="form-control"></textarea>
                            <center><label for="">KLB</label></center>
                            <textarea name="klb" id="" class="form-control"></textarea>
                            <center><label for="">KDH</label></center>
                            <textarea name="kdh" id="" class="form-control"></textarea>
                            <center><label for="">PSU</label></center>
                            <textarea name="psu" id="" class="form-control"></textarea>
                            <center><label for="">KTB</label></center>
                            <textarea name="ktb" id="" class="form-control"></textarea>
                        </div>
                        <div class="col-3">
                            <center><label for="">JAP</label></center>
                            <textarea name="jap" id="" class="form-control"></textarea>
                            <center><label for="">JKP</label></center>
                            <textarea name="jkp" id="" class="form-control"></textarea>
                            <center><label for="">JKS</label></center>
                            <textarea name="jks" id="" class="form-control"></textarea>
                            <center><label for="">JLP</label></center>
                            <textarea name="jlp" id="" class="form-control"></textarea>
                            <center><label for="">JLS</label></center>
                            <textarea name="jls" id="" class="form-control"></textarea>
                            <center><label for="">Jling</label></center>
                            <textarea name="jling" id="" class="form-control"></textarea>
                        </div>
                        <div class="col-6">
                            <label for="">Jaringan Utilitas (Bebas Bangunan)</label>
                            <textarea name="jaringan_utilitas" id="" class="form-control"></textarea>
                            <label for="">Prasarana Jalan</label>
                            <textarea name="prasarana_jalan" id="" class="form-control"></textarea>
                            <label for="">Sungai Bertanggul</label>
                            <input type="text" name="sungai_bertanggul" id="" class="form-control">
                            <label for="">Sungai Tidak Bertanggul</label>
                            <input type="text" name="sungai_tidak_bertanggul" id="" class="form-control">
                            <label for="">Mata Air</label>
                            <input type="text" name="mata_air" id="" class="form-control">
                            <label for="">Waduk (titik pasang tertinggi)</label>
                            <input type="text" name="waduk" id="" class="form-control">
                            <label for="">Tol (dari pagar)</label>
                            <input type="text" name="tol" id="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <!-- Page level plugins -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="{{ url('sb-admin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('sb-admin') }}/js/demo/datatables-demo.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                        location.replace(`{{ route('sketch-approve') }}?id=` + uuid)
                    } else {
                        swal("Cancel");
                    }
                });
        }
    </script>

    <script>
        // $('#select2').select2();
        $(".select").select2({
            tags: true,
            dropdownParent: $('#add .modal-content')
        });
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
                        location.replace(`{{ route('agenda-approve') }}?id=` + uuid)
                    } else {
                        swal("Cancel");
                    }
                });
        }
    </script>
@endpush
