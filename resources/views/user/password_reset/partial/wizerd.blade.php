<div class="wizard-steps d-flex flex-column flex-sm-row">
    <div class="wizard-step flex-grow-1 flex-basis-0" id="account_find_wizard_nav">
        <div class="wizard-wrapper pr-7">
            <div class="wizard-icon wizard-icon-active">
                <i class="wizard-check ki ki-check"></i>
                <span class="wizard-number">১</span>
            </div>
            <div class="wizard-label">
                <h3 class="wizard-title font-size-h3">ইউজার খুজুন</h3>
                <div class="wizard-desc font-size-h5">আপনার ইউজার আইডি অথবা ইউজার নেম দ্বারা খুজুন।</div>
            </div>
            <span class="svg-icon pl-6">
                @include('user.password_reset.partial.nextbutton')
            </span>

        </div>
    </div>
    <div class="wizard-step flex-grow-1 flex-basis-0" id="choose_medium_wizard_nav">
        <div class="wizard-wrapper pr-7">
            <div class="wizard-icon">
                <i class="wizard-check ki ki-check"></i>
                <span class="wizard-number">২</span>
            </div>
            <div class="wizard-label">
                <h3 class="wizard-title font-size-h3">যাচাই করুন</h3>
                <div class="wizard-desc font-size-h5">ভেরিফিকেশন মাধ্যম বাছাই করুন</div>
            </div>
{{--            <span class="svg-icon pl-6">--}}
{{--                @include('user.password_reset.partial.nextbutton')--}}
{{--            </span>--}}

        </div>
    </div>
{{--    <div class="wizard-step flex-grow-1 flex-basis-0" id="verify_code_wizard_nav">--}}
{{--        <div class="wizard-wrapper pr-7">--}}
{{--            <div class="wizard-icon">--}}
{{--                <i class="wizard-check ki ki-check"></i>--}}
{{--                <span class="wizard-number">3</span>--}}
{{--            </div>--}}
{{--            <div class="wizard-label">--}}
{{--                <h3 class="wizard-title">Verify Your Self</h3>--}}
{{--                <div class="wizard-desc">Verification Process</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
