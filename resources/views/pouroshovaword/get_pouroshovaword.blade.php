<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th>প্রশাসনিক বিভাগ</th>
        <th>জেলা</th>
        <th>উপজেলা</th>
        <th>পৌরসভা</th>
        <th>ওয়ার্ড কোড</th>
        <th>ওয়ার্ডের নাম(বাংলা)</th>
        <th>ওয়ার্ডের নাম(ইংরেজি)</th>
        <th>অবস্থা</th>
        <th class="no-sort">সম্পাদনা</th>
        <th class="no-sort" width="10%">
            <div class="btn-group">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span></span>
                </label>
                <button style="height: 18px;padding-left: 23px" type="button" id="delete_pouroshova_word"
                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                                                            class="fas fa-trash-alt text-danger"></i></button>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($pouroshova_words as $pouroshova_word)
        <tr class="text-center">
            <td>{{@$pouroshova_word->bivag->division_name_bng}}</td>
            <td>{{@$pouroshova_word->zila->district_name_bng}}</td>
            <td>{{@$pouroshova_word->upozila->upazila_name_bng}}</td>
            <td>{{@$pouroshova_word->pouroshova->municipality_name_bng}}</td>
            {{-- <td>{{enTobn(@$pouroshova_word->pouroshova->bbs_code)}}</td>
            <td>{{enTobn(@$pouroshova_word->upozila->bbs_code)}}</td>
            <td>{{@enTobn($pouroshova_word->zila->bbs_code)}}</td> --}}
            <td>{{enTobN($pouroshova_word->bbs_code)}}</td>
            <td>{{$pouroshova_word->ward_name_bng}} </td>
            <td>{{$pouroshova_word->ward_name_eng}} </td>
            <td>@if($pouroshova_word->status == 1)
                    সক্রিয়
                @else
                    নিষ্ক্রিয়
                @endif  </td>
            <td>
                <button
                    data-content="{{$pouroshova_word->id}},{{$pouroshova_word->bbs_code}},{{$pouroshova_word->ward_name_bng}},{{$pouroshova_word->ward_name_eng}},{{$pouroshova_word->status}},{{$pouroshova_word->geo_division_id}},{{$pouroshova_word->geo_district_id}},{{@$pouroshova_word->upozila->id}},{{@$pouroshova_word->pouroshova->id}},{{$pouroshova_word->division_bbs_code}},{{$pouroshova_word->district_bbs_code}}"
                    type="button" data-dismiss="modal" class="btn btn-icon btn-outline-brand btntableDataEdit"><i
                        class="fas fa-pencil-alt"></i></button>
            </td>
            <td>
                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                    <input class="pouro_word_id" value="{{$pouroshova_word->id}}" type="checkbox">
                    <span></span>
                </label>
                <x-geo-log-view geoid="{{$pouroshova_word->id}}" geotablename="geo_municipality_wards"></x-geo-log-view>
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
    $("#delete_pouroshova_word").click(function () {
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {

                var pouroshova_word_id = [];
                var id;
                $(".pouro_word_id").each(function (i, value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        pouroshova_word_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_pouroshova_word') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {pouroshova_word_id: pouroshova_word_id}, // pass in json format
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
