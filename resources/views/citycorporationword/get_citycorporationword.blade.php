<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="10%">প্রশাসনিক বিভাগ</th>
        <th width="10%">জেলা</th>
        <th width="10%">সিটি কর্পোরেশন</th>
        {{-- <th width="10%">সিটি কর্পোরেশন কোড</th> --}}
        <th width="10%">সিটি কর্‌পোরেশন ওয়ার্ড কোড</th>
        {{-- <th width="10%">জেলা কোড</th>
        <th width="10%">বিভাগ কোড</th> --}}
        <th width="10%">ওয়ার্ডের নাম(বাংলা)</th>
        <th width="10%">ওয়ার্ডের নাম(ইংরেজি)</th>
        <th width="10%">অবস্থা</th>
        <th class="no-sort" width="10%">সম্পাদনা</th>
        <th class="no-sort" width="10%">
            <div class="btn-group">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span></span>
                </label>
                <button style="height: 18px;padding-left: 23px" type="button" id="delete_city_corporatoin_word"
                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                                                            class="fas fa-trash-alt text-danger"></i></button>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($citycorporationwords as $citycorporationword)
        <tr class="text-center">
            <td>{{@$citycorporationword->bivag->division_name_bng}}</td>
            <td>{{@$citycorporationword->zila->district_name_bng}}</td>
            <td>{{$citycorporationword->city_corporation ? $citycorporationword->city_corporation->city_corporation_name_bng : ''}}</td>
            {{-- <td>{{$citycorporationword->city_corporation ? enTobn($citycorporationword->city_corporation->bbs_code) : ''}}</td> --}}
            <td>{{enTobn($citycorporationword->bbs_code)}}</td>
            {{-- <td>{{@enTobn($citycorporationword->zila->bbs_code)}}</td>
            <td>{{@enTobn($citycorporationword->bivag->bbs_code)}}</td> --}}
            <td>{{$citycorporationword->ward_name_bng}} </td>
            <td>{{$citycorporationword->ward_name_eng}} </td>
            <td>@if($citycorporationword->status == 1)
                    সক্রিয়
                @else
                    নিষ্ক্রিয়
                @endif  </td>
            <td>
                <button
                    data-content="{{$citycorporationword->id}},{{enTobn($citycorporationword->bbs_code)}},{{$citycorporationword->ward_name_bng}},{{$citycorporationword->ward_name_eng}},{{$citycorporationword->status}},{{$citycorporationword->geo_division_id}},{{$citycorporationword->geo_district_id}},{{@$citycorporationword->city_corporation->id}},{{$citycorporationword->division_bbs_code}},{{$citycorporationword->district_bbs_code}}"
                    type="button" data-dismiss="modal" class="btn btn-icon btn-outline-brand btntableDataEdit"><i
                        class="fas fa-pencil-alt"></i></button>
            </td>
            <td>
                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                    <input class="citycorporationword_id" value="{{$citycorporationword->id}}" type="checkbox">
                    <span></span>
                </label>
                <x-geo-log-view geotablename="geo_city_corporation_wards" geoid="{{$citycorporationword->id}}"></x-geo-log-view>
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
    $("#delete_city_corporatoin_word").click(function () {
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {

                var citycorporationword_id = [];
                var id;
                $(".citycorporationword_id").each(function (i, value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        citycorporationword_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_city_corporation_word') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {citycorporationword_id: citycorporationword_id}, // pass in json format
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
