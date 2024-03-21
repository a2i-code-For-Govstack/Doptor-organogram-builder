@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Office Admin Responsibilities History</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->

            <!--Begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0">
                        <div class="card-body">
                                <x-office-select grid="3" unit="false"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card custom-card round-0">
                                        <div class="card-body" id="admin_log_history">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--End::Row-->

            <!--Begin::Row-->
            <div class="row">
            </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <script !src="">

        $("select#office_id").change(function () {
            var office_id = $(this).children("option:selected").val();
            loadAdminLog(office_id);
        });

        function loadAdminLog(office_id) {
            var url = 'office_admin_responsibility_log_list';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                $("#admin_log_history").html(responseData);
            });
        }
    </script>
@endsection
