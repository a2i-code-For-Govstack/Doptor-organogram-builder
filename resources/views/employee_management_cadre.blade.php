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
                <h3 class="text-white my-1">Cadre List</h3>
            </div>
            <div class="mr-3 d-flex">

                <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0  d-flex mr-2" >
                    <div>
                        <i class="fa fa-download my-1 ml-2 mr-0"></i>
                    </div>

                    </button>
                <button  class="btn btn-sna-header-button-color py-0  d-flex create-posasonik" >
                    <div>
                        <i class="fa fa-plus mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1"> Create New Cadre</p>

                    </div>
                    </button>
            </div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">
                <div class="row mb-2">
                <div class="col-md-12">
                    <div style="display:none" class="card custom-card shadow-sm w-100 advance_search">
                        <div class="card-header">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="card-body">
                            <form onsubmit="searchData(this, 'search_cadre'); return false;">
                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input placeholder="Cadre Name (Others)" id="name_bn" class="form-control rounded-0" type="text" name="name_bn">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input placeholder="Cadre Name (English)" id="name_en" class="form-control rounded-0" type="text" name="name_en">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary">Search</button>
                                        </div>
                                    </div>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Begin::Row-->
            <div class="kt-portlet__body">
                <div id="list_div" class="load-table-data" data-href="/getEmployeeCadre"></div>
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
    <!-- begin::Form Quick Panel -->
    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0 col-md-12">
                New Cadre</span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form id="employee_management_cadre_form" onsubmit="submitData(this, '{{route('employee_cadre.store')}}'); return false;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cadre_name_bng">Cadre Name (Others)</label><span class="text-danger">*</span>
                            <input id="cadre_name_bng" class="form-control rounded-0" type="text" name="cadre_name_bng" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cadre_name_eng">Cadre Name (English)</label><span class="text-danger">*</span>
                            <input id="cadre_name_eng" class="form-control rounded-0" type="text" name="cadre_name_eng" required>
                        </div>
                    </div>

{{--                    <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="kt-checkbox-list">--}}
{{--                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">--}}
{{--                                        <input id="status" type="checkbox" name="status" value="0"> অবস্থা--}}
{{--                                        <span></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save</button>
                                <a id="reset_btn" class="btn  btn-danger text-white"><i class="fas fa-sync  mr-2"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="cadre_id" name="id">
                </form>
            </div>
        </div>
    </div>
    <!-- end::Form Quick Panel -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">
        $("#kt_quick_panel_close_btn").click(function(){
            $("#kt_quick_panel").removeAttr('style');
            $("#kt_quick_panel").css('opacity', 0);
            $("#kt_quick_panel").removeClass('kt-quick-panel--on');
            $("html").removeClass("side-panel-overlay");
        });
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
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $(".load-table-data").html(responseDate);
            });
        }

        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });
        $(".create-posasonik").click(function(){
            clearForm('#employee_management_cadre_form');
            $('#cadre_name_bng').val('');
            $('#cadre_name_eng').val('');
            $('#cadre_id').val('');
            $('.kt_quick_panel__title').text('Create New Cadre');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('Edit Cadre');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var id = content_value[0];
            var cadre_name_bng = content_value[1];
            var cadre_name_eng = content_value[2];

            $('#cadre_name_bng').val(cadre_name_bng);
            $('#cadre_name_eng').val(cadre_name_eng);
            $('#cadre_id').val(id);
        });

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                if (responseDate.status === 'success') {
                    loadData();
                    toastr.success(responseDate.msg);
                    $("#kt_quick_panel_close_btn").trigger('click');
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        }


            $('#cadre_name_bng').bangla({ enable: true });

            $("#reset_btn").click(function(){
                var cadre_id = $('#cadre_id').val();
                if(cadre_id){
                    $('#cadre_id'+cadre_id).click();
                }else{
                    $('.create-posasonik').click();
                }
            });

            $('#cadre_name_eng').on('blur',function (){
                var cadre_name_eng = $(this).val();
                // function to check unicode or not
                if (isUnicode(cadre_name_eng) == true) {
                    toastr.warning('Please use English word!');
                    $(this).val('');
                    return false
                }
            });

        $('#btn_excel_generate').on('click',function (){
            var url = 'generate_employee_management_cadre_excel_file';
            var data = {};
            var datatype = 'json';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (response) {
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


        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $("#list_div").html(responseData);
            });
        }

    </script>
@endsection
