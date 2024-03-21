@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3">
                <button id="btn-advance-search" class="btn btn-sna-header-button-color py-0  d-flex" >
                    <div>
                        <i class="fa fa-search mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">Search</p>

                    </div>
                    </button>
            </div>
            <div>
                <h3 class="text-white my-1">Units</h3>
            </div>
            <div class="mr-3 d-flex">

                <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0  d-flex mr-2" >
                    <div>
                        <i class="fa fa-download my-1 ml-2 mr-0"></i>
                    </div>

                    </button>
            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="kt-portlet kt-portlet--mobile" style="margin-bottom: 0">
                <!--Begin::Dashboard 1-->
                <form onsubmit="searchData(this, 'search_unit_by_name'); return false;">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="display: none;" class="card custom-card shadow-sm w-100 advance_search">
                                <div class="card-header">
                                    <h5 class="mb-0"></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input id="bangla" placeholder="Unit Name (Others)"
                                                       class="form-control rounded-0" type="text" name="bangla">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input id="english" placeholder="Unit Name (English)"
                                                       class="form-control rounded-0" type="text" name="english">
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-square">Search</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--Begin::Row-->
                <div class="kt-portlet__body">
                    <x-office-select unit="false" grid="3" only_office="true"/>
                    <div id="list_div" class="load-table-data" data-href="/getUnitNameList"></div>
                </div>
                <!--End::Dashboard 1-->
            </div>

            <!-- end:: Content -->
        </div>

        <script type="text/javascript">
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();

                if ($(".load-table-data").length > 0) {
                    loadData($('#office_id').val());
                }
            });

            $("select#office_id").change(function () {
                loadData($('#office_id').val());
            });

            function loadData(office_id, url = '') {
                if (url === '') {
                    url = $(".load-table-data").data('href');
                }
                var data = {office_id};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'post', function (responseDate) {
                    $(".load-table-data").html(responseDate);
                });
            }

            $('#btn_excel_generate').on('click', function () {
                var url = 'generate_rename_unit_excel_file';
                var data = {};
                var datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (response) {
                    a = document.createElement('a');
                    a.href = response.full_path;
                    a.download = response.file_name;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(a.href);
                    // deleteFile(responseDate.file_name);
                });
            });
            // $(document).on('click', "ul.pagination>li>a", function(e) {
            //     e.preventDefault();
            //     loadData($(this).attr('href'));
            // });
            function searchData(form, url) {
                var data = $(form).serialize();
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $('#list_div').html(responseDate);
                });
            }
        </script>


@endsection
