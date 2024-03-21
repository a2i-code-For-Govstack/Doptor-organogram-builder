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
                        <p class="mb-0 pt-1">Official search</p>

                    </div>
                </button>
            </div>
            <div>
                <h3 class="text-white my-1">Doptor Employee List</h3>
            </div>
            <div class="mr-3 d-flex">

                <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0  d-flex mr-2">
                    <div>
                        <i class="fa fa-download my-1 ml-2 mr-0"></i>
                    </div>

                </button>

                @if($admin->is_admin || $admin->is_unit_admin)
                    <button class="btn btn-sna-header-button-color py-0  d-flex">
                        <div>
                            <i class="fa fa-plus mr-2 my-1"></i>
                        </div>

                        <div>

                            <p class="mb-0 pt-1">

                                <a href="{{url('create_employee_by_office_admin')}}">
                                    Add Employee
                                </a>
                            </p>


                        </div>

                    </button>
                @endif()
            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="office_id" name="office_id"
                               value="{{ auth()->user()->current_office_id() }}">
                        <div class="card custom-card rounded-0 shadow-sm advance_search">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input placeholder="Name" class="form-control rounded-0" type="text"
                                                   id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input placeholder="Login Id" class="form-control rounded-0" type="text"
                                                   id="loginId" name="loginId">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input placeholder="Nid Number" class="form-control rounded-0"
                                                   type="text" id="identity_no" name="identity_no">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input placeholder="Mobile" class="form-control rounded-0" type="text"
                                                   id="phone" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="searchEmployee" class="btn btn-info btn-font-lg" type="submit"><i
                                                class="fa fa-search mr-2"></i>Search
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="kt-portlet__body">
                                    <div class="row mt-3">
                                        <div class="load-table-data" data-href="/get_office_wise_employee_list">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Begin::Dashboard 1-->


            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
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

        function loadData(url = '') {
            if (url === '') {
                url = $(".load-table-data").data('href');
            }
            // office_unit_id = $('#office_unit_id').val();
            // name_en = $('#name_en').val();
            // emp_nid = $('#emp_nid').val();
            // emp_email = $('#emp_email').val();
            office_id = $('#office_id').val();
            name_bn = $('#name').val();
            login_id = $('#loginId').val();
            emp_mobile = $('#phone').val();
            var data = {office_id, name_bn, login_id, emp_mobile};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $(".mt-3 .load-table-data").html(responseDate);
            });
        }

        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });

        // Bangla font / unicode check
        //------------------------------------------
        $('#name_bng').bangla({ enable: true });

        $("#searchEmployee").click(function () {
            var office_id = $('#office_id').val();
            var name = $('#name').val();
            var loginId = $('#loginId').val();
            var identity_no = $('#identity_no').val();
            var phone = $('#phone').val();

            var url = 'search_office_wise_employee_list';
            var data = {office_id, name: name, loginId: loginId, identity_no: identity_no, phone: phone};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $(".mt-3 .load-table-data").html(responseDate);
            });

        });


        // English font check
        //--------------------------------
        $('#name_eng').on('blur', function () {
            var name_eng = $(this).val();
            // function to check unicode or not
            if (isUnicode(name_eng) == true) {
                toastr.warning('Please use English words.');
                $(this).val('');
                return false
            }
        });

        $('#btn_excel_generate').on('click', function () {
            var url = 'generate_office_wise_employee_excel_file';
            var data = {};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (response) {
                a = document.createElement('a');
                a.href = response.full_path;
                a.download = response.file_name;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(a.href);
            });
        });

        $('#loginId').blur(function () {
            if (!isNaN($('#loginId').val())) {
                var loginid = $('#loginId').val();
                var start = loginid.substr(0, 1);
                var restof = loginid.substr(1);
                loginid = start + str_pad(restof, 11);
                $('#loginId').val(loginid);
            }
        });

        $(document).on('blur', '#searchByLoginId', function () {
            if ($('#searchByLoginId').val()) {
                var loginid = $('#searchByLoginId').val();
                var start = loginid.substr(0, 1);
                var restof = loginid.substr(1);
                loginid = start + str_pad(restof, 11);
                $('#searchByLoginId').val(loginid);
                let url = $(".load-table-data").data('href');
                let data = {login_id: loginid};
                let datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $(".mt-3 .load-table-data").html(responseDate);
                    setTimeout(function () {
                        $('#searchByLoginId').val(loginid);
                    }, 100)
                });
            } else {
                loadData();
            }
        });

    </script>
@endsection
