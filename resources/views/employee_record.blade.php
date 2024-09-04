@extends('master')
@section('content')
<style>
    /* Base Styles */
.kt-portlet__body {
    padding: 15px;
    overflow: hidden;
}

.card.custom-card {
    margin-bottom: 20px;
}

.table-responsive {
    overflow-x: auto;
}

/* Responsive Styles for Mobile Devices */
@media (max-width: 575.98px) {
    .sna-subheader {
        flex-direction: column;
        align-items: flex-start;
    }

    .sna-subheader .btn, .sna-subheader h3 {
        margin-bottom: 10px;
    }

    .kt-portlet__body {
        padding: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .btn-group {
        width: 100%;
        text-align: center;
    }

    .kt-quick-panel__content {
        padding: 15px;
    }

    .kt-scrolltop {
        display: block;
        position: fixed;
        bottom: 10px;
        right: 10px;
    }
}

/* Responsive Styles for Tablets and Larger Devices */
@media (min-width: 576px) and (max-width: 767.98px) {
    .sna-subheader {
        flex-direction: row;
        flex-wrap: wrap;
    }

    .sna-subheader .btn {
        margin-right: 10px;
    }

    .kt-portlet__body {
        padding: 15px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-group {
        text-align: right;
    }

    .kt-scrolltop {
        display: block;
        position: fixed;
        bottom: 15px;
        right: 15px;
    }
}

/* Responsive Styles for Desktops */
@media (min-width: 768px) {
    .sna-subheader {
        flex-direction: row;
    }

    .kt-portlet__body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-group {
        text-align: right;
    }

    .kt-scrolltop {
        display: block;
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
}
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on touch devices */
}
.dataTables_length,.ml-3 {
    display: none;
}

.table {
    min-width: 600px; /* Adjust based on your table width */
}
</style>
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
                <h3 class="text-white my-1">Officer</h3>
            </div>
            <div class="mr-3 d-flex">
                @if(Auth::user()->user_role_id == config('menu_role_map.user'))
                    <button id="btn_excel_superadmin_generate"
                            class="btn btn-sna-header-button-color py-0  d-flex mr-2">
                        <div>
                            <i class="fa fa-download my-1 ml-2 mr-0"></i>
                        </div>
                    </button>
                @endif
                <a href="{{url('create_employee')}}" class="btn btn-sna-header-button-color py-0  d-flex">
                    <div>
                        <i class="fa fa-plus mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">Create New Officer</p>

                    </div>
                </a>
            </div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card custom-card rounded-0 shadow-sm advance_search" style="display: none;">
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <x-office-select grid="3" unit="true" only_office="true"></x-office-select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Name (Others)" id="name_bn"
                                                       class="form-control rounded-0" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="name (English)" id="name_en"
                                                       class="form-control rounded-0" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Login Id" id="login_id"
                                                       class="form-control rounded-0" type="number" name="loginId">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Nid number" id="emp_nid"
                                                       class="form-control rounded-0" type="text" name="emp_nid">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Email" id="emp_email" class="form-control rounded-0"
                                                       type="text" name="emp_email">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input placeholder="Mobile" id="emp_mobile"
                                                       class="form-control rounded-0" type="text" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <button id="searchEmployee" class="btn btn-primary" type="button">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-portlet__body">
                    <div class="row mt-3">
                        <div id="list_div" class="load-table-data" data-href="/get_office_wise_employee_list"></div>
                    </div>
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

            function loadData(url = '') {
                if (url === '') {
                    url = $(".load-table-data").data('href');
                }
                office_id = $('#office_id').val();
                office_unit_id = $('#office_unit_id').val();
                name_bn = $('#name_bn').val();
                name_en = $('#name_en').val();
                login_id = $('#login_id').val();
                emp_nid = $('#emp_nid').val();
                emp_email = $('#emp_email').val();
                emp_mobile = $('#emp_mobile').val();
                var data = {office_id, office_unit_id, name_bn, name_en, login_id, emp_nid, emp_email, emp_mobile};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $(".mt-3 .load-table-data").html(responseDate);
                });
            }

            $('#searchEmployee').click(function () {
                loadData();
            })

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


            // Bangla font / unicode check
            //------------------------------------------
            $('#name_bng').bangla({enable: true});


            // English font check
            //--------------------------------
            $('#name_eng').on('blur', function () {
                var name_eng = $(this).val();
                // function to check unicode or not
                if (isUnicode(name_eng) == true) {
                    toastr.warning('Please use english word!');
                    $(this).val('');
                    return false
                }
            });

            $('#btn_excel_superadmin_generate').on('click', function () {
                KTApp.block('#kt_content');
                var url = 'generate_office_wise_employee_excel_file';
                var data = {};
                var datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (response) {
                    if (response.status === 'success') {
                        window.open(response.full_path, '_blank');
                    } else {
                        toastr.error('Error!')
                    }
                    KTApp.unblock('#kt_content');
                });
            });

            $('#login_id').blur(function () {
                if ($('#login_id').val()) {
                    var loginid = $('#login_id').val();
                    var start = loginid.substr(0, 1);
                    var restof = loginid.substr(1);
                    loginid = start + str_pad(restof, 11);
                    $('#login_id').val(loginid);
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
                    let data = {office_id: 0, office_unit_id: 0, login_id: loginid};
                    let datatype = 'html';
                    ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                        $(".mt-3 .load-table-data").html(responseDate);
                        setTimeout(function () {
                            $('#searchByLoginId').val(loginid);
                        }, 100)
                    });
                    console.log($('#searchByLoginId').val());
                    console.log('nempty');
                } else {
                    console.log('empty');
                    loadData();
                }
            });
        </script>
@endsection
