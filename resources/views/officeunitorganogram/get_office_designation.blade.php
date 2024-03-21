<input  type="hidden" class="form-control mb-4" value="{{$designation_info->id}}" name="id" id="type_id">

<div class="form-group">
    <label for="type_name"> পদবি নাম ( বাংলা )</label>
    <input  type="text" class="form-control mb-4 bangla" value="{{$designation_info->designation_bng}}" name="designation_bng" id="designation_bng" placeholder="পদবি বাংলা">
</div>

<div class="form-group">
    <label for="type_name"> পদবি নাম ( ইংরেজী )</label>
    <input  type="text" class="form-control mb-4" value="{{$designation_info->designation_eng}}" name="designation_eng" id="designation_eng" placeholder="পদবি ইংরেজি">
</div>

<script>
    $('.bangla').bangla({ enable: true });
</script>
