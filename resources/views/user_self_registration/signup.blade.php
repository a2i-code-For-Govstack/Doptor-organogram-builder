<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>
    <base href="../../../">
    <meta charset="utf-8"/>
    <title>N Doptor Admin</title>
    <meta name="description" content="Signup page">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="{{asset('assets/css/pages/login/login-1.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset('assets/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/scss/global.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/dtable/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('assets/img/bd.png') }}"/>
    @yield('css')
    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.bangla.js') }}" type="text/javascript"></script>
    <link href="{{ URL::asset('assets/css/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/js/custom.js?='.time()) }}" type="text/javascript"></script>

    @include('partials.google_analytics')
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed">
    @include('partials.header.guest-header')
<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
        <div
            class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

            <!--begin::Content-->
            <div
                class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper pt-0">

                <!--end::Head-->

                <!--begin::Body-->
                <div class="kt-login__body">

                    <!--begin::Signup-->
                    <div class="form-container short-form-container">
                        <form id="register-form"
                                onsubmit="loadDetails(this); return false;"
                                class="form">
                            @csrf
                            <h3 class="text-center">নিবন্ধন করুন</h3>
                            <div class="form-group">
                                <label for="email">ইমেইল</label>
                                <input type="email" id="email" name="email" class="form-control rounded-0"
                                        placeholder="" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="nid">জাতীয় পরিচয়পত্র নম্বর</label>
                                <input type="text" id="nid" name="nid" class="form-control rounded-0"
                                        placeholder="" autocomplete="off" required pattern="[0-9]+" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">জন্ম তারিখ</label>
                                <div class="form-row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            {{-- <label for="year">বছর</label> --}}
                                            <select class="form-control" id="year" name="year" required>
                                                <option value="">বছর</option>
                                                @for ($i = date('Y'); $i >= 1900; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            {{-- <label for="month">মাস</label> --}}
                                            <select class="form-control" id="month" name="month" required>
                                                <option value="">মাস</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option
                                                        value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            {{-- <label for="day">দিন</label> --}}
                                            <select class="form-control" id="day" name="day" required>
                                                <option value="">দিন</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-square">নিবন্ধন করুন</button>
                            </div>
                        </form>
                    </div>

                    <!--start complete signup form-->
                    <div hidden class="form-container">
                        <form id="complete_signup_form"
                              onsubmit="signup(this, '{{ route('signup.store') }}'); return false;"
                              class="kt-form kt-form--label-right">
                            @csrf
                            <div class="kt-portlet__body">
                                <div class="form-group row">
                                    <input type="hidden" id="id" name="id">
                                    <div class="col-lg-6">
                                        <label>জন্ম তারিখ</label><span class="text-danger">*</span>
                                        <input name="date_of_birth" id="date_of_birth" type="text"
                                               class="form-control date"
                                               placeholder="জন্ম তারিখ" autocomplete="off">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="">জাতীয় পরিচয়পত্র নম্বর</label><span class="text-danger">*</span>
                                        <input name="nid" id="complete_signup_nid" type="text"
                                               class="form-control integer_type_positive"
                                               placeholder="জাতীয় পরিচয়পত্র নম্বর">
                                        <span class="text-danger">* জাতীয় পরিচয়পত্র নম্বর ১০ , ১৩ অথবা ১৭ সংখ্যার হতে হবে।</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <label>নামের শুরুর উপাধি (বাংলা) </label>
                                        <div class="kt-input-icon">
                                            <input name="prefix_name_bng" id="prefix_name_bng" type="text"
                                                   class="form-control bangla"
                                                   placeholder="নামের শুরুর উপাধি (বাংলা)"
                                                   onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>নাম (বাংলা) </label><span class="text-danger">*</span>
                                        <div class="kt-input-icon">
                                            <input name="name_bng" id="name_bng" type="text" class="form-control bangla"
                                                   placeholder="নাম (বাংলা)"
                                                   onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <label class="">নামের শুরুর উপাধি (ইংরেজি)</label>
                                        <div class="kt-input-icon">
                                            <input name="prefix_name_eng" id="prefix_name_eng" type="text"
                                                   class="form-control"
                                                   placeholder="নামের শুরুর উপাধি (ইংরেজি)"
                                                   onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="">নাম (ইংরেজি)</label><span class="text-danger">*</span>
                                        <div class="kt-input-icon">
                                            <input name="name_eng" id="name_eng" type="text" class="form-control"
                                                   placeholder="নাম (ইংরেজি)"
                                                   onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>নামের শেষের উপাধি (বাংলা) </label>
                                        <div class="kt-input-icon">
                                            <input name="surname_bng" id="surname_bng" type="text"
                                                   class="form-control bangla"
                                                   placeholder="নামের শেষের উপাধি (বাংলা)"
                                                   onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                        </div>
                                        <p class="mb-0">সম্পূর্ণ নাম (বাংলা): <span class="text-success"
                                                                                    id="full_name_bng"></span></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="">নামের শেষের উপাধি (ইংরেজি)</label>
                                        <div class="kt-input-icon">
                                            <input name="surname_eng" id="surname_eng" type="text" class="form-control"
                                                   placeholder="নামের শেষের উপাধি (ইংরেজি)"
                                                   onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                        </div>
                                        <p class="mb-0">সম্পূর্ণ নাম (ইংরেজি): <span class="text-success"
                                                                                     id="full_name_eng"></span></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>পিতার নাম (বাংলা) </label>
                                        <div class="kt-input-icon">
                                            <input id="father_name_bng" name="father_name_bng" type="text"
                                                   class="form-control bangla" placeholder="পিতার নাম (বাংলা)">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="">পিতার নাম (ইংরেজি)</label>
                                        <div class="kt-input-icon">
                                            <input id="father_name_eng" name="father_name_eng" type="text"
                                                   class="form-control english" placeholder="পিতার নাম (ইংরেজি)">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>মাতার নাম (বাংলা) </label>
                                        <div class="kt-input-icon">
                                            <input id="mother_name_bng" name="mother_name_bng" type="text"
                                                   class="form-control bangla" placeholder="নাম (বাংলা)">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="">মাতার নাম (ইংরেজি)</label>
                                        <div class="kt-input-icon">
                                            <input id="mother_name_eng" name="mother_name_eng" type="text"
                                                   class="form-control english" placeholder="মাতার নাম (ইংরেজি)">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label for="gender">লিঙ্গ</label><span class="text-danger">*</span>
                                        <select id="gender" name="gender" class="form-control select-select2">
                                            <option value="" selected="selected">--বাছাই করুন--</option>
                                            <option value="1">পুরুষ</option>
                                            <option value="2">নারী</option>
                                            <option value="3">অন্যান্য</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="religion">ধর্ম</label>
                                        <select name="religion" id="religion" class="form-control select-select2">
                                            <option value="" selected="selected">--বাছাই করুন--</option>
                                            <option value="Islam">ইসলাম</option>
                                            <option value="Hindu">হিন্দু</option>
                                            <option value="Christian">খ্রিস্টান</option>
                                            <option value="Buddhist">বৌদ্ধ</option>
                                            <option value="Shik">শিখ</option>
                                            <option value="Others">অন্যান্য</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label for="blood_group">রক্তের গ্রুপ </label>
                                        <select name="blood_group" id="blood_group" class="form-control select-select2">
                                            <option value="" selected="selected">--বাছাই করুন--</option>
                                            <option value="O+">ও+</option>
                                            <option value="O-">ও−</option>
                                            <option value="A+">এ+</option>
                                            <option value="A-">এ−</option>
                                            <option value="B+">বি+</option>
                                            <option value="B-">বি−</option>
                                            <option value="AB+">এবি+</option>
                                            <option value="AB-"> এবি-</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="marital_status"> বৈবাহিক অবস্থা </label>
                                        <select id="marital_status" name="marital_status"
                                                class="form-control select-select2">
                                            <option value="" selected="selected">--বাছাই করুন--</option>
                                            <option value="Married">বিবাহিত</option>
                                            <option value="Single">অবিবাহিত</option>
                                            <option value="Widowed">বিধবা</option>
                                            <option value="Separated">বিপত্নীক</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>ব্যক্তিগত ইমেইল</label><span class="text-danger">*</span>
                                        <div class="kt-input-icon">
                                            <input name="personal_email" id="personal_email" type="text"
                                                   class="form-control"
                                                   placeholder="ব্যক্তিগত ইমেইল">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>ব্যক্তিগত মোবাইল নম্বর </label><span class="text-danger">*</span>
                                        <div class="kt-input-icon">
                                            <input name="personal_mobile" id="personal_mobile" type="text"
                                                   class="form-control integer_type_positive"
                                                   placeholder="ব্যক্তিগত মোবাইল"
                                                   maxlength="11">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>চাকুরীতে যোগদানের তারিখ </label>
                                        <input id="joining_date" name="joining_date" type="text"
                                               class="form-control date"
                                               placeholder="যোগদানের তারিখ" value="{{ date('d-m-Y') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>কর্মচারী ধরন</label><span class="text-danger">*</span>
                                        <div class="kt-radio-inline">
                                            <label class="kt-radio kt-radio--solid">
                                                <input id="is_cadre" type="radio" name="is_cadre" value="1">
                                                ক্যাডার
                                                <span></span>
                                            </label>
                                            <label class="kt-radio kt-radio--solid">
                                                <input type="radio" name="is_cadre" value="2"> নন ক্যাডার
                                                <span></span>
                                            </label>
                                            <label class="kt-radio kt-radio--solid">
                                                <input type="radio" name="is_cadre" value="3">জনপ্রতিনিধি
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="cadre_info">
                                    <div class="form-group row">
                                        <div id="employee_cadre_div" class="col-lg-3">
                                            <label for="employee_cadre_id">ক্যাডার টাইপ </label>
                                            <select id="employee_cadre_id" name="employee_cadre_id"
                                                    class="form-control select-select2">
                                                <option value="" selected="selected">--বাছাই করুন--</option>
                                                @foreach ($cadres as $cadre)
                                                    <option
                                                        value="{{ $cadre->id }}">{{ $cadre->cadre_name_bng }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="employee_batch_div" class="col-lg-3">
                                            <label for="employee_batch_id">ব্যাচ নম্বর </label>
                                            <select id="employee_batch_id" name="employee_batch_id"
                                                    class="form-control select-select2">
                                                <option value="" selected="selected">--বাছাই করুন--</option>
                                                @foreach ($batches as $batch)
                                                    <option value="{{ $batch->id }}">{{ $batch->batch_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="employee_grade_div" class="col-lg-3">
                                            <label for="employee_grade">গ্রেড </label><span class="text-danger">*</span>
                                            <select id="employee_grade" name="employee_grade"
                                                    class="form-control select-select2">
                                                <option value="" selected="selected">--বাছাই করুন--</option>
                                                @for ($i = 1; $i <= 20; $i++)
                                                    <option value="{{ $i }}">{{ enTobn($i) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div id="identity_no_div" class="col-lg-3">
                                            <label>পরিচিতি নম্বর </label>
                                            <input id="identity_no" name="identity_no" type="text"
                                                   class="form-control integer_type_positive"
                                                   placeholder="পরিচিতি নম্বর ">
                                        </div>

                                        <div id="appointment_memo_no_div" class="col-lg-6">
                                            <label>নিয়োগ পত্রের স্মারক নম্বর </label>
                                            <input id="appointment_memo_no" name="appointment_memo_no" type="text"
                                                   class="form-control" placeholder="নিয়োগ পত্রের স্মারক নম্বর">
                                        </div>


                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label> কর্মকর্তা ব্যবস্থাপনা </label><span class="text-danger">*</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <x-office-select unit="true" only_office="false" grid="3"/>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="designation_id"> পদ </label>
                                            <select name="designation_id" id="designation_id"
                                                    class="form-control rounded-0 select-select2">
                                                <option value="">--বাছাই করুন--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>পদে যোগদানের তারিখ </label>
                                        {{--                                <span class="text-danger">*</span> --}}
                                        <input id="designation_joining_date" name="designation_joining_date" type="text"
                                               class="form-control date" placeholder="পদে যোগদানের তারিখ"
                                               value="{{ date('d-m-Y') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i>
                                                সংরক্ষণ
                                            </button>
                                            <button type="reset" class="btn  btn-danger btn-square reset"><i
                                                    class="fas fa-sync  mr-2"></i> রিসেট
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::complete signup form-->
                    <!--end::Body-->
                </div>

                <!--end::Content-->
            </div>
        </div>
    </div>
    @include('partials.footer.guest-footer')
</div>

<!-- end:: Page -->
<style>
    .form-group label {
        font-size: 1.3rem;
    }

    html {
        position: relative;
        min-height: 100%;
    }

    body {
        display: flex;
        justify-content: center;
        /* background-color: #f2f2f2 !important; */
        align-items: center;
        height: auto;
        margin-bottom: 100px;
    }

    .form-container {
        width: 80%;
        padding: 60px;
        background-color: #f0f6fb;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: auto;
    }

    .form-container .kt-login__title {
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
    }

    footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #f5f5f5;
        text-align: center;
        padding: 0;
        z-index: 9999;
    }

    header {
        position: sticky;
        top: 0;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #f5f5f5;
        text-align: center;
        padding: 0;
    }

    .short-form-container {
        align-items: center;
        justify-content: center;
        display: inline-block;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        width: 30% !important;
    }

</style>
<!-- begin::Global Config(global config for global JS sciprts) -->

<script>
    function loadData(url = '') {
        if (url === '') {
            url = $(".load-table-data").data('href');
        }
        var data = {};
        var datatype = 'html';
        ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $(".load-table-data").html(responseDate);
            $(".short-form-container").hide();
            $('#complete_signup_form').closest('div').removeAttr('hidden');

            var date = $('#day').val() + '-' + $('#month').val() + '-' + $('#year').val();
            $('#date_of_birth').val(date);
            $('#date_of_birth').prop('readonly', true);

            $('#complete_signup_nid').val($('#nid').val());
            $('#complete_signup_nid').prop('readonly', true);

            $('#personal_email').val($('#email').val());
            $('#personal_email').prop('readonly', true);

        });
    }

    function loadDetails(form) {
        var email = $('#email').val();
        var nid = $('#nid').val();
        var date = $('#year').val() + '-' + $('#month').val() + '-' + $('#day').val();
        var data = {email, nid, date};
        loadData();
    }

    function signup(form, url) {

        var data = $(form).serialize();
        var datatype = 'json';
        ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
            if (responseDate.status === 'success') {
                loadData();
                toastr.success(responseDate.msg);
                $("#kt_quick_panel_close_btn").trigger('click');
                swal.fire({
                    // title: '',
                    text: "আপনার তথ্য সফল ভাবে সংরক্ষণ করা হয়েছে। পরবর্তী তথ্য আপনাকে ইমেইলের মাধ্যমে জানানো হবে।",
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'ঠিক আছে',
                }).then((result) => {
                    window.location.href = "{{ route('dashboard') }}";
                });
            } else {
                toastr.error(responseDate.msg);
            }
        });
    }

    $(document).ready(function () {
        var today = new Date();
        var currentYear = today.getFullYear();
        var currentMonth = today.getMonth() + 1;
        var currentDate = today.getDate();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: new Date(1900, 0, 1),
            endDate: new Date(currentYear, currentMonth, currentDate),
            autoclose: true,
            orientation: "bottom",
            todayHighlight: true,
            language: "en"
        });
    });

    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };

    $("input[name$='is_cadre']").click(function () {
        var cadre = $(this).val();
        if (cadre == 1) {
            $('#appointment_memo_no').val('');
            $('#employee_cadre_div').show();
            $('#employee_grade_div').show();
            $('#employee_batch_div').show();
            $('#identity_no_div').show();
            $('#appointment_memo_no_div').hide();
        } else if (cadre == 2) {
            $('#employee_cadre_div').hide();
            $('#employee_grade_div').show();
            $('#employee_batch_div').hide();
            $('#identity_no_div').hide();
            $('#appointment_memo_no_div').show();
            $('#appointment_memo_no').val('');
            $('#employee_cadre_id').val('');
            $('#employee_batch_id').val('');
            $('#identity_no').val('');
        } else if (cadre == 3) {
            $('#appointment_memo_no').val('');
            $('#employee_cadre_id').val('');
            $('#employee_batch_id').val('');
            $('#identity_no').val('');
            $('#employee_cadre_div').hide();
            $('#employee_grade_div').hide();
            $('#employee_batch_div').hide();
            $('#appointment_memo_no_div').show();
            $('#identity_no_div').hide();
        }
    });

    $("select#office_unit_id").change(function () {
        var office_unit_id = $(this).children("option:selected").val();
        var office_id = $('#office_id').val();
        loadDesignation(office_id, office_unit_id);
    });

    function loadDesignation(office_id, office_unit_id) {
        var url = 'load_designation_for_assignemployee';
        var data = {
            office_id,
            office_unit_id
        };
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#designation_id").html(responseDate);
            $('#loader').hide();
        });
    }

    $(function () {
        var sel_user_options = $("select#user-options"),
            opts = sel_user_options.find('option');

        sel_user_options.bind('change', function (e) {
            e.preventDefault();
            var optselected = $(this).find("option:selected");

            if (optselected.attr('id') == 'other') {
                sel_user_options.after(
                    "<div class='additional'><input class='form-control' id=other name='other' placeholder='টাইপ করুন'/></div>"
                );

                var oth = $("input#other");
                oth.keyup(function (e) {
                    optselected.html($(this).val());
                });
            } else {
                $('.additional').hide();
            }
        });
    });

</script>

<!-- end::Global Config -->

<!--begin::Page Vendors(used by this page) -->
<script src="{{ asset('assets/plugins/dtable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/dtable/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/plugins/custom/datatables/unchanged/colResizable-1.5.min.js') }}"
        type="text/javascript"></script>

<!--end::Page Vendors -->
<link href="{{ asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.init.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/components/extended/sweetalert2.js') }}" type="text/javascript"></script>
<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/js/pages/dashboard.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/components/extended/treeview.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/tapp.js') }}" type="text/javascript"></script>

<!--begin::Page Scripts(used by this page) -->
<script src="{{asset('assets/js/custom.js')}}" type="text/javascript"></script>

<!--end::Page Scripts -->


<!-- end::Body -->
</body>

<!-- end::Body -->
</html>
