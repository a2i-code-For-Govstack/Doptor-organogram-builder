
    <option value="0">--বাছাই করুন--</option>
    @foreach($office_units as $office_unit)
        <option value="{{$office_unit->id}}">{{$office_unit->unit_name_bng}}</option>
    @endforeach