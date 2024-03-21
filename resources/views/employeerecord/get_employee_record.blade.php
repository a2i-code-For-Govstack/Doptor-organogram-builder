<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
     <tr class="text-center">
            <th width="10%">নাম (বাংলা)</th>
            <th width="10%">নাম (ইংরেজি)</th>
            <th width="10%">জাতীয় পরিচয়পত্র নাম্বার</th>
            <th width="8%">ইমেইল</th>
            <th width="8%">মোবাইল</th>
            <th width="2%">ক্যাডার</th>
            <th width="10%">পদবি</th>
            <th width="10%">শাখা</th>
            <th width="10%">অফিস</th>
            <th width="10%">লগইন আইডি</th>
            <th width="8%">কার্যক্রম</th>
            <th class="no-sort" width="10%">
                <div class="btn-group">
                    <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                        <input id="all" type="checkbox">
                        <span></span>
                    </label>
                    <button style="height: 18px;padding-left: 23px" type="button" id="delete_employee"
                    class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                    class="fas fa-trash-alt text-danger"></i></button>
                </div>
            </div>
            </th>
        </tr>
        </thead>
        <tbody>

        @foreach($employee_records as $employee_record)
            @if($employee_record->employee_office->first())
                @foreach($employee_record->employee_office as $employee_office)
                    <tr class="text-center">
                        <td>{{$employee_record->name_bng}}</td>
                        <td>{{$employee_record->name_eng}}</td>
                        <td>{{$employee_record->nid}}</td>
                        <td>{{$employee_record->personal_email}}</td>
                        <td>{{$employee_record->personal_mobile}}</td>
                        <td><?php echo ($employee_record->is_cadre == 1)?'হ্যা':'না'?></td>
                        <td>{{($employee_office) ? $employee_office->designation : ''}}</td>
                        <td>{{($employee_office) ? $employee_office->unit_name_bn : ''}}</td>
                        <td>{{($employee_office) ? $employee_office->office_name_bn : ''}}</td>
                        <td>{{@$employee_record->user->username}}</td>
                        <td>
                            <div class="btn-group">
                                 <a href="{{url('edit_employee/'.$employee_record->id)}}" class="btn btn-warning btn-icon btn-square"><i
                                            class="fas fa-pencil-alt"></i></a>
                                <button data-id="{{$employee_record->id}}" type="button" class="btn btn-info btn-icon btn-square changePassword"><i class="fas fa-key"></i></button>
                            </div>
                        </td>
                        <td>
                            <label class="kt-checkbox kt-checkbox--success">
                                <input class="employee_record_id" value="{{$employee_record->id}}" type="checkbox">
                                <span></span>
                            </label>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td>{{$employee_record->name_bng}}</td>
                    <td>{{$employee_record->name_eng}}</td>
                    <td>{{$employee_record->identity_no}}</td>
                    <td>{{$employee_record->personal_email}}</td>
                    <td>{{$employee_record->personal_mobile}}</td>
                    <td><?php echo ($employee_record->is_cadre == 1)?'হ্যা':'না'?></td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{@$employee_record->user->username}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{url('edit_employee/'.$employee_record->id)}}" class="btn btn-warning btn-icon btn-square"><i
                                            class="fas fa-pencil-alt"></i></a>
                            <button data-id="{{$employee_record->id}}" type="button" class="btn btn-info btn-icon btn-square changePassword"><i class="fas fa-key"></i></button>
                        </div>
                    </td>
                    <td>
                        <label class="kt-checkbox kt-checkbox--success">
                            <input class="employee_record_id" value="{{$employee_record->id}}" type="checkbox">
                            <span></span>
                        </label>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

<script type="text/javascript">
    tapp_table_init();
    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#delete_employee").click(function(){
         swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function(result) {
            if (result.value) {

        var employee_record_id=[];
        var id;
        $(".employee_record_id").each(function(i,value) {
            id = $(this).val();
            if ($(this).is(':checked')) {
                employee_record_id.push(id);
            }
        });

        $.ajax({
            method: 'POST',
            url: "{{ url('delete_employee') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {employee_record_id:employee_record_id}, // pass in json format
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                }else{
                    toastr.error(data.msg);
                }
                // location.reload();
            },
            error : function(data){
                var errors = data.responseJSON;
                $.each(errors.errors,function (k,v) {
                    toastr.error(v);
                });
            }
        });

            }
        });

    });

    $(".changePassword").click(function(){
        var employee_record_id = $(this).data('id');
         swal.fire({
            title: 'আপনি কি পাসওয়ার্ড পরিবর্তন করতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function(result) {
            if (result.value) {

        $.ajax({
            method: 'POST',
            url: "{{ url('change_password_by_admin') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {employee_record_id:employee_record_id}, // pass in json format
            error : function(data){
                var errors = data.responseJSON;
                $.each(errors.errors,function (k,v) {
                    toastr.error(v);
                });
            },
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                }else{
                    console.log(data.data);
                    toastr.error(data.msg)
                }
                // location.reload();
            }

        });

            }
        });
    });



</script>
