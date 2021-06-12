<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="" >
    <meta name="author" content="Hemran Akhtari">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--Meta Responsive tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <!--Custom style.css-->
    <link rel="stylesheet" href="{{ asset('/css/quicksand.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <!--Font Awesome-->
    <link rel="stylesheet" href="{{ asset('/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/fontawesome.css') }}">
    
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <title>rheingold GmbH - @yield('title')</title>
  </head>

  <body class="login-body">
    
    <!--Login Wrapper-->

    <div class="container-fluid login-wrapper">
        <div class="login-box">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12 login-box-info"> 
                    <div class="logo-box">  
                        <img src="{{ asset('/img/logo.png') }}" alt="Logo" width="300px">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12 login-box-form p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>    

    <!--Login Wrapper-->

    <!-- Page JavaScript Files-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
    <!--Popper JS-->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <!--Bootstrap-->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!--Custom Js Script-->
    <script src="{{ asset('js/custom.js') }}"></script>
    <!--Custom Js Script-->
  </body>
</html>