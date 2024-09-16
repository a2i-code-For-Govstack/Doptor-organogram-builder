<style>
    /* Ensure the table is scrollable on small screens */
.table-responsive {
    overflow-x: auto;
}

/* Hide unnecessary elements on small screens */
@media (max-width: 576px) {
    .no-print {
        display: none;
    }
}

/* Adjust table cell display on small screens */
@media (max-width: 768px) {
    .table thead {
        display: none;
    }

    .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
    }

    .table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    .table td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 10px;
        font-weight: bold;
        white-space: nowrap;
    }
}
/* Ensure the portlet body is responsive */
.kt-portlet__body {
    padding: 15px;
}

/* Adjust padding on smaller screens */
@media (max-width: 576px) {
    .kt-portlet__body {
        padding: 10px;
    }
}

/* Manage overflow and layout adjustments */
@media (max-width: 768px) {
    .ml-3, .dataTables_length{
        display: none;   
        padding: 2px;
    }
    .text-white{
        margin: 40px;
    }
    .kt-portlet__body {
        overflow-x: auto; /* Allow horizontal scrolling if needed */
    }
    
    .kt-portlet__body table {
        width: 100%; /* Make tables inside the portlet body take full width */
        display: block; /* Ensure tables scroll horizontally */
        overflow-x: auto;
    }

    .kt-portlet__body .form-group {
        margin-bottom: 15px; /* Space out form groups */
    }

    .kt-portlet__body .form-group label {
        display: block; /* Make labels block elements for better stacking */
        margin-bottom: 5px;
    }

    .kt-portlet__body .form-group input,
    .kt-portlet__body .form-group select,
    .kt-portlet__body .form-group textarea {
        width: 100%; /* Make form controls take full width */
    }
}

/* Manage layout and spacing on medium to large screens */
@media (min-width: 769px) {
    .kt-portlet__body {
        padding: 20px;
    }

    .kt-portlet__body table {
        width: 100%; /* Ensure table takes full width */
    }

    .kt-portlet__body .form-group {
        margin-bottom: 20px; /* Space out form groups */
    }
}

</style>

<div class="table-responsive">
    <table class="tapp_table table table-striped table-bordered table-hover table-checkable custom-table-border">
        <thead class="table-head-color">
        <tr class="text-center">
            <th width="8%" class="d-none d-sm-table-cell">Sl.</th>
            <th width="10%">Type</th>
            <th width="10%" class="d-none d-md-table-cell">Ministry / Department Code</th>
            <th width="10%">Name (Others)</th>
            <th width="10%">Name (English)</th>
            <th width="10%" class="d-none d-lg-table-cell">Short Name</th>
            <th width="10%">Current Status</th>
            <th width="10%" class="no-sort no-print">Edit</th>
            <th width="10%" class="no-sort no-print text-center">
                <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                    <input id="all" type="checkbox">
                    <span style="top: -7px"></span>
                </label>
                <button style="height: 18px; padding-left: 23px;" type="button" id="delete_ministry"
                        class="btn btn-icon btn-square btn-sm">
                    <i style="margin-top: 9px;" class="fas fa-trash-alt text-danger delete_alert"></i>
                </button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($office_ministries as $key=>$office_ministry)
            <tr class="text-center">
                <td class="d-none d-sm-table-cell">{{$key+1}}</td>
                <td>@if($office_ministry->active_status == 1)
                        Ministry
                    @else
                        Department
                    @endif
                </td>
                <td class="d-none d-md-table-cell">{{$office_ministry->reference_code}}</td>
                <td>{{$office_ministry->name_bng}}</td>
                <td>{{$office_ministry->name_eng}}</td>
                <td class="d-none d-lg-table-cell">{{$office_ministry->name_eng_short}}</td>
                <td>@if($office_ministry->active_status == 1)
                        Active
                    @else
                        Inactive
                    @endif
                </td>
                <td class="no-print">
                    <button style="height: 30px; width: 30px;" type="button"
                            data-content="{{$office_ministry->id}},{{$office_ministry->office_type}},{{$office_ministry->name_bng}},{{$office_ministry->name_eng}},{{$office_ministry->name_eng_short}},{{$office_ministry->active_status}},{{enTobn($office_ministry->reference_code)}}"
                            data-dismiss="modal"
                            id="ministry_id{{$office_ministry->id}}"
                            class="btn btn-icon btn-outline-brand btntableDataEdit btn-sm">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
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
