<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="10%">প্রশাসনিক বিভাগ</th>
        <th width="10%">জেলা</th>
        <th width="10%">সিটি কর্পোরেশন কোড</th>
        {{-- <th width="10%">জেলা কোড</th>
        <th width="10%">বিভাগ কোড</th> --}}
        <th width="10%">সিটি কর্পোরেশনের নাম(বাংলা)</th>
        <th width="10%">সিটি কর্পোরেশনের নাম(ইংরেজি)</th>
        <th width="10%">অবস্থা</th>
        <th class="no-sort" width="10%">সম্পাদনা</th>
        <th class="no-sort" width="10%">
            <div class="btn-group">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span></span>
                </label>
                <button style="height: 18px;padding-left: 23px" type="button" id="delete_city_corporatoin"
                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                                                            class="fas fa-trash-alt text-danger"></i></button>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($citycorporations as $citycorporation)
        <tr class="text-center">
            <td>{{@$citycorporation->bivag->division_name_bng}}</td>
            <td>{{@$citycorporation->zila->district_name_bng}}</td>
            <td>{{@enTobn($citycorporation->bbs_code)}}</td>
            {{-- <td>{{@enTobn($citycorporation->zila->bbs_code)}}</td>
            <td>{{@enTobn($citycorporation->bivag->bbs_code)}}</td> --}}
            <td>{{$citycorporation->city_corporation_name_bng}} </td>
            <td>{{$citycorporation->city_corporation_name_eng}} </td>
            <td>@if($citycorporation->status == 1)
                    সক্রিয়
                @else
                    নিষ্ক্রিয়
                @endif  </td>
            <td>
                <button
                    data-content="{{$citycorporation->id}},{{enTobn($citycorporation->bbs_code)}},{{$citycorporation->city_corporation_name_bng}},{{$citycorporation->city_corporation_name_eng}},{{$citycorporation->status}},{{$citycorporation->geo_division_id}},{{$citycorporation->geo_district_id}},{{$citycorporation->division_bbs_code}},{{$citycorporation->district_bbs_code}}"
                    type="button" data-dismiss="modal" class="btn btn-icon btn-outline-brand btntableDataEdit"><i
                        class="fas fa-pencil-alt"></i></button>
            </td>
            <td>
                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                    <input class="corporatoin_id" value="{{$citycorporation->id}}" type="checkbox">
                    <span></span>
                </label>

                <x-geo-log-view geotablename="geo_city_corporations" geoid="{{$citycorporation->id}}"></x-geo-log-view>
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
    $("#delete_city_corporatoin").click(function () {
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {

                var city_corporatoin_id = [];
                var id;
                $(".corporatoin_id").each(function (i, value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        city_corporatoin_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_city_corporation') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {city_corporatoin_id: city_corporatoin_id}, // pass in json format
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
            }
        });
    });

</script>
