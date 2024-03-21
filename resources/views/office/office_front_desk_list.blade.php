<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
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
    @foreach($organograms as $key => $organogram)
        <tr class="text-center">
            <td>
                <input type="radio" name="office_admin" id="office_unit_organogram_id"
                       @if($organogram->assigned_front_desk && $organogram->assigned_front_desk->office_unit_organogram_id == $organogram->id) checked
                       @endif
                       data-office_unit_organogram_id="{{$organogram->id}}">

                @if ($organogram->assigned_front_desk && $organogram->assigned_front_desk->office_unit_organogram_id == $organogram->id)
                    <p></p>
                @endif
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
<div>
    <button type="button" class="btn btn-md btn-primary" id="assignOfficeFrontDesk">দায়িত্ব প্রদান</button>
</div>
<script type="text/javascript">
    tapp_table_init('tapp_table', 0);
</script>



