<select name="office_id" id="office_id" class="form-control rounded-0">
    <option value="0">--বাছাই করুন--</option>
    @foreach($offices as $office)
        <option value="{{$office->id}}">{{$office->office_name_bng}}</option>
    @endforeach
</select>

