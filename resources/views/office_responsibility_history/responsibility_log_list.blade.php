<table class="tapp_table table table-striped- table-bordered table-hover table-checkable  custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="10%" class="sort">নাম (বাংলা)</th>
        <th width="10%">নাম (ইংরেজি)</th>
        <th width="10%">পদবি</th>
        <th width="10%">শাখা</th>
        <th width="10%">অফিস</th>
        <th width="10%">লগইন আইডি</th>
        <th width="10%">দায়িত্ব শুরু</th>
        <th width="10%">দায়িত্ব শেষ</th>
    </tr>
    </thead>
    <tbody>
    @if($current_responsible)
        <tr class="text-center">
            <td>{{$current_responsible->employee_name_bn ? $current_responsible->employee_name_bn : '-' }}</td>
            <td>{{$current_responsible->employee_name_en ? $current_responsible->employee_name_en : '-'}}</td>
            <td>{{$current_responsible->office_unit_organogram->designation_bng}}</td>
            <td>{{$current_responsible->office_unit->unit_name_bng}}</td>
            <td>{{$current_responsible->office_info->office_name_bng}}</td>
            <td>{{$current_responsible->employee_record ? $current_responsible->employee_record->user->username : '-'}}</td>
            <td>{{$current_responsible->assign_from ? enTobn(date('d/m/Y',strtotime($current_responsible->assign_from))) : 'অজানা'}}</td>
            <td>
                {{ $current_responsible->assign_to ? enTobn(date('d/m/Y',strtotime($current_responsible->assign_to))) : 'বর্তমান'}}
            </td>
        </tr>
    @endif

    @foreach($responsible_log_list as $key => $responsible)
        <tr class="text-center">
            <td>{{$responsible->employee_name_bn ? $responsible->employee_name_bn : '-' }}</td>
            <td>{{$responsible->employee_name_en ? $responsible->employee_name_en : '-'}}</td>
            <td>{{$responsible->office_unit_organogram->designation_bng}}</td>
            <td>{{$responsible->office_unit->unit_name_bng}}</td>
            <td>{{$responsible->office_info->office_name_bng}}</td>
            <td>{{$responsible->employee_record ? $responsible->employee_record->user->username : '-'}}</td>
            <td>{{$responsible->assign_from ? enTobn(date('d/m/Y',strtotime($responsible->assign_from))) : 'অজানা'}}</td>
            <td>
                {{ $responsible->assign_to ? enTobn(date('d/m/Y',strtotime($responsible->assign_to))) : 'বর্তমান'}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script type="text/javascript">
    no_order_tapp_table_init('tapp_table');
</script>


