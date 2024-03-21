<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <meta name="description" content="Singin page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>

    <link rel="shortcut icon" href="{{ asset('assets/img/bd.png') }}"/>
    @yield('style')
    <!--begin::Fonts -->
    <style type="text/css">
        @font-face {
            font-family: SolaimanLipi;
            src: url('{{ asset('/fonts/SolaimanLipi.ttf') }}');
        }

        body {
            font-family: 'SolaimanLipi';
        }
    </style>
    @include('partials.google_analytics')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading bg-white">
<!--begin::Main-->
@yield('content')
<!--end::Main-->
<!--begin::Global Config(global config for global JS scripts)-->
@yield('script')
</body>

</html>
