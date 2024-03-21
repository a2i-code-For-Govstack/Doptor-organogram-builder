<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
     <tr class="text-center">
            <th width="20%">Sl.</th>
            <th width="20%">Batch Number</th>
            <th width="20%">Joining Year</th>
            <th class="no-sort" width="20%">Edit</th>
            <th class="no-sort" width="20%">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span style="top:-7px"></span>
                </label>
                <button style="height: 18px;padding-left: 23px" type="button" id="delete_batch"
                class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                class="fas fa-trash-alt text-danger"></i></button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($employee_batches as $employee_batch)
            <tr class="text-center">
                <td>{{enTobn($loop->iteration)}}</td>
                <td>{{enTobn($employee_batch->batch_no)}}</td>
                <td>{{enTobn($employee_batch->batch_year)}}</td>
                <td>
                    <div class="btn-group">
                        <button style="height: 30px;width: 30px;"
                            data-content="{{$employee_batch->id}},{{enTobn($employee_batch->batch_no)}},{{enTobn($employee_batch->batch_year)}}"
                           id="batch_id{{$employee_batch->id}}" type="button" data-dismiss="modal"
                            class="btn  btn-icon  btn-outline-brand btntableDataEdit"><i
                                class="fas fa-pencil-alt"></i></button>
                    </div>
                </td>
                <td>
                    <label style="margin-bottom: 10%" class="kt-checkbox kt-checkbox--success">
                        <input class="emp_batch_id" value="{{$employee_batch->id}}" type="checkbox">
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

    $("#delete_batch").click(function(){

         swal.fire({
            title: 'Do you want to delete the data?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
         }).then(function(result) {
            if (result.value) {
                var emp_batch_id=[];
                var id;
                $(".emp_batch_id").each(function(i,value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        emp_batch_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_batch') }}",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {emp_batch_id:emp_batch_id}, // pass in json format
                    success: function(data) {
                        if (data.status === 'success') {
                            toastr.success(data.msg);
                            location.reload();
                        }else if(data.status === 'error'){
                            toastr.error(data.msg);
                        }

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

