@extends('master')
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Layer based Office List</h3>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_ministry">Office Ministry</label>
                                        <select id="office_ministry" class="form-control rounded-0 select-select2"
                                                name="">
                                            <option value="" selected="selected">----Choose----</option>
                                            @foreach($ministries as $ministry)
                                                <option value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_layer_id">Ministry/ Department </label>
                                        <select name="office_layer" id="office_layer_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0 shadow-sm">
                        <div class="card-body" id="layer_wise_office_list">
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
                            <label for="office_name_bng">Office Name</label><span class="text-danger">*</span>
                            <input id="office_name_bng" class="form-control rounded-0" type="text"
                                   name="office_name_bng" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save
                                </button>
                                <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> Cancal
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="office_id" name="id">
                    <input type="hidden" id="office_ministry_id" name="office_ministry_id">
                    <input type="hidden" id="office_origin_id" name="office_origin_id">
                    <input type="hidden" id="office_layer_id" name="office_layer_id">
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
            $('.kt_quick_panel__title').text('Basic Office');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('Edit Basic Office');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var id = content_value[0];
        });


        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                if (responseDate.status === 'success') {
                    $('#office_ministry_id').trigger('change');
                    toastr.success(responseDate.msg);
                    $("#kt_quick_panel_close_btn").trigger('click');
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        }

        $('#office_ministry').on('change', function () {
            var ministry_id = $(this).children("option:selected").val();
            $('#office_ministry_id').val(ministry_id);
            loadLayer(ministry_id);
        });

        function loadLayer(ministry_id) {
            var url = 'load_layer_ministry_wise';
            var data = {ministry_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_layer_id").html(responseDate);
            });
        }

        $("select#office_layer_id").change(function () {
            var office_layer_id = $(this).children("option:selected").val();
            $('#office_layer').val(office_layer_id);
            var ministry_id = $('#office_ministry_id').val();
            loadOfficeLayerMinistryWise(ministry_id,office_layer_id);
        });

        function loadOfficeLayerMinistryWise(ministry_id,office_layer_id) {
            var url = 'load_ministry_wise_layer_list';
            var data = {ministry_id,office_layer_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#layer_wise_office_list").html(responseDate);
            });
        }




        // $('#office_name_bng').on('blur',function (){
        //     var office_name_bng = $(this).val();
        //     // function to check unicode or not
        //     if (isUnicode(office_name_bng) == false) {
        //         toastr.warning('অনুগ্রহ করে বাংলা শব্দ ব্যবহার করুন |');
        //         $(this).val('');
        //         return false
        //     }
        // });

        // $('#office_name_eng').on('blur',function (){
        //     var office_name_eng = $(this).val();
        //     // function to check unicode or not
        //     if (isUnicode(office_name_eng) == true) {
        //         toastr.warning('অনুগ্রহ করে ইংরেজি শব্দ ব্যবহার করুন |');
        //         $(this).val('');
        //         return false
        //     }
        // });

    </script>
@endsection
