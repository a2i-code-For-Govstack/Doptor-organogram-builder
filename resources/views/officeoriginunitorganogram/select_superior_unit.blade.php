@if (!empty($unit_organograms[0]['unit_name_bng']))
<select name="office_origin_unit_id" id="office_origin_unit_id" class="form-control rounded-0" required>
        <option @if($unit_organograms[0]['unit_name_bng']) selected @endif value="{{$unit_organograms[0]['id']}}">{{$unit_organograms[0]['unit_name_bng']}}</option>
</select>
@else
<select name="office_origin_unit_id" id="office_origin_unit_id" class="form-control rounded-0" required>
    <option value="0">--বাছাই করুন--</option>
    @foreach($unit_organograms[0]->originUnit->originOffice->originUnits as $unit)
        <option @if($unit_organograms[0]->office_origin_unit_id == $unit->id) selected @endif value="{{$unit->id}}">{{$unit->unit_name_bng}}</option>
    @endforeach
</select>
@endif
