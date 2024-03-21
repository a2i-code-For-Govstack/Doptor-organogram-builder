@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Menu</h3>
            </div>
            <div class="mr-3 d-flex">
                <button  class="btn btn-sna-header-button-color py-0  d-flex create-posasonik" >
                    <div>
                        <i class="fa fa-plus mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">Create New Menu</p>

                    </div>
                    </button>
            </div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">

                {{--                @include('menu.role.menu.search')--}}

                <div class="kt-portlet__body">
                    <div id="list_div" class="load-table-data" data-href="/role/get_menus">
                    </div>
                </div>

            </div>

            <!-- end:: Content -->
        </div>

        <!-- begin::Form Quick Panel -->
        <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
            <div class="kt_quick_panel__head">
                <h5 class="kt_quick_panel__title mb-0 col-md-12">
                    Edit Menu</span></a></li>
                    <!--<small>5</small>-->
                </h5>
                <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
            </div>
            <div class="kt-quick-panel__content">
                <div class="mt-3">
                    <form id="menu_form"
                          onsubmit="submitData(this, '{{route('role.store_menus')}}'); return false;">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="menu_name">Menu Name</label><span class="text-danger">*</span>
                                <input id="menu_name" class="form-control rounded-0" type="text" name="menu_name"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="menu_link">Menu Link</label>
                                <input id="menu_link" class="form-control rounded-0" type="text" name="menu_link">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="parent_menu_id">Parent Menu</label><span class="text-danger">*</span>
                                <select class="form-control rounded-0 select-select2" name="parent_menu_id"
                                        id="parent_menu_id">
                                    <option value="0">Choose</option>
                                    @foreach($menus as $menu)
                                        <option value="{{$menu->id}}">{{$menu->menu_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="menu_icon">Menu Icon</label>
                                <input name="menu_icon" id="menu_icon" class="form-control rounded-0" type="text"
                                >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="display_order">Menu Order</label>
                                <input name="display_order" id="display_order" class="form-control rounded-0"
                                       type="number">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                        <input autocomplete="off" id="status" type="checkbox" name="status"
                                               checked="" value="1"> Status <span class="text-danger">*</span>
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
                                    <a style="color: #fff" data-id="" id="reset_form"
                                       class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="menu_id" name="id">
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
                $("#kt_quick_panel").removeClass('kt-quick-panel--on');http://127.0.0.1:8000/role/menus
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
                clearForm('#menu_form');
                $('#menu_name').val('');
                $('#menu_link').val('');
                $('#parent_menu_id').val('');
                $('#display_order').val('');
                $('#menu_icon').val('');
                $('#status').prop('checked', true);
                $('#status').val(1);
                $('#menu_id').val('');
                $('#reset_form').data('id', 1);
                $('.kt_quick_panel__title').text('Create Menu');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
            })

            $(document).on('click', ".btntableDataEdit", function () {
                $(".kt_quick_panel__title").text('Edit Menu');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
                var content = $(this).attr('data-content');
                var content_value = content.split(',')
                var id = content_value[0];
                var menu_name = content_value[1];
                var menu_link = content_value[2];
                var menu_icon = content_value[3];
                var parent_menu_id = content_value[4];
                var display_order = content_value[5];
                var status = content_value[6];

                $('#menu_id').val(id);
                $('#menu_name').val(menu_name);
                $('#menu_link').val(menu_link);
                $('#menu_icon').val(menu_icon);
                $('#parent_menu_id').val(parent_menu_id);
                $('#display_order').val(display_order)
                $('#status').val(status);

                if (status == 1) {
                    $('#status').prop('checked', true);
                    $('#status').val(1);
                } else {
                    $('#status').prop('checked', false);
                    $('#status').val(0);
                }
            });

            function submitData(form, url) {
                var data = $(form).serialize();
                var datatype = 'json';

                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    if (responseDate.status === 'success') {
                        loadData();
                        toastr.success(responseDate.msg);
                        $("#kt_quick_panel_close_btn").trigger('click');
                        // location.reload()
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            }

            $(document).on('click', "#reset_form", function () {
                $(".btntableDataEdit").trigger("click");
            });

            function searchData(form, url) {
                var data = $(form).serialize();
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                    $("#list_div").html(responseData);
                });
            }
        </script>
@endsection
