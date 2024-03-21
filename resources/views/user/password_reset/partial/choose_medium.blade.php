<div class="pb-5 d-none" id="choose_medium">
    <div class="pt-lg-0 pt-5 pb-15">
        <div class="text-muted font-weight-bold font-size-h4">ভেরিফিকেশন মাধ্যম বাছাই করুন এবং প্রয়োজনীয় নির্দেশনা অনুসরন করুন।</div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="form-group row">
                <div class="col-6 col-form-label">
                    <div class="radio-list">
                        <label class="radio radio-success radio-rounded">
                            <input type="radio" checked id="emailMedium" onclick="changeVerifyMedium('mail')"/>
                            <span></span>
                            ই-মেইল
                        </label>
                        <div class="input-group" id="emailgroup">
                            <div class="input-group-prepend"><span class="input-group-text"><i
                                        class="fa fa-mailbox icon-lg"></i></span></div>
                            <input type="email" class="form-control" placeholder="ই-মেইল" name="emailaddress" id="emailaddress"/>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-form-label">
                    <div class="radio-list">
                        <label class="radio radio-success radio-rounded">
                            <input type="radio" id="phoneMedium" onclick="changeVerifyMedium('phone')"/>
                            <span></span>
                            মোবাইল নম্বর
                        </label>
                        <div class="input-group d-none" id="phonegroup">
                            <div class="input-group-prepend"><span class="input-group-text"><i
                                        class="fa fa-phone icon-lg"></i></span></div>
                            <input type="text" class="form-control" placeholder="মোবাইল নম্বর" name="phonenumber" id="phonenumber"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 d-none">
            <div class="form-group">
                <button type="button"
                        class="d-none btn btn-light font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                        id="choose_medium_prev">
                    <span class="svg-icon svg-icon-md ml-2">
                        @include('user.password_reset.partial.previousbutton')
                    </span>পুর্ববর্তী
                </button>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="form-group float-right">
                <button type="button"
                        class="d-none btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                        id="choose_medium_submit">পরবর্তী
                    <span class="svg-icon svg-icon-md ml-2">
                        @include('user.password_reset.partial.nextbutton')
                    </span>
                </button>
            </div>
        </div>
    </div>

</div>

