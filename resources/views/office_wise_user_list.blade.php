
            <!--Begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0">
                        <div class="card-body">

                                <x-office-select grid="3" unit="false"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card custom-card round-0">
                                        <div class="card-body" id="employee_list_div">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--End::Row-->

            <!--Begin::Row-->
            <div class="row">
            </div>

            <!--End::Row-->
    <!--Start::Modal-->
    <div class="modal fade bd-example-modal-lg" id="unassignModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">পদবি পরিবর্তন করুন</h5>
                    <button type="button" class="close distroy-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="edit_form">
                    <div id="modal_body" class="modal-body">

                    </div>
                    @method('POST')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger distroy-modal" data-dismiss="modal">বন্ধ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::Modal-->

    <script !src="">

        @if(\Auth::user()->current_office_id()  && \Auth::user()->user_role_id == config('menu_role_map.user'))
        $(document).ready(function () {
            var office_id = $('#office_id').val();
            loadOfficeUsers(office_id);
        })
        @endif

        $("select#office_id").change(function () {
            var office_id = $(this).children("option:selected").val();
            loadOfficeUsers(office_id);
        });

        function loadOfficeUsers(office_id) {
            var url = 'load_office_wise_users';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#employee_list_div").html(responseDate);

            });
        }

        $(document).on('click', '#assignOfficeAdmin', function () {
            var office_unit_organogram_id = $("input[name='office_admin']:checked").data("office_unit_organogram_id");
            var url = 'assign_office_admin';
            var data = {office_unit_organogram_id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                if (responseDate.status === 'success') {
                    toastr.success(responseDate.msg);
                    admin = '{{Auth::user()->user_role_id == config("menu_role_map.user")}}'
                    if (admin) {
                        loadUnassignOfficeAdmin();
                    }
                    loadOfficeUsers($("#office_id").val());
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        });

        function loadUnassignOfficeAdmin() {
            var org_id = '{{Auth::user()->current_designation_id()}}';
            $.ajax({
            method: "GET",
            url: "unassign_office_admin/" + org_id,
            data: org_id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                $("#modal_body").html(data);
                $("#unassignModal").modal("show");
            }
        });
        }

        $(document).on('click', '#admin_disable_designation', function () {
            var office_id = $(this).attr('data-office_id');
            var employee_record_id = $(this).attr('data-employee_record_id');
        swal.fire({
                title: 'আপনি কি এই পদবি থেকে অব্যহতি দিতে চান?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'হ্যাঁ',
                cancelButtonText: 'না'
            }).then(function (result) {
                if (result.value) {


                    var date = $('#last_office_date_' + office_id).val();
                    var url = 'disable_designation';
                    var data = {office_id, employee_record_id, date};
                    var datatype = 'json';

                    ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                        if (responseDate.status === 'success') {
                            toastr.success(responseDate.msg);
                            window.location.href = "{{ route('profile') }}";
                        } else {
                            toastr.error(responseDate.msg);
                        }
                    });
                }
            });
        });

        $(".distroy-modal").click(function() {
            window.location.href = "{{ route('profile') }}";
        });

    </script>
