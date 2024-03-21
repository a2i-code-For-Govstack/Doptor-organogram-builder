<table class="tapp_table table table-striped- table-bordered table-hover table-checkable  custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="3%" class="no-sort"></th>
        <th width="11%" class="sort">নাম (বাংলা)</th>
        <th width="11%">নাম (ইংরেজি)</th>
        <th width="10%">মোবাইল</th>
        <th width="10%">ই-মেইল</th>
        <th width="10%">পদবি</th>
        <th width="10%">শাখা</th>
        <th width="15%">অফিস</th>
        <th width="10%">লগইন আইডি</th>
    </tr>
    </thead>
    <tbody>

    @if($current_responsible)
        <tr class="text-center">
            <td>
                <input type="radio" name="office_admin" data-office_id="{{$current_responsible->office_id}}"
                       id="office_unit_organogram_id"
                       @if($current_responsible->is_admin == 1) checked @endif
                       data-office_unit_organogram_id="{{$current_responsible->id}}" onclick="assignOfficeAdmin()">
            </td>
            <td>{{($current_responsible->assigned_user && $current_responsible->assigned_user->employee_record) ? $current_responsible->assigned_user->employee_record->full_name_bng : '-'}}</td>
            <td>{{($current_responsible->assigned_user && $current_responsible->assigned_user->employee_record) ? $current_responsible->assigned_user->employee_record->full_name_eng : '-'}}</td>
            <td>{{($current_responsible->assigned_user && $current_responsible->assigned_user->employee_record) ? $current_responsible->assigned_user->employee_record->personal_mobile : '-'}}</td>
            <td>{{($current_responsible->assigned_user && $current_responsible->assigned_user->employee_record) ? $current_responsible->assigned_user->employee_record->personal_email : '-'}}</td>
            <td> {{$current_responsible->designation_bng}}</td>
            <td>{{($current_responsible->office_unit) ? $current_responsible->office_unit_org->unit_name_bng : '-'}}</td>
            <td>{{($current_responsible->office_info) ? $current_responsible->office_info->office_name_bng : '-'}}</td>
            <td>{{($current_responsible->assigned_user && $current_responsible->assigned_user->designation_user) ? $current_responsible->assigned_user->designation_user->username : '-'}}</td>
        </tr>
    @endif

    @foreach($assigned_users as $key => $organogram)
        <tr class="text-center">
            <td>
                <input type="radio" name="office_admin" data-office_id="{{$organogram->office_id}}"
                       id="office_unit_organogram_id"
                       @if($organogram->is_admin == 1) checked @endif
                       data-office_unit_organogram_id="{{$organogram->id}}" onclick="assignOfficeAdmin()">
            </td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record) ? $organogram->assigned_user->employee_record->full_name_bng : '-'}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record) ? $organogram->assigned_user->employee_record->full_name_eng : '-'}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record) ? $organogram->assigned_user->employee_record->personal_mobile : '-'}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record) ? $organogram->assigned_user->employee_record->personal_email : '-'}}</td>
            <td>{{($organogram) ? $organogram->designation_bng : '-'}}</td>
            <td>{{($organogram->office_unit) ? $organogram->office_unit_org->unit_name_bng : '-'}}</td>
            <td>{{($organogram->office_info) ? $organogram->office_info->office_name_bng : '-'}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->designation_user) ? $organogram->assigned_user->designation_user->username : '-'}}</td>
        </tr>
    @endforeach
    @foreach($unassigned_users as $key => $organogram)
        <tr class="text-center">
            <td>
                <input type="radio" name="office_admin" data-office_id="{{$organogram->office_id}}"
                       id="office_unit_organogram_id"
                       @if($organogram->is_admin == 1) checked @endif
                       data-office_unit_organogram_id="{{$organogram->id}}" onclick="assignOfficeAdmin()">
            </td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record) ? $organogram->assigned_user->employee_record->full_name_bng : '-'}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record) ? $organogram->assigned_user->employee_record->full_name_eng : '-'}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record) ? $organogram->assigned_user->employee_record->personal_mobile : '-'}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record) ? $organogram->assigned_user->employee_record->personal_email : '-'}}</td>
            <td>{{($organogram) ? $organogram->designation_bng : '-'}}</td>
            <td>{{($organogram->office_unit) ? $organogram->office_unit_org->unit_name_bng : '-'}}</td>
            <td>{{($organogram->office_info) ? $organogram->office_info->office_name_bng : '-'}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->designation_user) ? $organogram->assigned_user->designation_user->username : '-'}}</td>
        </tr>
    @endforeach
    </tbody>

</table>
<script type="text/javascript">
    no_order_tapp_table_init();

    function assignOfficeAdmin() {
        swal.fire({
            title: 'অফিস অ্যাডমিন দায়িত্ব পরিবর্তন করতে চান?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যা',
            cancelButtonText: 'না',
        }).then(function (result) {
            if (result.value) {
                office_unit_organogram_id = $("input[name='office_admin']:checked").data("office_unit_organogram_id");
                url = 'assign_office_admin';
                data = {office_unit_organogram_id};
                datatype = 'json';

                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    if (responseDate.status === 'success') {
                        toastr.success(responseDate.msg);
                        admin = '{{Auth::user()->user_role_id == config("menu_role_map.user")}}'
                        if (admin) {
                            loadUnassignOfficeAdmin();
                            window.location = "/profile"
                        }
                        loadOfficeUsers($("#office_id").val());
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            }
        });
    }
</script>


