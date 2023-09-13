@extends('layouts')
@section('header')
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="#" style="text-decoration: none;">{{ config('app.name') }}</a></h1>

        </div>
    </header><!-- End Header -->
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-1 order-lg-1 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
                <div class="col-lg-4 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-2 m-auto"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="hold-transition register-page">
                        <div class="register-box">
                            <div class="card w-55">
                                <div class="card-body">
                                    <p class="login-box-msg">{{ env('APP_NAME') }}</p>
                                    @include('users.alert')
                                    <form action="{{ route('user-login-post') }}" method="post" role="form"
                                        class="php-email-form">
                                        @csrf
                                        <center>
                                            <img src="{{ asset('uploads/' . App\Models\Setting::whereGroup('LOGO')->first()->value) }}"
                                                alt="" width="100px">
                                        </center>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="name">Email</label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" required>
                                            <div class="text-right mb-1">
                                                <a href="{{ route('password.request') }}">Forget Password ?</a>
                                            </div>
                                        </div>
                                        <div class="my-3 d-none">
                                            <div class="loading">Loading</div>
                                            <div class="error-message"></div>
                                            <div class="sent-message">Your message has been sent. Thank you!</div>
                                        </div>
                                        <div class="text-center mb-1">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        <div class="text-center m-1">
                                            tidak punya akun? <a href="{{ route('registration') }}">Buat Akun</a>
                                        </div>
                                        <div class="social-auth-links text-center">
                                            <p>- OR -</p>
                                            <a href="{{ route('google-auth') }}" class="btn btn-block btn-danger">
                                                <i class="fab fa-google mr-2"></i>
                                                Sign up using Google
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- End Hero -->
@endsection
{{-- @section('content')
    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Informasi Layanan</h2>
                <p>{{ config('app.name') }}</p>
            </div>

            <div class="row justify-content-center">

                @foreach (\App\Models\TermAndCondition::orderBy('id')->get() as $item)
                    <a href="{{ url('uploads/' . $item->file) }}">
                        <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in"
                            data-aos-delay="400">
                            <div class="icon-box">
                                <div class="icon">
                                    <img src="{{ asset('uploads/' . $item->image) }}" width="200px" alt="">
                                </div>
                                <h4><a href="{{ url($item->file) }}">{{ $item->title }}</a></h4>
                            </div>
                        </div>
                    </a>
                @endforeach


            </div>

        </div>
    </section><!-- End Services Section -->
@endsection --}}



@section('footer')
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6 footer-contact">
                    <h3>Lokasi</h3>
                    <p>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11946.118927757949!2d110.59138205784186!3d-7.5399637573715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a694bb6114c8b%3A0x9eb63655528ecb5a!2sDPU%20PR%20Kab.%20Boyolali!5e0!3m2!1sen!2sid!4v1659860037339!5m2!1sen!2sid"
                            width="100%" height="250" frameborder="0" style="border:0" allowfullscreen=""></iframe>
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

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Sosial Media</h4>
                    <div class="social-links mt-3">
                        @foreach (\App\Models\SocialMedia::get() as $item)
                            <a href="{{ url($item->url) }}" class="{{ strtolower($item->title) }}"><i
                                    class="bx bxl-{{ strtolower($item->title) }}"></i></a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
