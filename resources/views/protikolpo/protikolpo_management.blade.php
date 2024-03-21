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
                <h3 class="text-white my-1">প্রতিকল্প ব্যবস্থাপনার তালিকা</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row card">
                <div class="card-body">
                    <div id="list_div" class="load-table-data" data-href="/get_portikolpo_list">

                    </div>
                </div>
            </div>


            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <!-- end::Form Quick Panel -->
    <!-- Edit Modal -->
    <div class="modal fade" id="protikolpo_modal" tabindex="-1" role="dialog" aria-labelledby="editModalTable"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">অফিসার নির্বাচন করুন</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="protikolpo_form" onsubmit="submitData(this, 'set_protikolpo'); return false;">
                    <div id="modal_body" class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="office_id"> কার্যালয় </label>
                                    <select id="office_id" name="office_id" class="form-control">
                                        <option selected=""
                                                value="{{$office->id}}">{{$office->office_name_bng}}</option>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="is_unit_admin" id="is_unit_admin" value="{{$is_unit_admin}}">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="office_unit_id"> দপ্তর/শাখা </label>
                                    <select name="office_unit_id" id="office_unit_id"
                                            class="form-control rounded-0 select-select2"
                                            required>
                                        <option value="">--বাছাই করুন--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="designation_id"> পদ </label>
                                    <select name="designation_id" id="designation_id"
                                            class="form-control rounded-0 select-select2"
                                            required>
                                        <option value="">--বাছাই করুন--</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="officer_name">অফিসার</label>
                                    <input class="form-control" id="officer_name" type="text" name="officer_name">
                                    <input class="form-control" id="officer_id" type="hidden" name="officer_id">
                                </div>
                            </div>

                            <div class="col-md-6" style="margin-top: 35px">
                                <div class="form-group">
                                    <div class="kt-checkbox-list">
                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                            <input checked="" class="form-control" id="status" name="status"
                                                   type="checkbox" value="1"> নিজ অফিস
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <input type="hidden" id="pro_office_id" name="pro_office_id">
                        <input type="hidden" id="pro_office_unit_id" name="pro_office_unit_id">
                        <input type="hidden" id="pro_office_unit_organogram_id" name="pro_office_unit_organogram_id">
                        <input type="hidden" id="pro_employee_record_id" name="pro_employee_record_id">
                        <input type="hidden" id="pro_employee_name" name="pro_employee_name">
                        <input type="hidden" id="protikolpo_no" name="protikolpo_no">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
                        <button class="btn btn-primary edit_button">সংরক্ষণ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="protikolpo_assing_modal" tabindex="-1" role="dialog" aria-labelledby="editModalTable"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">দায়িত্ব হস্তান্তরের তারিখ নির্বাচন করুন</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="protikolpo_assign_form" onsubmit="assignProtikolpo(this, 'assign_protikolpo'); return false;">
                    <div id="modal_body" class="modal-body">

                        <div class="row">
                            <div class="col-md-2">
                                <p class="text-right" style="margin-top: 10px">ছুটির সময় </p>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="protikolpo_start_date" placeholder="শুরুর তারিখ" type="text"
                                           name="protikolpo_start_date" class="form-control date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input placeholder="শেষের তারিখ" type="text" id="protikolpo_end_date"
                                           name="protikolpo_end_date"
                                           class="form-control date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group text-right" style="margin-top: 10px">
                                    <div class="kt-checkbox-list">
                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                            <input id="is_show_acting" name="is_show_acting" type="checkbox"> পদবিতে
                                            দেখাবে
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="acting_level" id="acting_level"
                                            class="form-control rounded-0 user-options">
                                        <option selected="selected" value="">--বাছাই করুন--</option>
                                        @foreach($office_incharges as $incharge)
                                            <option value="{{$incharge->name_bng}}">{{$incharge->name_bng}}</option>
                                        @endforeach
                                        <option id="other">অন্যান্য</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="office_unit_organogram_id" name="office_unit_organogram_id">
                        <input type="hidden" id="employee_record_id" name="employee_record_id">
                        <input type="hidden" id="employee_name" name="employee_name">

                        <div class="row">
                            <div class="col-md-12">
                                <div id="employee_protikolpo_list">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary assign_protikolpo_btn edit_button">সংরক্ষণ</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
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

            // loadOfficeUnits(65);
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

        //
        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });


        $("select#office_unit_id").change(function () {
            $('#loader').show();
            var office_id = $('#office_id').val();
            var office_unit_id = $(this).children("option:selected").val();
            loadDesignation(office_id, office_unit_id);
        });

        function loadDesignation(office_id, office_unit_id) {
            var url = 'load_designation_office_unit_wise';
            var data = {office_id, office_unit_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#designation_id").html(responseDate);
                $('#loader').hide();
            });
        }

        $("select#office_id").change(function () {
            $('#loader').show();
            var office_id = $(this).children("option:selected").val();
            loadOfficeUnits(office_id);
        });

        function loadOfficeUnits(office_id) {
            url = 'load_office_unit_office_wise';
            is_unit_admin = '{{$is_unit_admin}}';
            is_office_admin = '{{$is_office_admin}}';
            unit_id = '{{$office_unit_id}}';
            // console.log(unit_id);
            data = {
                office_id: office_id,
                is_unit_admin: is_unit_admin,
                unit_id: unit_id,
                is_office_admin: is_office_admin
            };
            datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_unit_id").html(responseDate);
                $('#loader').hide();
            });
        }

        $("select#designation_id").change(function () {
            designation_id = $(this).val();
            url = 'get_officer_name';
            data = {designation_id};
            datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                $("#officer_name").val(responseData.name_bng);
                $("#officer_id").val(responseData.id);
            });
        });

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                if (responseData.status === 'success') {
                    toastr.success(responseData.msg);
                    location.reload();
                } else {
                    toastr.error(responseData.msg);
                }
            });
        }

        function assignProtikolpo(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (resp) {
                if (resp.status === 'success') {
                    toastr.success('সফলভাবে হালনাগাদ হয়েছে');
                    $('.assign_protikolpo_btn').prop('disabled', true);
                    url = '{{url('employee_protikolpo_list')}}';
                    datatype = 'html';
                    ajaxCallAsyncCallback(url, data, datatype, 'POST', function (response) {
                        $('#employee_protikolpo_list').html(response);
                        location.reload();
                    })
                } else if (resp.status === 'error') {
                    toastr.error(resp.msg);
                }
            })

        }


        $('#protikolpo_start_date').datepicker(
            {
                format: 'dd-mm-yyyy',
                startDate: '{{date('d-m-Y')}}',
                autoclose: true
            }
        );
        $('#protikolpo_end_date').datepicker(
            {
                format: 'dd-mm-yyyy',
                startDate: '{{date('d-m-Y')}}',
                autoclose: true
            }
        );

        $(function () {
            var sel_user_options = $("select.user-options"),
                opts = sel_user_options.find('option');
            sel_user_options.bind('change', function (e) {
                e.preventDefault();
                var optselected = $(this).find("option:selected");
                if (optselected.attr('id') == 'other') {
                    sel_user_options.after("<div class='additional'><input class='form-control' id=other name='other' placeholder='টাইপ করুন'/></div>");
                    var oth = $("input#other");
                    oth.keyup(function (e) {
                        optselected.html($(this).val());
                    });
                } else {
                    $('.additional').hide();
                }
            });
        });
    </script>
@endsection
