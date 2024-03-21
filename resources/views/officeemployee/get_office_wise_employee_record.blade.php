<div>
    @if (!empty($admin) && $admin->is_admin == 0 && $admin->is_unit_admin == 1)
        <div class="text-center text-dark">
            <p style="font-size: 18px"><b>Branch:</b> {{ $admin->office_unit->unit_name_bng }}</p>
        </div>
    @endif

    <table id="employee_table"
           class="table table-striped- table-bordered table-hover table-checkable custom-table-border">
        <thead class="table-head-color">
        <tr class="text-center">
            <th>Login Id</th>
            <th>Name (Others)</th>
            <th>Name (English)</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Cadre</th>
            <th>Designation</th>
            <th>Branch</th>
            <th>Designation Information</th>
            <th>Activity</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<!-- Active Employee Info Modal -->
<div class="modal fade bd-example-modal-xl" id="employeeInfoModal" tabindex="-1" role="dialog"
     aria-labelledby="employeeInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Present Designations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table
                    class="table table-striped- table-bordered table-hover table-checkable custom-table-border text-center">
                    <thead class="table-head-color">
                    <tr>
                        <th>Designation</th>
                        <th>Branch</th>
                        <th>Office</th>
                    </tr>
                    </thead>
                    <tbody id="activeOrgInfo">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<!-- Organogram Info Modal -->
<div class="modal fade bd-example-modal-xl" id="designationInfoModal" tabindex="-1" role="dialog"
     aria-labelledby="designationInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Work History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<script type="text/javascript">
    $(document).ready(function () {
        unit_admin = '{{ isset($admin) ? $admin->is_unit_admin : 0 }}';
        user_role_id = '{{ Auth::user()->user_role_id }}';
        role_id = "{{ config('menu_role_map.super_admin') }}";

        office_id = "{{ $office_id ?? Auth::user()->current_office_id() }}";
        office_unit_id = "{{ $office_unit_id ?? '' }}";
        name_bn = "{{ $name_bn ?? '' }}";
        name_en = "{{ $name_en ?? '' }}";
        login_id = "{{ $login_id ?? '' }}";
        emp_nid = "{{ $emp_nid ?? '' }}";
        emp_email = "{{ $emp_email ?? '' }}";
        emp_mobile = "{{ $emp_mobile ?? '' }}";
        identity_no = "{{ $identity_no ?? '' }}";

        // alert(unit_admin);
        $('#employee_table').on('preXhr.dt', function (e) {
            let search_field = $("#searchByLoginId");
            if (search_field.length == 0) {
                $("#employee_table_filter").prepend('<input type="text" name="login_id" id="searchByLoginId" class="form-control form-control-sm my-2 integer_type_positive" placeholder="Login Id Search">');
            } else {
                search_field.val('');
            }
        }).DataTable({
            language: {
                processing: "Please Wait...",
                lengthMenu: '<select class="custom-select custom-select-sm form-control form-control-sm">' +
                    '<option value="10">10</option>' +
                    '<option value="20">20</option>' +
                    '<option value="30">30</option>' +
                    '<option value="40">40</option>' +
                    '<option value="50">50</option>' +
                    '<option value="-1">All</option>' +
                    '</select> Data',
                zeroRecords: "Sorry! No information found.",
                info: "Showing _START_ to _END_ of _TOTAL_.",
                infoEmpty: "No information found.",
                paginate: {
                    previous: "Previous",
                    next: "Next",
                },
                sSearch: "",
                searchPlaceholder: "Other search"
            },
            "processing": true,
            // DataTables server-side processing mode
            "serverSide": true,
            // Initial no order.
            "order": [],
            "ajax": {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('employee_record_server_side') }}",
                type: 'GET',
                'data': {
                    "office_id": office_id,
                    "office_unit_id": office_unit_id,
                    "name_bn": name_bn,
                    "name_en": name_en,
                    "login_id": login_id,
                    "emp_nid": emp_nid,
                    "emp_email": emp_email,
                    "emp_mobile": emp_mobile,
                    "identity_no": identity_no,
                },
            },
            columns: [{
                data: 'username'
            },
                {
                    data: 'name_bng'
                },
                {
                    data: 'name_eng'
                },
                {
                    data: 'identity_no',
                    className: 'text-center'
                },
                {
                    data: 'personal_email'
                },
                {
                    data: 'personal_mobile'
                },
                {
                    data: 'is_cadre',
                    className: 'text-center'
                },
                {
                    data: 'designation_bng',
                    'visible': user_role_id == role_id ? false : true,
                },
                {
                    data: 'unit',
                    'visible': user_role_id == role_id ? false : true,
                },
                {
                    data: 'employee_info',
                    'visible': user_role_id == role_id ? true : false,
                    className: 'text-center'
                },
                {
                    data: 'action',
                    'visible': user_role_id == role_id ? true : false,
                    className: 'text-center'
                },
            ],

            // "columnDefs": [
            //     {className: "text-center", "targets": [0,1,2,3,4,5,6,7,8,9]}
            // ]
            drawCallback: function (settings) {
                let info = $("#employee_table_info").text();
                $("#employee_table_info").text(enTobn(info));

                $("#employee_table_paginate .pagination .page-item").each(function () {
                    let text = $(this).find('a').text();
                    $(this).find('a').text(enTobn(text));
                });

            }
        });
        $('#employee_table').DataTable().search($(this).val()).draw();
    });

    function changePasswordInEmployeeList(employee_record_id) {
        swal.fire({
            title: 'Do you want to change the password?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function (result) {
            if (result.value) {
                url = "{{ url('change_password_by_admin') }}";

                ajaxCallUnsyncCallback(url, {
                    employee_record_id
                }, 'json', 'post', function (response) {
                    if (response.status === 'success') {
                        swal.fire({
                            title: response.msg,
                            text: 'New Paaword : ' + response.password,
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        })
                    } else {
                        console.log(response);
                        toastr.error(response.msg)
                    }
                });
            }
        });
    }

    function showEmployeeInfo(employee_record_id) {
        url = 'get_assign_employee_info';
        data = {
            employee_record_id
        };
        datatype = 'JSON';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseData) {
            active_org = responseData.data;
            let modalBody = '';
            $.each(active_org, function (key, value) {
                modalBody += '<tr><td>' + value.designation + '</td> <td>' + value.unit_name_bn + '</td> <td>' + value.office_name_bn + '</td></tr>';
            });
            $('#activeOrgInfo').html(modalBody);
        });
    }

    function showWorkHistoryInEmployeeList(employee_record_id) {
        url = "{{ route('employee_record.show_history') }}";
        data = {
            employee_record_id
        };
        datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'get', function (responseData) {
            $('#modal_body').html(responseData);
        });
    }
</script>
