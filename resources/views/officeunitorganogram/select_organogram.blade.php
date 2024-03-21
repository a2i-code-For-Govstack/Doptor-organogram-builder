
    <option value="0">--বাছাই করুন--</option>
    @foreach($office_designations as $designation)
        <option title="{{$designation->assigned_user ? $designation->assigned_user->employee_record->name_bng : 'শুন্য পদবী'}}" data-designation-en="{{$designation->designation_eng}}" value="{{$designation->id}}">{{$designation->designation_bng}}</option>
    @endforeach
