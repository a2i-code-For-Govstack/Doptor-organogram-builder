<div class="pb-5" id="account_find">
    <div class="pb-10 pb-lg-12">
        <div class="text-muted font-weight-bold font-size-h4">পাসওয়ার্ড ভুলে যান নি?
            <a href="{{ $return_login_url ?: url('/') }}" class="text-primary font-weight-bolder">লগইন</a>
        </div>
    </div>
    <div class="form-group">
        <label class="font-size-h3 font-weight-bolder text-dark">ইউজারনেম অথবা ইউজার আইডি</label>
        <input type="text" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
            name="username" placeholder="ইউজারনেম অথবা ইউজার আইডি" id="username" />
    </div>
</div>

<button type="button" class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3 float-right"
    id="account_find_submit">পরবর্তী
    <span class="svg-icon svg-icon-md ml-2">
        @include('user.password_reset.partial.nextbutton')
    </span>
</button>
