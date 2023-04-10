<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <center>
                <img src="{{ asset('uploads/'.App\Models\Setting::whereGroup('LOGO')->first()->value) }}" alt="" width="40px">
            </center>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }} </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is(Request::route()->getPrefix().'-dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('administrator-dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if (Auth::guard('administrator')->user()->role == 'CEK' || Auth::guard('administrator')->user()->role == 'FILING' || Auth::guard('administrator')->user()->role == 'ADMIN')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Proses
        </div>
    
        <li class="nav-item {{ Route::is('agenda-berkas-proses') || Route::is('agenda-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('agenda-berkas-proses') }}">
                <i class="fas fa-fw fa-file"></i>
                <span>Proses Berkas</span></a>
        </li>
        <li class="nav-item {{ Route::is('agenda-selesai') || Route::is('selesai-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('agenda-selesai') }}">
                <i class="fas fa-fw fa-edit"></i>
                <span>Proses Selesai</span></a>
        </li>        
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Selesai
        </div>
    
        <li class="nav-item {{ Route::is('agenda-berkas-selesai', 'berkas-selesai-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('agenda-berkas-selesai') }}">
                <i class="fas fa-fw fa-file"></i>
                <span>Berkas Selesai</span></a>
        </li>
    @endif
    @if(Auth::guard('administrator')->user()->role == 'SUBKOR'  || Auth::guard('administrator')->user()->role == 'ADMIN')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Sub Kor
        </div>
    
        <li class="nav-item {{ Route::is('subkor-cek', 'subkor-cek-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('subkor-cek', 'subkor-cek-detail') }}">
                <i class="fas fa-fw fa-edit"></i>
                <span>Cek Manual</span></a>
        </li>        
        <li class="nav-item {{ Route::is('subkor-berkas-proses', 'subkor-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('subkor-berkas-proses') }}">
                <i class="fas fa-fw fa-file"></i>
                <span>Proses Berkas</span></a>
        </li>
    @endif
    @if(Auth::guard('administrator')->user()->role == 'KABID' || Auth::guard('administrator')->user()->role == 'ADMIN')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Kabid
        </div>
        <li class="nav-item {{ Route::is('kabid-cek', 'kabid-cek-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kabid-cek', 'kabid-cek-detail') }}">
                <i class="fas fa-fw fa-edit"></i>
                <span>Cek Manual</span></a>
        </li>    
        <li class="nav-item {{ Route::is('kabid-berkas-proses', 'kabid-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kabid-berkas-proses') }}">
                <i class="fas fa-fw fa-file"></i>
                <span>Proses Berkas</span></a>
        </li>
    @endif
    @if(Auth::guard('administrator')->user()->role == 'KADIS' || Auth::guard('administrator')->user()->role == 'ADMIN')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Kadis
        </div>
        <li class="nav-item {{ Route::is('kadis-cek', 'kadis-cek-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kadis-cek', 'kadis-cek-detail') }}">
                <i class="fas fa-fw fa-edit"></i>
                <span>Cek Manual</span></a>
        </li>    
        <li class="nav-item {{ Route::is('kadis-berkas-proses', 'kadis-detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kadis-berkas-proses') }}">
                <i class="fas fa-fw fa-file"></i>
                <span>Proses Berkas</span></a>
        </li>   
    @endif

</ul>
<!-- End of Sidebar -->