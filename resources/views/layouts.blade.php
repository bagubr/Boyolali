<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    {{-- <link href="{{ url('') }}/assets/img/favicon.png" rel="icon">
  <link href="{{ url('') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ url('/') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ url('') }}/assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Arsha - v4.11.0
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  @stack('css')
</head>

<body>
    @yield('header')
    <main id="main">

    @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        @yield('footer')
        <div class="container footer-bottom clearfix">
            <div class="copyright">
                &copy; Copyright <strong><span>DPUPR BOYOLALI {{ date('Y') }}</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ url('/') }}/vendor/aos/aos.js"></script>
    <script src="{{ url('/') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ url('/') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ url('/') }}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ url('/') }}/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="{{ url('/') }}/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ url('') }}/assets/js/main.js"></script>
    @stack('js')

</body>

</html>
