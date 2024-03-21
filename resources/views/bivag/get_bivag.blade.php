<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="10%">বিভাগ কোড</th>
        <th width="10%">প্রশাসনিক বিভাগের নাম(বাংলা)</th>
        <th width="10%">প্রশাসনিক বিভাগের নাম(ইংরেজি)</th>
        <th width="10%">অবস্থা</th>
        <th class="no-sort" width="10%">কার্যক্রম</th>
        <th class="no-sort" width="10%">

            <div class="btn-group">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span></span>
                </label>
                <button style="height: 18px;padding-left: 23px" type="button" id="delete_division"
                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                                                            class="fas fa-trash-alt text-danger"></i></button>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($bivags as $bivag)
        <tr class="text-center">
            <td>{{enTobn($bivag->bbs_code)}}</td>
            <td>{{$bivag->division_name_bng}}</td>
            <td>{{$bivag->division_name_eng}}</td>
            <td>@if($bivag->status == 1)
                    সক্রিয়
                @else
                    নিষ্ক্রিয়
                @endif</td>
            <td>
                <button style="height: 30px;width: 30px;"
                        data-content="{{$bivag->id}},{{enTobn($bivag->bbs_code)}},{{$bivag->division_name_bng}},{{$bivag->division_name_eng}},{{$bivag->status}}"
                        id="bivag_id{{$bivag->id}}" data-dismiss="modal"
                        class="btn  btn-icon btn-outline-brand btntableDataEdit">
                    <i class="fas fa-pencil-alt"></i></button>
            </td>
            <td>
                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                    <input class="division_id" id="division_id" value="{{$bivag->id}}" type="checkbox">
                    <span></span>
                </label>
                <x-geo-log-view geotablename="geo_divisions" geoid="{{$bivag->id}}"/>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<script type="text/javascript">
    no_order_tapp_table_init();


    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
    $("#delete_division").click(function () {
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {

                var division_id = [];
                var id;
                $(".division_id").each(function (i, value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        division_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_division') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {division_id: division_id}, // pass in json format
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
