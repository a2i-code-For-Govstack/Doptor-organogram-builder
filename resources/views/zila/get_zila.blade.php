<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
            <thead class="table-head-color">
               <tr class="text-center">
                <th width="10%">প্রশাসনিক বিভাগ</th>
                <th width="10%">জেলা কোড</th>
                <th width="10%">জেলার নাম(বাংলা)</th>
                <th width="10%">জেলার নাম(ইংরেজি)</th>
                <th width="10%">অবস্থা</th>
                <th class="no-sort" width="10%">সম্পাদনা</th>
                <th class="no-sort" width="10%">
                    <div class="btn-group">
                        <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                            <input id="all" type="checkbox">
                            <span></span>
                        </label>
                        <button style="height: 18px;padding-left: 23px" type="button" id="delete_zila"
                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                        class="fas fa-trash-alt text-danger"></i></button>
                    </div>
                </th>
            </tr>
            </thead>
            <tbody>
                @foreach($zilas as $zila)
                <tr class="text-center">
                    <td>{{$zila->bivag->division_name_bng}}</td>
                    <td>{{enTobn($zila->bbs_code)}}</td>
                    <td>{{$zila->district_name_bng}}</td>
                    <td>{{$zila->district_name_eng}}</td>
                    <td>@if($zila->status == 1) সক্রিয় @else নিষ্ক্রিয়
                    @endif</td>
                    <td><button style="height: 30px;width: 30px;" id="zila_id{{$zila->id}}"  data-content="{{$zila->bivag->division_name_bng}},{{$zila->bivag->bbs_code}},{{$zila->id}},{{$zila->district_name_bng}},{{$zila->district_name_eng}},{{enTobn($zila->bbs_code)}},{{$zila->status}},{{$zila->bivag->id}}" type="button" data-dismiss="modal" class="btn btn-icon btn-outline-brand btntableDataEdit"><i class="fas fa-pencil-alt"></i></button></td>
                    <td>
                        <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                            <input class="zila_id" value="{{$zila->id}}" type="checkbox">
                            <span></span>
                        </label>
                        <x-geo-log-view geotablename="geo_districts" geoid="{{$zila->id}}"/>

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
    $("#delete_zila").click(function(){
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function(result) {
            if (result.value) {
                var zila_id = [];
        var id;
        $(".zila_id").each(function (i, value) {
            id = $(this).val();
            // id = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                zila_id.push(id);
            }

        });

        $.ajax({
            method: 'POST',
            url: "{{ url('delete_zila') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {zila_id: zila_id}, // pass in json format
            success: function (data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                    location.reload();
                } else {
                    toastr.error(data.msg);
                }
            },
            error: function (err) {
                console.log(err)
            }
        });

            }
        });
    });

</script>
