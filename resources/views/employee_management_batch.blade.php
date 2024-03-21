@extends('master')
@section('content')
@section('css')
<style>
.ui-datepicker-calendar {
    display: none;
    }
    </style>
@endsection
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
                <h3 class="text-white my-1">Batch List</h3>
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
                        <p class="mb-0 pt-1">Create New Batch</p>

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
                            <form onsubmit="searchData(this, 'search_batch'); return false;">
                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input placeholder="Batch Number" id="batch_name" class="form-control rounded-0 integer_type_positive" type="text" name="batch_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input placeholder="Joining Year" id="batch_date" class="form-control rounded-0" type="text" name="batch_date">
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

           <div class="kt-portlet__body">
             <div id="list_div" class="load-table-data" data-href="/getEmployeeBatch"> </div>
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
                New Batch </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form id="employee_management_batch_form" onsubmit="submitData(this, '{{route('employee_batch.store')}}'); return false;">

                <div class="col-md-12">
                        <div class="form-group">
                            <label for="batch_no">Batch Number</label><span class="text-danger">*</span>
                            <input id="batch_no" class="form-control rounded-0 integer_type_positive" type="text" name="" required>
                            <input id="batch_no_hidden" class="form-control rounded-0" type="hidden" name="batch_no" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="batch_year">Joining Year</label>
                            <input id="batch_year" class="date-own form-control" name="" type="text">
                            <input id="batch_year_hidden"  class="form-control" name="batch_year" type="hidden">

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save</button>
                                <a id="reset_btn" class="btn  btn-danger text-white"><i class="fas fa-sync  mr-2"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="batch_id" name="id">
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
        $('.date-own').datepicker({
         minViewMode: 2,
         format: 'yyyy'
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
            clearForm('#employee_management_batch_form');
            $('#batch_no').val('');
            $('#batch_no_hidden').val('');
            $('#batch_year').val('');
            $('#batch_year_hidden').val('');
            $('#batch_id').val('');
            $('.kt_quick_panel__title').text('Create New Batch');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('Edit Batch');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var id = content_value[0];
            var batch_no = content_value[1];
            var batch_year = content_value[2];

            $('#batch_no').val(batch_no);
            $('#batch_no_hidden').val(batch_no);
            $('#batch_year').val(batch_year);
            $('#batch_year_hidden').val(batch_year);
            $('#batch_id').val(id);
        });

        $('#batch_no').on('blur',function (){
            var number = $(this).val();
            if(number.length > 2){
                toastr.error('Not more than 2 number!');
                $(this).val('');
                return;
            }
            var is_uni = isUnicode(number);
            if (is_uni) {
               var converted =  convertBanglaToEnglishNumber(number);
               $('#batch_no_hidden').val(converted);
            }else{
                $('#batch_no_hidden').val(number);
            }
        });

        $('#batch_year').on('blur',function (){
            var number = $(this).val();

            var is_uni = isUnicode(number);
            if (is_uni) {
               var converted =  convertBanglaToEnglishNumber(number);
               $('#batch_year_hidden').val(converted);
            }else{
                $('#batch_year_hidden').val(number);
            }
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

        $("#reset_btn").click(function(){
                var batch_id = $('#batch_id').val();
                if(batch_id){
                    $('#batch_id'+batch_id).click();
                }else{
                    $('.create-posasonik').click();
                }
            });

        $('#btn_excel_generate').on('click',function (){
            var url = 'generate_employee_management_batch_excel_file';
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
