<input type="hidden" class="form-control mb-4" value="{{$designation_id}}" name="designation_id" id="designation_id">
<input type="hidden" class="form-control mb-4" value="{{$employee_office_id}}" name="employee_office_id"
       id="employee_office_id">

<div class="form-group">
    <label for="type_name">পদবি বাংলায়</label>
    <input type="text" class="form-control mb-4" value="{{$designation_info->designation_bng}}" name="designation_bng"
           id="designation_bng" placeholder="পদবি বাংলায়">
</div>

<div class="form-group">
    <label for="type_name">পদবি ইংরেজিতে</label>
    <input type="text" class="form-control mb-4" value="{{$designation_info->designation_eng}}" name="designation_eng"
           id="designation_eng" placeholder="পদবি ইংরেজিতে">
</div>
