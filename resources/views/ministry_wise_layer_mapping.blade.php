@extends('master')
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Ministry based custom layer mapping</h3>
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
                                        <label for="office_ministry">Ministry</label>
                                        <select id="office_ministry" class="form-control rounded-0 select-select2"
                                                name="">
                                            <option value="" selected="selected">----Choose----</option>
                                            @foreach($ministries as $ministry)
                                                <option value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card custom-card round-0 shadow-sm">

                                        <div class="card-body" id="layer_wise_office_list">
                                            <table class="table table-bordered table-hover"><thead>
                                                <tr class="heading">
                                                    <th class="text-center">Sl.</th>
                                                    <th class="text-center">Main layer Name</th>
                                                    <th class="text-center">Custom Layer</th>
                                                   <th class="text-center"> Activity</th>
                                                </tr>
                                                </thead>

                                                <tbody id="addData">

                                                </tbody>
                                            </table>
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
                Create Office
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form id="office_form" onsubmit="submitData(this, '{{route('layer.store')}}'); return false;">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="layer_name_bng">Main Layer</label>
                            <input id="layer_name_bng" class="form-control rounded-0" type="text"
                                   name="layer_name_bng" disabled>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="custom_layer_id">Custom Layer</label>
                            <select id="custom_layer_id" class="form-control rounded-0 select-select2" name="custom_layer_id">
                            <option value="" selected="selected">--Choose--</option>
                            @foreach($custom_layers as $custom_layer)
                                <option value="{{$custom_layer->id}}">{{$custom_layer->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>

                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save
                                </button>
                                <a id="reset_btn" class="btn  btn-danger text-white"><i class="fas fa-sync  mr-2"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="layer_id" class="form-control rounded-0" type="text" name="layer_id">
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

        $("#reset_btn").click(function(){
                var office_id = $('#office_id').val();
                if(office_id){
                    $('#office_id'+office_id).click();
                }else{
                    $('.create-posasonik').click();
                }
            });

        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('Edit Custom Layer');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            $("#layer_id").val($(this).data("id"));
            $("#layer_name_bng").val($(this).data("content"));
        });


        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                if (responseDate.status === 'success') {
                    $('#office_ministry_id').trigger('change');
                    toastr.success(responseDate.msg);
                    $("#kt_quick_panel_close_btn").trigger('click');
                    var ministry_id = $("select#office_ministry").val();
                    loadOfficeLayerMinistryWise(ministry_id);

                } else {
                    toastr.error(responseDate.msg);
                }
            });
        }

        $('#office_ministry').on('change', function () {
            var ministry_id = $(this).children("option:selected").val();

            loadOfficeLayerMinistryWise(ministry_id);
        });

        function loadOfficeLayerMinistryWise(ministry_id) {
            var url = 'load_layer_and_custom_layer_ministry_wise';
            var data = {ministry_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#layer_wise_office_list").html(responseDate);
            });
        }




        $('#office_name_bng').bangla({ enable: true });

        $('#office_name_eng').on('blur',function (){
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
