<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="Responsive HTML Template">
    <meta name="description" content="Vixka Responsive HTML Template">
    <meta name="author" content="tivatheme">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,700%7CHerr+Von+Muellerhoff' rel='stylesheet' type='text/css'>

    <!-- Vendor CSS -->
    {!! Html::style('css/bootstrap-theme.css') !!}
    {!! Html::style('css/font-awesome.min.css') !!}
    {!! Html::style('css/pe-icon-7-stroke.min.css') !!}
    {!! Html::style('css/owl.carousel.css') !!}
    {!! Html::style('css/magnific-popup.css') !!}

    <!-- Main CSS -->
    {!! Html::style('css/global.css') !!}
    {!! Html::style('css/responsive.css') !!}

</head>
<body id="index" class="index home-1">
    <div id="all">
        @include('includes.header')
        @yield('content')
        @include('includes.footer')
    </div><!-- end all -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Vendor JS -->
    {!! Html::script('js/jquery-1.11.3.min.js')!!}
    {!! Html::script('js/owl.carousel.js')!!}
    {!! Html::script('js/jquery.magnific-popup.js')!!}
    {!! Html::script('js/bootstrap.min.js')!!}

    {{--<script src="http://maps.google.com/maps/api/js?key=AIzaSyBd1UJcqm8K9sZ4p9xloWUHSzsFaovKxuM"></script>--}}

    <!-- Main JS -->
    {!! Html::script('js/custom.js')!!}
    {!! Html::script('js/addtocart.js')!!}

</body>
</html>





