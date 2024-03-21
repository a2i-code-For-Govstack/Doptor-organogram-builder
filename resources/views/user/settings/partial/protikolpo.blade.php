
<div class="card card-custom">
    <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
        <div class="col-md-6">
            <div class="title py-2">
                <h4 class="mb-0 font-weight-bold"><i class="fas fa-list mr-3"></i>{{ __('প্রতিকল্প')}}
                </h4>
            </div>
        </div>
    </div>
<div id="protikolpo" class="portlet box green mt-4">
    <div class="portlet-body">
        <form id="protikolpo_assign_form"
              onsubmit="portikolpoSubmitData(this, 'assign_protikolpo'); return false;">
            <!-- <div id="modal_body" class="modal-body"> -->

            <div class="row">
                <div class="col-md-2">
                    <p class="text-right" style="margin-top: 10px">ছুটির
                        সময় </p>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input id="protikolpo_start_date"
                               placeholder="ছুটি শুরু" type="text"
                               name="protikolpo_start_date"
                               class="form-control date">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <input placeholder="ছুটি শেষ" type="text"
                               name="protikolpo_end_date"
                               id="protikolpo_end_date"
                               class="form-control date">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group text-right" style="margin-top: 10px">
                        <div class="kt-checkbox-list">
                            <label
                                class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                <input id="is_show_acting" name="is_show_acting"
                                       type="checkbox"> পদবিতে দেখাবে
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select name="acting_level" id="acting_level"
                                class="form-control rounded-0 user-options">
                            <option selected="selected" value="">--বাছাই করুন--</option>
                            @foreach($office_incharges as $incharge)
                                <option
                                    value="{{$incharge->name_bng}}">{{$incharge->name_bng}}</option>
                            @endforeach
                            <option id="other">অন্যান্য</option>
                        </select>
                    </div>
                </div>
            </div>

            <input type="hidden" id="office_unit_organogram_id"
                   name="office_unit_organogram_id" value="">
            <input type="hidden" id="employee_record_id"
                   name="employee_record_id"
                   value="{{Auth::user()->employee->id}}">
            <input type="hidden" id="employee_name" name="employee_name"
                   value="{{Auth::user()->employee->name_bng}}">

            <div class="row">
                <div class="col-md-12">
                    <div id="employee_protikolpo_list"></div>
                </div>
            </div>

            <!-- </div> -->
            <div class="modal-footer">
                <button  class="btn btn-info btn-font-lg"><i class="fas fa-save mr-2"></i>সংরক্ষণ</button>
                 <!-- <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ</button> -->
                <!-- <button class="btn btn-primary">সংরক্ষণ</button> -->
            </div>
        </form>
    </div>
</div>
</div>


<script>
    $('input[type="checkbox"]').on('change', function () {
        this.value ^= 1;
    });
    $(document).ready(function () {
        employeeProtikolpoList();
    })

    function portikolpoSubmitData(form, url) {
        var data = $(form).serialize();
        var datatype = 'json';
        ajaxCallAsyncCallback(url, data, datatype, 'POST', function (resp) {
            console.log(resp.status)
            if (resp.status === 'success') {
                toastr.success('সফলভাবে হালনাগাদ হয়েছে');
                employeeProtikolpoList()
            }else if(resp.status === 'error'){
                toastr.error(resp.msg);
            }
        })
    }

    function employeeProtikolpoList() {
        url = '{{url('employee_protikolpo_list')}}';
        data = {employee_record_id: '{{Auth::user()->employee->id}}'}
        datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'POST', function (response) {
            $('#employee_protikolpo_list').html(response);
        })
    }

    $('#protikolpo_start_date').datepicker(
        {
            format: 'dd-mm-yyyy',
            startDate: '{{date('d-m-Y')}}',
            autoClose: true,
        }
    );
    $('#protikolpo_end_date').datepicker(
        {
            format: 'dd-mm-yyyy',
            startDate: '{{date('d-m-Y')}}',
            autoClose: true,
        }
    );

    $(function() {
        var sel_user_options = $("select.user-options"),
        opts = sel_user_options.find('option');
        sel_user_options.bind('change', function (e) {
            e.preventDefault();
            var optselected = $(this).find("option:selected");
            if (optselected.attr('id') == 'other') {
                sel_user_options.after("<div class='additional'><input class='form-control' id=other name='other' placeholder='টাইপ করুন'/></div>");
                var oth = $("input#other");
                oth.keyup(function (e) {
                    optselected.html($(this).val());
                });
            } else {
                $('.additional').hide();
            }
        });
    });
</script>
