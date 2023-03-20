<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
    <li class="nav-item {{ Request::is(Request::route()->getPrefix().'/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard-'.Request::route()->getPrefix()) }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <li class="nav-item {{ Request::is(Request::route()->getPrefix().'/berkas-proses') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route(Request::route()->getPrefix().'-berkas-proses') }}">
            <i class="fas fa-fw fa-file"></i>
            <span>Proses Berkas</span></a>
    </li>
    <li class="nav-item {{ Request::is(Request::route()->getPrefix().'/revisi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route(Request::route()->getPrefix().'-revisi') }}">
            <i class="fas fa-fw fa-edit"></i>
            <span>Proses Revisi</span></a>
    </li>

</ul>
<!-- End of Sidebar -->