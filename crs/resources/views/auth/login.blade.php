
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Log In | CRS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRS') }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">
    <!-- App css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{asset('assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="dark-style" />

</head>

<body class=" pb-0" data-layout-config='{"darkMode":false}'>

    <div class="auth-fluid">
   
     <!-- Auth fluid right content -->
     <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial pb-5">
			<div class="text-center">
				<img class="me-3 rounded bg-white" src="{{asset('assets/images/Mak_logo.png')}}" width="16%" alt="">
			</div>
            <h1 class="mb-3">COVID-19 Results System (CRS)</h1>
            <p class="lead"><i class="mdi mdi-format-quote-open"></i>
                A Laboratory Information Management System (LIMS) that manages the entire laboratory workflow for the COVID-19 testing, from sample collection, accessioning, results to quality control.
                <i class="mdi mdi-format-quote-close"></i>
				<br />
            </p>
            <p><u>Developed with love from the Creators!</u></p>
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
   
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">
                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="index.html" class="logo-dark">
                        <span><img src="assets/images/loo-dark.png" alt="" height="18"></span>
                    </a>
                    <a href="index.html" class="logo-light">
                        <span><img src="assets/images/log.png" alt="" height="18"></span>
                    </a>
                </div>
                <!-- title-->
                <div class="text-center"><h2 class="mt-0">LOGIN</h2></div>
                <!-- form -->
                <form method="POST" action="{{ route('login') }}">
                      @csrf
                      @include('layouts.messages')
                    <div class="mb-3">
                        <label for="emailaddress" class="form-label">Email address</label>
                        <input class="form-control" type="email" id="emailaddress" value="{{old('email')}}" required="" placeholder="Enter your email" name="email" autofocus>
                    </div>
                    <div class="mb-3">
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-muted float-end"> <small>{{ __('Forgot your password?') }}</small></a>
                        </a>
                        @endif
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" type="password" id="password" placeholder="Enter your password" name="password" required autocomplete="current-password">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>
                    </div>
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Log In </button>
                    </div>
                    <!-- social-->
                </form>
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <script>document.write(new Date().getFullYear())</script> © Makerere Biomedical Research Centre
                            </div>

                        </div>
                    </div>
                </footer>

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->       
</div>
<!-- end auth-fluid-->

<!-- bundle -->
<script src="{{asset('assets/js/vendor.min.js')}}"></script>
<script src="{{asset('assets/js/app.min.js')}}"></script>

</body>

</html>