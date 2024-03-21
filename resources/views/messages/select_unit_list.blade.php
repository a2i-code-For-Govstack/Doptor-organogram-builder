<select multiple="multiple" name="unit_select[]" id="unit_select" class="form-control rounded-0 select-select2">
    @foreach($units as $unit)
        <option value="{{$unit->id}}">{{$unit->unit_name_bng}}</option>
    @endforeach
</select>
