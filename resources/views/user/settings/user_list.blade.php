@extends('master')
@section('content')

<style>
    @media (max-width: 575.98px) {
    .dataTables_length {
        display: none;
    }
}
</style>
    <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">
            <div class="ml-3">
                {{-- Uncomment if needed --}}
                {{-- <button id="btn-advance-search" class="btn btn-sna-header-button-color py-0 d-flex">
                    <div>
                        <i class="fa fa-search mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">অনুসন্ধান</p>
                    </div>
                </button> --}}
            </div>
            <div class="text-center w-100">
                <h3 class="text-white my-1">User List</h3>
            </div>
            <div class="mr-3 d-flex">
                {{-- Uncomment if needed --}}
                {{-- <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0 d-flex mr-2">
                    <div>
                        <i class="fa fa-download my-1 ml-2 mr-0"></i>
                    </div>
                </button>
                <button class="btn btn-sna-header-button-color py-0 d-flex create-posasonik">
                    <div>
                        <i class="fa fa-plus mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">নতুন তৈরি করুন</p>
                    </div>
                </button> --}}
            </div>
        </div>
        <!--end::Subheader-->
        
        <!-- begin::Content -->
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="card custom-card shadow-sm advance_search">
                            <div class="card-header">
                                <h5 class="mb-0"></h5>
                            </div>
                            <div class="card-body">
                                <!-- Search content goes here -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--Begin::Row-->
                <div class="kt-portlet__body">
                    <div class="table-responsive">
                        <div id="list_div" class="load-table-data" data-href="/user/get_user_list"></div>
                    </div>
                </div>
                <!--End::Row-->
            </div>
            <!--End::Dashboard 1-->
        </div>
        <!-- end:: Content -->
    </div>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            if ($(".load-table-data").length > 0) {
                loadData();
            }
        });

        function loadData(url = '') {
            if (url === '') {
                url = $(".load-table-data").data('href');
            }
            var data = {};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                $(".load-table-data").html(responseData);
            });
        }
    </script>
@endsection
