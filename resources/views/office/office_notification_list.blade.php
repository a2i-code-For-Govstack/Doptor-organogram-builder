
   <table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
       <tr class="text-center">
            <th></th>
            <th class="">ইমেইল</th>
            <th class="">এস এম এস</th>
            <th class="">মোবাইল অ্যাপ</th>
        </tr>
        </thead>
        <tbody>


        @foreach($office_notifications as $notification)
            @php
                $email_status = 0;
                $sms_status = 0;
                $mobile_app_status = 0;
            @endphp
             @foreach($office_notifications_status as $key => $val)
                @if($notification->id == $key)
                    @php
                        $email_status = $val->email;
                        $sms_status = $val->sms;
                        $mobile_app_status = $val->mobile_app;
                    @endphp

                @endif
             @endforeach
         <tr>
            <td>{{$notification->event_name_bng}}</td>
            <td>
                <span class="kt-switch kt-switch--icon">
                    <label>
                        <input class="email" type="checkbox" data-id="{{$notification->id}}" value="{{$email_status}}" <?php if($email_status == '1'){echo 'checked';} ?> name="email[]">
                        <span></span>
                    </label>
                </span>
            </td>
            <td>
                <span class="kt-switch kt-switch--icon">
                    <label>
                        <input class="sms" type="checkbox" data-id="{{$notification->id}}" value="{{$sms_status}}" <?php if($sms_status == '1'){echo 'checked';} ?> name="sms[]">
                        <span></span>
                    </label>
                </span>
            </td>
            <td>
                <span class="kt-switch kt-switch--icon">
                    <label>
                        <input class="mobile_app" type="checkbox" data-id="{{$notification->id}}"  value="{{$mobile_app_status}}" <?php if($mobile_app_status == '1'){echo 'checked';} ?> name="mobile_app[]">
                        <span></span>
                    </label>
                </span>
            </td>
        </tr>

        @endforeach
        </tbody>

    </table>
<div class="">
    <button type="button" class="btn btn-md btn-primary"  id="notificationSubmit" >দায়িত্ব প্রদান</button>
</div>

<script type="text/javascript">
tapp_table_init();
    $("#notificationSubmit").click(function(){

        var office_id = $('#office_id').val();
        var data;
        var email;
        var sms;
        var mobile_app;

        var email_arr=[];
        var sms_arr=[];
        var mobile_arr=[];

        $(".email").each(function(i,value) {
            email = $(this).val();
            id = $(this).attr('data-id');
            email_arr[id] = email;
        });

        $(".sms").each(function(i,value) {
            sms = $(this).val();
            id = $(this).attr('data-id');
            sms_arr[id] = sms;
        });

        $(".mobile_app").each(function(i,value) {
            mobile_app = $(this).val();
            id = $(this).attr('data-id');
            mobile_arr[id] = mobile_app;
        });

        $.ajax({
            method: 'POST',
            url: "{{ url('office_notification') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {sms:sms_arr,email:email_arr,mobile_app:mobile_arr,office_id:office_id}, // pass in json format
            success   : function(data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                } else {
                    toastr.error(data.msg);
                }
            },
            error : function(err){
                console.log(err)
            }
        });
    });



    $(".email").change(function() {
        var email = $(this).val();
        if (email == 1) {
            $(this).val(0);
        }else if(email == 0){
           $(this).val(1);
        }
    });

    $(".sms").change(function() {
        var sms = $(this).val();
        if (sms == 1) {
            $(this).val(0);
        }else if(sms == 0){
           $(this).val(1);
        }
    });

    $(".mobile_app").change(function() {
        var mobile_app = $(this).val();
        if (mobile_app == 1) {
            $(this).val(0);
        }else if(mobile_app == 0){
           $(this).val(1);
        }
    });
</script>


