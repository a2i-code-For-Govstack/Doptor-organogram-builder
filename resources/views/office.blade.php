@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">
            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Office Management</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->

            <div class="row">
                <div class="col-md-4">
                    {{--                    <x-office-select grid="3" only_office="true" unit="false"/>--}}
                    <div class="form-group">
                        <label for="ministry_id">Ministry</label>
                        <!-- <span class="text-danger">*</span> -->
                        <select id="ministry_id" class="form-control rounded-0 select-select2">
                            <option value="">--Choose--</option>
                            @foreach($ministries as $ministrie)
                                <option value="{{$ministrie->id}}">{{$ministrie->name_bng}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!--Begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card custom-card round-0 shadow-sm border">
                                        <div class="card-header">
                                            <h5>Basic Office</h5>
                                        </div>
                                        <div class="card-body" id="moulik_office_tree">
                                            {{--                                            <div id="kt_tree_3" class="tree-demo"></div>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card custom-card round-0 shadow-sm border">
                                        <div class="card-header">
                                            <h5>Office</h5>
                                        </div>
                                        <div id="kt_ui_loader"></div>
                                        <div class="card-body" id="office_tree">
                                            {{--                                            <div id="kt_tree_7" class="tree-demo"></div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            <h5 class="kt_quick_panel__title mb-0">
                Create Office
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form id="office_form" onsubmit="submitData(this, '{{route('office.store')}}'); return false;">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="geo_division_id">Department</label>
                            <!-- <span class="text-danger">*</span> -->
                            <select id="geo_division_id" name="geo_division_id"
                                    class="form-control rounded-0 select-select2">
                                <option value="0">--Choose--</option>
                                @foreach($bivags as $bivag)
                                    <option value="{{$bivag->id}}">{{$bivag->division_name_bng}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="geo_district_id">Zila</label>
                            <!-- <span class="text-danger">*</span> -->
                            <select id="geo_district_id" name="geo_district_id"
                                    class="form-control rounded-0 select-select2">
                                <option value="0">--Choose--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="geo_upazila_id">Upazila</label>
                            <!-- <span class="text-danger">*</span> -->
                            <select id="geo_upazila_id" name="geo_upazila_id"
                                    class="form-control rounded-0 select-select2">
                                <option value="0">--Choose--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_name_bng">Name (Others)</label><span class="text-danger">*</span>
                            <input id="office_name_bng" class="form-control rounded-0 bangla" type="text"
                                   name="office_name_bng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_name_eng">Name (English)</label><span class="text-danger">*</span>
                            <input id="office_name_eng" class="form-control rounded-0 english" type="text"
                                   name="office_name_eng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="parent_office_id">Higher Office</label>
                            <select id="parent_office_id" name="parent_office_id"
                                    class="form-control rounded-0 select-select2">
                                <option selected="" value="0">--Choose--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_address">Address</label><span class="text-danger">*</span>
                            <textarea id="office_address" class="form-control" name="office_address"
                                      rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_phone">Phone</label>
                            <input id="office_phone" class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                   type="text" name="office_phone">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_mobile">Mobile</label>
                            <input id="office_mobile" class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                   type="text" name="office_mobile" maxlength="11">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_fax">Fax</label>
                            <input id="office_fax" class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                   type="text" name="office_fax">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_email">Email</label>
                            <input id="office_email" class="form-control rounded-0" type="email" name="office_email">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_web">Office Website</label>
                            <input id="office_web" class="form-control rounded-0" type="text" name="office_web">
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="digital_nothi_code">ডিজিটাল নথি কোড (প্রথম ৮টি)</label>
                            <input id="digital_nothi_code" class="form-control rounded-0" type="text"
                                   name="digital_nothi_code">
                        </div>
                    </div> -->
                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="reference_code">রেফারেন্স কোড</label>
                            <input id="reference_code" class="form-control rounded-0" type="text" name="reference_code">
                        </div>
                    </div> -->

                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square save_btn"><i class="fas fa-save mr-2"></i>
                                    Save
                                </button>
                                <!-- <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> বাতিল</button> -->
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="office_id" name="id">
                    <input type="hidden" id="office_ministry_id" name="office_ministry_id">
                    <input type="hidden" id="office_origin_id" name="office_origin_id">
                    <input type="hidden" id="office_layer_id" name="office_layer_id">
                    <input type="hidden" id="custom_layer_id" name="custom_layer_id">
                    <input type="hidden" id="geo_union_id" name="geo_union_id" value="0">
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

        {{--$(document).ready(function () {--}}
        {{--    @if(Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin'))--}}
        {{--    officeOriginByCurrentOfficeID('{{Auth::user()->current_office_id()}}');--}}
        {{--    loadOfficeTree('{{Auth::user()->current_office_id()}}');--}}
        {{--    @endif--}}
        {{--});--}}

        function Edit(id) {
            $('.kt_quick_panel__title').text('Basic Office Unit');
            $("#kt_quick_panel").addClass('kt-quick-panel--on').css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            loadParentOffice($('#ministry_id').val(), id);
            emptyInputField();
            getOfficeInfo(id);
        }

        function addNew(id) {
            var data = {id: id};
            var ministry_id = $('#ministry_id').val();
            loadParentOffice(ministry_id, 0);

            ajaxCallAsyncCallback('{{ url('get_office_info') }}', data, 'json', 'GET', function (response) {
                // console.log(response);
                $('#office_id').val('');
                $('#office_ministry_id').val('');
                $('#office_layer_id').val('');
                $('#office_origin_id').val('');
                $('#custom_layer_id').val('');
                // $('#parent_office_id').val(0);
                clearForm('#office_form');
                $('#geo_division_id').val(0);
                $('#geo_district_id').val(0);
                $('#geo_upazila_id').val(0);
                $('.kt_quick_panel__title').text('Office');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
                $('#office_ministry_id').val(response.office_ministry_id);
                $('#office_layer_id').val(response.office_layer_id);
                $('#office_origin_id').val(response.office_origin_id);
                getCustomLayerId(response.office_layer_id);
                $('#parent_office_id').val(response.id);
                // $("#parent_office_id option:selected").text(response.office_name_bng);
            });
        }

        function Delete(id) {
            swal.fire({
                title: 'Are you want to delete Information?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then(function (result) {
                if (result.value) {
                    var data = {id: id};
                    ajaxCallAsyncCallback('{{ url('office_delete') }}', data, 'json', 'POST', function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.msg);
                            $("#office_tree").html(' ');
                            var office_origin_id = $('#office_origin_id').val();
                            loadOfficeTreeOriginWise(office_origin_id);
                        } else {
                            toastr.error(response.msg);
                        }
                    });
                }
            });

        }

        $("#kt_quick_panel_close_btn").click(function () {
            $("#kt_quick_panel").removeAttr('style');
            $("#kt_quick_panel").css('opacity', 0);
            $("#kt_quick_panel").removeClass('kt-quick-panel--on');
            $("html").removeClass("side-panel-overlay");
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
        $(".create-posasonik").click(function () {
            clearForm('#office_form');
            $('#geo_division_id').val(0);
            $('#geo_district_id_id').val(0);
            $('#geo_upazila_id_id').val(0);
            $('.kt_quick_panel__title').text('Basic Office');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(".btntableDataEdit").click(function () {
            $(".kt_quick_panel__title").text('Edit Basic Office');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });

        $("select#geo_division_id").change(function () {
            var division_id = $(this).children("option:selected").val();
            loadZila(division_id);
        });

        function loadZila(division_id) {
            var url = 'load_zila_division_wise';
            var data = {division_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#geo_district_id").html(responseDate);
            });
        }

        $("select#geo_district_id").change(function () {
            var district_id = $(this).children("option:selected").val();
            loadUpoZila(district_id);
        });

        function loadUpoZila(district_id) {
            var url = 'load_upozila_district_wise';
            var data = {district_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#geo_upazila_id").html(responseDate);
            });
        }

        function loadParentOffice(ministry_id, office_id) {
            var url = 'load_parent_office';
            var data = {ministry_id: ministry_id, office_id: office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                $("#parent_office_id").html(responseData);
            });
        }

        function submitData(form, url) {
            $('.save_btn').prop('disabled', true);
            var data = $(form).serialize();
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                if (responseDate.status === 'success') {
                    $('#office_ministry_id').trigger('change');
                    toastr.success(responseDate.msg);
                    var office_origin_id = $('#office_origin_id').val();
                    loadOfficeTreeOriginWise(office_origin_id);
                    $('.save_btn').prop('disabled', false);
                    $("#kt_quick_panel_close_btn").trigger('click');
                } else {
                    $('.save_btn').prop('disabled', false);
                    toastr.error(responseDate.msg);
                }
            });
        }

        // $("select#office_id").change(function () {
        //     var office_id = $(this).children("option:selected").val();
        //     officeOriginByCurrentOfficeID(office_id);
        // });

        $("select#ministry_id").change(function () {
            var ministry_id = $(this).children("option:selected").val();
            $("#office_tree").html(' ');
            loadOfficeOriginTree(ministry_id);
        });

        function officeOriginByCurrentOfficeID(office_id) {
            var url = 'load_office_origin_by_current_office_id';
            var datatype = 'json';
            var data = {office_id}
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (resp) {
                console.log(resp)
                loadOfficeOriginTree(resp.data)
            });
        }

        function loadOfficeOriginTree(ministry_id) {
            var url = 'load_office_origin_tree';
            var data = {ministry_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#moulik_office_tree").html(responseDate);
                KTTreeview.init();
                $(".kt_tree_21").jstree("open_all");
            });
        }

        $(document).on('click', "#office_origin_tree .jstree-anchor", function (e, data) {
            var link = $(this);//.find('a');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");

            var id = link.data('id'); //clicked node data-id
            emptyInputField();
            $('#geo_division_id').val(0);
            $('#geo_district_id').val(0);
            $('#geo_upazila_id').val(0);
            $('#office_origin_id').val(id);

            var office_ministry = $('#ministry_id').val();
            $('#office_ministry_id').val(office_ministry);
            // alert(office_ministry);
            var office_id = $('#office_id').val();
            getOfficeOriginInfo(id);
            // alert(office_id);
            // $("#parent_office_id option[value=]").attr("disabled", "disabled");

            $('#parent_office_id').val(0);
            loadParentOffice(office_ministry, 0);
            loadOfficeTreeOriginWise(id);
        });


        function loadOfficeTreeOriginWise(id) {
            KTApp.block('#kt_ui_loader');
            var url = 'load_office_tree_origin_wise';
            var data = {id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {

                KTApp.unblock('#kt_ui_loader');
                $("#office_tree").html(responseDate);
                KTTreeview.init();
                $(".kt_tree_23").jstree("open_all");
                getOfficeLayerid(id);
            });
        }

        function getCustomLayerId(office_layer_id) {
            var url = 'get_custom_layer_id';
            var data = {office_layer_id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (resp) {
                $("#custom_layer_id").val(resp.custom_layer_id);
            });
        }

        function getOfficeLayerid(id) {
            var url = 'get_office_layer_id';
            var data = {id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_layer_id").val(responseDate.office_layer_id);
                getCustomLayerId(responseDate.office_layer_id);
            });
        }

        function getOfficeOriginInfo(id) {
            var url = 'get_origin_office_info';
            var data = {id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                $('#office_layer_id').val(responseData.office_layer_id);
                getCustomLayerId(responseData.office_layer_id);
            });
        }

        // $(document).on('click', "#office_tree .jstree-anchor", function (e, data) {
        //     var link = $(this);//.find('a');
        //
        //     $("#kt_quick_panel").addClass('kt-quick-panel--on');
        //     $("#kt_quick_panel").css('opacity', 1);
        //     $("html").addClass("side-panel-overlay");
        //
        //     var id = link.data('id'); //clicked node data-id
        //     // $('#office_origin_id').val(id);
        //     emptyInputField();
        //     $('#office_id').val(id);
        //     getOfficeInfo(id);
        //
        // });

        function emptyInputField() {
            $("#office_form").find('input:text, input:password, input:file, select, textarea').val('');
            $("#office_form").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
        }

        function getOfficeInfo(id) {
            var url = 'get_office_info';
            var data = {id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#geo_division_id option[value=' + responseDate.geo_division_id + ']').prop('selected', true).trigger('change');
                $('#geo_district_id option[value=' + responseDate.geo_district_id + ']').prop('selected', true).trigger('change');
                $('#geo_upazila_id option[value=' + responseDate.geo_upazila_id + ']').prop('selected', true).trigger('change');


                $("#office_id").val(id);
                $("#geo_union_id").val(responseDate.geo_union_id);
                $("#geo_upazila_id").val(responseDate.geo_upazila_id);
                $("#office_name_bng").val(responseDate.office_name_bng);
                $("#office_name_eng").val(responseDate.office_name_eng);
                $("#office_origin_id").val(responseDate.office_origin_id);
                $("#office_layer_id").val(responseDate.office_layer_id);
                $("#parent_office_id").val(responseDate.parent_office_id);
                $("#office_address").val(responseDate.office_address);
                $("#office_phone").val(EngFromBn(responseDate.office_phone));
                $("#office_mobile").val(EngFromBn(responseDate.office_mobile));
                $("#office_fax").val(EngFromBn(responseDate.office_fax));
                $("#office_email").val(responseDate.office_email);
                $("#office_web").val(responseDate.office_web);
                // loadOfficeTreeOriginWise(responseDate.office_origin_id);
                // $("#digital_nothi_code").val(responseDate.digital_nothi_code);
                // $("#reference_code").val(responseDate.reference_code);

            });
        }


        $('#office_name_bng').bangla({ enable: true });

        $('#office_name_eng').on('blur', function () {
            var office_name_eng = $(this).val();
            // function to check unicode or not
            if (isUnicode(office_name_eng) == true) {
                toastr.warning('Please use English word!');
                $(this).val('');
                return false
            }
        });

    </script>
@endsection
