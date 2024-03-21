<script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $('#username').blur(function () {
        if (!isNaN($('#username').val())) {
            var loginid = $('#username').val();
            var start = loginid.substr(0, 1);
            var restof = loginid.substr(1);
            loginid = start + str_pad(restof, 11);
            $('#username').val(loginid);
        }
    });

    function str_pad(str, max) {
        return str.length < max ? str_pad("0" + str, max) : str;
    }

    $(document).on('click', '#choose_medium_submit', function () {
        chooseMedium();
    })

    function chooseMedium() {
        blockUI('#kt_body')

        let verifyData = $('#phoneMedium').is(':checked') ? $('#phonenumber').val() : $('#emailaddress').val()
        let verifyMedium = $('#phoneMedium').is(':checked') ? 'phone' : 'email'
        let userinfo = $('#username').val();

        let url = '{{ route('password.verificationcode') }}';
        let data = {
            userinfo: userinfo,
            verifyData: verifyData,
            verifyMedium: verifyMedium,
        };
        $.ajax({
            method: 'POST',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (resp) {
                if (resp.statusCode === '200') {
                    if (verifyMedium === 'email') {
                        sendMail(verifyData, userinfo)
                    } else
                        sendOTP(verifyData, userinfo)
                } else {
                    toastr.error(resp.msg)
                }
                unblockUI('#kt_body')
            },
            error: function (resp) {
                var errors = resp.responseJSON;
                $.each(errors.errors, function (k, v) {
                    toastr.error(v);
                });
                unblockUI('#kt_body')
            }
        });
    }

    function sendMail(email, userinfo) {
        let url = '{{ route('password.sendmail') }}';
        let data = {
            email,
            userinfo,
        };
        $.ajax({
            method: 'POST',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (resp) {
                if (resp.statusCode === '200') {
                    emailCodeVerifyArea(userinfo)
                    toastr.success(resp.msg)
                } else {
                    toastr.error(resp.msg)
                }
            },
            error: function (resp) {
                errors = resp.responseJSON;
                $.each(errors.errors, function (k, v) {
                    toastr.error(v);
                });
                unblockUI('#kt_body')
            }
        });
    }

    function sendOTP(phone, userinfo) {
        let url = '{{ route('password.send_otp') }}';
        let data = {
            phone,
            userinfo
        };
        $.ajax({
            method: 'POST',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (resp) {
                if (resp.statusCode === '200') {
                    phoneCodeVerifyArea(userinfo)
                    toastr.success(resp.msg)
                } else {
                    toastr.error(resp.msg)
                }
            }
        });
    }

    function changeVerifyMedium(med) {
        if (med === 'mail') {
            $('#phoneMedium').prop('checked', false);
            $('#emailgroup').removeClass('d-none')
            $('#phonegroup').addClass('d-none')
        } else {
            $('#emailMedium').prop('checked', false);
            $('#phonegroup').removeClass('d-none')
            $('#emailgroup').addClass('d-none')
        }
    }

    function wizardContentControl(prev, next) {
        $(`#${prev}`).addClass('d-none');
        $(`#${next}`).removeClass('d-none');
    }

    function wizardNavControl(prev, next) {
        $(`#${prev}_wizard_nav .wizard-icon`).removeClass('wizard-icon-active');
        $(`#${next}_wizard_nav .wizard-icon`).addClass('wizard-icon-active');
    }

    function wizardProcessButtonControl(prev, next) {
        $(`#${prev}_submit`).addClass('d-none');
        $(`#${next}_prev`).removeClass('d-none');
        $(`#${next}_submit`).removeClass('d-none');
    }

    function wizardControl(prev, next) {
        wizardContentControl(prev, next);
        wizardNavControl(prev, next);
        wizardProcessButtonControl(prev, next);
    }

    function phoneCodeVerifyArea(userinfo) {
        let url = '{{ route('password.phonecodeare') }}';
        let data = {
            userinfo
        };
        $.ajax({
            method: 'POST',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (resp) {
                $('#choose_medium').html(resp)
            }
        });
    }

    function emailCodeVerifyArea(userinfo) {
        let url = '{{ route('password.emailcodeare') }}';
        let data = {
            userinfo
        };
        $.ajax({
            method: 'POST',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (resp) {
                $('#choose_medium').html(resp)
            }
        });
    }

    function newPasswordSubmit() {
        let userId = $('#x-header-id').val()
        let newPass = $('#newPassword').val()
        let confirmPass = $('#confirmPassword').val()
        let url = '{{ route('password.savenew') }}';

        if (newPass === confirmPass) {
            let regx = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*\.]{8,}$/;
            if (newPass.match(regx)) {
                let data = {
                    userId: userId,
                    newPass: newPass
                };
                $.ajax({
                    method: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function (resp) {
                        if (resp.statusCode === '200') {
                            toastr.success(resp.msg);
                            window.location.replace("{{ url('/') }}");
                        } else {
                            toastr.error(resp.msg);
                        }
                    },
                    error: function (resp) {
                        var errors = resp.msg;
                        $.each(errors.errors, function (k, v) {
                            toastr.error(v);
                        });
                    }
                });
            } else {
                toastr.error(
                    'অনুগ্রহ করে কমপক্ষে ৬টি অক্ষর, ১টি বড় হাতের অক্ষর, ১টি ছোট হাতের অক্ষর, ১টি বিশেষ অক্ষর এবং ১টি সংখ্যা প্রদান করুন।'
                );
            }
        } else {
            toastr.error('Please match the two password!')
        }
    }

    function blockUI(el) {
        el = $(el);
        el.block({
            message: '<i class="icon-spinner4 spinner"></i> অপেক্ষা করুন...',
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                cursor: 'wait',
                'box-shadow': '0 0 0 1px #1b2024'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });
    }

    function unblockUI(el) {
        el = $(el);
        el.unblock();
    }

</script>
