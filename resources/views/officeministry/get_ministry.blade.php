<table class="tapp_table table table-striped- table-bordered table-hover table-checkable  custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="8%">Sl.</th>
        <th width="10%">Type</th>
        <th width="10%">Ministry / Department Code</th>
        <th width="10%">Name (Others)</th>
        <th width="10%">Name (English)</th>
        <th width="10%">Short Name</th>
        <th width="10%">Current Status</th>
        <th width="10%" class="no-sort no-print">Edit</th>
        <th width="10%" class="no-sort no-print text-center">
            <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                <input id="all" type="checkbox">
                <span style="top: -7px"></span>
            </label>
            <button style="height: 18px;padding-left: 23px" type="button" id="delete_ministry"
                    class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                                                        class="fas fa-trash-alt text-danger delete_alert"></i>
            </button>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($office_ministries as $key=>$office_ministry)
        <tr class="text-center">
            <td>{{$key+1}}</td>
            <td>@if($office_ministry->active_status == 1)
                    Ministry
                @else
                    Department
                @endif
            </td>
            <td>{{$office_ministry->reference_code}}</td>
            <td>{{$office_ministry->name_bng}}</td>
            <td>{{$office_ministry->name_eng}}</td>
            <td>{{$office_ministry->name_eng_short}}</td>
            <td>@if($office_ministry->active_status == 1)
                    Active
                @else
                    Inactive
                @endif </td>
            <td class="no-print">
                <button style="height: 30px;width: 30px;" type="button"
                        data-content="{{$office_ministry->id}},{{$office_ministry->office_type}},{{$office_ministry->name_bng}},{{$office_ministry->name_eng}},{{$office_ministry->name_eng_short}},{{$office_ministry->active_status}},{{enTobn($office_ministry->reference_code)}}"
                        data-dismiss="modal"
                        id="ministry_id{{$office_ministry->id}}"
                        class="btn  btn-icon  btn-outline-brand btntableDataEdit"><i
                        class="fas fa-pencil-alt"></i></button>
            </td>
            <td class="no-print">
                <label style="margin-bottom: 12%" class="kt-checkbox kt-checkbox--success">
                    <input class="ministry_id" value="{{$office_ministry->id}}" type="checkbox">
                    <span></span>
                </label>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>


<script type="text/javascript">

    tapp_table_init();

    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#delete_ministry").click(function () {
        swal.fire({
            title: 'Do you want to delete the data?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function (result) {
            if (result.value) {

                var ministry_id = [];
                var id;

                $(".ministry_id").each(function (i, value) {
                    id = $(this).val();
                    if ($(this).is(':checked')) {
                        ministry_id.push(id);
                    }

                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_office_ministry') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {ministry_id: ministry_id}, // pass in json format
                    success: function (data) {
                        if (data.status === 'success') {
                            toastr.success(data.msg);
                        } else {
                            toastr.error(data.msg);
                        }
                        setTimeout(function () {
                            location.reload();
                        }, 300);
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
