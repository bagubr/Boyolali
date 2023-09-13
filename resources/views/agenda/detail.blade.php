@extends('admin_templates.app')
@push('css')
    <link href="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                                <h6 class="m-0 font-weight-bold text-primary d-inline">Data Berkas</h6>
                                <a href="#" class="btn btn-success float-right" data-toggle="modal"
                                    data-target="#addReferensi"
                                    onclick="add({{ $user_information->id }}, {{ \App\Models\ReferenceType::whereNotIn('id',\App\Models\ApplicantReference::where('user_information_id', $user_information->id)->get()->pluck('reference_type_id'))->get()->pluck('file_type', 'id') }})">Tambah</a>
                            </div>
                            <div class="card-body" id="dataBerkas">
                                <table class="table">
                                    <tbody>
                                        @foreach ($user_information->applicant_reference as $item)
                                            <tr>
                                                <td>{{ $item->reference_type->file_type }}</td>
                                                <td>:</td>
                                                <td>
                                                    {{-- <a href="{{ url('uploads/'.$item->file) }}" class="btn btn-success" download>Download</a> --}}
                                                    <a href="{{ url('storage/' . $item->file) }}" class="btn btn-primary"
                                                        target="_blank">Lihat</a>
                                                    <a href="#" class="btn btn-info" data-toggle="modal"
                                                        data-target="#updateReferensi"
                                                        onclick="edit({{ $item->id }})">Edit</a>
                                                    {{-- <a href="{{ route('agenda-delete-reference') }}" data-toggle="modal"
                                                        data-target="#deleteModal" class="btn btn-danger">Hapus</a> --}}
                                                    {{-- <a class="btn btn-danger btn-xs button-delete" data-id="{{$chat->id}}">Delete</a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">

                        <!-- Basic Card Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Buat Agenda</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('agenda-post', $user_information->id) }}" method="post">
                                    @csrf
                                    @php
                                        $nomor = \App\Models\UserInformation::orderBy('nomor', 'desc')->first()->nomor ?? 0;
                                        $default = \App\Models\Setting::whereGroup('NO_REG')
                                            ->orderBy('id')
                                            ->get()
                                            ->pluck('value');
                                        $nomor_registration_before = $default[0] . '/' . $nomor . '/' . $default[1];
                                        
                                        if (!$user_information->nomor_registration) {
                                            $nomor_registration = $default[0] . '/' . $nomor + 1 . '/' . $default[1];
                                            $nomor = $nomor + 1;
                                        } else {
                                            $nomor_registration = $default[0] . '/' . $nomor . '/' . $default[1];
                                            $nomor = $nomor;
                                        }
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
                                    @if (!$user_information->nomor_registration)
                                        <button type="submit" class="btn btn-success m-auto">Save</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (count($user_information->revision->where('to', \App\Models\UserInformation::STATUS_FILING)) > 0)
                        <div class="col-lg-12">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Revisi Agenda</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            @foreach ($user_information->revision->where('to', \App\Models\UserInformation::STATUS_FILING) as $key => $item)
                                                <tr>
                                                    <td>Keterangan</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $item->note }}
                                                    </td>
                                                    <td>
                                                        @if (count($user_information->revision->where('to', \App\Models\UserInformation::STATUS_FILING)) == $key + 1)
                                                            <i class="btn btn-primary">New</i>
                                                            <button class="btn btn-success float-right" onclick="approve('{{ $user_information->uuid }}')">Selesai</button>
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
@endsection
@push('js')
    <!-- Page level plugins -->
    <script src="{{ url('sb-admin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('sb-admin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('sb-admin') }}/js/demo/datatables-demo.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
