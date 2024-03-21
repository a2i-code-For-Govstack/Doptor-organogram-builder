<select name="parent_unit_id" id="parent_unit_id" class="form-control rounded-0 select-select2" required>
    <option value="0">--বাছাই করুন--</option>
    @foreach($origin_units as $origin_unit)
        <option value="{{$origin_unit->id}}">{{$origin_unit->unit_name_bng}}</option>
    @endforeach
</select>
