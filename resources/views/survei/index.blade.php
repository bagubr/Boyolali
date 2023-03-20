@extends('layouts')

@section('content')
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Login Survei</h2>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-5 mt-5 mt-lg-0">
                    @include('users.alert')
                    <form action="{{ route('survei-login') }}" method="post" role="form" class="php-email-form">
                        @csrf
                        <center>
                            <img src="{{ asset('uploads/'.App\Models\Setting::whereGroup('LOGO')->first()->value) }}" alt="" width="150px">
                        </center>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Username</label>
                                <input type="username" class="form-control" name="username" id="username" required>
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
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->
@endsection
