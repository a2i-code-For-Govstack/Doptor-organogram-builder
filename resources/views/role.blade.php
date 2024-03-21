@extends('master')
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Role</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            {{--            @include('role.role.search')--}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                {{--@include('role.role.create')--}}
                                <div class="load-table-data" data-href="/role/getRole">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                </div>

                <!--End::Row-->

                <!--End::Dashboard 1-->
            </div>

            <!-- end:: Content -->
        </div>

        <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
            <div class="kt_quick_panel__head">
                <h5 class="kt_quick_panel__title mb-0">
                    Edit Administrative Section </span></a></li>
                    <!--<small>5</small>-->
                </h5>
                <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
            </div>
            <div class="kt-quick-panel__content">
                <div class="mt-5">
                    <form id="role_form" onsubmit="submitData(this, '{{route('role.store')}}'); return false;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Role</label> <span class="text-danger">*</span>
                                <input id="name" class="form-control rounded-0" type="text" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input id="description" class="form-control rounded-0" type="text" name="description">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user_level">User layer</label><span class="text-danger">*</span>
                                <input id="user_level" class="form-control rounded-0" type="text" name="user_level"
                                       required>
                            </div>
                        </div>

                        <input type="hidden" id="role_id" name="id">

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
                    $(".load-table-data").html(responseDate);
                });
            }

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

            $(".create-posasonik").click(function () {
                $('#role_form')[0].reset();

                $('#name').val('');
                $('#description').val('');
                $('#user_level').val('');
                $('#role_id').val('');
                $('.kt_quick_panel__title').text('Administrative Section');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
            })
            $(document).on('click', ".btntableDataEdit", function () {
                var content = $(this).attr('data-content');
                var content_value = content.split(',')
                var role_id = content_value[0];
                var name = content_value[1];
                var description = content_value[2];
                var user_level = content_value[3];


                $('#name').val(name);
                $('#description').val(description);
                $('#user_level').val(user_level);
                $('#role_id').val(role_id);


                $(".kt_quick_panel__title").text('Edit Administrative Section');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
            });

            $('#btn_excel_generate').on('click', function () {
                var url = 'generate_role_excel_file';
                var data = {};
                var datatype = 'json';
                ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    window.open(responseDate.full_path, '_blank');
                });
            });

            $('#name').on('blur', function () {
                var name = $(this).val();
                // function to check unicode or not
                if (isUnicode(name) == true) {
                    toastr.warning('Please use English words.');
                    $(this).val('');
                    return false
                }
            });

        </script>
@endsection
