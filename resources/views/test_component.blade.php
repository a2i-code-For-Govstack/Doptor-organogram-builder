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
                        <h5 class="text-info  my-1 mr-5">অফিস অ্যাডমিন দায়িত্ব প্রদান</h5>

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

            <!--Begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0">
                        <div class="card-body">
                            <x-office-select grid="3" unit="true" />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card custom-card round-0 border">
                                        {{--                                        <div class="card-header">--}}
                                        {{--                                            <h5>মৌলিক শাখার তালিকা</h5>--}}
                                        {{--                                        </div>--}}
                                        <div class="card-body" id="employee_list_div">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover"
                                                       id="sample_1">
                                                    <thead>
                                                    <tr>
                                                        <th class=""></th>
                                                        <th class="">ক্রমিক নং</th>
                                                        <th class="">নাম</th>
                                                        <th class="">পদবি</th>
                                                        <th class="">শাখা</th>
                                                        <th class="">ইউজারনেম</th>
                                                        <th class="">মোবাইল</th>
                                                        <th class="">ইমেইল</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td class="form-actions" colspan="8"><input
                                                                class="btn btn-md btn-primary" type="button"
                                                                id="assignOfficeAdmin" value="দায়িত্ব প্রদান"></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
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
            loadOfficeUsers(office_id);
        });

        function loadOfficeUsers(office_id) {
            var url = 'load_office_wise_users';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#employee_list_div").html(responseDate);

            });
        }

        $(document).on('click', '#assignOfficeAdmin', function () {
            var office_unit_organogram_id = $("input[name='office_admin']:checked").data("office_unit_organogram_id");
            var url = 'assign_office_admin';
            var data = {office_unit_organogram_id};
            var datatype = 'json';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                if (responseDate.status === 'success') {
                    toastr.success(responseDate.msg);
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        });

    </script>
@endsection
