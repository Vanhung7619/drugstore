@extends('layout')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/styleinvoice.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Liên kết CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
    @yield('contentinvoice')
@endsection
