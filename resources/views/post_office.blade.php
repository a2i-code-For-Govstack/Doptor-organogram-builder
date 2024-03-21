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
                <h3 class="text-white my-1">পোষ্ট অফিসের তালিকা</h3>
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
                        <p class="mb-0 pt-1">পোষ্ট অফিস তৈরি</p>

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
                    <div style="display:none" class="card custom-card shadow-sm w-100 advance_search">
                        <div class="card-header">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="card-body">
                            <form onsubmit="searchData(this, 'search_post_office'); return false;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="division_id" class="form-control rounded-0 select-select2"
                                                    name="division_id">
                                                <option value="">বিভাগ নির্বাচন করুন</option>
                                                @foreach($bivags as $bivag)
                                                    <option data-bivag_bbs_code="{{$bivag->bbs_code}}"
                                                            value="{{$bivag->id}}">{{$bivag->division_name_bng}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><select id="district_id"
                                                                        class="form-control rounded-0 select-select2"
                                                                        name="district_id">
                                                <option value="" selected="selected">জেলা নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><select id="upozila_id"
                                                                        class="form-control rounded-0 select-select2"
                                                                        name="upozila_id">
                                                <option value="" selected="selected">উপজেলা নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="thana" class="form-control rounded-0 select-select2"
                                                    name="office_ministry_id">
                                                <option value="" selected="selected">থানা নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="name_en" placeholder="পোষ্ট অফিসের নাম (ইংরেজি)"
                                                   class="form-control rounded-0 " type="text" name="name_en">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="name_bn" placeholder="পোষ্ট অফিসের নাম (বাংলা)"
                                                   class="form-control rounded-0 " type="text" name="name_bn">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <input id="post_office_code" placeholder="পোষ্ট অফিস কোড"
                                                   class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                                   type="text" name="post_office_code" style="font-size: 14px;">
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        {{-- <div class="form-group">

                                           <span class="kt-switch kt-switch--icon">

                                                    <label>  <t class="col-md-2 align-items-center">অবস্থা</t>
                                                        <input class="show_unit" type="checkbox" data-id="" value=""
                                                               name="post_office_status" checked="">
                                                        <span></span>
                                                    </label>
                                                </span>
                                        </div> --}}
                                        <div class="form-group">
                                            <select name="post_office_status" id="post_office_status"
                                                    class="select-select2">
                                                {{-- <option value="all">সকল</option> --}}
                                                <option value="1">সক্রিয়</option>
                                                <option value="0">নিষ্ক্রিয়</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
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

                <div id="list_div" class="load-table-data" data-href="/getPostOffice">

                </div>
            </div>


        </div>

        <!-- end:: Content -->
    </div>
    <!-- begin::Form Quick Panel -->
    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0 col-md-12">
                পোষ্ট অফিসর সম্পাদনা </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-5">
                <form id="post_office_form"
                      onsubmit="submitData(this, '{{route('post_office.store')}}'); return false;">
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
                            <label for="upazila_name_bng">উপজেলা</label><span class="text-danger">*</span>
                            <select name="geo_upazila_id" id="geo_upazila_id"
                                    class="form-control rounded-0 select-select2"></select>

                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="geo_thana_id">থানা</label>
                            <input id="geo_thana_id" class="form-control rounded-0" type="hidden" name="geo_thana_id">
                        </div>
                    </div> -->


                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">পোষ্টঅফিসের নাম (বাংলা)</label><span class="text-danger">*</span>
                            <input id="postoffice_name_bng" class="form-control rounded-0" type="text"
                                   name="postoffice_name_bng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="postoffice_name_eng">পোষ্টঅফিসের নাম (ইংরেজি)</label><span
                                class="text-danger">*</span>
                            <input id="postoffice_name_eng" class="form-control rounded-0" type="text"
                                   name="postoffice_name_eng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bbs_code">পোষ্টঅফিস BBS কোড</label><span class="text-danger">*</span>
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
                    <input type="hidden" id="post_office_id" name="id">
                    <input type="hidden" id="division_bbs_code" name="division_bbs_code">
                    <input type="hidden" id="district_bbs_code" name="district_bbs_code">
                    <input type="hidden" id="upozila_bbs_code" name="upozila_bbs_code">

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
            data = {};
            datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $(".load-table-data").html(responseDate);
            });
        }

        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });


        $(".create-posasonik").click(function () {
            clearForm('#post_office_form');
            $('#postoffice_name_bng').val('');
            $('#postoffice_name_eng').val('');
            $('#bbs_code').val('');
            $('#bbs_code_hidden').val('');

            $('#post_office_id').val('');
            $('.kt_quick_panel__title').text('পোষ্ট অফিস');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });
        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('পোষ্ট অফিস সম্পাদন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            content = $(this).attr('data-content');
            content_value = content.split(',')
            post_office_id = content_value[0];
            bbs_code = content_value[1];
            postoffice_name_bng = content_value[2];
            postoffice_name_eng = content_value[3];
            status = content_value[4];
            geo_division_id = content_value[5];
            geo_district_id = content_value[6];
            geo_upazila_id = content_value[7];
            geo_thana_id = content_value[8];
            division_bbs_code = content_value[9];
            district_bbs_code = content_value[10];

            $('#post_office_id').val(post_office_id);
            $('#division_bbs_code').val(division_bbs_code);
            $('#district_bbs_code').val(district_bbs_code);
            // $('#upozila_bbs_code').val(bbs_code);
            if (status == 1) {
                $('#status').prop('checked', true);
                $('#status').val(1);
            } else {
                $('#status').prop('checked', false);
            }

            $('#postoffice_name_bng').val(postoffice_name_bng);
            $('#postoffice_name_eng').val(postoffice_name_eng);
            $('#bbs_code').val(bbs_code);
            $('#bbs_code_code').val(bbs_code);
            $('#geo_thana_id').val(geo_thana_id);

            $('#geo_division_id option[value=' + geo_division_id + ']').prop('selected', true).trigger('change');
            division_code = $('#geo_division_id').children("option:selected").attr('data-bivag_bbs_code');
            $('#division_bbs_code').val(division_code);


            $('#geo_district_id option[value=' + geo_district_id + ']').prop('selected', true).trigger('change');
            district_code = $('#geo_district_id').children("option:selected").attr('data-zila_bbs_code');
            $('#district_bbs_code').val(district_code);

            $('#geo_upazila_id option[value=' + geo_upazila_id + ']').prop('selected', true);
            upozila_code = $('#geo_upazila_id').children("option:selected").attr('data-upozila_bbs_code');
            $('#upozila_bbs_code').val(upozila_code);


            $('#post_office_id').val(id);
        });
        $("select#geo_division_id").change(function () {
            division_code = $(this).children("option:selected").attr('data-bivag_bbs_code');
            division_id = $(this).children("option:selected").val();
            $('#division_bbs_code').val(division_code);
            // $('#division_bbs_code').val(division_code);
            loadZila(division_id);
        });

        function loadZila(division_id) {
            url = 'load_zila_division_wise';
            data = {division_id};
            datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#geo_district_id").html(responseDate);
            });
        }

        $("select#geo_district_id").change(function () {
            district_code = $(this).children("option:selected").attr('data-zila_bbs_code');
            district_id = $(this).children("option:selected").val();

            $('#district_bbs_code').val(district_code);
            // $('#division_bbs_code').val(division_code);
            loadUpoZila(district_id);
        });

        function loadUpoZila(district_id) {
            url = 'load_upozila_district_wise';
            data = {district_id};
            datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#geo_upazila_id").html(responseDate);
            });
        }

        function submitData(form, url) {
            data = $(form).serialize();
            datatype = 'json';

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
            district_code = $(this).children("option:selected").attr('data-zila_bbs_code');
            $('#district_bbs_code').val(district_code);
        });

        //need to fix it later
        $("select#geo_upazila_id").change(function () {
            upozila_id = $(this).children("option:selected").val();
            $('#geo_thana_id').val(upozila_id);
        });

        $('#btn_excel_generate').on('click', function () {
            url = 'generate_post_office_excel_file';
            data = {};
            datatype = 'json';
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

        $('#postoffice_name_bng').bangla({enable: true});

        //for search

        $("select#division_id").change(function () {
            division_code = $(this).children("option:selected").attr('data-bivag_bbs_code');
            division_id = $(this).children("option:selected").val();
            $('#division_bbs_code').val(division_code);
            // $('#division_bbs_code').val(division_code);
            loadSearchZila(division_id);
        });

        function loadSearchZila(division_id) {
            url = 'load_zila_division_wise';
            data = {division_id};
            datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#district_id").html(responseDate);
            });
        }

        $("select#district_id").change(function () {
            district_code = $(this).children("option:selected").attr('data-zila_bbs_code');
            district_id = $(this).children("option:selected").val();

            $('#district_bbs_code').val(district_code);
            // $('#division_bbs_code').val(division_code);
            loadSerachUpoZila(district_id);
        });

        function loadSerachUpoZila(district_id) {
            url = 'load_upozila_district_wise';
            data = {district_id};
            datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#upozila_id").html(responseDate);
            });
        }

        function searchData(form, url) {
            data = $(form).serialize();
            datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                $("#list_div").html(responseData);
            });
        }

        $('#bbs_code').on('blur', function () {
            number = $(this).val();
            is_uni = isUnicode(number);
            if (is_uni) {
                converted = convertBanglaToEnglishNumber(number);
                $('#bbs_code_hidden').val(converted);
            } else {
                $('#bbs_code_hidden').val(number);
            }
        });
    </script>
@endsection
