<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
        <tr>
            <th>ধরন (বাংলা)</th>
            <th>ধরন (ইংরেজি)</th>
            <th class="no-sort text-center">সম্পাদনা</th>
            <th  class="no-sort text-center">
                    <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                        <input id="all" type="checkbox">
                        <span style="top: -7px"></span>
                    </label>
                    <button style="height: 18px;padding-left: 23px" type="button" id="delete_unit_category"
                    class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                    class="fas fa-trash-alt text-danger"></i></button>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($office_unit_categories as $office_unit_category)
        <tr>
            <td>{{$office_unit_category->category_name_bng}}</td>
            <td>{{$office_unit_category->category_name_eng}}</td>
            <td class="text-center">
                <div class="btn-group">
                    <button style="height: 30px;width: 30px;"
                     data-content="{{$office_unit_category->id}},{{$office_unit_category->category_name_bng}},{{$office_unit_category->category_name_eng}}"
                    id ="category_id{{$office_unit_category->id}}" type="button" data-dismiss="modal"
                    class="btn btn-icon btn-outline-brand btntableDataEdit"><i
                    class="fas fa-pencil-alt"></i></button>
                </div>
            </td>
            <td class="text-center">
                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                    <input class="unit_category_id" value="{{$office_unit_category->id}}" type="checkbox">
                    <span></span>
                </label>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    tapp_table_init();
    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#delete_unit_category").click(function(){
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function(result) {
            if (result.value) {
                var unit_category_id=[];
                var id;
                $(".unit_category_id").each(function(i,value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        unit_category_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('category_delete') }}",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {unit_category_id:unit_category_id}, // pass in json format
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
