<select name="geo_upazila_id" id="geo_upazila_id" class="form-control rounded-0" required>
    <option value="0">উপজেলা নির্বাচন করুন</option>
    @foreach($upazilas as $upazila)
        <option data-upazila_bbs_code="{{$upazila->bbs_code}}" value="{{$upazila->id}}">{{$upazila->upazila_name_bng}}</option>
    @endforeach
</select>
