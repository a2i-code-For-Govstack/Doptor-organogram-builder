@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3">
            </div>
            <div>
                <h3 class="text-white my-1">অফিস ভিত্তিক লগইন ট্রাকিং</h3>
            </div>
            <div class="mr-3 d-flex">
            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Row-->
            <div class="kt-portlet__body">
                <x-office-select unit="true" grid="3" only_office="true"/>

                <div id="list_div" class="load-table-data" data-href="{{ route('login_history') }}">

                </div>
            </div>
            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            if ($(".load-table-data").length > 0) {
              //  loadData($('#office_unit_id').val());
            }
        });

        $("select#office_unit_id").change(function () {
            loadData($('#office_unit_id').val());
        });


        function loadData(office_unit_id, url = '') {
            if (url === '') {
                url = $(".load-table-data").data('href');
            }
            var data = {office_unit_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                $(".load-table-data").html(responseDate);
            });
        }

        $('#btn_excel_generate').on('click', function () {
            var url = 'generate_rename_office_designation_excel_file';
            var data = {};
            var datatype = 'json';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                window.open(responseDate.full_path, '_blank');
            });
        });

        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#list_div').html(responseDate);
            });
        }
    </script>


@endsection