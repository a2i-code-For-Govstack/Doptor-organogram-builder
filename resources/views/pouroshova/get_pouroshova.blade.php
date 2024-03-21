<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
       <tr class="text-center">
          <th>প্রশাসনিক বিভাগ</th>
            <th>জেলা</th>
            <th>উপজেলা</th>
            <th>পৌরসভা কোড</th>
            {{-- <th>উপজেলা কোড  </th>
            <th>জেলা কোড</th> --}}
            <th>পৌরসভার নাম(বাংলা)</th>
            <th>পৌরসভার নাম(ইংরেজি)</th>
            <th>অবস্থা</th>
            <th class="no-sort">সম্পাদনা</th>
            <th class="no-sort" width="10%">
                <div class="btn-group">
                    <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                        <input id="all" type="checkbox">
                        <span></span>
                    </label>
                    <button style="height: 18px;padding-left: 23px" type="button" id="delete_pouroshova"
                    class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                    class="fas fa-trash-alt text-danger"></i></button>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($pouroshovas as $pouroshova)
        <tr class="text-center">
            <td>{{@$pouroshova->bivag->division_name_bng}}</td>
            <td>{{@$pouroshova->zila->district_name_bng}}</td>
            <td>{{@$pouroshova->upozila->upazila_name_bng}}</td>
            <td>{{enTobn($pouroshova->bbs_code)}}</td>
            {{-- <td>{{enTobn(@$pouroshova->upozila->bbs_code)}}</td>
            <td>{{enTobn(@$pouroshova->zila->bbs_code)}}</td> --}}

            <td>{{$pouroshova->municipality_name_bng}} </td>
            <td>{{$pouroshova->municipality_name_eng}} </td>
            <td>@if($pouroshova->status == 1) সক্রিয় @else নিষ্ক্রিয় @endif  </td>
            <td><button data-content="{{$pouroshova->id}},{{$pouroshova->bbs_code}},{{$pouroshova->municipality_name_bng}},{{$pouroshova->municipality_name_eng}},{{$pouroshova->status}},{{$pouroshova->geo_division_id}},{{$pouroshova->geo_district_id}},{{@$pouroshova->upozila->id}},{{$pouroshova->division_bbs_code}},{{$pouroshova->district_bbs_code}}"
                    type="button" data-dismiss="modal" class="btn btn-icon btn-outline-brand btntableDataEdit"><i class="fas fa-pencil-alt"></i></button></td>
            <td>
                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                    <input class="pouro_id" value="{{$pouroshova->id}}" type="checkbox">
                    <span></span>
                </label>
                <x-geo-log-view geoid="{{$pouroshova->id}}" geotablename="geo_municipalities"></x-geo-log-view>

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
    $("#delete_pouroshova").click(function(){
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function(result) {
            if (result.value) {

                var pouroshova_id=[];
        var id;
        $(".pouro_id").each(function(i,value) {
            id = $(this).val();
            // id = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                pouroshova_id.push(id);
            }

        });

        $.ajax({
            method: 'POST',
            url: "{{ url('delete_pouroshova') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {pouroshova_id:pouroshova_id}, // pass in json format
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                }
                location.reload();
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
