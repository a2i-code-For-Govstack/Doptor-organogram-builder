<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="20%">Name (Others)</th>
        <th width="20%">Name (English)</th>
        <th width="20%">Layer Level</th>
        <th class="no-sort" width="20%">Activity</th>
        <th class="no-sort" width="20%">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span style="top: -7px"></span>
                </label>
                <button style="height: 18px;padding-left: 23px" type="button" id="delete_custom_layer"
                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                                                            class="fas fa-trash-alt text-danger"></i></button>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($layers as $layer)
        <tr class="text-center">
            <td>{{$layer->name}}</td>
            <td>{{$layer->name_eng}}</td>
            <td>{{enTobn($layer->layer_level)}}</td>
            <td>
                <button type="button" style="height: 30px;width: 30px;"
                        data-content="{{$layer->id}},{{$layer->name}},{{$layer->name_eng}},{{enTobn($layer->layer_level)}}"
                        data-dismiss="modal"
                        id="layer_id{{$layer->id}}"
                        class="btn btn-icon btn-outline-brand btntableDataEdit"><i
                        class="fas fa-pencil-alt"></i></button>
            </td>
            <td>
                <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                    <input class="custom_layer_id" type="checkbox" data-id="" value="{{$layer->id}}" name="">
                    <span></span>
                </label>
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


    $("#delete_custom_layer").click(function(){
        swal.fire({
            title: 'Do you want to delete the data?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function(result) {
            if (result.value) {

                var custom_layer_id = [];
        var id;
        $(".custom_layer_id").each(function (i, value) {
            id = $(this).val();
            // id = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                custom_layer_id.push(id);
            }

        });

        $.ajax({
            method: 'POST',
            url: "{{ url('delete_custom_layer') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {custom_layer_id: custom_layer_id}, // pass in json format
            success: function (data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                }else{
                    toastr.error(data.msg);
                }

                setTimeout(function(){
                       window.location.reload(1);
                    }, 1000);
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
