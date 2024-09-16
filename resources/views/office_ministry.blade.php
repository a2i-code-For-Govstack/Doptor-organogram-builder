@extends('master')
@section('content')
<style>
@media (max-width: 575.98px) {
#btn_excel_generate{
    margin-left: 15px;
}
}
</style>
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
                <h3 class="text-white my-1">Ministries/Departments List</h3>
            </div>
            <div class="mr-3 d-flex">
                <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0  d-flex mr-2">
                    <div>
                        <i class="fa fa-download my-1 ml-2 mr-0"></i>
                    </div>

                </button>
                <button class="btn btn-sna-header-button-color py-0  d-flex create-posasonik">
                    <div>
                        <i class="fa fa-plus mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">Create new Ministries/Departments</p>

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
                                <form onsubmit="searchData(this, 'search_office_ministry'); return false;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Ministry / Department Name" id="ministry_name"
                                                       class="form-control rounded-0" type="text" name="ministry_name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select name="status" id="ministry_status" class="select-select2">
                                                    {{-- <option value="all">সকল</option> --}}
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
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
                    <div id="list_div" class="load-table-data" data-href="/getOfficeMinistry">
                    </div>
                </div>

            </div>

            <!-- end:: Content -->
        </div>
        <!-- begin::Form Quick Panel -->
        <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
            <div class="kt_quick_panel__head">
                <h5 class="kt_quick_panel__title mb-0 col-md-12">Edit Administrative Section</h5>
                <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
            </div>
            <div class="kt-quick-panel__content">
                <div class="mt-3">
                    <form id="office_ministry_form"
                          onsubmit="submitData(this, '{{route('office_ministry.store')}}'); return false;">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="office_type">type</label><span class="text-danger">*</span>
                                <select id="office_type" class="form-control rounded-0 select-select2" type="text"
                                        name="office_type">
                                    <option value="">---- choose ----</option>
                                    <option value="1">Ministry</option>
                                    <option value="2">Department</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_bng">Name (Others)</label><span class="text-danger">*</span>
                                <input id="name_bng" class="form-control rounded-0 bangla" type="text" name="name_bng">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_eng">Name (English)</label><span class="text-danger">*</span>
                                <input id="name_eng" class="form-control rounded-0 english" type="text" name="name_eng">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_eng_short">Short Name</label><span class="text-danger">*</span>
                                <input id="name_eng_short"
                                       onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57)"
                                       class="form-control rounded-0" type="text" name="name_eng_short">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="reference_code">Ministry / Department Code </label><span
                                    class="text-danger">*</span>
                                <input id="reference_code" class="form-control rounded-0" type="text">

                                <input id="reference_code_hidden" class="form-control rounded-0" type="hidden"
                                       name="reference_code">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                        <input autocomplete="off" id="status" type="checkbox" name="active_status"
                                               checked="" value="1"> Status <span class="text-danger">*</span>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save
                                    </button>
                                    <a id="reset_btn" class="btn  btn-danger text-white"><i
                                            class="fas fa-sync  mr-2"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="ministry_id" name="id">
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

            $(".create-posasonik").click(function () {
                clearForm('#office_ministry_form');
                $('#office_type').val('');
                $('#name_bng').val('');
                $('#name_eng').val('');
                $('#name_eng_short').val('');
                // $('#active_status').val('');
                $('#reference_code').val('');
                $('#reference_code_hidden').val('');
                $('#status').prop('checked', true);
                $('#status').val(1);
                $('#ministry_id').val('');
                $('#reset_form').data('id', 1);
                $('.kt_quick_panel__title').text('Create new Ministries/Departments');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
            })
            $(document).on('click', ".btntableDataEdit", function () {

                $(".kt_quick_panel__title").text('Edit Ministry/Department');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
                var content = $(this).attr('data-content');
                var content_value = content.split(',')
                var id = content_value[0];
                var office_type = content_value[1];
                var name_bng = content_value[2];
                var name_eng = content_value[3];
                var name_eng_short = content_value[4];
                var active_status = content_value[5];
                var reference_code = content_value[6];

                $('#office_type').val(office_type);
                $('#name_bng').val(name_bng);
                $('#name_eng').val(name_eng);
                $('#name_eng_short').val(name_eng_short);
                $('#active_status').val(active_status);
                $('#reference_code').val(reference_code);
                $('#reference_code_hidden').val(EngFromBn(reference_code));

                $('#ministry_id').val(id);
                if (active_status == 1) {
                    $('#status').prop('checked', true);
                    $('#status').val(1);
                } else {
                    $('#status').prop('checked', false);
                    $('#status').val(0);
                }
            });

            function submitData(form, url) {
                var data = $(form).serialize();
                var datatype = 'json';

                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    if (responseDate.status === 'success') {
                        loadData();
                        toastr.success(responseDate.msg);
                        $("#kt_quick_panel_close_btn").trigger('click');
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            }

            $('#btn_excel_generate').on('click', function () {
                var url = 'generate_office_ministry_excel_file';
                var data = {};
                var datatype = 'json';
                ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    window.open(responseDate.full_path, '_blank');
                });
            });


            function searchData(form, url) {
                var data = $(form).serialize();
                console.log(data);
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                    $("#list_div").html(responseData);
                });
            }


            $('#reference_code').on('blur', function () {
                var number = $(this).val();
                var is_uni = isUnicode(number);
                if (is_uni) {
                    var converted = convertBanglaToEnglishNumber(number);
                    $('#reference_code_hidden').val(converted);
                } else {
                    $('#reference_code_hidden').val(number);
                }
            });

            $("#reset_btn").click(function () {
                var ministry_id = $('#ministry_id').val();
                if (ministry_id) {
                    $('#ministry_id' + ministry_id).click();
                } else {
                    $('.create-posasonik').click();
                }
            });

        </script>
@endsection
