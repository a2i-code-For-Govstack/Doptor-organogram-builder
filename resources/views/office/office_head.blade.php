@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3">
                <button id="btn-advance-search" class="btn btn-sna-header-button-color py-0  d-flex">
                    <div>
                        <i class="fa fa-search mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">Search</p>

                    </div>
                </button>
            </div>
            <div>
                <h3 class="text-white my-1">Doptor Head Selection </h3>
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
                    <div style="display: none;" class="card custom-card rounded-0 shadow-sm advance_search ">
                        <div class="card-body">
                            <form onsubmit="searchData(this, 'search_office_head'); return false;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input class="form-control rounded-0" placeholder="Name (Others)" type="text"
                                                   id="name_bng" name="name_bng">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input class="form-control rounded-0" placeholder="name(English)" type="text"
                                                   id="name_eng" name="name_eng">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input class="form-control rounded-0" placeholder="Login Id" type="text"
                                                   id="loginId" name="loginId">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input class="form-control rounded-0" placeholder="Nid Number"
                                                   type="text" id="nid" name="nid">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button id="searchEmployee" class="btn btn-primary" type="submit">Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <x-office-select grid="3" unit="false"/>

            <div class="kt-portlet__body mt-2">
                <div id="list_div" class="load-table-data" data-href="get_office_head">

                </div>
            </div>

        </div>

        <!-- end:: Content -->
    </div>

    <script !src="">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            if ($(".load-table-data").length > 0) {
                loadData($('#office_id').val());
            }
        });

        $("select#office_id").change(function () {
            loadData($('#office_id').val());
        });

        function loadData(office_id) {

            url = $(".load-table-data").data('href');

            var data = {office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                $(".load-table-data").html(responseDate);
            });
        }

        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                $("#list_div").html(responseData);
            });
        }


    </script>
@endsection
