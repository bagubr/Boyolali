@extends('layouts')
@section('header')
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="#">{{ config('app.name') }}</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="#" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            
            @include('users.navbar')

        </div>
    </header><!-- End Header -->
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- End Hero -->
@endsection
@section('content')
@endsection



@section('footer')
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6 footer-contact">
                    <h3>Lokasi</h3>
                    <p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11946.118927757949!2d110.59138205784186!3d-7.5399637573715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a694bb6114c8b%3A0x9eb63655528ecb5a!2sDPU%20PR%20Kab.%20Boyolali!5e0!3m2!1sen!2sid!4v1659860037339!5m2!1sen!2sid" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Informasi Kontak</h4>
                    <ul>
                        @foreach (\App\Models\Information::get() as $item)
                        <li class="p-0">
                            <strong>{{ $item->title }}</strong> : 
                        </li>
                        <li class="p-0">
                            {{ $item->value }}
                        </li>
                        <hr>
                        @endforeach
                    </ul>
                </div>

                {{-- <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                    </ul>
                </div> --}}

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Sosial Media</h4>
                    <div class="social-links mt-3">
                        @foreach (\App\Models\SocialMedia::get() as $item)
                            <a href="{{ url($item->url) }}" class="{{ strtolower($item->title) }}"><i class="bx bxl-{{ strtolower($item->title) }}"></i></a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
