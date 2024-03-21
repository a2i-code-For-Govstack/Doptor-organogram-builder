@extends('master')
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
            border-bottom: 1px solid #d2eaff;
            background: #ECF6FF;
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
    </style>
@endsection

@section('content')
    <div class="card card-custom">
        <!--begin::Header-->
        <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
            <div class="col-md-6">
                <div class="title py-2">
                    <h4 class="mb-0 font-weight-bold"><i class="fas fa-list mr-3"></i>New User</h4>
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form class="form add_user_form">
            <!--begin::Body-->
            <div class="card-body" id="kt_profile_scroll">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">{{__('User Login Name')}}<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-9 col-xl-9">
                                <input id="username" type="text" class="form-control form-control-lg form-control-solid"
                                       placeholder="Login Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">{{__('New Password')}}<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-9 col-xl-9">
                                <input id="password" type="password"
                                       class="form-control form-control-lg form-control-solid checkPasword"
                                       onkeyup="getPassword(this)"
                                       placeholder="{{__('New Password')}}">
                                <div onclick="togglePassword(this)"
                                     style="margin-top: -25px;display: block;margin-right: 15px;position: absolute;cursor: pointer;right: 0;">
                                    <i class="fa fa-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">{{ __('Repeat Password') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-9 col-xl-9">
                                <input id="confirm_password" type="password"
                                       class="form-control form-control-lg form-control-solid"
                                       placeholder="{{  __('Repeat New Password') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">{{ __('User Role') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-9 col-xl-9">
                                <select id="user_role_id" class="form-control">
                                    <option selected value="0">--Choose--</option>
                                    <option value="1">Super Admin</option>
                                    <option value="2">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label
                                class="col-xl-3 col-lg-3 col-form-label text-alert">{{ __('Attach the officer') }}
                                <span class="text-danger">*</span></label>

                            <div class="col-lg-7 col-xl-7">
                                <input type="text" id="user_search_for_superadmin"
                                       class="form-control form-control-solid form-control-solid"
                                            placeholder="Give User Id">
                            </div>
                            <div class="col-lg-2 col-xl-2">
                                <button type="button" class="btn btn-primary btn-sm btn-square"
                                        id="employee_search_btn"><i
                                        class="fa fa-search"></i> {{ __('Search') }}</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-alert"></label>
                            <div class="col-lg-5 col-xl-5">
                                <p class="mt-2 mb-2"><span id="employee_name"></span>
                                    <button class="btn btn-danger btn-sm btn-square" id="remove_employee_btn"
                                            type="button"
                                            style="display: none;">
                                        <i class="fa fa-trash"></i>{{ __('Cancel') }}
                                    </button>
                                </p>
                                <p class="mt-2 mb-2"><span id="employee_email"></span></p>
                                <input type="hidden" name="employee_record_id" id="employee_record_id">
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-end">
                            <div class="btn-group">
                                <button onclick="storeUser(event)" id="submitBtnP" disabled
                                        class="btn btn-success btn-sm btn-square"><i
                                        class="fa fa-save"></i>{{ __('Save')}}</button>

                                <button type="button" class="btn btn-danger reset-btn"><i class="fas fa-sync  mr-2"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #FFF4DE;" class="card card-custom card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body alert alert-custom alert-light-warning">
                                <!--begin::Item-->
                                <div class="">
                                    <p id="pass_strength_length" class="text-danger align-items-center correct-text"><i
                                            class="fas fa-times text-danger mr-2"></i> {{ __('At least 8 characters')}}</p>
                                    <p id="pass_strength_lowercase" class="text-danger align-items-center small-letter">
                                        <i
                                            class="fas fa-times text-danger  mr-2"></i> {{ __('At least 1 lowercase letter') }}
                                    </p>
                                    <p id="pass_strength_uppercase"
                                       class="text-danger align-items-center capital-letter"><i
                                            class="fas fa-times text-danger  mr-2"></i> {{ __('At least 1 uppercase letter') }}
                                    </p>
                                    <p id="pass_strength_number" class="text-danger align-items-center number-check"><i
                                            class="fas fa-times text-danger  mr-2"></i> {{ __('At least 1 number') }}
                                    </p>
                                    <p id="pass_strength_special"
                                       class="text-danger align-items-center special-characters mb-0"><i
                                            class="fas fa-times text-danger  mr-2"></i> {{ __('At least 1 special character') }}
                                    </p>
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </form>
        <!--end::Form-->
    </div>

    <script>
        function storeUser(e) {
            e.preventDefault();
            url = "{{ route('user.store') }}";
            data = {
                "user_role_id": $('#user_role_id').val(),
                "username": $('#username').val(),
                "password": $('#password').val(),
                "confirm_password": $('#confirm_password').val(),
                "employee_record_id": $('#employee_record_id').val(),
            };

            ajaxCallAsyncCallback(url, data, 'json', 'post', function (resp) {
                if (resp.status === 'success') {
                    Swal.fire({
                        type: "success",
                        title: resp.msg,
                        text: '',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('.reset-btn').click();
                    $('#remove_employee_btn').click();
                } else {
                    if (resp.statusCode === '422') {
                        errors = resp.msg;
                        $.each(errors, function (k, v) {
                            if (v !== '') {
                                toastr.error(v);
                            }

                        });
                    } else {
                        toastr.error(resp.msg);
                    }
                }
            });
        }

        $(document).on('blur', '#user_search_for_superadmin', function () {
            if ($('#user_search_for_superadmin').val()) {
                if (!isNaN($('#user_search_for_superadmin').val())) {
                    username = $('#user_search_for_superadmin').val();
                    start = username.substr(0, 1);
                    restof = username.substr(1);
                    username = start + str_pad(restof, 11);
                    $('#user_search_for_superadmin').val(username);

                }
            }
        });

        $(document).on('blur', '#username', function () {
            if ($('#username').val()) {
                username = $('#username').val();
                username = username.replace(/\s/g, "");
                $('#username').val(username);
            }
        });


        $('#employee_search_btn').click(function () {
            keyword = $('#user_search_for_superadmin').val()
            if (keyword) {
                ajaxCallAsyncCallback("{{ url('get_user_by_username_or_alias') }}", {keyword}, 'json', 'post', function (resp) {
                    if (resp.status === 'success') {
                        $('#remove_employee_btn').show();
                        $('#employee_name').html(resp.data.full_name_bng);
                        $('#employee_email').html(resp.data.personal_email);
                        $('#employee_record_id').val(resp.data.id);
                    } else {
                        $('#remove_employee_btn').hide();
                        $('#employee_name').html('');
                        $('#employee_email').html('');
                        $('#employee_record_id').val('');
                        toastr.error(resp.msg);
                    }
                });
            } else {
                $('#remove_employee_btn').hide();
                $('#employee_name').html('');
                $('#employee_record_id').val('');
            }

        });


        $('.reset-btn').click(function () {
            clearForm('.add_user_form');
            $('#remove_employee_btn').click();
            $('#user_role_id').val(0);
        })

        $('#remove_employee_btn').click(function () {
            $('#user_search_for_superadmin').val('');
            $('#employee_name').html('');
            $('#employee_email').html('');
            $('#employee_record_id').val('');
            $('#remove_employee_btn').hide();
        });
    </script>
@endsection
