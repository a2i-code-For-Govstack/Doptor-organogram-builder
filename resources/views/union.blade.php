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
                <h3 class="text-white my-1">ইউনিয়ন তালিকা</h3>
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
                        <p class="mb-0 pt-1">ইউনিয়ন তৈরি</p>

                    </div>
                </button>

            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div style="display:none" class="card custom-card shadow-sm w-100 advance_search">
                        <div class="card-header">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="card-body">
                            <form onsubmit="searchData(this, 'search_union'); return false;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="division_id" class="form-control rounded-0 select-select2"
                                                    name="division_id">
                                                <option value="" selected="selected">বিভাগ নির্বাচন করুন</option>
                                                @foreach ($bivags as $bivag)
                                                    <option data-bivag_bbs_code="{{ $bivag->bbs_code }}"
                                                            value="{{ $bivag->id }}">{{ $bivag->division_name_bng }}</option>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="upazila_id" class="form-control rounded-0 select-select2"
                                                    name="upazila_id">
                                                <option value="" selected="selected">উপজেলা নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="union_bbs_code"
                                                   class="form-control bijoy-bangla rounded-0 integer_type_positive"
                                                   placeholder="ইউনিয়ন কোড" type="text" name="union_bbs_code"
                                                   style="font-size: 14px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="name_bn" placeholder="ইউনিয়ন নাম (বাংলা)"
                                                   class="form-control rounded-0" type="text" name="name_bn">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="name_en" placeholder="ইউনিয়ন নাম (ইংরেজি)"
                                                   class="form-control rounded-0" type="text" name="name_en">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="union_status" id="union_status" class="select-select2">
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

            <!--Begin::Row-->
            <div class="kt-portlet__body">
                <div id="list_div" class="load-table-data" data-href="/getUnion">

                </div>
            </div>
        </div>

        <!-- end:: Content -->
    </div>
    <!-- begin::Form Quick Panel -->
    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0 col-md-12">
                ইউনিয়ন সম্পাদনা </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i
                    class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-5">
                <form id="union_form" onsubmit="submitData(this, '{{ route('union.store') }}'); return false;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="division_name_bng">প্রশাসনিক বিভাগ</label><span class="text-danger">*</span>
                            <select name="geo_division_id" id="geo_division_id"
                                    class="form-control rounded-0 select-select2" required>
                                <option value="">বিভাগ নির্বাচন করুন</option>
                                @foreach ($bivags as $bivag)
                                    <option data-bivag_bbs_code="{{ $bivag->bbs_code }}" value="{{ $bivag->id }}">
                                        {{ $bivag->division_name_bng }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="geo_district_id">জেলা</label><span class="text-danger">*</span>
                            <select name="geo_district_id" id="geo_district_id"
                                    class="form-control rounded-0 select-select2" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="geo_upazila_id">উপজেলা</label><span class="text-danger">*</span>
                            <select name="geo_upazila_id" id="geo_upazila_id"
                                    class="form-control rounded-0 select-select2"
                                    required></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="union_name_bng">ইউনিয়ন নাম(বাংলা)</label><span class="text-danger">*</span>
                            <input id="union_name_bng" class="form-control rounded-0 bangla" type="text"
                                   name="union_name_bng" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="union_name_eng">ইউনিয়ন নাম(ইংরেজি)</label><span class="text-danger">*</span>
                            <input id="union_name_eng" class="form-control rounded-0 english" type="text"
                                   name="union_name_eng" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bbs_code">ইউনিয়ন BBS কোড</label><span class="text-danger">*</span>
                            <input id="bbs_code" class="form-control rounded-0" type="text" required placeholder="">
                            <input id="bbs_code_hidden" class="form-control rounded-0" type="hidden" name="bbs_code"
                                   required>
                        </div>
                    </div>
                    <input id="division_bbs_code" class="form-control rounded-0" readonly type="hidden"
                           name="division_bbs_code">
                    <input id="district_bbs_code" class="form-control rounded-0" readonly type="hidden"
                           name="district_bbs_code">
                    <input id="upazila_bbs_code" class="form-control rounded-0" readonly type="hidden"
                           name="upazila_bbs_code">
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
                    <input type="hidden" id="union_id" name="id">
                    <input type="hidden" id="created_by" name="created_by" value="0">
                    <input type="hidden" id="modified_by" name="modified_by" value="0">
                </form>
            </div>
        </div>
    </div>
    <!-- end::Form Quick Panel -->
    <x-geo-log-view-panel/>
    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <!-- end::Scrolltop -->
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
            clearForm('#union_form');
            $('#union_name_bng').val('');
            $('#union_name_eng').val('');
            $('#bbs_code').val('');
            $('#bbs_code_hidden').val('');

            $('#union_id').val('');
            $('.kt_quick_panel__title').text('ইউনিয়ন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('ইউনিয়ন সম্পাদন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var id = content_value[0];
            var bbs_code = content_value[1];
            var union_name_bng = content_value[2];
            var union_name_eng = content_value[3];
            var status = content_value[4];
            var geo_division_id = content_value[5];
            var geo_district_id = content_value[6];
            var geo_upazila_id = content_value[7];
            var division_bbs_code = content_value[8];
            var district_bbs_code = content_value[9];
            var upazila_bbs_code = content_value[10];

            loadZila(geo_division_id, geo_district_id);
            var division_code = $('#geo_division_id').children("option:selected").attr('data-bivag_bbs_code');
            $('#division_bbs_code').val(division_code);

            loadUpoZila(geo_district_id, geo_upazila_id);
            var district_code = $('#geo_district_id').children("option:selected").attr('data-zila_bbs_code');
            $('#district_bbs_code').val(district_code);

            $('#geo_upazila_id option[value=' + geo_upazila_id + ']').prop('selected', true).trigger('change');
            var upazila_code = $('#geo_upazila_id').children("option:selected").attr('data-upazila_bbs_code');
            $('#upazila_bbs_code').val(upazila_code);

            $('#union_name_bng').val(union_name_bng);
            $('#union_name_eng').val(union_name_eng);
            $('#bbs_code').val(bbs_code);
            $('#bbs_code_hidden').val(bbs_code);
            if (status == 1) {
                $('#status').attr('checked', true).val(status);
            } else {
                $('#status').attr('checked', false).val(status);
            }
            $('#union_id').val(id);
        });

        $("select#geo_division_id").change(function () {
            var division_code = $(this).children("option:selected").attr('data-bivag_bbs_code');
            var division_id = $(this).children("option:selected").val();
            $('#division_bbs_code').val(division_code);
            loadZila(division_id);
        });

        function loadZila(division_id, geo_district_id = '') {
            var url = 'load_zila_division_wise';
            var data = {division_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#geo_district_id").html(responseDate);
                if (geo_district_id) {
                    $("#geo_district_id").val(geo_district_id);
                }
            });
        }

        $("select#geo_district_id").change(function () {
            var district_code = $(this).children("option:selected").attr('data-zila_bbs_code');
            var district_id = $(this).children("option:selected").val();
            $('#district_bbs_code').val(district_code);
            loadUpoZila(district_id);
        });

        function loadUpoZila(district_id, geo_upazila_id = '') {
            var url = 'load_upozila_district_wise';
            var data = {district_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#geo_upazila_id").html(responseDate);
                if (geo_upazila_id) {
                    $("#geo_upazila_id").val(geo_upazila_id);
                }
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

        $("select#geo_upazila_id").change(function () {
            var upazila_code = $(this).children("option:selected").attr('data-upazila_bbs_code');
            $('#upazila_bbs_code').val(upazila_code);
        });

        $('#btn_excel_generate').on('click', function () {
            var url = 'generate_union_excel_file';
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
            var data = {
                division_id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#district_id").html(responseDate);
            });
        }

        $("select#district_id").change(function () {
            var district_code = $(this).children("option:selected").attr('data-zila_bbs_code');
            var district_id = $(this).children("option:selected").val();
            $('#district_bbs_code').val(district_code);
            loadserchUpazila(district_id);
        });

        function loadserchUpazila(district_id) {
            var url = 'load_upazila_wise';
            var data = {
                district_id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#upazila_id").html(responseDate);
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
