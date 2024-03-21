<select name="geo_city_corporation_id" id="geo_city_corporation_id" class="form-control rounded-0" required>
    <option value="0">সিটি কর্পোরেশন নির্বাচন করুন</option>
    @foreach($citycorporations as $citycorporation)
        <option data-city_corporation_bbs_code="{{$citycorporation->bbs_code}}" value="{{$citycorporation->id}}">{{$citycorporation->city_corporation_name_bng}}</option>
    @endforeach
</select>
