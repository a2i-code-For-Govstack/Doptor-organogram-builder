<table style="text-align: center"; class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
            <thead class="table-head-color">
               <tr>
                <th width="10%">Ministry/Department</th>
                <th width="10%">Immediate level</th>
                <th width="10%">Custom Layer</th>
                <th width="15%">Layer Name (Others)</th>
                <th width="15%">Layer Name (English)</th>
                <th width="8%">Layer</th>
                <th width="8%">Order</th>
                <th class="no-sort" width="8%">Status</th>
                <!-- <th width="5%">সম্পাদনা</th> -->
                <th class="no-sort"  width="10%">
                    <span>
                        <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                            <input id="all" type="checkbox">
                            <span style="top: -7px"></span>
                        </label>
                        <button style="height: 18px;padding-left: 23px" type="button" id="delete_office_layer"
                        class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                        class="fas fa-trash-alt text-danger"></i></button>
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($office_layers as $layer)
            <tr>
                <td>{{($layer->office_ministry) ? $layer->office_ministry->name_bng : ''}}</td>
                <td>Immediate level</td>
                <td>{{$layer->custom_layer ? $layer->custom_layer->name : ''}}</td>
                <td>{{$layer->layer_name_bng}}</td>
                <td>{{$layer->layer_name_eng}}</td>
                <td class="text-center">{{enTobn($layer->layer_level)}}</td>
                <td class="text-center">{{enTobn($layer->layer_sequence)}}</td>
                <td>@if($layer->active_status == 1) Active @else Inactive @endif </td>
                <!-- <td>
                    <button type="button"
                    data-content=""
                    data-dismiss="modal"
                    class="btn btn-warning btn-icon btn-square btntableDataEdit"><i
                    class="fas fa-pencil-alt"></i></button>
                </td> -->
                <td class="text-center">
                    <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                        <input class="office_layer_id" value="{{$layer->id}}" type="checkbox">
                        <span></span>
                    </label>
                </td>
            </tr>
            @endforeach()
        </tbody>
    </table>

<script type="text/javascript">
    tapp_table_init();

    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });


    $("#delete_office_layer").click(function(){
        swal.fire({
            title: 'Do you want to delete the data?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function(result) {
            if (result.value) {
                var office_layer_id=[];
        var id;
        $(".office_layer_id").each(function(i,value) {
            id = $(this).val();
            // id = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                office_layer_id.push(id);
            }

        });

        $.ajax({
            method: 'POST',
            url: "{{ url('delete_office_layer') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {office_layer_id:office_layer_id}, // pass in json format
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                }else{
                    toastr.error(data.msg);
                }

                    setTimeout(function(){
                       window.location.reload(1);
                    }, 20000);
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
