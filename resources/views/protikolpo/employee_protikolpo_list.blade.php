<table
    class="table table-striped- table-bordered table-hover table-checkable  custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="10%">পদবি</th>
        <th width="10%">অবস্থা</th>
    </tr>
    </thead>
    <tbody id="employee_protikolpo_lists">
    @foreach($emoployee_protikolpo_list as $value)
        <tr>
            <td>{{$value['designation_name_bng']}}</td>
            <td>
                @if(!empty($value['start_date']) &&
                !empty($value['end_date']))
                    @if ($value['selected_protikolpo']
                    == 1)
                        প্রতিকল্প ১ {{$value['protikolpo_info']}} নির্বাচন করা হয়েছে।
                    @elseif ($value['selected_protikolpo'] == 2)
                        প্রতিকল্প ২ {{$value['protikolpo_info']}} নির্বাচন করা হয়েছে।
                    @else
                        সকল প্রতিকল্প এ সময় ছুটিতে রয়েছে।
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
