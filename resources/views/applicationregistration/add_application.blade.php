@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid bg-light-primary" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">

                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">

                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">

                        <!--begin::Page Title-->
                        <h5 class="text-info  my-1 mr-5">অ্যাপ্লিকেশন নিবন্ধন</h5>

                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>

                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-body">
                            <form id="application_create_form">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="application_name_en">এপ্লিকেশন নাম</label>
                                            <input id="application_name_en" required class="form-control rounded-0"
                                                   value=""
                                                   type="text" name="application_name_en">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="application_name_bn">এপ্লিকেশন নাম (বংলা)</label>
                                            <input id="application_name_bn" required class="form-control rounded-0"
                                                   value=""
                                                   type="text" name="application_name_bn">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="url">ইউআরএল</label>
                                            <input id="url" required class="form-control rounded-0"
                                                   value="" type="text"
                                                   name="url">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="redirect_url">রিডায়রেক্ট ইউআরএল </label>
                                            <input id="redirect_url" class="form-control rounded-0"
                                                   value="" type="text"
                                                   name="redirect_url">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="default_page_url">ডিফল্ট পেজ</label>
                                            <input id="default_page_url" class="form-control rounded-0"
                                                   value=""
                                                   type="text"
                                                   name="default_page_url">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="logout_url">লগ-আউট লিঙ্ক</label>
                                            <input id="logout_url" class="form-control rounded-0"
                                                   value="" type="text"
                                                   name="logout_url">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="api_url">এপিআই লিঙ্ক</label>
                                            <input id="api_url" class="form-control rounded-0"
                                                   value="" type="text"
                                                   name="api_url">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mobile_number">মোবাইল</label>
                                            <input id="mobile_number" required class="form-control rounded-0"
                                                   value=""
                                                   type="text"
                                                   name="mobile_number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email_address">ইমেইল</label>
                                            <input id="email_address" required class="form-control rounded-0"
                                                   value=""
                                                   type="text"
                                                   name="email_address">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="slo_url">এস ওল ও লিঙ্ক</label>
                                            <input id="slo_url" class="form-control rounded-0"
                                                   value="" type="text"
                                                   name="slo_url">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sync_api_url">সিঙ্ক এপিআই লিঙ্ক</label>
                                            <input id="sync_api_url" class="form-control rounded-0"
                                                   value="" type="text"
                                                   name="sync_api_url">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="logo_url">লোগো লিঙ্ক</label>
                                            <input id="logo_url" class="form-control rounded-0"
                                                   value="" type="text"
                                                   name="logo_url">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="kt-checkbox-list" style="margin-top: 35px">
                                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                    <input id="application_status"
                                                           type="checkbox" value="1" checked>
                                                    অনুমোদিত
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="kt-checkbox-list" style="margin-top: 35px">
                                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                    <input id="is_widget_show" type="checkbox"
                                                           value="1" checked>
                                                    SSO Widget
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button class="btn btn-primary btn-square" type="button"
                                                id="update_application" onclick="storeApplication()">
                                            সংরক্ষণ
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Content -->
    </div>


    <!-- end::Form Quick Panel -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>
@endsection
@section('js')
    <script>
        function storeApplication() {
            url = '{{url('store_application_registration')}}';
            form = $('#application_create_form');
            data = form.serialize();

            is_widget_show = $('#is_widget_show').is(':checked') ? 1 : 0;
            application_status = $('#application_status').is(':checked') ? 1 : 0;

            data += '&is_widget_show=' + is_widget_show;
            data += '&status=' + application_status;

            ajaxCallAsyncCallback(url, data, 'json', 'post', function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            });
        }
    </script>
@endsection
