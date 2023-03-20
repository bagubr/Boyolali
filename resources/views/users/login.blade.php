@extends('layouts')

@section('content')
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Login</h2>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-5 mt-5 mt-lg-0">
                    @include('users.alert')
                    <form action="{{ route('user-login-post') }}" method="post" role="form" class="php-email-form">
                        @csrf
                        <center>
                            <img src="{{ asset('uploads/'.App\Models\Setting::whereGroup('LOGO')->first()->value) }}" alt="" width="150px">
                        </center>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Your Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center">
                            <button type="submit">Login</button>
                            <a href="{{ route('registration') }}"
                                style="background: #47b2e4;
                                border: 0;
                                padding: 12px 34px;
                                color: #fff;
                                transition: 0.4s;
                                border-radius: 50px;">Daftar</a>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->
@endsection
