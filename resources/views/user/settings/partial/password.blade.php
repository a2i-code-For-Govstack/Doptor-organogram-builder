<div class="card card-custom">
    <!--begin::Header-->
    <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
        <div class="col-md-6">
            <div class="title py-2">
                <h4 class="mb-0 font-weight-bold"><i class="fas fa-list mr-3"></i>{{ __('Change Password')}}</h4>
            </div>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form class="form">
        <!--begin::Body-->
        <div class="card-body" id="kt_profile_scroll">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">{{ __('Present Password') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input id="old_password" type="password" class="form-control form-control-lg form-control-solid mb-2"
                                   placeholder="{{ __('Present Password') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">{{__('New Password')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input id="password" type="password" class="form-control form-control-lg form-control-solid checkPasword"
                                   onkeyup="getPassword(this)"
                                   placeholder="{{__('New Password')}}">
                            <div onclick="togglePassword(this)"
                                 style="margin-top: -25px;display: block;margin-right: 15px;position: absolute;cursor: pointer;right: 0;">
                                <i class="fa fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">{{ __('Repeat Password') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input id="confirm_password" type="password" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{  __('Repeat New Password') }}">
                        </div>
                    </div>
                    <div class="mt-5 d-flex justify-content-end">
                        <div class="btn-group">
                            <button onclick="changePass(event)" id="submitBtnP" disabled
                                    class="btn btn-success btn-sm btn-square"><i
                                    class="fa fa-save"></i>{{ __('Save')}}</button>
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
                                        class="fas fa-times text-danger mr-2"></i> {{ __('At least 8 characters.')}}</p>
                                <p id="pass_strength_lowercase" class="text-danger align-items-center small-letter"><i
                                        class="fas fa-times text-danger  mr-2"></i> {{ __('At least 1 lowercase letter.') }}
                                </p>
                                <p id="pass_strength_uppercase" class="text-danger align-items-center capital-letter"><i
                                        class="fas fa-times text-danger  mr-2"></i> {{ __('At least 1 uppercase letter.') }}
                                </p>
                                <p id="pass_strength_number" class="text-danger align-items-center number-check"><i
                                        class="fas fa-times text-danger  mr-2"></i> {{ __('At least 1 number.') }}</p>
                                <p id="pass_strength_special"
                                   class="text-danger align-items-center special-characters mb-0"><i
                                        class="fas fa-times text-danger  mr-2"></i> {{ __('At least 1 special character.') }}
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

    function changePass(e) {
        e.preventDefault();
        var url = "{{ route('password.change') }}";
        var data = {
            "old_password": $('#old_password').val(),
            "password": $('#password').val(),
            "confirm_password": $('#confirm_password').val(),
        };

        ajaxCallAsyncCallback(url, data, 'json', 'post', function (resp) {
            if (resp.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: resp.msg,
                    text: ''
                });
            } else {
                if (resp.statusCode === '422') {
                    var errors = resp.msg;
                    $.each(errors, function (k, v) {
                        if (v !== '') {
                            toastr.error(v);
                        }

                    });
                } else {
                    toastr.error(resp.msg);
                    console.log(resp)
                }
            }
        });

    }
</script>
