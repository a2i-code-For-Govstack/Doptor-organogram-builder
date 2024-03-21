<select name="geo_district_id" id="geo_district_id" class="form-control rounded-0" required>
    <option value="0">পৌরসভা নির্বাচন করুন</option>
    @foreach($pouroshovas as $pouroshova)
        <option data-pouroshova_bbs_code="{{$pouroshova->bbs_code}}" value="{{$pouroshova->id}}">{{$pouroshova->municipality_name_bng}}</option>
    @endforeach
</select>
