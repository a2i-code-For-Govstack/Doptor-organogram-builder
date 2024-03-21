
    <option value="0">--বাছাই করুন--</option>
    @foreach($office_units as $office_unit)
       @foreach($office_unit->active_organograms as $organogram)
        @if(!$organogram->assigned_user)
        <option  value="{{$organogram->id}}">{{$organogram->designation_bng}}</option>
        @endif
       @endforeach
    @endforeach
