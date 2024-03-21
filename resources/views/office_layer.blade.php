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
                <h3 class="text-white my-1">Office Layer</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->

            <!--Begin::Row-->
            <div class="row">
                <form id="office_layer_form"
                      onsubmit="submitData(this, '{{route('office_layer.store')}}'); return false;">

                    <div class="col-md-6">
                        <div class="card custom-card round-0 shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="office_ministry_id">Ministry/Department</label><span
                                                class="text-danger">*</span><br>
                                            <select name="office_ministry_id" id="office_ministry_id"
                                                    class="form-control rounded-0 select-select2" required>
                                                <option value="">--Choose--</option>
                                                @foreach($ministries as $ministry)
                                                    <option value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="custom_layer">Office Custom layer</label>
                                            <select id="custom_layer" name="custom_layer_id"
                                                    class="form-control rounded-0 select-select2">
                                                <option value="">--Choose--</option>
                                                @foreach($custom_layers as $custom_layer)
                                                    <option data-name_eng="{{$custom_layer->name_eng}}"
                                                            data-layer="{{$custom_layer->layer_level}}"
                                                            value="{{$custom_layer->id}}">{{$custom_layer->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name (Others)</label><span class="text-danger">*</span>
                                            <input id="name" name="layer_name_bng" type="text"
                                                   class="form-control rounded-0" placeholder="Name (Others)"
                                                   readonly="readonly" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name (English)</label><span class="text-danger">*</span>
                                            <input id="name_eng" name="layer_name_eng" type="text"
                                                   class="form-control rounded-0" placeholder="Name (English)"
                                                   readonly="readonly" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Layer</label>
                                            <!-- <span class="text-danger">*</span> -->
                                            <input id="layer_level" name="layer_level" type="text"
                                                   class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                                   readonly="readonly" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="layer_sequence">Order</label>
                                            <!-- <span class="text-danger">*</span> -->
                                            <input id="layer_sequence" type="text" name="layer_sequence"
                                                   class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Immediate level</label>
                                            <select name="parent_layer_id" id="parent_layer"
                                                    class="form-control rounded-0 select-select2">
                                                <option value="">--Choose--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="btn-group btn-songrokkhon" role="group"
                                                 aria-label="Button group">
                                                <button class="btn btn-info mt-4"><i class="fas fa-save mr-2"></i>
                                                    Save
                                                </button>
                                                <button type="button" class="btn btn-danger mt-4 reset-btn"><i
                                                        class="fas fa-sync  mr-2"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" id="layer_id">
                </form>
                <div class="col-md-6">
                    <div class="card custom-card round-0 shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Office Layer List</h5>
                        </div>
                        <div class="card-body" id="tree_div">


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
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(".create-posasonik").click(function () {
            $('.kt_quick_panel__title').text('create Ministry/Department');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(".btntableDataEdit").click(function () {
            $(".kt_quick_panel__title").text('Edit Ministry/Department');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })

        $('#custom_layer').on('change', function () {
            layer_id = $(this).children("option:selected").val();
            name = $(this).children("option:selected").text();
            name_eng = $(this).children("option:selected").attr('data-name_eng');
            layer_level = $(this).children("option:selected").attr('data-layer');

            $('#name').val(name);
            $('#name_eng').val(name_eng);
            $('#layer_level').val(layer_level);
        });

        $('#office_ministry_id').on('change', function () {
            ministry_id = $(this).children("option:selected").val();
            getLayer(ministry_id);
            getTree(ministry_id);
        });

        function getLayer(ministry_id) {
            url = 'load_layer_ministry_wise';
            data = {ministry_id};
            datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#parent_layer").html(responseDate);
            });
        }

        function getTree(ministry_id) {
            url = 'load_layer_tree';
            data = {ministry_id};
            datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#tree_div").html(responseDate);
                KTTreeview.init();
            });
        }

        $(document).on('click', ".jstree-anchor", function (e, data) {
            $("#kt_quick_panel").removeClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").removeClass("side-panel-overlay");
            link = $(this);//.find('a');
            console.log(link);
            id = link.data('id');
            url = 'edit_layer';
            data = {id};
            datatype = 'json';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#layer_id').val(responseDate.id);
                // $('#office_ministry_id option[value=' + responseDate.office_ministry_id + ']').prop('selected', true).trigger('change');
                // $('#custom_layer option[value=' + responseDate.custom_layer_id + ']').prop('selected', true).trigger('change');
                $('#office_ministry_id').val(responseDate.office_ministry_id);
                $('#custom_layer').val(responseDate.custom_layer_id);
                $('#name').val(responseDate.name_bng);
                $('#name_eng').val(responseDate.name_eng);
                $('#layer_level').val(responseDate.layer_level);
                $('#layer_sequence').val(responseDate.layer_sequence);
                $('#parent_layer option[value=' + responseDate.parent_layer_id + ']').prop('selected', true);
            });
            return false;

        });

        function submitData(form, url) {
            if ($('#office_ministry_id').val()) {
                data = $(form).serialize();
                datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    if (responseDate.status === 'success') {
                        toastr.success(responseDate.msg);
                        getTree($('#office_ministry_id').val());
                        // $('#office_ministry_id').trigger('change');
                        // $('#office_ministry_id').val(null).trigger('change');
                        // $("#kt_quick_panel_close_btn").trigger('click');
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            } else {
                toastr.error('Choose Ministry/Department');
            }
        }

        $(".reset-btn").click(function () {
            clearForm('#office_layer_form');
            $('#office_ministry_id').val('')
            $('#tree_div').html('');
        })

    </script>

@endsection
