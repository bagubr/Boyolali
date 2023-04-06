<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ url('') }}/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="{{ url('') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="{{ url('') }}/dist/css/adminlte.min.css?v=3.2.0">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card">
            <div class="card-body">
                <p class="login-box-msg">{{ env('APP_NAME') }}</p>
                @include('users.alert')
                <form action="{{ route('user-login-post') }}" method="post" role="form" class="php-email-form">
                    @csrf
                    <center>
                        <img src="{{ asset('uploads/' . App\Models\Setting::whereGroup('LOGO')->first()->value) }}"
                            alt="" width="100px">
                    </center>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                        <div class="text-right mb-1">
                            <a href="{{ route('user-login') }}">Forget Password ?</a>
                        </div>
                    </div>
                    <div class="text-center mb-1">
                        <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="text-center m-1">
                        don't have accaount?
                    </div>
                    <div class="text-center">
                        <a class="btn btn-success w-100" href="{{ route('registration') }}">Buat Akun</a>
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


    <script src="{{ url('') }}/plugins/jquery/jquery.min.js"></script>

    <script src="{{ url('') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="{{ url('') }}/dist/js/adminlte.min.js?v=3.2.0"></script>
</body>

</html>
