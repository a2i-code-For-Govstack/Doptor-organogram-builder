@extends('master')
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Office Front Desk</h3>
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
                            @if(Auth::user()->user_role_id == config('menu_role_map.super_admin') || Auth::user()->user_role_id == config('menu_role_map.admin'))
                                <x-office-select grid="4" unit="false"></x-office-select>
                            @else
                                <div class="d-none">
                                    <x-office-select grid="6" unit="false" onlyoffice="true"></x-office-select>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card custom-card round-0 ">
                                        <div class="card-body" id="employee_list_div"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script !src="">

            $(document).ready(function () {
                @if(Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin'))
                loadOfficeUsers('{{Auth::user()->current_office_id()}}')
                @endif
            });

            $("select#office_id").change(function () {
                loadOfficeUsers($('#office_id').val());
            });

            function loadOfficeUsers(office_id, url = '') {
                if (url == '') {
                    url = 'get_office_front_desk_list';
                }
                var data = {office_id};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                    $("#employee_list_div").html(responseDate);

                });
            }

            $(document).on('click', '#assignOfficeFrontDesk', function () {
                var office_unit_organogram_id = $("input[name='office_admin']:checked").data("office_unit_organogram_id");
                var url = 'assign_front_desk';
                var data = {office_unit_organogram_id};
                var datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    if (responseDate.status === 'success') {
                        toastr.success(responseDate.msg);
                        loadOfficeUsers($("#office_id").val());
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            });


        </script>
@endsection
