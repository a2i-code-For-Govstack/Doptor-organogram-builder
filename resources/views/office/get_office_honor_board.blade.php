<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="10%">নাম</th>
        <th width="10%">পদবি</th>
        <th width="10%">হইতে</th>
        <th width="10%">পর্যন্ত</th>
        <th width="10%">ইনচার্জ লেভেল</th>
{{--        <th class="no-sort no-print" width="10%">সম্পাদনা করুন</th>--}}
{{--        <th class="no-sort no-print" width="10%">--}}
{{--            <div class="btn-group">--}}
{{--                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">--}}
{{--                    <input id="all" type="checkbox">--}}
{{--                    <span></span>--}}
{{--                </label>--}}
{{--                <button style="height: 18px;padding-left: 23px" type="button" id="delete_zila"--}}
{{--                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"--}}
{{--                                                            class="fas fa-trash-alt text-danger"></i></button>--}}
{{--            </div>--}}
{{--        </th>--}}
    </tr>
    </thead>
    <tbody>
    @foreach($honor_board_list as $key => $value)
    <tr class="text-center">
            <td>{{$value->name}}</td>
            <td>{{$value->organogram_name}}</td>
            <td>{{enTobn(date('d-m-Y',strtotime($value->join_date)))}}</td>
            <td>{{$value->release_date ? enTobn(date('d-m-Y',strtotime($value->release_date))) : ''}}</td>
            <td>{{$value->incharge_label}}</td>
{{--            <td class="text-center no-print">--}}
{{--                <button type="button"--}}
{{--                        data-content="{{$value->id}},{{$value->name}},{{$value->organogram_name}},{{date('d-m-Y',strtotime($value->join_date))}},{{date('d-m-Y',strtotime($value->release_date))}},{{$value->incharge_label}},{{$value->unit_id}},{{$value->organogram_id}},{{$value->employee_record_id}}"--}}
{{--                        data-dismiss="modal"--}}
{{--                        class="btn btn-icon btn-outline-brand btntableDataEdit"><i--}}
{{--                        class="fas fa-pencil-alt"></i></button>--}}
{{--            </td>--}}
{{--            <td class="text-center no-print">--}}

{{--                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">--}}
{{--                    <input class="honor_id" value="{{$value->id}}" type="checkbox">--}}
{{--                    <span></span>--}}
{{--                </label>--}}
{{--            </td>--}}
        </tr>
    @endforeach()

    </tbody>
</table>

<script type="text/javascript">
    tapp_table_init('tapp_table', 3);

    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#delete_honor_board").click(function () {
        var result = confirm("Want to delete?");
        if (!result) {
            return;
        }
        var honor_id = [];
        var id;
        $(".honor_id").each(function (i, value) {
            id = $(this).val();
            // id = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                honor_id.push(id);
            }

        });

        $.ajax({
            method: 'POST',
            url: "{{ url('delete_honor_board') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {honor_id: honor_id}, // pass in json format
            success: function (data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                }
                location.reload();
            },
            error: function (data) {
                var errors = data.responseJSON;
                $.each(errors.errors, function (k, v) {
                    toastr.error(v);
                });
            }
        });
    });
</script>
