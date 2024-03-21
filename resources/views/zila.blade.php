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
                <h3 class="text-white my-1">জেলার তালিকা</h3>
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
                        <p class="mb-0 pt-1">জেলা তৈরি</p>

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
                            <form onsubmit="searchData(this, 'search_zila'); return false;">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <!--  <label for="name_bng">জেলার নাম(বাংলা) </label> -->
                                            <input placeholder="জেলার নাম(বাংলা)" id="name_bng" class="form-control rounded-0" type="text" name="district_name_bng">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label for="name_eng">জেলার নাম(ইংরেজি) </label> -->
                                            <input placeholder="জেলার নাম(ইংরেজি)" id="name_eng" class="form-control rounded-0" type="text" name="district_name_eng">
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <!-- <label for="geo_division">বিভাগ </label> -->
                                        <select name="geo_division_id" id="geo_division" class="form-control rounded-0 select-select2" >
                                            <option value="">বিভাগ নির্বাচন করুন</option>
                                            @foreach($bivags as $bivag)
                                            <option data-bivag_bbs_code="{{$bivag->bbs_code}}"
                                                value="{{$bivag->id}}">{{$bivag->division_name_bng}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input placeholder="জেলা কোড" id="bbs_code" class="form-control rounded-0 bijoy-bangla integer_type_positive" type="text" name="bbs_code" style="font-size: 14px;">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        {{-- <div class="form-group" style="margin-top: 0px">
                                           <span class="kt-switch kt-switch--icon">
                                                <label>অবস্থা
                                                    <input id="zila_status" class="" type="checkbox" data-id="" value="0"  name="zila_status">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div> --}}
                                        <div class="form-group">
                                            <select name="zila_status" id="zila_status" class="select-select2">
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
                <div id="list_div" class="load-table-data" data-href="/getZila"></div>
            </div>
        </div>

        </div>

        <!-- end:: Content -->
    </div>

    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0 col-md-12">
                জেলা সম্পাদনা </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-5">
                <form id="zila_form" onsubmit="submitData(this, '{{route('zila.store')}}'); return false;">

                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="division_name_bng">প্রশাসনিক বিভাগ</label><span class="text-danger">*</span>
                            <select name="geo_division_id" id="geo_division_id" class="form-control rounded-0 select-select2" required>
                                <option value="">বিভাগ নির্বাচন করুন</option>
                                @foreach($bivags as $bivag)
                                    <option data-bivag_bbs_code="{{$bivag->bbs_code}}"
                                            value="{{$bivag->id}}">{{$bivag->division_name_bng}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="district_name_bng">জেলার নাম(বাংলা)</label><span class="text-danger">*</span>
                            <input id="district_name_bng" class="form-control rounded-0" type="text"
                                   name="district_name_bng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="district_name_eng">জেলার নাম(ইংরেজি)</label><span class="text-danger">*</span>
                            <input id="district_name_eng" class="form-control rounded-0" type="text"
                                   name="district_name_eng" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="zila_bbs_code">জেলা BBS কোড</label><span class="text-danger">*</span>

                            <input id="zila_bbs_code" class="form-control rounded-0" type="text" required placeholder="">
                            <input id="zila_bbs_code_hidden" class="form-control rounded-0" type="hidden" name="bbs_code" required>
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
                    <input type="hidden" id="zila_id" name="id">
                    <input type="hidden" id="division_bbs_code" name="division_bbs_code">
                    <input type="hidden" id="created_by" name="created_by" value="0">
                    <input type="hidden" id="modified_by" name="modified_by" value="0">

                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ
                                </button>
                                <a id="reset_btn"  class="btn  btn-danger text-white"><i class="fas fa-sync  mr-2"></i> রিসেট</a>
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


        })

        $(document).ready(function() {
            $('.advance_search').hide();
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
        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });

        $(".create-posasonik").click(function () {
            clearForm('#zila_form');
            $('.kt_quick_panel__title').text('জেলা তৈরি');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            $('#division_bbs_code').val('');
            $('#district_name_bng').val('');
            $('#district_name_eng').val('');
            $('#status').val('');
            $('#status').prop('checked', false);
            $('#zila_bbs_code').val('');
            $('#zila_bbs_code_hidden').val('');
            $('#bivag_bbs_code').val('');
            $('#zila_id').val('');
            $('#geo_division_id').val('');

        })
        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('জেলা সম্পাদন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");

            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var division_name_bng = content_value[0];
            var bivag_bbs_code = content_value[1];
            var zila_id = content_value[2];
            var district_name_bng = content_value[3];
            var district_name_eng = content_value[4];
            var zila_bbs_code = content_value[5];
            var status = content_value[6];
            var bivag_id = content_value[7];

            $('#geo_division_id option[value=' + bivag_id + ']').prop('selected', true);
            var division_code = $('#geo_division_id').children("option:selected").attr('data-bivag_bbs_code');
            $('#division_bbs_code').val(division_code);
            $('#district_name_bng').val(district_name_bng);
            $('#district_name_eng').val(district_name_eng);

            $('#zila_bbs_code').val(zila_bbs_code);
            $('#zila_bbs_code_hidden').val(zila_bbs_code);
            $('#bivag_bbs_code').val(bivag_bbs_code);


            $('#zila_id').val(zila_id);
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
            $('#division_bbs_code').val(division_code);
        });

        $('#btn_excel_generate').on('click',function (){
            var url = 'generate_zila_excel_file';
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

        $('#district_name_bng').bangla({ enable: true });

        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $("#list_div").html(responseData);
            });
        }

        $('#zila_bbs_code').on('blur',function (){
            var number = $(this).val();
            var is_uni = isUnicode(number);
            if (is_uni) {
               var converted =  convertBanglaToEnglishNumber(number);
               $('#zila_bbs_code_hidden').val(converted);
            }else{
                $('#zila_bbs_code_hidden').val(number);
            }
        });

        $("#reset_btn").click(function(){
           var zila_id = $('#zila_id').val();
           if(zila_id){
                $('#zila_id'+zila_id).click();
           }else{
               $('.create-posasonik').click();
           }
        });


    </script>
@endsection
