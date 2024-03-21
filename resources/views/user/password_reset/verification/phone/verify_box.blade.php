<div class="pt-lg-0 pt-5 pb-15">
    <div class="text-muted font-weight-bold font-size-h3">
                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-04-19-122603/theme/html/demo2/dist/../src/media/svg/icons/Communication/Readed-mail.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path
                                            d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                        <path
                                            d="M12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.98630124,11 4.48466491,11.0516454 4,11.1500272 L4,7 C4,5.8954305 4.8954305,5 6,5 L20,5 C21.1045695,5 22,5.8954305 22,7 L22,16 C22,17.1045695 21.1045695,18 20,18 L12.9835977,18 Z M19.1444251,6.83964668 L13,10.1481833 L6.85557487,6.83964668 C6.4908718,6.6432681 6.03602525,6.77972206 5.83964668,7.14442513 C5.6432681,7.5091282 5.77972206,7.96397475 6.14442513,8.16035332 L12.6444251,11.6603533 C12.8664074,11.7798822 13.1335926,11.7798822 13.3555749,11.6603533 L19.8555749,8.16035332 C20.2202779,7.96397475 20.3567319,7.5091282 20.1603533,7.14442513 C19.9639747,6.77972206 19.5091282,6.6432681 19.1444251,6.83964668 Z"
                                            fill="#000000"/>
                                        </g>
                                        </svg>
                                    </span>
        আপনার মোবাইলে ভেরিফিকেশন কোড প্রেরণ করা হয়েছে। অনুগ্রহ করে তা যাচাই করুন।
    </div>
</div>
<form class="form" novalidate="novalidate">
    <div class="form-group">
        <label class="font-size-h3 font-weight-bolder text-dark">ভেরিফিকেশন কোড</label>
        <input type="text"
               class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
               name="phone_verification_code" placeholder="ভেরিফিকেশন কোড" id="phone_verification_code" required/>
        <span id="vcodeError" class="d-none text-danger">ভেরিফিকেশন কোড প্রদান করুন।</span>
    </div>
    <input type="hidden" id="x-header-id" value="{{$userId}}">
    <div id="set_new_password">
        <button type="button"
        class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3 float-right"
        id="verifyPhoneCode">নিশ্চিত করুন
            <span class="svg-icon svg-icon-md ml-2">
            @include('user.password_reset.partial.nextbutton')
        </span>
        </button>
    </div>
</form>

<script>
    $('#verifyPhoneCode').click(function () {
        verifyPhoneCode();
    })

    function verifyPhoneCode() {
        let vCode = $('#phone_verification_code').val();
        let userId = $('#x-header-id').val()
        if (vCode) {
            $('#vcodeError').addClass('d-none')
            let url = '{{route('password.verifypassresetphone')}}';
            let data = {code: vCode, userId: userId};
            $.ajax({
                method: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (resp) {
                    if (resp.status == 'error') {
                        toastr.error(resp.msg)
                    } else {
                        $('#set_new_password').html(resp);
                    }
                }
            });
        } else {
            $('#vcodeError').removeClass('d-none')
        }
    }
</script>
