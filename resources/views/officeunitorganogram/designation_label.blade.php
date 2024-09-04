@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
        id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Doptor Sections List</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card  w-100">
                        <div class="card-header alert-info">
                            <h4 class="text-center mb-0">Defaults to '' if designation level/order is zero or blank.</h4>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- begin:: Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card  w-100">
                        <div class="card custom-card rounded-0 shadow-sm">
                            <div class="card-body">
                                @if (Auth::user()->user_role_id == config('menu_role_map.super_admin') || Auth::user()->user_role_id == config('menu_role_map.admin'))
                                    <x-office-select grid="4" unit="true" only_office="false">
                                    </x-office-select>
                                @endif
                                <div>
                                    <div class="mb-0 load-table-data" id="list_div">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- begin:: Content -->
        </div>
        <!-- begin::Form Quick Panel -->
        <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
            <div class="kt_quick_panel__head">
                <h5 class="kt_quick_panel__title mb-0 col-md-12">
                    Edit designation layer </span></a></li>
                    <!--<small>5</small>-->
                </h5>
                <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i
                        class="flaticon2-delete"></i></a>
            </div>
            <div class="kt-quick-panel__content">
                <div class="mt-3">
                    <form id="menu_form";
                        onsubmit="submitData(this, '{{ route('save.designation_lebel') }}'); return false;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="designation_level">Designation Layer</label>
                                <input name="designation_level" id="designation_level" class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                    type="text" maxlength="3">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="designation_sequence">Designation Sl.</label>
                                <input name="designation_sequence" id="designation_sequence" class="form-control rounded-0 bijoy-bangla integer_type_positive"
                                    type="text" maxlength="3">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i>
                                        Save
                                    </button>
                                    <a style="color: #fff" data-id="" id="reset_form"
                                        class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="designation_id" name="id">
                        <input type="hidden" id="unit_id" name="unit_id">
                    </form>
                </div>
            </div>
        </div>
        <!-- end::Form Quick Panel -->

        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            if ($(".load-table-data").length > 0) {
                loadData();
            }
        });

        $("select#office_unit_id").change(function() {
            var unit_id = $(this).children("option:selected").val();
            $('#unit_id').val(unit_id);
            loadData(unit_id);
        });

        function loadData(unit_id) {
            var url = '{{ url('/designation_label_list') }}'
            var data = {
                unit_id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $(".load-table-data").html(responseData);
            });
        }

        @if (session('success'))
            toastr.success('{{ session('success') }}')
        @endif

        @if (session('error'))
            toastr.error('{{ session('error') }}')
        @endif

        $("#kt_quick_panel_close_btn").click(function() {
            $("#kt_quick_panel").removeAttr('style');
            $("#kt_quick_panel").css('opacity', 0);
            $("#kt_quick_panel").removeClass('kt-quick-panel--on');
            $("html").removeClass("side-panel-overlay");
        });

        $(document).on('click', ".btntableDataEdit", function() {
            $(".kt_quick_panel__title").text('Edit Designation Layer');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var id = content_value[0];
            var designation_level = content_value[1];
            var designation_sequence = content_value[2];

            $('#designation_id').val(id);
            $('#designation_level').val(designation_level);
            $('#designation_sequence').val(designation_sequence);
        });

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                if (responseData.status === 'success') {
                    loadData($("#office_unit_id").val());
                    toastr.success(responseData.msg);
                    $("#kt_quick_panel_close_btn").trigger('click');
                } else {
                    toastr.error(responseData.msg);
                }
            });
        }

        $(document).on('click', "#reset_form", function() {
            $(".btntableDataEdit").trigger("click");
        });

        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $("#list_div").html(responseData);
            });
        }
    </script>
@endsection
