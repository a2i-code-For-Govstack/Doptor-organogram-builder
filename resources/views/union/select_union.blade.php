<select name="geo_union_id" id="geo_union_id" class="form-control rounded-0">
    <option value="0">ইউনিয়ন নির্বাচন করুন</option>
    @foreach($unions as $union)
        <option value="{{$union->id}}">{{$union->union_name_bng}}</option>
    @endforeach
</select>
