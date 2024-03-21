<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border text-center">
    <thead class="table-head-color">
     <tr>
            <th width="10%">Sl.</th>
            <th width="30%">Cadre Name (Others)</th>
            <th width="30%">Cadre Name (English)</th>
            <th class="no-sort text-center" width="15%">Edit</th>
            <th class="no-sort text-center" width="15%">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span style="top:-7px"></span>
                </label>
                <button style="height: 18px;padding-left: 23px" type="button" id="delete_cadre"
                class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                class="fas fa-trash-alt text-danger"></i></button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($employee_cadres as $employee_cadre)
            <tr>
                <td class="text-center">{{enTobn($loop->iteration)}}</td>
                <td>{{$employee_cadre->cadre_name_bng}}</td>
                <td>{{$employee_cadre->cadre_name_eng}}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <button style="height: 30px;width: 30px;"
                            data-content="{{$employee_cadre->id}},{{$employee_cadre->cadre_name_bng}},{{$employee_cadre->cadre_name_eng}}"
                          id="cadre_id{{$employee_cadre->id}}" type="button" data-dismiss="modal"
                            class="btn  btn-icon  btn-outline-brand btntableDataEdit"><i
                                class="fas fa-pencil-alt"></i></button>
                    </div>
                </td>
                <td class="text-center">
                    <label style="margin-bottom: 12%" class="kt-checkbox kt-checkbox--success">
                        <input class="emp_cadre_id" value="{{$employee_cadre->id}}" type="checkbox">
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

    $("#delete_cadre").click(function(){
         swal.fire({
            title: 'Do you want to delete the data?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
         }).then(function(result) {
            if (result.value) {

                var emp_cadre_id=[];
                var id;
                $(".emp_cadre_id").each(function(i,value) {
                    id = $(this).val();
                    // id = $(this).attr('data-id');
                    if ($(this).is(':checked')) {
                        emp_cadre_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_cadre') }}",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {emp_cadre_id:emp_cadre_id}, // pass in json format
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
