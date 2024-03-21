@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">


        {{-- SNA SUB HEADER START --}}
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3">

            </div>


            <div>
                <h3 class="text-white my-1">
                    Employee management
                </h3>
            </div>


            <div class="mr-3 d-flex">


            </div>


        </div>

    {{-- SNA SUB HEADER END --}}

    <!--Start::Modal-->
    <div class="modal fade bd-example-modal-lg" id="unassignModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">Change the Office Admin role</h5>
                    <button type="button" class="close distroy-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="edit_form">
                    <div id="modal_body" class="modal-body">

                    </div>
                    @method('POST')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger distroy-modal" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::Modal-->

    <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card  w-100">
                        <div class="card-header" style="background: #eaedf1">
                            <h4 class="mb-0">Search with Login ID/National Identity Card/Mobile/Email of Officer
                            </h4>
                        </div>
                        <div class="card-body">
                            <form onsubmit="submitData(this, '{{route('get_employee_info')}}'); return false;">
                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="username">Login Id</label>
                                            <input id="username" class="form-control rounded-0" type="text"
                                                   name="username">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nid">National Id Card</label>
                                            <input id="nid" class="form-control rounded-0" type="text" name="nid">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="phone">Mobile</label>
                                            <input id="phone" class="form-control rounded-0" type="text" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" class="form-control rounded-0" type="text" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <div class="form-group">
                                            <button id="searchButton" class="btn btn-info btn-font-lg"><i
                                                    class="fa fa-search mr-2"></i>Search
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3" id="employee_info"></div>

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>



    <div class="kt-content mt-4 kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        {{-- SNA SUB HEADER START --}}
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" style="background: #6c757d !important"
            id="kt_subheader">
            <div class="ml-3">
            </div>
            <div>
                <h3 class="text-white my-1">
                    {{$office_name}}
                </h3>
            </div>
            <div class="mr-3 d-flex">
            </div>
        </div>
    {{-- SNA SUB HEADER END --}}

    <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->


            <div id="employee_management_view">
                <i class="fa fa-spinner fa-pulse"></i>
            </div>
            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>











    <!-- begin::Form Quick Panel -->
    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0">
                New Batch </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form action="">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Batch No.</label>
                            <input id="" class="form-control rounded-0" type="text" name="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Joining Date</label>
                            <input id="" class="form-control rounded-0" type="text" name="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save
                                </button>
                                <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end::Form Quick Panel -->
    <img id="loader" src="{{asset('assets/plugins/global/images/owl.carousel/ajax-loader.gif')}}" alt="">
    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">

        $(document).ready(function () {
            loadEmployeeManagement('{{$office_id}}');
        })

        function loadEmployeeManagement(office_id) {
            url = '{{url('employee_management')}}';
            data = {office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                $("#employee_management_view").html(responseDate);
            });
        }


        $('#loader').hide();
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
            $('.kt_quick_panel__title').text('Create New Batch');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(".btntableDataEdit").click(function () {
            $(".kt_quick_panel__title").text('Edit Batch');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#employee_info').html(responseDate);
            });
        }

        $("select#office_ministry_id").change(function () {
            var ministry_id = $(this).children("option:selected").val();
            $('#office_ministry').val(ministry_id);
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
            loadOfficeOrigin(office_layer_id);
        });

        function loadOfficeOrigin(office_layer_id) {
            var url = 'load_office_origin_layer_wise';
            var data = {office_layer_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_origin_id").html(responseDate);

            });
        }


        $("select#office_origin_id").change(function () {
            var office_origin_id = $(this).children("option:selected").val();
            loadOffice(office_origin_id);
        });

        function loadOffice(office_origin_id) {
            var url = 'load_office_origin_wise';
            var data = {office_origin_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_id").html(responseDate);

            });
        }

        $("select#office_id").change(function () {
            $('#loader').show();
            var office_id = $(this).children("option:selected").val();
            loadOfficeUnits(office_id);

        });

        function loadOfficeUnits(office_id) {
            var url = 'load_office_wise_units';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_unit_div").html(responseDate);
                $('#loader').hide();
            });
        }

        $(document).on('click', '#disable_designation', function () {
            var office_id = $(this).attr('data-office_id');
            var date = $('#last_office_date_' + office_id).val();
            var employee_record_id = $(this).attr('data-employee_record_id');

            var organogram_id = $(this).attr('data-org_id');
            $.ajax({
                method: "GET",
                url: "check_office_admin/" + organogram_id,
                data: organogram_id,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                    if (data.status == 'success') {
                        swal.fire({
                        title: 'Do you want to hand over office admin duties?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then(function (result) {
                        if (result.value) {
                            loadUnassignOfficeAdmin();
                        } else {
                            unAssignUser(date, office_id, employee_record_id);
                        }
                    })
                    } else {
                        unAssignUser(date, office_id, employee_record_id);
                    }
                }
            });
        });

        function loadUnassignOfficeAdmin() {
            var office_id = $(this).attr('data-office_id');
                $.ajax({
                method: "GET",
                url: "release_assign_user/" + office_id,
                data: office_id,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                    $("#modal_body").html(data);
                    $("#unassignModal").modal("show");
                }
            });
        }

        function unAssignUser(date, office_id, employee_record_id) {
            office_admin = '{{$office_admin}}';
            user_employee_id = '{{Auth::user()->employee_record_id}}';
            current_user_designation_id = '{{Auth::user()->current_designation_id()}}';
            var release_designation_id = $(this).attr('data-org_id');


            // if(office_admin && current_user_designation_id == release_designation_id){
            //     toastr.warning('আপনি অফিস অ্যাডমিন পদে রয়েছেন অব্যাহতির করিতে পারিবেন না');
            //     return;
            // }

            swal.fire({
                title: 'Do you want to avoid this surname?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then(function (result) {
                if (result.value) {

                    var url = 'disable_designation';
                    var data = {office_id, employee_record_id, date};
                    var datatype = 'json';

                    ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                        if (responseDate.status === 'success') {
                            toastr.success(responseDate.msg);
                            $('#searchButton').trigger('click');
                            loadEmployeeManagement('{{$office_id}}');
                        } else {
                            toastr.error(responseDate.msg);
                        }
                    });
                }
            });

        }

        $(document).on('click', '.addOfficeEmployee', function () {
            var org_id = $(this).data('id');
            var office_unit_id = $('#office_unit_id' + org_id).val();
            var office_id = $('#office_id' + org_id).val();
            var designation_bng = $('#designation_bng' + org_id).val();
            var designation_eng = $('#designation_eng' + org_id).val();
            var designation_level = $('#designation_level' + org_id).val();
            var designation_sequence = $('#designation_sequence' + org_id).val();
            var unit_name_bn = $('#unit_name_bn' + org_id).val();
            var unit_name_en = $('#unit_name_en' + org_id).val();
            var office_name_bng = $('#office_name_bng' + org_id).val();
            var office_name_eng = $('#office_name_eng' + org_id).val();
            var employee_record_id = $('#emp_id').val();
            var identification_number = $('#userName').val();
            var incharge_label = $('#incharge_label' + org_id).val();
            var joining_date = $('#joining_date' + org_id).val();

            swal.fire({
                title: 'Do you want to take responsibility for this position?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then(function(result) {
                if (result.value) {
                    var url = 'assing_office_employee';

                    var data = {
                        org_id,
                        office_unit_id,
                        office_id,
                        designation_bng,
                        designation_eng,
                        designation_level,
                        designation_sequence,
                        unit_name_bn,
                        unit_name_en,
                        office_name_bng,
                        office_name_eng,
                        employee_record_id,
                        identification_number,
                        incharge_label,
                        joining_date
                    };
                    var datatype = 'json';
                    ajaxCallUnsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                        if (responseDate.status === 'success') {
                            toastr.success(responseDate.msg);
                            // location.reload();
                            $('#searchButton').trigger('click');
                            loadEmployeeManagement('{{$office_id}}');
                            var office = $('#office_id').val();
                            $('select[name="office_id"]').val(office).trigger('change');
                            // $('#office_id option[value=' + office + ']').prop('selected', true).trigger('change');
                        } else {
                            toastr.error(responseDate.msg);
                        }
                    });

                }
            });
        });
    </script>
    <script !src="">
        $('.row_inside_input').hide();
        $(".check_row input:checkbox").change(function () {
            var ischecked = $(this).is(':checked');
            var row_id = $(this).closest('td').next('td').find('div').attr('id');
            if (ischecked) {
                $('#' + row_id).show();
            } else {
                $('#' + row_id).hide();
            }
        });
        $('.date').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
@endsection
