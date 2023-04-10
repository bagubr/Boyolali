@extends('admin_templates.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>

        <!-- Content Row -->
        <div class="row">
            @if (Auth::guard('administrator')->user()->role == 'CEK' || Auth::guard('administrator')->user()->role == 'FILING')
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('agenda-berkas-proses') }}">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Proses Berkas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $data['total_proses_berkas'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('agenda-selesai') }}">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Proses Selesai</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $data['total_proses_selesai'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Proses
                                        Validasi
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                {{ $data['total_proses_validasi'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('agenda-berkas-selesai') }}">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Berkas
                                            Selesai</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $data['total_berkas_selesai'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if (Auth::guard('administrator')->user()->role == 'SUBKOR')
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('subkor-berkas-proses') }}">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Berkas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $data['total_proses_subkor'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if (Auth::guard('administrator')->user()->role == 'KABID')
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('kabid-berkas-proses') }}">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Berkas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $data['total_proses_kabid'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if (Auth::guard('administrator')->user()->role == 'KADIS')
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('kadis-berkas-proses') }}">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Berkas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $data['total_proses_kadis'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
