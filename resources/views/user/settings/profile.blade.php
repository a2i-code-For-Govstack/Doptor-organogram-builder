@if ($userHasRole)
    @php
        $layout = 'master';
    @endphp
@else
    @php
        $layout = 'layouts.no-role';
    @endphp
@endif
@extends($layout)
@section('css')
    <style>
        .kt-aside__brand-logo span,
        .kt-aside--minimize span,
        .kt-aside--minimize-hover span,
        .kt-header-mobile__logo span {
            font-size: 12px !important;
        }


        .form-control-solid {
            height: 32px;
        }

        .page-title-wrapper {
            border-bottom: 1px solid #E4E6EF;
            background: #ECF6FF;
            border-color: #d2eaff;
            color: #0A4675;
        }

        .text-grey {
            color: #6c6c6c !important;
        }

        .pro-con-sec span {
            font-size: 15px !important;
        }

        #myvTab .nav.nav-tabs {
            float: left;
            display: block;
            width: 100%;


        }

        #myvTab .nav-tabs .nav-item .nav-link:hover {
            background: #f5f5f5;
        }

        #myvTab .nav-tabs .nav-item .nav-link.active i,
        .nav-tabs .nav-item .nav-link:active i {
            color: #228ae8 !important;
        }

        #myvTab .nav-tabs .nav-item .nav-link i,
        .nav-tabs .nav-item .nav-link i {
            color: #495057;
        }

        #myvTab .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            background: white;
            font-size: 15px !important;
        }

        #myvTab .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #e0efff !important;
            border-color: transparent !important;
        }

        #myvTab .nav-tabs .nav-link {
            color: #646c9a !important;
            border: 0px solid transparent;
            border-top-left-radius: 0rem !important;
            border-top-right-radius: 0rem !important;
        }

        #myvTab .nav-tabs .nav-item .nav-link:hover {
            border: 0px solid transparent;
            border-radius: 0px;
        }

        #myvTab .nav-tabs .nav-item .nav-link.active {
            border-top: 0px solid transparent;
            border-radius: 0px;
            color: #228ae8 !important;
            background: #eff6ff !important;
        }

        #alertMessage {
            padding-left: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex">
        <div class="col-md-12">
            @if (isset($err_string))
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-danger d-flex align-items-center mt-2" role="alert" style="margin-bottom: 0px;">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                </div>
            @endif
        </div>
    </div>
    <!-- begin:: Content -->
    <div class="d-flex mt-2">
        <!--begin::Aside-->
        <div class="col-md-3 border-right h-100" id="kt_profile_aside">
            <!--begin::Profile Card-->
            <div class="card card-custom">
                <!--begin::Body-->
                <div class="card-body pt-4">
                    <!--begin::User-->
                    <div class="d-flex align-items-center">

                        <div class="col-4 px-0">
                            <img id="profile_page_pic"
                                 style="min-width:72px;max-width:100%;border-radius:7px;max-height:150px;"
                                 src="{{ Auth::user()->employee ? Auth::user()->employee->profile_picture() : asset('images/no.png') }}"
                                 alt="">
                        </div>
                        <div class="col-8">
                            <a href="#"
                               class="font-weight-bold font-size-h5 text-dark text-hover-primary">{{ Auth::user()->employee->full_name_bng ?? Auth::user()->username }}</a>
                            <div class="">{{ Auth::user()->current_designation->designation ?? '' }}</div>
                            <div class="">
                                {{ Auth::user()->current_designation->office_info->office_name_bng ?? '' }}</div>
                        </div>
                    </div>
                    <!--end::User-->
                    <!--begin::Contact-->
                    <div class="pt-4 pb-5 pro-con-sec">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="font-weight-bold ml-0 text-grey">{{ __('Email :') }}</span>
                            <span class=" text-grey">{{ Auth::user()->employee->personal_email ?? '' }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="font-weight-bold ml-0 text-grey">{{ __('Phone :') }}</span>
                            <span class=" text-grey">{{ Auth::user()->employee->personal_mobile ?? '' }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="font-weight-bold ml-0 text-grey">{{ __('User Id :') }}</span>
                            <span class=" text-grey">{{ Auth::user()->username ?? '' }}</span>
                        </div>
                    </div>
                    <!--end::Contact-->
                    <!--begin::Nav-->
                    <div class="" id="myvTab">
                        <ul class="nav nav-tabs" role="tablist">
                            @if (Auth::user()->user_role_id == config('menu_role_map.user'))
                                <li class="nav-item">
                                    <a id="datainfoview"
                                       onclick="profileManager('{{ url('change-profile/overview') }}', 'datainfoview')"
                                       class="nav-link active d-flex" data-toggle="tab" href="#home" role="tab"
                                       aria-controls="home">
                                        <div><i class="fa fa-list"></i></div>
                                        <div style="margin-top:2px;">Information</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="signatureBtn"
                                       onclick="profileManager('{{ url('change-profile/signature') }}', 'signatureBtn')"
                                       class="nav-link  d-flex pointer" data-toggle="tab" role="tab" aria-controls="">
                                        <div><i class="fa fa-sign"></i></div>
                                        <div style="margin-top:2px;">Signature</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="digitalCaBtn"
                                       onclick="profileManager('{{ url('change-profile/digital-certificate') }}', 'signatureBtn')"
                                       class="nav-link  d-flex pointer" data-toggle="tab" role="tab" aria-controls="">
                                        <div><i class="fa fa-sign"></i></div>
                                        <div style="margin-top:2px;">Digital Certificate</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="passBtn"
                                       onclick="profileManager('{{ url('change-profile/pass-area') }}', 'passBtn')"
                                       class="nav-link  d-flex pointer" data-toggle="tab" role="tab" aria-controls="">
                                        <div><i class="fa fa-lock"></i></div>
                                        <div style="margin-top:2px;">Password</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="imgBtn"
                                       onclick="profileManager('{{ url('change-profile/image') }}', 'imgBtn')"
                                       class="nav-link  d-flex pointer" data-toggle="tab" role="tab" aria-controls="">
                                        <div><i class="fa fa-file-image"></i></div>
                                        <div style="margin-top:2px;">Profile Picture</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="protikolpoBtn"
                                       onclick="profileManager('{{ url('change-profile/protikolpo') }}', 'protikolpoBtn')"
                                       class="nav-link  d-flex pointer" data-toggle="tab" role="tab" aria-controls="">
                                        <div><i class="fa fa-user-circle"></i></div>
                                        <div style="margin-top:2px;">protikolpo</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="workHistoryBtn"
                                       onclick="profileManager('{{ url('change-profile/work-history') }}', 'workHistoryBtn')"
                                       class="nav-link  d-flex pointer" data-toggle="tab" role="tab" aria-controls="">
                                        <div><i class="fa fa-file-image"></i></div>
                                        <div style="margin-top:2px;">Work History</div>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a id="passBtn"
                                       onclick="profileManager('{{ url('change-profile/pass-area') }}', 'passBtn')"
                                       class="nav-link d-flex active" href="#home" data-toggle="tab" role="tab"
                                       aria-controls="home">
                                        <div><i class="fa fa-lock"></i></div>
                                        <div style="margin-top:2px;">Password</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="imgBtn"
                                       onclick="profileManager('{{ url('change-profile/image') }}', 'imgBtn')"
                                       class="nav-link  d-flex pointer" data-toggle="tab" role="tab" aria-controls="">
                                        <div><i class="fa fa-file-image"></i></div>
                                        <div style="margin-top:2px;">Profile Picture</div>
                                    </a>
                                </li>
                            @endif
                            {{-- <li class="nav-item">
                                <a id="notificationBtn"
                                    onclick="profileManager('{{ url('change-profile/notification') }}', 'notificationBtn')"
                                    class="nav-link  d-flex pointer" data-toggle="tab" role="tab" aria-controls="">
                                    <div><i class="fa fa-marker "></i></div>
                                    <div style="margin-top:2px;">নোটিফিকেশন</div>
                                </a>
                            </li> --}}

                        </ul>
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Profile Card-->
        </div>
        <!--end::Aside-->
        <!--begin::Content-->
        <div class="col-md-9 profile_area">
            <!--begin::Card-->

        </div>
        <!--end::Content-->
    </div>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            $('body').hasClass('kt-aside--enabled') ? $('body').addClass('kt-aside--fixed kt-aside--minimize') : '';
        });

        //change checkbox value "on" to "1"
        $('input[type="checkbox"]').on('change', function () {
            this.value ^= 1;
        });

        $('.date').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        if ({{ Auth::user()->user_role_id }} == {{ config('menu_role_map.user') }}) {
            $(document).ready(function () {
                $('#datainfoview').click()
            });
        } else {
            $(document).ready(function () {
                $('#passBtn').click()
            });
        }


        function profileManager(url, btn) {
            $("#myvTab a").each(function (index) {
                $(this).removeClass('active')
            })
            $(`#${btn}`).addClass('active')

            ajaxCallAsyncCallback(url, '', 'html', 'post', function (resp) {
                $('.profile_area').html(resp);
            });
        }

        @if (session('success'))
        toastr.success('{{ session('success') }}');
        // Swal.fire({
        //     icon: 'success',
        //     title: '{{ session('success') }}',
        //     text: ''
        // });
        @endif

        @if (session('error'))
        toastr.error('{{ session('error') }}');
        // Swal.fire({
        //     icon: 'error',
        //     title: '{{ session('error') }}',
        //     text: ''
        // });
        @endif
        @if (session('password-reminder'))
        toastr.warning('{{ session('password-reminder') }}')
        // Swal.fire({
        //     icon: 'warning',
        //     title: '{{ session('password-reminder') }}',
        //     text: ''
        // });
        @endif

        @if ($errors->any())
            @php
                $str = '';
            @endphp
            @foreach ($errors->all() as $error)
                @php
                    $str .= $error . "\r\n";
                @endphp
            @endforeach
        @endif
    </script>
@endsection
