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
                        <p class="mb-0 pt-1">অনুসন্ধান</p>

                    </div>
                </button>
            </div>
            <div>
                <h3 class="text-white my-1">প্রশাসনিক বিভাগের তালিকা</h3>
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
                        <p class="mb-0 pt-1"> বিভাগ তৈরি</p>

                        {{-- <button class="btn btn-primary btn-square create-posasonik" data-dismiss="modal">
                            <i class="la la-plus"></i>
                            বিভাগ তৈরি
                        </button> --}}
                    </div>
                </button>
            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->

            <div class="row mb-2">
                <div class="col-md-12">
                    <div style="display:none" class="card custom-card shadow-sm w-100 advance_search ">
                        <div class="card-header">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="card-body">
                            <form onsubmit="searchData(this, 'search_division'); return false;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="name_bangla" class="form-control rounded-0" type="text"
                                                   placeholder="প্রশাসনিক বিভাগের নাম(বাংলা)" name="division_name_bng">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="name_english" class="form-control rounded-0" type="text"
                                                   placeholder="প্রশাসনিক বিভাগের নাম(ইংরেজি)" name="division_name_eng">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="division_code"
                                                   class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                                   type="text" placeholder="বিভাগ কোড" name="bbs_code"
                                                   style="font-size: 14px;">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        {{-- <div class="form-group">

                                           <span class="kt-switch kt-switch--icon">
                                                    <label>অবস্থা
                                                        <input id="division_status" class="division_status" type="checkbox" data-id="" value="1"  name="division_status">
                                                        <span></span>
                                                    </label>
                                                </span>
                                        </div> --}}
                                        <div class="form-group">
                                            <select name="division_status" id="division_status" class="select-select2">
                                                {{-- <option value="all">সকল</option> --}}
                                                <option value="1">সক্রিয়</option>
                                                <option value="0">নিষ্ক্রিয়</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-square">অনুসন্ধান</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="list_div" class="load-table-data" data-href="/getBivag">
                </div>
            </div>


            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0 col-md-12">
                প্রশাসনিক বিভাগ সম্পাদনা </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-5">
                <form id="bivag_form" onsubmit="submitData(this, '{{route('bivag.store')}}'); return false;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="my-input">প্রশাসনিক বিভাগের নাম(বাংলা)</label> <span
                                class="text-danger">*</span>
                            <input id="division_name_bng" class="form-control rounded-0" type="text"
                                   name="division_name_bng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="my-input">প্রশাসনিক বিভাগের নাম(ইংরেজি)</label><span
                                class="text-danger">*</span>
                            <input id="division_name_eng" class="form-control rounded-0" type="text"
                                   name="division_name_eng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="my-input">বিভাগ BBS কোড</label><span class="text-danger">*</span>
                            <input id="bbs_code" class="form-control rounded-0" type="text" required placeholder="">
                            <input id="bbs_code_hidden" class="form-control rounded-0" type="hidden" name="bbs_code"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="kt-checkbox-list">
                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                    <input id="status" name="status" type="checkbox" value="0"> অবস্থা
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="bivag_id" name="id">
                    <input type="hidden" id="created_by" name="created_by" value="0">
                    <input type="hidden" id="modified_by" name="modified_by" value="0">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ
                                </button>
                                <a id="reset_btn" class="btn  btn-danger text-white"><i class="fas fa-sync  mr-2"></i>
                                    রিসেট</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-geo-log-view-panel/>

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

        $(document).on('click', "ul.pagination>li>a", function (e) {
            e.preventDefault();
            loadData($(this).attr('href'));
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

        $(".create-posasonik").click(function () {
            clearForm('#bivag_form');
            $('#division_name_bng').val('');
            $('#division_name_eng').val('');
            $('#bbs_code').val('');
            $('#bbs_code_hidden').val('');
            $('#bivag_id').val('');
            $('#status').val('');
            $('#status').prop('checked', false);
            $('.kt_quick_panel__title').text('প্রশাসনিক বিভাগ');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var bivag_id = content_value[0];
            var bbs_code = content_value[1];
            var division_name_bng = content_value[2];
            var division_name_eng = content_value[3];
            var status = content_value[4];

            $('#division_name_bng').val(division_name_bng);
            $('#division_name_eng').val(division_name_eng);
            $('#bbs_code').val(bbs_code);
            $('#bbs_code_hidden').val(bbs_code);
            $('#bivag_id').val(bivag_id);
            if (status == 1) {
                $('#status').prop('checked', true);
                $('#status').val(1);
            } else {
                $('#status').prop('checked', false);
            }

            $(".kt_quick_panel__title").text('প্রশাসনিক বিভাগ সম্পাদন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });

        $('#btn_excel_generate').on('click', function () {
            var url = 'generate_bivag_excel_file';
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
            });
        });

        $('#division_name_bng').bangla({enable: true});

        $(function () {
            $('#btn_pdf_generate').click(function (event) {
                event.preventDefault();
                var pageSource = '<html>' + $('html').html() + '</html>';
                var url = 'generate_bivag_pdf_file';
                var data = {pageSource};
                var datatype = 'html';
                ajaxCallUnsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                    console.log(responseDate);
                    return false;
                    window.open(responseDate.full_path, '_blank');
                });
            });
        });

        $("select#office_id").change(function () {
            var office_id = $(this).children("option:selected").val();

            if (office_id == 0) {
                toastr.error('অফিস বাছাই করুন');
                return;
            }

            loadOfficeNotification(office_id);
        });

        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                $("#list_div").html(responseData);
            });
        }

        $("#reset_btn").click(function () {
            var bivag_id = $('#bivag_id').val();
            if (bivag_id) {
                $('#bivag_id' + bivag_id).click();
            } else {
                $('.create-posasonik').click();
            }
        });

        $('#bbs_code').on('blur', function () {
            var number = $(this).val();
            var is_uni = isUnicode(number);
            if (is_uni) {
                var converted = convertBanglaToEnglishNumber(number);
                $('#bbs_code_hidden').val(converted);
            } else {
                $('#bbs_code_hidden').val(number);
            }
        });


    </script>
@endsection
