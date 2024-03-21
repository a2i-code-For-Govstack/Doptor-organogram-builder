<select name="office_id" id="office_id" class="form-control rounded-0">
    <option value="0">--বাছাই করুন--</option>
    @foreach($units as $unit)
        <option value="{{$unit->id}}" data-unit-name-en="{{$unit->unit_name_eng}}">{{$unit->unit_name_bng}}</option>
    @endforeach
</select>

