<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
       <tr class="text-center">
            <th width="10%">প্রশাসনিক বিভাগ</th>
            <th width="10%">জেলা</th>
            <th width="10%">উপজেলা কোড</th>
            <th width="10%">উপজেলার নাম(বাংলা)	</th>
            <th width="10%">উপজেলার নাম(ইংরেজি)	</th>
            <th width="10%">অবস্থা</th>
            <th class="no-sort" width="10%">সম্পাদনা</th>
            <th class="no-sort" width="10%">
                <div class="btn-group">
                    <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                        <input id="all" type="checkbox">
                        <span></span>
                    </label>
                    <button style="height: 18px;padding-left: 23px" type="button" id="delete_upozila"
                    class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                    class="fas fa-trash-alt text-danger"></i></button>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($upozilas as $upozila)
            <tr class="text-center">
                <td>{{$upozila->bivag->division_name_bng}}</td>
                <td>{{@$upozila->zila->district_name_bng}}</td>
                <td>{{enTobn($upozila->bbs_code)}}</td>
                <td>{{$upozila->upazila_name_bng}} </td>
                <td>{{$upozila->upazila_name_eng}} </td>
                <td>
                    @if($upozila->status == 1)
                        সক্রিয়
                    @else
                        নিষ্ক্রিয়
                    @endif
                </td>
                <td>
                    <button
                        data-content="{{$upozila->id}},{{enTobn($upozila->bbs_code)}},{{$upozila->upazila_name_bng}},{{$upozila->upazila_name_eng}},{{$upozila->status}},{{$upozila->geo_division_id}},{{$upozila->geo_district_id}},{{$upozila->division_bbs_code}},{{$upozila->district_bbs_code}}"
                        id="upozila_id{{$upozila->id}}" type="button" data-dismiss="modal"
                        class="btn btn-icon btn-outline-brand btntableDataEdit"><i class="fas fa-pencil-alt"></i>
                    </button>
                </td>
                <td>
                    <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                        <input class="upozila_id" value="{{$upozila->id}}" type="checkbox">
                        <span></span>
                    </label>
                    <x-geo-log-view geotablename="geo_upazilas" geoid="{{$upozila->id}}"></x-geo-log-view>
                </td>
            </tr>
        @endforeach
        </tbody>
</table>


<script type="text/javascript">
    no_order_tapp_table_init();

    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
    $("#delete_upozila").click(function () {
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {

                var upozila_id = [];
                var id;
                $(".upozila_id").each(function (i, value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        upozila_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_upozila') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {upozila_id:upozila_id}, // pass in json format
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                    location.reload();
                } else {
                    toastr.error(data.msg);
                }
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

</script>
