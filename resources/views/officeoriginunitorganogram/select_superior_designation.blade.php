<select name="superior_designation_id" id="superior_designation_id" class="form-control rounded-0" required>
    <option value="0">--বাছাই করুন--</option>
    @foreach($unit_organograms as $unit_organogram)
        <option value="{{$unit_organogram->id}}">{{$unit_organogram->designation_bng}}</option>
    @endforeach
</select>
