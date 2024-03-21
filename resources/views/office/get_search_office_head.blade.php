<table class="table table-bordered">
    <thead>
    <tr>
        <th class=""></th>
        <th>নাম (বাংলা)</th>
        <th>নাম (ইংরেজি)</th>
        <th>পদবি</th>
        <th>শাখা</th>
        <th>অফিস</th>
        <th>জাতীয় পরিচয়পত্র নম্বর </th>
        <th>লগইন আইডি</th>
    </tr>
    </thead>
    <tbody>
    @foreach($employee_records as $employee_record)
        @if($employee_record->employee_office)
            @foreach($employee_record->employee_office as $employee_office)
                <tr>
                    <td>
                        <input type="radio" name="office_admin" data-office_id="{{$employee_office->office_id}}" id="office_unit_organogram_id" @if($employee_record->employee_office && $employee_office->office_head == 1) checked @endif
                        data-office_unit_organogram_id="{{$employee_office->office_unit_organogram_id}}">
                    </td>
                    <td>{{$employee_record->name_bng}}</td>
                    <td>{{$employee_record->name_eng}}</td>
                    <td>{{($employee_office) ? $employee_office->designation : ''}}</td>
                    <td>{{($employee_office) ? $employee_office->unit_name_bn : ''}}</td>
                    <td>{{($employee_office) ? $employee_office->office_name_bn : ''}}</td>
                    <td>{{$employee_record->nid}}</td>
                    <td>{{@$employee_record->user->username}}</td>
                </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td class="form-actions" colspan="8">
            <button type="button" class="btn btn-md btn-primary"  id="assignOfficeHead" >দায়িত্ব প্রদান</button>
        </td>
    </tr>
    </tfoot>
</table>

<div class="ajaxPagination">
    {!! $employee_records->onEachSide(1)->links() !!}
</div>

