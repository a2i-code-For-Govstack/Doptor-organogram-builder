<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
       <tr class="text-center">
            <th>প্রশাসনিক বিভাগ</th>
            <th>জেলা</th>
            <th>উপজেলা</th>
            {{-- <th>থানা</th> --}}
            <th>পোষ্ট অফিস কোড</th>
            <th>পোষ্ট অফিসের নাম(বাংলা)</th>
            <th>পোষ্ট অফিসের নাম(ইংরেজি)</th>
            <th>অবস্থা</th>
            <th class="no-sort">সম্পাদনা</th>
            <th class="no-sort" width="10%">
                <div class="btn-group">
                    <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                        <input id="all" type="checkbox">
                        <span></span>
                    </label>
                    <button style="height: 18px;padding-left: 23px" type="button" id="delete_post_office"
                    class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                    class="fas fa-trash-alt text-danger"></i></button>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($post_offices as $post_office)
        <tr class="text-center">
            <td>{{($post_office->bivag) ? $post_office->bivag->division_name_bng : '-'}}</td>
            <td>{{($post_office->zila) ? $post_office->zila->district_name_bng : '-'}}</td>
            <td>{{($post_office->upozila) ? $post_office->upozila->upazila_name_bng : '-'}}</td>
            {{-- <td>{{($post_office->thana) ? $post_office->thana->thana_name_bng : '-'}}</td> --}}
            <td>{{enTobn($post_office->bbs_code)}}</td>
            <td>{{$post_office->postoffice_name_bng}} </td>
            <td>{{$post_office->postoffice_name_eng}} </td>
            <td>
                @if($post_office->status == 1) সক্রিয় @else নিষ্ক্রিয় @endif
             </td>
            <td><button data-content="{{$post_office->id}},{{enTobn($post_office->bbs_code)}},{{$post_office->postoffice_name_bng}},{{$post_office->postoffice_name_eng}},{{$post_office->status}},{{$post_office->geo_division_id}},{{$post_office->geo_district_id}},{{$post_office->geo_upazila_id}},{{$post_office->geo_thana_id}},{{$post_office->division_bbs_code}},{{$post_office->district_bbs_code}}"
                    type="button" data-dismiss="modal" class="btn btn-icon btn-outline-brand btntableDataEdit"><i class="fas fa-pencil-alt"></i></button></td>
            <td>
                <label class="kt-checkbox kt-checkbox--success">
                    <input class="post_office_id" value="{{$post_office->id}}" type="checkbox">
                    <span></span>
                </label>
                <x-geo-log-view geotablename="geo_post_offices" geoid="{{$post_office->id}}"></x-geo-log-view>
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
    $("#delete_post_office").click(function(){
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function(result) {
            if (result.value) {

                var post_office_id=[];
        var id;
        $(".post_office_id").each(function(i,value) {
            id = $(this).val();
            // id = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                post_office_id.push(id);
            }

        });

        $.ajax({
            method: 'POST',
            url: "{{ url('delete_post_office') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {post_office_id:post_office_id}, // pass in json format
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
