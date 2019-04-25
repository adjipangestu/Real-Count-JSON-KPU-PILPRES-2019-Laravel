<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sekelik Corporation</title>

    <link href="{{ asset ('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset ('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset ('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset ('assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

<div id="wrapper">
<!-- main menu -->
@include('partial.main_menu')
<!-- end main menu -->

        <div id="page-wrapper" class="gray-bg">
            

            <!-- content -->
            @yield('content')
            <!-- end content -->

        </div>
</div>
</body>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
@stack('script')
</html>
