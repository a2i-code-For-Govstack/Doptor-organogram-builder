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
                        <p class="mb-0 pt-1">অনুসন্ধান</p>

                    </div>
                    </button>
            </div>
            <div>
                <h3 class="text-white my-1">অফিস শাখার ধরনের তালিকা</h3>
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
                        <p class="mb-0 pt-1">শাখার ধরন তৈরি করুন</p>

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
                    <div class="card custom-card shadow-sm w-100 advance_search">
                        <div class="card-header">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="card-body">
                            <form onsubmit="searchData(this, 'search_unit_category'); return false;">
                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input placeholder="ধরন (বাংলা)" id="name_bn" class="form-control rounded-0 bangla" type="text" name="name_bn">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input placeholder="ধরন (ইংরেজি)" id="name_en" class="form-control rounded-0 english" type="text" name="name_en">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary">অনুসন্ধান</button>
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Begin::Row-->
             <div id="list_div" class="load-table-data" data-href="/getOfficeUnitCategory"></div>

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
            <h5 class="kt_quick_panel__title mb-0">
                প্রশাসনিক বিভাগ সম্পাদনা </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form onsubmit="submitData(this, '{{route('office_unit_category.store')}}'); return false;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category_name_bng">ধরন (বাংলা)</label><span class="text-danger">*</span>
                            <input id="category_name_bng" class="form-control rounded-0 bangla" type="text"
                                   name="category_name_bng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category_name_eng">ধরন (ইংরেজি)</label><span class="text-danger">*</span>
                            <input id="category_name_eng" class="form-control rounded-0 english" type="text"
                                   name="category_name_eng" required>
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <div class="kt-checkbox-list">
                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                    <input id="status" name="status" type="checkbox" value="0"> অবস্থা
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ
                                </button>
                                <a id="reset_btn" class="btn  btn-danger text-white"><i class="fas fa-sync  mr-2"></i> রিসেট
                                    </a>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="category_id" name="id">
                    <input type="hidden" id="created_by" name="created_by" value="0">
                    <input type="hidden" id="modified_by" name="modified_by" value="0">
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
        $("#kt_quick_panel_close_btn").click(function () {
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

        $("#reset_btn").click(function(){
                var category_id = $('#category_id').val();
                if(category_id){
                    $('#category_id'+category_id).click();
                }else{
                    $('.create-posasonik').click();
                }
            });

        $(".create-posasonik").click(function () {
            $('#category_name_bng').val('');
            $('#category_name_eng').val('');
            $('#category_id').val('');
            $('.kt_quick_panel__title').text('অফিস শাখার ধরন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var id = content_value[0];
            var category_name_bng = content_value[1];
            var category_name_eng = content_value[2];
            $('#category_name_bng').val(category_name_bng);
            $('#category_name_eng').val(category_name_eng);
            $('#category_id').val(id);
            $(".kt_quick_panel__title").text('অফিস শাখার ধরন সম্পাদন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
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
        $('#btn_excel_generate').on('click',function (){
            var url = 'generate_unit_category_excel_file';
            var data = {};
            var datatype = 'json';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                window.open(responseDate.full_path,'_blank' );
            });
        });
        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $("#list_div").html(responseData);
            });
        }

        function deleteItem(id) {
            var confirmation = confirm("Are you sure you want to delete?");
            if (confirmation) {
                var data = {id};
                var datatype = 'json';

                ajaxCallAsyncCallback('category_delete', data, datatype, 'GET', function (responseDate) {
                    if (responseDate.status === 'success') {
                        loadData();
                        toastr.success(responseDate.msg);
                        $("#kt_quick_panel_close_btn").trigger('click');
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            } else
                toastr.error(responseDate.msg);
            return false;
        }
    </script>
@endsection
