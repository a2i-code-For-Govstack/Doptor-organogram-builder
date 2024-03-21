@extends('layouts.guest')
@section('title') নিশ্চিত করুন @endsection
@section('style')
    <style>
        .error.error-6 .error-title {
            font-size: 5rem !important
        }

        @media (min-width: 768px) {
            .error.error-6 .error-title {
                font-size: 10rem !important
            }
        }
    </style>
@endsection
@section('content')
    <div class="d-flex flex-column flex-root">
        <!--begin::Error-->
        <div class="error error-6 d-flex flex-row-fluid bgi-size-cover bgi-position-center"
             style="background-image: url({{asset('assets/media/error/bg6.jpg')}});">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-row-fluid text-center">
                <h1 class="error-title font-weight-boldest text-white mb-12" style="margin-top: 12rem;">দুঃখিত</h1>
                <p class="display-4 font-weight-bold text-white">{{$msg}}</p>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Error-->
    </div>
@endsection
@section('script')
@endsection