<select name="parent_office_id" id="parent_office_id" class="form-control rounded-0" required>
    <option value="0">--বাছাই করুন--</option>
    @foreach($parent_office as $parent)
        <option  value="{{$parent->id}}">{{$parent->office_name_bng}}</option>
    @endforeach
</select>