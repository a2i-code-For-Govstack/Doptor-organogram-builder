<select name="geo_district_id" id="geo_district_id" class="form-control rounded-0" required>
    <option value="0">জেলা নির্বাচন করুন</option>
    @foreach($zilas as $zila)
        <option data-zila_bbs_code="{{$zila->bbs_code}}" value="{{$zila->id}}">{{$zila->district_name_bng}}</option>
    @endforeach
</select>
