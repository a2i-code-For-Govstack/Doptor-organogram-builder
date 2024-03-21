@extends('layouts.flat')

@section('title')
    অফিস তৈরি করুন | দপ্তর
@endsection
@section('style')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          type="text/css">
    <link rel="stylesheet" href="{{asset('assets/plugins/custom/jstree/jstree.bundle.css')}}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.min.css')}}">
    <style>
        .step-line {
            background: #5578eb;
            height: 2px;
            width: 35vw;
            position: absolute;
            top: 30px;
            z-index: 1;
        }

        .nav-pills.custom li {
            background: transparent;
            margin: 0 30px;
            z-index: 2;
        }

        .nav-link.active.custom {
            background-color: transparent;
            color: #007bff;
        }

        .nav-link.custom {
            color: inherit;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 12vw;
        }

        .nav-link.custom span.icon {
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 50px;
            width: 46px;
            height: 46px;
            margin: 0 auto;
            border: 1px solid #007bff;
            box-shadow: 0 0px 10px 0px #007bff;
        }

        .nav-link.custom.active span.icon {
            background-color: #007bff;
            color: #fff;
        }

        .nav-link.custom i {
            font-size: 28px;
        }

        .tab-content.custom {
            display: flex;
            justify-content: center;
        }

        .tab-content.custom .tab-pane {
            width: 50vw;
        }

        @media screen and (min-width: 840px) {
            .tab-content.custom .tab-pane {
                width: 40vw;
            }
        }

        .box {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .alert {
            margin-top: 25px;
            background-color: #fff;
            font-size: 25px;
            font-family: sans-serif;
            text-align: center;
            width: 300px;
            height: 100px;
            padding-top: 150px;
            position: relative;
            border: 1px solid #efefda;
            border-radius: 2%;
            box-shadow: 0px 0px 3px 1px #ccc;
        }

        .alert::before {
            width: 100px;
            height: 100px;
            position: absolute;
            border-radius: 100%;
            inset: 20px 0px 0px 100px;
            font-size: 60px;
            line-height: 100px;
            border: 5px solid gray;
            animation-name: reveal;
            animation-duration: 1.5s;
            animation-timing-function: ease-in-out;
        }

        .alert > .alert-body {
            opacity: 0;
            animation-name: reveal-message;
            animation-duration: 1s;
            animation-timing-function: ease-out;
            animation-delay: 1.5s;
            animation-fill-mode: forwards;
        }

        @keyframes reveal-message {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .success {
            color: green;
        }

        .success::before {
            content: '✓';
            background-color: #eff;
            box-shadow: 0px 0px 12px 7px rgba(200, 255, 150, 0.8) inset;
            border: 5px solid green;
        }

        .error {
            color: red;
        }

        .error::before {
            content: '✗';
            background-color: #fef;
            box-shadow: 0px 0px 12px 7px rgba(255, 200, 150, 0.8) inset;
            border: 5px solid red;
        }

        @keyframes reveal {
            0% {
                border: 5px solid transparent;
                color: transparent;
                box-shadow: 0px 0px 12px 7px rgba(255, 250, 250, 0.8) inset;
                transform: rotate(1000deg);
            }
            25% {
                border-top: 5px solid gray;
                color: transparent;
                box-shadow: 0px 0px 17px 10px rgba(255, 250, 250, 0.8) inset;
            }
            50% {
                border-right: 5px solid gray;
                border-left: 5px solid gray;
                color: transparent;
                box-shadow: 0px 0px 17px 10px rgba(200, 200, 200, 0.8) inset;
            }
            75% {
                border-bottom: 5px solid gray;
                color: gray;
                box-shadow: 0px 0px 12px 7px rgba(200, 200, 200, 0.8) inset;
            }
            100% {
                border: 5px solid gray;
                box-shadow: 0px 0px 12px 7px rgba(200, 200, 200, 0.8) inset;
            }
        }

    </style>
@endsection
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 text-center">
                <img width="80" src="{{asset('assets/img/ndoptor.svg')}}"><span style="font-size: 1.8em" class="ml-2">দপ্তর</span>
            </div>
        </div>
    </div>
    <div class="container mb-3 mt-3" style="min-height: 85vh">
        <div class="row border"
             style="border-color: #007bff82!important;padding-bottom: 3em !important;box-shadow: 0px 0px 10px 1px #007bff6e;">
            <div class="col">
                <ul class="nav nav-pills justify-content-center mb-3 text-center custom border-bottom"
                    id="pills-tab" role="tablist" style="border-color: #007bff82!important;">
                    <div class="step-line"></div>
                    <li class="nav-item">
                        <a class="nav-link active custom" id="pills-1-tab" data-toggle="pill" href="#pills-1"
                           role="tab"
                           aria-controls="pills-1" aria-selected="true">
                            <span class="icon"><i class="fa fa-building"></i></span>
                            <span class="text">অফিস তথ্য</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" id="pills-2-tab" href="#pills-2" role="tab"
                           aria-controls="pills-2" aria-selected="false">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <span class="text">পদবি তৈরি</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" id="pills-3-tab" href="#pills-3" role="tab"
                           aria-controls="pills-3" aria-selected="false">
                            <span class="icon"><i class="fa fa-check"></i></span>
                            <span class="text">সম্পন্ন</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content custom pt-4" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-1" role="tabpanel"
                         aria-labelledby="pills-home-tab">
                        @include('organogram-builder.office-create')
                        <button type="button" class="btn btn-primary btn-next office_create mt-2"
                                data-to="#pills-2-tab">
                            পরবর্তি ধাপ
                        </button>
                    </div>
                    <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-profile-tab">
                        @include('organogram-builder.office-unit-organgram-create')
                        <button type="button" class="btn btn-primary btn-prev mt-2" data-to="#pills-1-tab">
                            পূর্বের ধাপ
                        </button>
                        <button type="button" class="btn btn-primary btn-next organogram_create mt-2"
                                data-to="#pills-3-tab">
                            পরবর্তি ধাপ
                        </button>
                    </div>
                    <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="box" style="margin-top: 0;">
                            <div class="success alert" style="margin-top: 0"></div>
                            <h3>আপনার অফিস তৈরি আবেদন সফলভাবে সম্পন্ন হয়েছে। পরবর্তি আপডেট ইমেইল এ জানানো হবে।</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer.guest-footer')
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="{{asset('assets/js/jquery.bangla.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/jstree/jstree.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/components/extended/treeview.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>

    <script src="{{asset('assets/js/tapp.js')}}"></script>
    <script>
        selected_organograms_count = 0;

        $(document).ready(function () {
            $('.btn-next').on('click', function () {
                is_nextable = false;
                n = $(this).attr('data-to');
                if ($(this).hasClass('office_create')) {
                    ministry_id = $('#office_ministry_id').val()
                    if (ministry_id == '0' || ministry_id == '') {
                        toastr.warning('মন্ত্রণালয় নির্বাচন করুন')
                        return false;
                    }

                    layer_id = $('#office_layer_id').val()
                    if (layer_id == '0' || layer_id == '') {
                        toastr.warning('অফিস পর্যায় নির্বাচন করুন')
                        return false;
                    }

                    origin_id = $('#office_origin_id').val()
                    if (origin_id == '0' || origin_id == '') {
                        toastr.warning('উর্ধ্বতন অফিস নির্বাচন করুন')
                        return false;
                    }

                    if ($('#office_name_eng').val() == '' || $('#office_name_bng').val() == '') {
                        toastr.warning('অফিসের নাম ইনপুট করুন')
                        return false;
                    }

                    if ($('#geo_division_id').val() == '0' || $('#geo_division_id').val() == '') {
                        toastr.warning('বিভাগ নির্বাচন করুন')
                        return false;
                    }
                    if ($('#geo_district_id').val() == '0' || $('#geo_district_id').val() == '') {
                        toastr.warning('জেলা নির্বাচন করুন')
                        return false;
                    }
                    if ($('#geo_upazila_id').val() == '0' || $('#geo_upazila_id').val() == '') {
                        toastr.warning('উপজেলা নির্বাচন করুন')
                        return false;
                    }
                    if ($('#office_mobile').val() == '0' || $('#office_mobile').val() == '' || $('#office_mobile').val().length < 11 || $('#office_mobile').val().length > 14) {
                        toastr.warning('মোবাইল নাম্বার ইনপুট করুন')
                        return false;
                    }
                    if ($('#office_email').val() == '0' || $('#office_email').val() == '' || !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#office_email').val())) {
                        toastr.warning('ইমেইল ইনপুট করুন')
                        return false;
                    }

                    if ($('#office_web').val() == '0' || $('#office_web').val() == '' || !/^(http|https):\/\/[^ "]+$/.test($('#office_web').val())) {
                        toastr.warning('অফিসের ওয়েবসাইট ইনপুট করুন')
                        return false;
                    }

                    is_nextable = true;
                }

                if ($(this).hasClass('organogram_create')) {
                    if (selected_organograms_count == 0) {
                        toastr.warning('অফিস নির্বাচন করুন')
                        return false;
                    }

                    swal.fire({
                        title: 'আপনি কি অফিস তৈরি সম্পন্ন করতে চান?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'হ্যাঁ',
                        cancelButtonText: 'না'
                    }).then((result) => {
                        if (result.value) {
                            $(n).attr('data-toggle', "pill");
                            $(n).trigger('click');
                            is_nextable = true;
                        } else {
                            return false;
                        }
                    });
                }

                if (is_nextable) {
                    $(n).attr('data-toggle', "pill");
                    $(n).trigger('click');
                }
            });
            $('.btn-prev').on('click', function () {
                const n = $(this).attr('data-to');
                $(n).attr('data-toggle', "pill");
                $(n).trigger('click');
            });
        });
    </script>
@endsection
