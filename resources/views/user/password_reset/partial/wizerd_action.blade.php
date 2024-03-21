<!--begin: Wizard Actions-->
<div class="d-flex justify-content-between pt-7">
    <div class="mr-2">
        <button type="button"
                class="btn btn-light-primary font-weight-bolder font-size-h6 pr-8 pl-6 py-4 my-3 mr-3"
                data-wizard-type="action-prev">
										<span class="svg-icon svg-icon-md mr-2">
											@include('user.password_reset.partial.previousbutton')
										</span>Previous
        </button>
    </div>
    <div>
        <button class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                data-wizard-type="action-submit" type="submit"
                id="kt_login_signup_form_submit_button">Submit
            <span class="svg-icon svg-icon-md ml-2">
											@include('user.password_reset.partial.nextbutton')
										</span></button>
        <button type="button"
                class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                data-wizard-type="action-next">Next
            <span class="svg-icon svg-icon-md ml-2">
											@include('user.password_reset.partial.nextbutton')
										</span></button>
    </div>
</div>
<!--end: Wizard Actions-->
