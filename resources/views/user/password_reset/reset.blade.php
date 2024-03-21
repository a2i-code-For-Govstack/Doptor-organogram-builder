@extends('layouts.guest')

@section('title')
    পাসওয়ার্ড রিসেট
@endsection
@section('style')
    <style>
        .login.login-4 .login-container .login-content.login-content-signup {
            width: 45%;
        }

        .wizard-icon-active {
            transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease !important;
            background-color: #C9F7F5 !important;
        }
    </style>
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <div class="container bg-white">
        <div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid wizard" id="kt_login"
             style="padding-top: 5%">
            <div
                class="login-container d-flex flex-center flex-row flex-row-fluid order-2 order-lg-1 flex-row-fluid bg-white py-lg-0 pb-lg-0 pt-10 pb-12">
                <div class="login-content login-content-signup d-flex flex-column">
                    <div class="d-flex flex-column-auto flex-column px-10">
                        <a href="{{ url('/') }}" class="login-logo pb-lg-4 pb-10 text-center">
                            <img src="{{ asset('assets/img/ndoptor.svg') }}" class="max-h-90px" alt=""/>
                        </a>
                        {{-- <div class="wizard-nav pt-4 pt-lg-10 pb-10">
                            @include('user.password_reset.partial.wizerd')
                        </div> --}}
                    </div>
                    <div class="login-form">
                        <form class="form px-10" novalidate="novalidate" id="kt_login_signup_form">
                            <div class="pb-5" id="account_find">
                                <div class="pb-10 pb-lg-12">
                                    <div class="text-muted font-weight-bold font-size-h4">পাসওয়ার্ড ভুলে যান নি?
                                        <a href="{{ $return_login_url ?: url('/') }}"
                                           class="text-primary font-weight-bolder">লগইন</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="font-size-h3 font-weight-bolder text-dark">ইউজারনেম অথবা ইউজার
                                        আইডি</label>
                                    <input type="text"
                                           class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                           name="username" placeholder="ইউজারনেম অথবা ইউজার আইডি" id="username"/>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <div class="col-6 col-form-label">
                                                <div class="radio-list">
                                                    <label class="radio radio-success radio-rounded">
                                                        <input type="radio" checked id="emailMedium"
                                                               onclick="changeVerifyMedium('mail')"/>
                                                        <span></span>
                                                        ই-মেইল
                                                    </label>
                                                    <div class="input-group" id="emailgroup">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                                    class="fa fa-envelope icon-lg"></i></span></div>
                                                        <input type="email" class="form-control" placeholder="ই-মেইল"
                                                               name="emailaddress" id="emailaddress"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-form-label">
                                                <div class="radio-list">
                                                    <label class="radio radio-success radio-rounded">
                                                        <input type="radio" id="phoneMedium"
                                                               onclick="changeVerifyMedium('phone')"/>
                                                        <span></span>
                                                        মোবাইল নম্বর
                                                    </label>
                                                    <div class="input-group d-none" id="phonegroup">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                                    class="fa fa-mobile icon-lg"></i></span></div>
                                                        <input type="text" class="form-control"
                                                               placeholder="মোবাইল নম্বর" name="phonenumber"
                                                               id="phonenumber"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="choose_medium">
                                    <button type="button"
                                            class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3 float-right"
                                            id="choose_medium_submit">পরবর্তী
                                        <span class="svg-icon svg-icon-md ml-2">
                                            @include('user.password_reset.partial.nextbutton')
                                        </span>
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Login-->
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @include('scripts.reset_pass')
@endsection
