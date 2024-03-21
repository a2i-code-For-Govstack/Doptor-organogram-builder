<select name="parent_office_id" id="parent_office_id" class="form-control rounded-0" required>
    <option value="0">--বাছাই করুন--</option>
    @foreach($parent_origins as $parent_origin)
        <option value="{{$parent_origin->id}}">{{$parent_origin->office_name_bng}}</option>
    @endforeach
</select>
