@if($employee_info)

<div class="col-md-6">
  <div class="card custom-card round-0 shadow-sm">
    <div class="card-header">
      <h4>বাক্তিগত তথ্য</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <td>নাম </td>
            <td>{{$employee_info->name_bng}}</td>
          </tr>
          <tr>
            <td>পিতার নাম </td>
            <td>{{$employee_info->father_name_bng}}</td>
          </tr>
          <tr>
            <td>জাতীয় পরিচয়পত্র নম্বর</td>
            <td>{{$employee_info->nid}}</td>
          </tr>
          <tr>
            <td>জন্ম তারিখ</td>
            <td>{{dateEnToBn($employee_info->date_of_birth)}}</td>
          </tr>
          <tr>
            <td>ইমেল:</td>
            <td>{{$employee_info->personal_email}}</td>
          </tr>
          <tr>
            <td>ফোন:</td>
            <td>{{$employee_info->personal_mobile}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="card custom-card round-0 shadow-sm">
    <div class="card-header">
      <h4>বর্তমান পদবি</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
         @foreach($employee_info->employee_office as $employee_office_info)
         <tr>
          <td>ইউজার আইডি</td>
          <td>{{$employee_info->user->username}}</td>
        </tr>
        <tr>
          <td>কেডার আইডি</td>
          <td id="cadre_id">{{$employee_info->identity_no}}</td>
        </tr>
        <tr>
          <td>পদবি</td>
          <td>{{$employee_office_info->designation}}</td>
        </tr>
        <tr>
          <td>যোগদানের তারিখ</td>
          <td>{{dateEnToBn($employee_info->joining_date)}}</td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
</div>

<div class="col-md-12 mt-2">
  <div class="card custom-card shadow-sm w-100">
    <div class="card-header">
      <h5 class="mb-0"></h5>
    </div>
    <div class="card-body">
      <form onsubmit="changeToCadre(this, 'change_to_cadre'); return false;">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="identity_no">কেডার আইডি</label>
              <input id="identity_no" class="form-control rounded-0" type="text" name="identity_no">
              <input type="hidden" value="{{$employee_info->id}}" name="employee_record_id">
            </div>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <div class="form-group">
              <button id="makeCadre" class="btn btn-primary">পরিবর্তন করুন</button>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>
@else
    <div class="col-md-6">
  <div class="card custom-card round-0 shadow-sm">
    <div class="card-body">
        <h4>কোন তথ্য পাওয়া যায়নি</h4>
    </div>
  </div>
</div>
@endif
<script type="text/javascript">
  function changeToCadre(form, url) {
    var data = $(form).serialize();
    var datatype = 'json';
    ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {

      if (responseData.status === 'success') {
        toastr.success(responseData.msg);
        $('#username').val(responseData.username);
        $('#search').trigger('click');
      } else {
        toastr.error(responseData.msg);
      }
    });
  }
</script>
