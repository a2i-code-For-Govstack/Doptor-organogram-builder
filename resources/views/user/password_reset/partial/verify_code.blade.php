<div class="pb-5 d-none" id="verify_code">
    <!--begin::Title-->
    <div class="pt-lg-0 pt-5 pb-15">
        <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Complete</h3>
        <div class="text-muted font-weight-bold font-size-h4">Complete Your Signup And
            Become A Member!
        </div>
    </div>
    <!--end::Title-->

    <div class="row">

    </div>

    <div class="row">
        <div class="col-xl-6 d-none">
            <div class="form-group">
                <button type="button"
                        class="d-none btn btn-light font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                        id="verify_code_prev">
                    <span class="svg-icon svg-icon-md ml-2">
                        @include('user.password_reset.partial.previousbutton')
                    </span>Previous
                </button>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="form-group float-right">
                <a href="{{url('/')}}">
                    <button type="button"
                            class="d-none btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                            id="verify_code_submit">Login
                        <span class="svg-icon svg-icon-md ml-2">
                        @include('user.password_reset.partial.nextbutton')
                    </span>
                    </button>
                </a>
            </div>
        </div>
    </div>

</div>

