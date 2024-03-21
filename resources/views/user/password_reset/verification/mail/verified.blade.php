<div class="row">
    <div class="col-md-7">
        <form class="form" novalidate="novalidate" id="kt_login_signup_form">
            <div class="form-group">
                <label class="font-size-h3 font-weight-bolder text-dark">নতুন পাসওয়ার্ড</label>
                <input type="password"
                       class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                       name="newPassword"
                       onkeyup="getPassword(this)" placeholder="নতুন পাসওয়ার্ড" id="newPassword"/>
                <div onclick="togglePassword(this)"
                     style="margin-top: -42px;display: block;margin-right: 15px;position: absolute;cursor: pointer;right: 0;">
                    <i class="fa fa-eye"></i>
                </div>
            </div>
            <div class="form-group">
                <label class="font-size-h3 font-weight-bolder text-dark">পুনরায় পাসওয়ার্ড</label>
                <input type="password"
                       class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                       name="confirmPassword" placeholder="পুনরায় পাসওয়ার্ড" id="confirmPassword"/>
            </div>
            <input type="hidden" id="x-header-id" value="{{$userId}}">
            <button type="button"
                    onclick="newPasswordSubmit()"
                    class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3 float-right"
                    id="new_password_submit">সংরক্ষণ
                <span class="svg-icon svg-icon-md ml-2">
                                        @include('user.password_reset.partial.nextbutton')
                                    </span>
            </button>
        </form>
        <!--end::Form-->
    </div>
    <div class="col-md-5">
        <div class="validation-message">
            <div style="background: #FFF4DE;" class="card card-custom card-stretch">
                <!--begin::Body-->
                <div class="card-body alert alert-custom alert-light-warning">
                    <!--begin::Item-->
                    <div class="">
                        <p id="pass_strength_length" class="text-danger align-items-center correct-text"><i
                                class="fas fa-times text-danger mr-2"></i> {{ __('কমপক্ষে ৮টি অক্ষর')}}</p>
                        <p id="pass_strength_lowercase" class="text-danger align-items-center small-letter">
                            <i
                                class="fas fa-times text-danger  mr-2"></i> {{ __('কমপক্ষে ১টি ছোট হাতের অক্ষর') }}
                        </p>
                        <p id="pass_strength_uppercase"
                           class="text-danger align-items-center capital-letter"><i
                                class="fas fa-times text-danger  mr-2"></i> {{ __('কমপক্ষে ১টি বড় হাতের অক্ষর') }}
                        </p>
                        <p id="pass_strength_number" class="text-danger align-items-center number-check"><i
                                class="fas fa-times text-danger  mr-2"></i> {{ __('কমপক্ষে ১টি সংখ্যা') }}
                        </p>
                        <p id="pass_strength_special"
                           class="text-danger align-items-center special-characters mb-0"><i
                                class="fas fa-times text-danger  mr-2"></i> {{ __('কমপক্ষে ১টি বিশেষ অক্ষর') }}
                        </p>
                    </div>
                    <!--end::Item-->
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
</div>
