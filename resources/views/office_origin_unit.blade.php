@extends('master')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Basic Office Branch</h3>
            </div>
            <div class="mr-3 d-flex"></div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->

            <!--Begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_ministry_id">Ministry</label>
                                        <select name="office_ministry" id="office_ministry_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="">--Choose--</option>
                                            @foreach($ministries as $ministry)
                                                <option value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_layer_id">Ministry/Department</label>
                                        <select name="office_layer" id="office_layer_id" class="form-control rounded-0 select-select2">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_origin_id">Doptor/Odhidoptor Type</label>
                                        <select name="office_origin" id="office_origin_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="ml-4">
                                    <h5 class="text-dark mb-2">Basic Branch</h5>
                                    {{--                                            <button type="button" class="btn btn-info rounded-0 float-left">নতুন জোগ করুন</button>--}}
                                    <button id="new_create_btn"
                                            class="btn btn-primary mb-3 btn-square create-posasonik float-left"
                                            data-dismiss="modal"><i class="fas fa-plus-circle"></i> Add New
                                    </button>
                                </div>
                                <div class="col-md-12">
                                    <div class="card card-custom border-0">
                                        <div class="card-body tree_div">
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
            <h5 class="kt_quick_panel__title mb-0 col-md-12">
                Basic Office Branch </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form id="office_origin_unit_form" onsubmit="submitData(this, '{{route('office_origin_unit.store')}}'); return false;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_unit_category">Branch type</label><span class="text-danger">*</span>
                            <select name="office_unit_category" id="office_unit_category"
                            class="form-control rounded-0 select-select2">
                                <option value="" selected="">--Choose--</option>
                                @foreach($office_unit_category as $category)
                                <option value = '{{$category->id}}'>{{$category->category_name_bng}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="parent_unit_id">Parent Branch</label>
                            <select id="parent_unit_id" class="form-control rounded-0 select-select2" type="text"
                                   name="parent_unit_id">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="unit_name_bng">Name (Others)</label><span class="text-danger">*</span>
                            <input id="unit_name_bng" class="form-control rounded-0 bangla" type="text" name="unit_name_bng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="unit_name_eng">Name (English)</label><span class="text-danger">*</span>
                            <input id="unit_name_eng" class="form-control rounded-0 english" type="text" name="unit_name_eng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="unit_level">Layer</label>
                            <input id="unit_level" class="form-control rounded-0 bijoy-bangla"  type="text" name="unit_level" value="0">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="unit_sequence">Sl.</label>
                            <input id="unit_sequence" class="form-control rounded-0 bijoy-bangla" type="text" name="unit_sequence" value="0">
                        </div>
                    </div>
                    <div id="total_insert_div" class="col-md-12" style="display: none">
                        <div class="form-group">
                            <label for="total_insert">How many want to add?</label>
                            <input id="total_insert" class="form-control rounded-0" type="text" name="total_insert" value="1">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="kt-checkbox-list">
                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                    <input id="status" type="checkbox" name="active_status" value="0"> Status
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
                                <!-- <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> রিসেট
                                </button> -->
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="unit_id" name="id">
                    <input type="hidden" id="office_ministry" name="office_ministry_id">
                    <input type="hidden" id="office_origin" name="office_origin_id">
                    <input type="hidden" id="office_layer" name="office_layer_id">
{{--                    <input type="hidden" id="active_status" name="active_status" value="1">--}}
                    <input type="hidden" id="created_by" name="created_by" value="{{ \Auth::user()->id }}">
                    <input type="hidden" id="modified_by" name="modified_by" value="{{ \Auth::user()->id }}">
{{--                    <input type="hidden" id="parent_unit_id" name="parent_unit_id" value="0">--}}

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
        function Edit(id){
                var data = {table : $("#dataTable").val(), id: id};
                var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
                var office_layer_id = $('#office_layer_id').children("option:selected").val();
                var office_origin_id = $('#office_origin_id').children("option:selected").val();
                loadParentOriginUnit(office_ministry_id,office_layer_id,office_origin_id);

                ajaxCallAsyncCallback('{{ route('get_office_origin_data') }}', data, 'json', 'POST', function (response) {
                clearForm('#office_origin_unit_form');
                $("#unit_id").val(id);
                $("#office_unit_category").val(response.office_unit_category);
                $("#unit_name_eng").val(response.unit_name_eng);
                $("#unit_name_bng").val(response.unit_name_bng);
                $("#unit_level").val(response.unit_level);
                $("#unit_sequence").val(response.unit_sequence);
                if(response.active_status == 1) {
                    $("#status").prop('checked', true);
                }else{
                    $("#status").prop('checked', false);
                }
                $('#status').val(response.active_status);
                $('.kt_quick_panel__title').text('Basic Office Branch');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
                $('#total_insert_div').addClass('d-none');
                $("#parent_unit_id").val(response.parent_unit_id);
            });
        }
        function addNew(id){
                var data = {table : $("#dataTable").val(), id: id};
                var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
                var office_layer_id = $('#office_layer_id').children("option:selected").val();
                var office_origin_id = $('#office_origin_id').children("option:selected").val();
                loadParentOriginUnit(office_ministry_id,office_layer_id,office_origin_id);
                ajaxCallAsyncCallback('{{ route('get_office_origin_data') }}', data, 'json', 'POST', function (response) {
                clearForm('#office_origin_unit_form');
                $("#unit_id").val(0);
                $('.kt_quick_panel__title').text('Basic Office Branch');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
                $('#total_insert_div').removeClass('d-none');
                $('#total_insert').val(1);
                $('#unit_level').val(0);
                $('#status').prop('checked', true);
                $('#status').val(1);
                $("#parent_unit_id").val(id);
            });
        }
        function Delete(id){
        $.confirm({
            title: 'Are you sure?',
            content: ' ',
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Delete',
                    btnClass: 'btn-red',
                    action: function(){
                        var data = {table : $("#dataTable").val(), id: id};
                        ajaxCallAsyncCallback('{{ route('office_origin_remove') }}', data, 'json', 'POST', function (response) {
                            if (response.status === 'success') {
                                var office_origin_id = $('#office_origin_id').children("option:selected").val();
                                toastr.success(response.msg);
                                $("#kt_quick_panel_close_btn").trigger('click');
                                $('#office_origin_id option[value=' + office_origin_id + ']').prop('selected', true).trigger('change');
                            } else {
                                toastr.error(response.msg);
                            }
                        });
                    }
                },
                close: {
                    text: 'না'
                }
            }
        });
        }

        $('#new_create_btn').hide();
        $("#kt_quick_panel_close_btn").click(function () {
            $("#kt_quick_panel").removeAttr('style');
            $("#kt_quick_panel").css('opacity', 0);
            $("#kt_quick_panel").removeClass('kt-quick-panel--on');
            $("html").removeClass("side-panel-overlay");
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(".create-posasonik").click(function () {
            clearForm('#office_origin_unit_form');
            $('.kt_quick_panel__title').text('Basic Office Branch');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            $('#unit_id').val('');
            $('#office_ministry').val('');
            $('#office_origin').val('');
            $('#office_layer').val('');
            $('#total_insert_div').removeClass('d-none');
            $('#total_insert').val(1);
            $('#unit_level').val(0);
            $('#status').prop('checked', true);
            $('#status').val(1);
            var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
            var office_layer_id = $('#office_layer_id').children("option:selected").val();
            var office_origin_id = $('#office_origin_id').children("option:selected").val();

            $('#office_ministry').val(office_ministry_id);
            $('#office_origin').val(office_origin_id);
            $('#office_layer').val(office_layer_id);
            loadParentOriginUnit(office_ministry_id,office_layer_id,office_origin_id);
        })
        $(".btntableDataEdit").click(function () {
            $(".kt_quick_panel__title").text('Edit Basic Office Branch');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });

        $("select#office_ministry_id").change(function () {
            var ministry_id = $(this).children("option:selected").val();

            $('#office_ministry').val(ministry_id);
            loadLayer(ministry_id);
        });

        function loadLayer(ministry_id) {
            var url = 'load_layer_ministry_wise';
            var data = {ministry_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_layer_id").html(responseDate);
            });
        }

        $("select#office_layer_id").change(function () {
            var office_layer_id = $(this).children("option:selected").val();
            $('#office_layer').val(office_layer_id);
            loadOfficeOrigin(office_layer_id);
        });

        function loadOfficeOrigin(office_layer_id) {
            var url = 'load_office_origin_layer_wise';
            var data = {office_layer_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_origin_id").html(responseDate);

            });
        }


        $("select#office_origin_id").change(function () {
            var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
            var office_layer_id = $('#office_layer_id').children("option:selected").val();
            var office_origin_id = $(this).children("option:selected").val();
            loadTree(office_ministry_id, office_layer_id, office_origin_id);
            $('#office_origin').val(office_origin_id);
            $('#new_create_btn').show();
        });

        function loadTree(office_ministry_id, office_layer_id, office_origin_id) {
            var url = 'load_office_unit_origin_unit_tree';
            var data = {office_ministry_id, office_layer_id, office_origin_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $(".tree_div").html(responseDate);
                KTTreeview.init();
                $(".kt_tree_24").jstree("open_all");
                let treeData = $(".jstree-anchor");
                treeData.each(function(index, value) {
                    var html = $(value).html();
                    $(value).empty();
                    $(value).after(html);
                })
            });
        }


        $(document).on('click', ".jstree-ocl", function () {

            let treeData = $(".jstree-anchor");
            treeData.each(function(index, value) {
                var html = $(value).html();
                $(value).empty();
                $(value).after(html);
            })

        });


        $(document).on('click', ".jstree-clicked", function (e, data) {

            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            var link = $(this);//.find('a');
            var id = link.data('id');

            var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
            var office_layer_id = $('#office_layer_id').children("option:selected").val();
            var office_origin_id = $('#office_origin_id').children("option:selected").val();
            loadParentOriginUnit(office_ministry_id,office_layer_id,office_origin_id);
            var url = 'edit_office_origin_unit';
            var data = {id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                // console.log(responseDate);
                $('#unit_id').val(responseDate.id);
                $('#unit_name_bng').val(responseDate.unit_name_bng);
                $('#unit_name_eng').val(responseDate.unit_name_eng);
                $('#office_unit_category').val(responseDate.office_unit_category);
                $('#unit_level').val(responseDate.unit_level);
                $('#office_ministry').val(responseDate.office_ministry_id);
                $('#office_origin').val(responseDate.office_origin_id);
                $('#office_layer').val(responseDate.office_layer_id);
                // $('#parent_unit_id').val(responseDate.parent_unit_id);
                $('#parent_unit_id option[value=' + responseDate.parent_unit_id + ']').prop('selected', true);
                $('#parent_unit_id option[value=' + responseDate.id + ']').prop('disabled', true);
            });
        });

        function loadParentOriginUnit(office_ministry_id,office_layer_id,office_origin_id)
        {
            var url = 'load_parent_office_origin_unit';
            var data = {office_ministry_id,office_layer_id,office_origin_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#parent_unit_id').html(responseDate);
            });
        }

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                if (responseDate.status === 'success') {
                    var office_origin_id = $('#office_origin_id').children("option:selected").val();
                    toastr.success(responseDate.msg);
                    $("#kt_quick_panel_close_btn").trigger('click');
                    $('#office_origin_id option[value=' + office_origin_id + ']').prop('selected', true).trigger('change');
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        }
    </script>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endsection
