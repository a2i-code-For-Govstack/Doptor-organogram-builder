<form id="work_history_edit" onsubmit="submitData(this, '{{route('work_history_update')}}'); return false;">
    <input type="hidden" name="id" value="{{$work_history_info->id}}">
    <div class="col-md-12">
        <div class="form-group">
            <label for="ministry_id">মন্ত্রণালয়/বিভাগ</label>
            <select name="ministry_id" id="ministry_id"
                    class="form-control rounded-0 select-select2">
                <option value="0">--বাছাই করুন--</option>
                @foreach($office_ministry as  $ministry)
                    <option @if($ministry->id == $work_history_info->office_info->office_ministry_id) selected @endif value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="custom_layer_id">অফিস কাস্টম লেয়ার</label>
            <select name="custom_layer_id" id="custom_layer_id"
                    class="form-control rounded-0 select-select2">
                <option value="0">--বাছাই করুন--</option>
                @foreach($custom_layers as  $custom_layer)
                    <option @if($custom_layer->id == $work_history_info->office_info->custom_layer_id) selected @endif value="{{$custom_layer->id}}">{{$custom_layer->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="office_layer_id">অধিদপ্তরের ধরন</label>
            <select name="office_layer_id" id="office_layer_id"
                    class="form-control rounded-0 select-select2">
                <option value="0">--বাছাই করুন--</option>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <div class="form-group">
                <label for="office_id">অফিস</label>
                <select id="office_id" class="form-control rounded-0 select-select2" name="office_id">
                    <option value="0">--বাছাই করুন--</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <div class="form-group">
                <label for="office_unit_id">অফিস শাখা</label>
                <select id="office_unit_id" class="form-control rounded-0 select-select2" name="office_unit_id">
                    <option value="0">--বাছাই করুন--</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <div class="form-group">
                <label for="designation_id">পদ</label>
                <select id="designation_id" class="form-control rounded-0 select-select2" name="designation_id">
                    <option value="0">--বাছাই করুন--</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="joining_date">শুরু কার্যদিবস</label><span class="text-danger">*</span>
            <input id="joining_date" autocomplete="off" name="joining_date" class="form-control rounded-0 date" value="{{$work_history_info->joining_date ? date('d-m-Y',strtotime($work_history_info->joining_date)) : ''}}" type="text">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="last_office_date">শেষ কার্যদিবস</label><span class="text-danger">*</span>
            <input id="last_office_date" autocomplete="off" name="last_office_date" class="form-control rounded-0 date" value="{{ !empty($work_history_info->last_office_date) ? date('d-m-Y',strtotime($work_history_info->last_office_date)) : ''}}" type="text">
        </div>
    </div>

    <div class="col-md-12">
        <div class="d-flex justify-content-end">
            <div class="btn-group" role="group" aria-label="Button group">
                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ</button>
                <a id="reset_btn"  class="btn  btn-danger text-white"><i class="fas fa-sync  mr-2"></i> রিসেট</a>
            </div>
        </div>
    </div>
</form>

<script>
   $(document).ready(function (){
       ministry_id = '{{$work_history_info->office_info->office_ministry_id}}';
       office_layer_id = '{{$work_history_info->office_info->office_layer_id}}';
       office_id = '{{$work_history_info->office_info->id}}';
       office_unit_id = '{{$work_history_info->office_unit->id}}';
       loadOfficeLayer(ministry_id);
       loadOffice(ministry_id,office_layer_id);
       loadOfficeUnit(office_id);
       loadDesignation(office_id,office_unit_id);
   });

   function submitData(form, url) {
       var data = $(form).serializeArray();
       office_name_bng = $('#office_id').find(':selected').text();
       office_name_eng = $('#office_id').find(':selected').attr('data-office-name-en');

       unit_name_bng = $('#office_unit_id').find(':selected').text();
       unit_name_eng = $('#office_unit_id').find(':selected').attr('data-unit-name-en');

       designation_name_bng = $('#designation_id').find(':selected').text();
       designation_name_eng = $('#designation_id').find(':selected').attr('data-designation-en');

       data.push({name: "office_name_bng", value: office_name_bng});
       data.push({name: "office_name_eng", value: office_name_eng});

       data.push({name: "unit_name_bng", value: unit_name_bng});
       data.push({name: "unit_name_eng", value: unit_name_eng});

       data.push({name: "designation_name_bng", value: designation_name_bng});
       data.push({name: "designation_name_eng", value: designation_name_eng});

       var datatype = 'json';

       ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
           if (responseData.status === 'success') {
               toastr.success(responseData.msg);
               $('#kt_quick_panel_close_btn').click();
               var keyword = $('#username').val();
               searchEmployee(keyword);
           } else {
               toastr.error('Server Error');
           }
       });
   }

   function searchEmployee(keyword) {
        var url = 'employee_record_search';
        var data = {keyword};
        var datatype = 'html';
        ajaxCallAsyncCallback(url, data, datatype, 'POST', function(responseData) {
            $("#work_history").html(responseData);
        });
   }

   $("select#ministry_id").change(function () {
       var ministry_id = $(this).val();
       loadOfficeLayer(ministry_id);
   });

   $("select#office_layer_id").change(function () {
       var ministry_id = $('#ministry_id').val();
       var office_layer_id = $(this).val();
       loadOffice(ministry_id,office_layer_id);
   });


   $("select#office_id").change(function () {
       var office_id = $(this).val();
       loadOfficeUnit(office_id);
   });

   $("select#office_unit_id").change(function () {
       var office_unit_id = $('#office_unit_id').val();
       var office_id = $('#office_id').val();
       loadDesignation(office_id, office_unit_id);
   });

   function loadOfficeLayer(ministry_id) {
       var url = 'load_office_layer_ministry_wise';
       var data = {ministry_id};
       var datatype = 'html';
       ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (response) {
           $("#office_layer_id").html(response);
           office_layer_id = '{{$work_history_info->office_info->office_layer_id}}';
           $("#office_layer_id").val(office_layer_id);
       });
   }

   function loadOffice(ministry_id,office_layer_id){
       var url = 'ministry_and_layer_wise_office_select';
       var data = {ministry_id,office_layer_id};
       var datatype = 'html';
       ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (response) {
           $("#office_id").html(response);
           office_id = '{{$work_history_info->office_info->id}}';
           $("#office_id").val(office_id);
       });
   }

   function loadOfficeUnit(office_id) {
       var url = 'load_unit_office_wise';
       var data = {office_id};
       var datatype = 'html';
       ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (response) {
           $("#office_unit_id").html(response);
           office_unit_id = '{{$work_history_info->office_unit->id}}';
           $("#office_unit_id").val(office_unit_id);
       });
   }

   function loadDesignation(office_id,office_unit_id) {
       var url = 'load_designation_office_unit_wise';
       var data = {office_id,office_unit_id};
       var datatype = 'html';
       ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (response) {
           $("#designation_id").html(response);
           designation_id = '{{$work_history_info->office_unit_organogram->id}}';
           $("#designation_id").val(designation_id);
       });
   }

</script>
