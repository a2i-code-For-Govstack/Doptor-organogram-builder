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
                <h3 class="text-white my-1">থানার তালিকা</h3>
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
                        <p class="mb-0 pt-1">থানা তৈরি</p>

                    </div>
                </button>

            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            {{-- <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">

                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <div class="dropdown dropdown-inline">
                                    <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> এক্সপোর্ট
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__section kt-nav__section--first">
                                            <span class="kt-nav__section-text">বাছাই করুন</span>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a onclick="window.print()" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-print"></i>
                                                <span class="kt-nav__link-text">প্রিন্ট</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a id="btn_excel_generate" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                                <span class="kt-nav__link-text">এক্সেল</span>
                                            </a>
                                        </li>
                                        <!-- <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-file-text-o"></i>
                                                <span class="kt-nav__link-text">CSV</span>
                                            </a>
                                        </li> -->

                                    </ul>
                                </div>
                            </div>
                            &nbsp;
                            <!-- <a href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                New Record
                            </a> -->
                            <button class="btn btn-primary btn-square create-posasonik" data-dismiss="modal">
                                <i class="la la-plus"></i>
                                থানা তৈরি
                            </button>
                        </div>
                    </div>
                </div>
            </div> --}}


            <div class="row mb-2">
                <div class="col-md-12">
                    <div style="display:none" class="card custom-card shadow-sm w-100 advance_search">
                        <div class="card-header">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="card-body">
                            <form onsubmit="searchData(this, 'search_thana'); return false;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="division_id" class="form-control rounded-0 select-select2"
                                                    name="division_id">
                                                <option value="" selected="selected">বিভাগ নির্বাচন করুন</option>
                                                @foreach($bivags as $bivag)
                                                    <option data-bivag_bbs_code="{{$bivag->bbs_code}}"
                                                            value="{{$bivag->id}}">{{$bivag->division_name_bng}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="district_id" class="form-control rounded-0 select-select2"
                                                    name="district_id">
                                                <option value="" selected="selected">জেলা নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="thana_bbs_code"class="form-control bijoy-bangla rounded-0 integer_type_positive"
                                            placeholder="থানা কোড" type="text" name="thana_bbs_code" style="font-size: 14px">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="name_bn" placeholder="থানার নাম (বাংলা)"
                                                   class="form-control rounded-0" type="text" name="name_bn">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="name_en" placeholder="থানার নাম (ইংরেজি)"
                                                   class="form-control rounded-0" type="text" name="name_en">
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

            <!--Begin::Row-->
            <div class="kt-portlet__body">
                <div id="list_div" class="load-table-data" data-href="/getThana">

                </div>
            </div>
        </div>

        <!-- end:: Content -->
    </div>
    <!-- begin::Form Quick Panel -->
    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0 col-md-12">
                থানা সম্পাদনা </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-5">
                <form id="thana_form" onsubmit="submitData(this, '{{route('thana.store')}}'); return false;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="division_name_bng">প্রশাসনিক বিভাগ</label><span class="text-danger">*</span>
                            <select name="geo_division_id" id="geo_division_id"
                                    class="form-control rounded-0 select-select2" required>
                                <option value="">বিভাগ নির্বাচন করুন</option>
                                @foreach($bivags as $bivag)
                                    <option data-bivag_bbs_code="{{$bivag->bbs_code}}"
                                            value="{{$bivag->id}}">{{$bivag->division_name_bng}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="geo_district_id">জেলা</label><span class="text-danger">*</span>
                            <select name="geo_district_id" id="geo_district_id"
                                    class="form-control rounded-0 select-select2" required></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="thana_name_bng">থানার নাম(বাংলা)</label><span class="text-danger">*</span>
                            <input id="thana_name_bng" class="form-control rounded-0" type="text" name="thana_name_bng"
                                   required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="thana_name_eng">থানার নাম(ইংরেজি)</label><span class="text-danger">*</span>
                            <input id="thana_name_eng" class="form-control rounded-0" type="text" name="thana_name_eng"
                                   required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bbs_code">থানা BBS কোড</label><span class="text-danger">*</span>
                            <input id="bbs_code" class="form-control rounded-0" type="text" required placeholder="">
                            <input id="bbs_code_hidden" class="form-control rounded-0" type="hidden" name="bbs_code"
                                   required>
                        </div>
                    </div>
                    <input id="division_bbs_code" class="form-control rounded-0" readonly type="hidden"
                           name="division_bbs_code">
                    <input id="district_bbs_code" class="form-control rounded-0" readonly type="hidden"
                           name="district_bbs_code">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="kt-checkbox-list">
                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                    <input id="status" type="checkbox" name="status" value="0"> অবস্থা
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ
                                </button>
                                <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> রিসেট
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="thana_id" name="id">
                    <input type="hidden" id="created_by" name="created_by" value="0">
                    <input type="hidden" id="modified_by" name="modified_by" value="0">
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

    <!-- end::Scrolltop -->

    <div class="modal fade show" id="kt_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         style="display: none;" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">প্রশাসনিক বিভাগের তালিকা</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-between mb-5">
                        <button class="btn btn-primary mb-3 btn-square create-posasonik" data-dismiss="modal">প্রশাসনিক
                            বিভাগ তৈরি
                        </button>
                        <div class="btn-group mb-3" role="group" aria-label="First group">
                            <button type="button" class="btn btn-primary btn-icon btn-square"><i
                                    class="fas fa-print"></i></button>
                            <button type="button" class="btn btn-success btn-icon  btn-square"><i
                                    class="fas fa-file-pdf"></i></button>
                            <button type="button" class="btn btn-warning btn-icon  btn-square"><i
                                    class="fas fa-file-excel"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>বিভাগ কোড</th>
                                <th>প্রশাসনিক বিভাগের নাম(বাংলা)</th>
                                <th>প্রশাসনিক বিভাগের নাম(ইংরেজি)</th>
                                <th>অবস্থা</th>
                                <th>কার্যক্রম</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>10</td>
                                <td>বরিশাল</td>
                                <td>Barisal</td>
                                <td>1</td>
                                <td>
                                    <button type="button" data-dismiss="modal"
                                            class="btn btn-warning btn-icon btn-square btntableDataEdit"><i
                                            class="fas fa-pencil-alt"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-square" data-dismiss="modal">বন্ধ করুন</button>
                </div>
            </div>
        </div>
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

        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });


        $(".create-posasonik").click(function () {
            clearForm('#thana_form');
            $('#thana_name_bng').val('');
            $('#thana_name_eng').val('');
            $('#bbs_code').val('');
            $('#bbs_code_hidden').val('');
            $('#status').val('');
            $('#status').prop('checked', false);
            $('#thana_id').val('');
            $('.kt_quick_panel__title').text('থানা');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('থানা সম্পাদন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var id = content_value[0];
            var bbs_code = content_value[1];
            var thana_name_bng = content_value[2];
            var thana_name_eng = content_value[3];
            var status = content_value[4];
            var geo_division_id = content_value[5];
            var geo_district_id = content_value[6];
            var division_bbs_code = content_value[7];
            var district_bbs_code = content_value[8];


            $('#geo_division_id option[value=' + geo_division_id + ']').prop('selected', true);
            loadZila(geo_division_id);
            var division_code = $('#geo_division_id').children("option:selected").attr('data-bivag_bbs_code');
            $('#division_bbs_code').val(division_code);

            $('#geo_district_id option[value=' + geo_district_id + ']').prop('selected', true).trigger('change');
            var district_code = $('#geo_district_id').children("option:selected").attr('data-zila_bbs_code');
            $('#district_bbs_code').val(district_code);


            $('#thana_name_bng').val(thana_name_bng);
            $('#thana_name_eng').val(thana_name_eng);
            $('#bbs_code').val(bbs_code);
            $('#bbs_code_hidden').val(bbs_code);

            $('#thana_id').val(id);
            if (status == 1) {
                $('#status').prop('checked', true);
                $('#status').val(1);
            }
            else {
                $('#status').prop('checked', false);
            }
        });

        $("select#geo_division_id").change(function () {
            var division_code = $(this).children("option:selected").attr('data-bivag_bbs_code');
            var division_id = $(this).children("option:selected").val();
            $('#division_bbs_code').val(division_code);
            // $('#division_bbs_code').val(division_code);
            loadZila(division_id);
        });

        function loadZila(division_id) {
            var url = 'load_zila_division_wise';
            var data = {division_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#geo_district_id").html(responseDate);
            });
        }

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

        $("select#geo_district_id").change(function () {
            var district_code = $(this).children("option:selected").attr('data-zila_bbs_code');
            $('#district_bbs_code').val(district_code);
        });

        $('#btn_excel_generate').on('click', function () {
            var url = 'generate_thana_excel_file';
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

        $('#thana_name_bng').bangla({ enable: true });

        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                $("#list_div").html(responseData);
            });
        }

        $("select#division_id").change(function () {
            var division_code = $(this).children("option:selected").attr('data-bivag_bbs_code');
            var division_id = $(this).children("option:selected").val();
            $('#division_bbs_code').val(division_code);
            // $('#division_bbs_code').val(division_code);
            loadserchZila(division_id);
        });

        function loadserchZila(division_id) {
            var url = 'load_zila_division_wise';
            var data = {division_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#district_id").html(responseDate);
            });
        }

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
