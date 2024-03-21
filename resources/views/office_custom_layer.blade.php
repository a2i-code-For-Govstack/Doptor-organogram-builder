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
                        <p class="mb-0 pt-1">Search</p>

                    </div>
                </button>
            </div>
            <div>
                <h3 class="text-white my-1">Office Custom layer List</h3>
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
                        <p class="mb-0 pt-1"> Create new office layer</p>

                    </div>
                </button>
            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">

                <div class="row mb-2">
                    <div class="col-md-12">
                        <div style="display:none" class="card custom-card shadow-sm w-100 advance_search">
                            <div class="card-header">
                                <h5 class="mb-0"></h5>
                            </div>
                            <div class="card-body">
                                <form onsubmit="searchData(this, 'search_custom_layer'); return false;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Name (Others)" id="name_bn"
                                                       class="form-control rounded-0" type="text" name="name_bn">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Name (English)" id="name_en"
                                                       class="form-control rounded-0" type="text" name="name_en">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Layer Level" id="layer_level"
                                                       class="form-control rounded-0" type="text" name="layer_level">
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <div class="form-group">
                                                <button class="btn btn-info">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card custom-card rounded-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="kt-portlet__body">
                                        <div class="col-md-12 mt-3">
                                            <div id="list_div" class="load-table-data"
                                                 data-href="{!! url('/getOfficeCustomLayer') !!}">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--End::Dashboard 1-->
            </div>

            <!-- end:: Content -->
        </div>


        <!-- begin::Form Quick Panel -->
        <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
            <div class="kt_quick_panel__head">
                <h5 class="kt_quick_panel__title mb-0 col-md-12">
                    Create New Office Layer
                    <!--<small>5</small>-->
                </h5>
                <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
            </div>
            <div class="kt-quick-panel__content">
                <div class="mt-3">
                    <form id="office_custom_layer_form"
                          onsubmit="submitData(this, '{{route('custom_office_layer.store')}}'); return false;">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name (Others)</label><span class="text-danger">*</span>
                                <input id="name" class="form-control rounded-0 bangla" type="text" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_eng">Name (English)</label><span class="text-danger">*</span>
                                <input id="name_eng" class="form-control rounded-0 english" type="text" name="name_eng"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="layer_level">Layer</label><span class="text-danger">*</span>
                                <input id="layer_level" class="form-control rounded-0 bijoy-bangla integer_type_positive" type="text" name="layer_level" required>
                                {{-- <input id="layer_level_hidden" class="form-control rounded-0" type="hidden" name="layer_level" required> --}}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save
                                    </button>
                                    <a id="reset_btn" class="btn  btn-danger text-white"><i
                                            class="fas fa-sync  mr-2"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="layer_id" name="id">
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
                    $(".mt-3 .load-table-data").html(responseDate);
                });
            }

            $(".create-posasonik").click(function () {
                clearForm('#office_custom_layer_form');
                $('#layer_id').val('');
                $('#name').val('');
                $('#name_eng').val('');
                $('#layer_level').val('');
                $('#layer_level_hidden').val('');

                $('.kt_quick_panel__title').text('Create New Office Layer');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
            })

            $('#btn_excel_generate').on('click', function () {
                var url = 'generate_office_custom_layer_excel_file';
                var data = {};
                var datatype = 'json';
                ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    window.open(responseDate.full_path, '_blank');
                });
            });

            $(document).on('click', ".btntableDataEdit", function () {
                $(".kt_quick_panel__title").text('Edit Office Custom layer');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");

                var content = $(this).attr('data-content');

                var content_value = content.split(',')
                var id = content_value[0];
                var name = content_value[1];
                var name_eng = content_value[2];
                var layer_level = content_value[3];

                $('#layer_id').val(id);
                $('#name').val(name);
                $('#name_eng').val(name_eng);
                $('#layer_level').val(layer_level);
                $('#layer_level_hidden').val(EngFromBn(layer_level));

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

            function searchData(form, url) {
                var data = $(form).serialize();
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                    $("#list_div").html(responseData);
                });
            }

            $("#reset_btn").click(function () {
                var layer_id = $('#layer_id').val();
                if (layer_id) {
                    $('#layer_id' + layer_id).click();
                } else {
                    $('.create-posasonik').click();
                }
            });
            $('#layer_level').on('blur', function () {
                var number = $(this).val();
                var is_uni = isUnicode(number);
                if (is_uni) {
                    var converted = convertBanglaToEnglishNumber(number);
                    $('#layer_level_hidden').val(converted);
                } else {
                    $('#layer_level_hidden').val(number);
                }
            });

            $('#name_bn').bangla({ enable: true });
        </script>
@endsection
