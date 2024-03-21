@extends('master')
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Edit Office Employee Designation</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="load-table-data" data-href="/office_designation_update_list">

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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">Change Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="edit_form">
                    <div id="modal_body" class="modal-body">

                    </div>
                    @method('POST')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit_button">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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

        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });

        $(".edit_button").click(function () {
            designation_id = $('#designation_id').val();
            designation_eng = $('#designation_eng').val();
            designation_bng = $('#designation_bng').val();
            employee_office_id = $('#employee_office_id').val();

            var data = {
                designation_id,
                designation_eng,
                designation_bng,
                employee_office_id,
            };
            var url = '{{url('office_employee_designation_update')}}';
            ajaxCallAsyncCallback(url, data, 'json', 'POST', function (data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                    location.reload();
                } else {
                    toastr.error(data.msg)
                    console.log(data)
                }
            });
        });

        // Bangla font / unicode check
        //------------------------------------------
        $('#name_bng').bangla({ enable: true });

        $("#searchEmployee").click(function () {
            var name = $('#name').val();
            var loginId = $('#loginId').val();
            var nid = $('#nid').val();
            var phone = $('#phone').val();

            var url = 'search_office_wise_employee_list';
            var data = {name: name, loginId: loginId, nid: nid, phone: phone};
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

    </script>
@endsection
