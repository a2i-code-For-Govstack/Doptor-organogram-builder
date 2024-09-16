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
                <h3 class="text-white my-1">Honor Board Officers</h3>
            </div>
            <div class="mr-3 d-flex">

                <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0  d-flex mr-2">
                    <div>
                        <i class="fa fa-download my-1 ml-2 mr-0"></i>
                    </div>

                </button>
            </div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body">
                    @if (Auth::user()->user_role_id == config('menu_role_map.super_admin') || Auth::user()->user_role_id == config('menu_role_map.admin'))
                    <x-office-select grid="4" unit="true" only_office="false"></x-office-select>
                    @endif
                    @if (Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin'))
                    <x-office-select grid="3" unit="true"/>
                    @endif
                    <div class="row mt-2">
                        <div id="list_div" class="load-table-data" data-href="/get_honor_board">

                        </div>
                    </div>
                </div>
                <!--End::Dashboard 1-->
            </div>

            <!-- end:: Content -->
        </div>

        <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
            <div class="kt_quick_panel__head">
                <h5 class="kt_quick_panel__title mb-0">
                    অনার বোর্ড সম্পাদনা </span></a></li>
                    <!--<small>5</small>-->
                </h5>
                <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
            </div>
            <div class="kt-quick-panel__content">
                <div class="mt-5">
                    <form id="honor_board_form" onsubmit="submitData(this, 'store_honor_board'); return false;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="unit_id">শাখা নির্বাচন করুন</label>
                                <select required="" id="unit_id" name="unit_id" class="form-control rounded-0">
                                    <option value="" selected="selected">----বাছাই করুন----</option>
                                    @foreach($office_units as $office_unit)
                                        <option data-id="{{$office_unit->id}}"
                                                value="{{$office_unit->id}}">{{$office_unit->unit_name_bng}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_bng">নাম</label>
                                <input id="name_bng" class="form-control rounded-0" type="text">
                            </div>
                        </div>
                        <!-- <div class="col-md-12">
                            <div class="form-group">
                                <label for="organogram_name">পদবি</label>
                                <input id="organogram_name" class="form-control rounded-0" type="text" name="organogram_name">
                            </div>
                        </div> -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="incharge_label">ইনচার্জ টাইপ </label>
                                <select id="incharge_label" name="incharge_label" class="form-control rounded-0">
                                    <option value="" selected="selected">----বাছাই করুন----</option>
                                    <option value="ভারপ্রাপ্ত">ভারপ্রাপ্ত</option>
                                    <option value="চলতি দায়িত্ব">চলতি দায়িত্ব</option>
                                    <option value="অতিরিক্ত দায়িত্ব">অতিরিক্ত দায়িত্ব</option>
                                    <option value="রুটিন দায়িত্ব">রুটিন দায়িত্ব</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="join_date">যোগদানের তারিখ </label>
                                <input id="join_date" class="form-control rounded-0 date" type="text" name="join_date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="release_date">শেষ অফিস তারিখ </label>
                                <input id="release_date" class="form-control rounded-0 date" type="text"
                                       name="release_date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                        <input id="status" name="status" type="checkbox" value="1"> চলতি
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="honor_board_id" name="id">
                        <input type="hidden" id="organogram_name" name="organogram_name">
                        <input type="hidden" id="organogram_id" name="organogram_id">
                        <input type="hidden" id="employee_record_id" name="employee_record_id">
                        <input type="hidden" id="name" name="name">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ
                                    </button>
                                    <!-- <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> রিসেট
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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

            $('#btn_excel_generate').on('click', function () {
                var url = 'generate_honor_board_excel_file';
                var data = {};
                var datatype = 'json';
                ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    window.open(responseDate.full_path, '_blank');
                });
            });

            $("select#office_unit_id").change(function () {
            var office_unit_id = $(this).children("option:selected").val();
            loadData(office_unit_id);
            });

            function loadData(office_unit_id) {
                url = '';
                if (url === '') {
                    url = $(".load-table-data").data('href');
                }
                var data = {office_unit_id};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $(".load-table-data").html(responseDate);
                });
            }

            // $(document).on('click', "ul.pagination>li>a", function (e) {
            //     e.preventDefault();
            //     loadData($(this).attr('href'));
            // });


            function submitData(form, url) {
                var data = $(form).serialize();
                var datatype = 'json';

                ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                    if (responseDate.status === 'success') {
                        loadData();
                        toastr.success(responseDate.msg);
                        $("#kt_quick_panel_close_btn").trigger('click');
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            }

            $(".create-posasonik").click(function () {
                clearForm('#honor_board_form');
                $('#name').val('');
                $('#name_bng').val('');
                $('#division_name_eng').val('');
                $('#organogram_name').val('');
                $('#honor_board_id').val('');
                $('#join_date').val('');
                $('#organogram_name').val('');
                $('#organogram_id').val('');
                $('#emp_id').val('');
                $('#release_date').val('');
                $('.kt_quick_panel__title').text('অনার বোর্ড');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
            })
            $(document).on('click', ".btntableDataEdit", function () {
                var content = $(this).attr('data-content');
                var content_value = content.split(',')
                var honor_board_id = content_value[0];
                var name = content_value[1];
                var organogram_name = content_value[2];
                var join_date = content_value[3];
                var release_date = content_value[4];
                var incharge_label = content_value[5];
                var unit_id = content_value[6];
                var organogram_id = content_value[7];
                var employee_record_id = content_value[8];

                $('#name').val(name);
                $('#name_bng').val(name);
                $('#organogram_name').val(organogram_name);
                $('#join_date').val(join_date);
                $('#release_date').val(release_date);
                $('#honor_board_id').val(honor_board_id);
                $('#organogram_id').val(organogram_id);
                $('#employee_record_id').val(employee_record_id);

                // var res = incharge_label.replace(/ /g, "\\&");
                if (incharge_label) {
                    $('#incharge_label').val(incharge_label);
                    // $('#incharge_label option[value=' + incharge_label + ']').prop('selected', true);
                }

                $('#unit_id option[value=' + unit_id + ']').prop('selected', true);
                // $('#unit_id').children("option:selected").attr('data-id');
                // if(status==1){
                //     $('#status').prop('checked', true);
                //     $('#status').val(1);
                // }

                $(".kt_quick_panel__title").text('অনার বোর্ড সম্পাদন');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
            });

            $('#name_bng').bangla({ enable: true });

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#name_bng").autocomplete({
                source: function (request, response) {
                    var unit_id = $('#unit_id').val();

                    if (!unit_id) {
                        alert('Please Select Office Unit');
                        $(this).val('');
                    }
                    $.ajax({
                        url: "{{ url('search_employee_office_wise') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            unit_id: unit_id,
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $(this).val(ui.item.label); // display the selected text
                    $('#organogram_id').val(ui.item.organogram_id);
                    $('#organogram_name').val(ui.item.organogram_name);
                    $('#name').val(ui.item.name_bng);
                    $('#employee_record_id').val(ui.item.value);
                    $('#unit_id').val(ui.item.unit_id);
                    return false;
                }
            });
        </script>
@endsection

