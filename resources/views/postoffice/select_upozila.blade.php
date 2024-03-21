<select name="geo_upazila_id" id="geo_upazila_id" class="form-control rounded-0" required>
    <option value="0">উপজেলা নির্বাচন করুন</option>
    @foreach($upozilas as $upozila)
        <option data-upozila_bbs_code="{{$upozila->bbs_code}}" value="{{$upozila->id}}">{{$upozila->upazila_name_bng}}</option>
    @endforeach
</select>
