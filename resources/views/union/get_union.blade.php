<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="10%">প্রশাসনিক বিভাগ</th>
        <th width="8%">জেলা</th>
        <th width="8%">উপজেলা</th>
        <th width="10%">ইউনিয়ন কোড</th>
        <th width="10%">ইউনিয়ন নাম(বাংলা)</th>
        <th width="8%">ইউনিয়ন নাম(ইংরেজি)</th>
        <th width="9%">অবস্থা</th>
        <th class="no-sort" width="10%">সম্পাদনা</th>
        <th class="no-sort" width="10%">
            <div class="btn-group">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span></span>
                </label>

                <button style="height: 18px;padding-left: 23px" type="button" id="delete_union"
                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                                                            class="fas fa-trash-alt text-danger"></i></button>
            </div>
    </tr>
    </thead>
    <tbody>
    @foreach($unions as $union)
        <tr class="text-center">
            <td> {{$union->bivag ? $union->bivag->division_name_bng : ''}}</td>
            <td> {{$union->zila ? $union->zila->district_name_bng : ''}}</td>
            <td> {{$union->upozila ? $union->upozila->upazila_name_bng : ''}}</td>
            <td> {{enTobn($union->bbs_code)}} </td>
            <td> {{$union->union_name_bng}} </td>
            <td> {{$union->union_name_eng}} </td>
            <td> @if($union->status == 1)
                    সক্রিয়
                @else
                    নিষ্ক্রিয়
                @endif </td>
            <td>
                <button
                    data-content="{{$union->id}},{{$union->bbs_code}},{{$union->union_name_bng}},{{$union->union_name_eng}},{{$union->status}},{{$union->geo_division_id}},{{$union->geo_district_id}},{{$union->geo_upazila_id}},{{$union->division_bbs_code}},{{$union->district_bbs_code}},{{$union->upazila_bbs_code}}"
                    type="button" data-dismiss="modal" class="btn btn-icon btn-outline-brand btntableDataEdit"><i
                        class="fas fa-pencil-alt"></i></button>
            </td>
            <td>
                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                    <input class="union_id" value="{{$union->id}}" type="checkbox">
                    <span></span>
                </label>
                <x-geo-log-view geotablename="geo_unions" geoid="{{$union->id}}"></x-geo-log-view>
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

    $("#delete_union").click(function () {
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {
                var union_id = [];
                var id;
                $(".union_id").each(function (i, value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        union_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_union') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {union_id: union_id}, // pass in json format
                    success: function (data) {
                        if (data.status === 'success') {
                            toastr.success(data.msg);
                            location.reload();
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function (data) {
                        var errors = data.responseJSON;
                        $.each(errors.errors, function (k, v) {
                            toastr.error(v);
                        });
                    }
                });

            }
        });
    });

</script>
