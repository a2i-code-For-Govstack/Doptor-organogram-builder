<table id="office_origin" class="table table-striped- table-bordered table-hover table-checkable  custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th>Sl.</th>
        <th>Office Ministry</th>
        <th>Office Layer</th>
        <th>Higher Office</th>
        <th>Name (Others)</th>
        <th>Name (English)</th>
        <th>Layer</th>
        <th>Order</th>
        <th class="no-sort" width="10%">Edit</th>
        {{--            <th class="no-sort text-center" width="10%">--}}
        {{--                    <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">--}}
        {{--                        <input id="all" type="checkbox">--}}
        {{--                        <span style="top: -7px"></span>--}}
        {{--                    </label>--}}
        {{--                    <button style="height: 18px;padding-left: 23px" type="button" id="delete_office_origin"--}}
        {{--                    class="btn  btn-icon btn-square"><i style="margin-top: 9px;"--}}
        {{--                    class="fas fa-trash-alt text-danger"></i></button>--}}
        {{--            </th>--}}
    </tr>
    </thead>
    <tbody></tbody>
</table>


</div>


<script type="text/javascript">
    // tapp_table_init();
    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $(".table tbody").on('click', '.delete_office_origin', function () {

        id = $(this).attr('data-id');
        var office_origin_id = [];
        office_origin_id.push(id);

        swal.fire({
            title: 'Do you want to delete the data?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function (result) {
            if (result.value) {
                //for multiple delete

                // $(".office_origin_id").each(function(i,value) {
                //     id = $(this).val();
                //     if ($(this).is(':checked')) {
                //         office_origin_id.push(id);
                //     }
                // });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('delete_office_origin') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {office_origin_id: office_origin_id}, // pass in json format
                    success: function (data) {
                        if (data.status === 'success') {
                            toastr.success(data.msg);
                            location.reload();
                        } else if (data.status === 'error') {
                            toastr.error(data.msg);
                        }

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

    $('#office_origin').DataTable({
        "processing": true,
        language: {
            processing: "Please wait...",
            lengthMenu: '<select class="custom-select custom-select-sm form-control form-control-sm">' +
                    '<option value="10">10</option>' +
                    '<option value="20">20</option>' +
                    '<option value="30">30</option>' +
                    '<option value="40">40</option>' +
                    '<option value="50">50</option>' +
                    '<option value="-1">All</option>' +
                    '</select> Data',
                zeroRecords: "Sorry! No information found.",
                info: "Showing _START_ to _END_ of _TOTAL_.",
                infoEmpty: "No information found.",
                paginate: {
                    previous: "Previous",
                    next: "Next",
                },
                sSearch: "",
                searchPlaceholder:"Search"
        },
        "serverSide": true,
        // Initial no order.
        "order": [],
        "ajax": {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url("office_origin_server_side")}}",
            type: 'GET',
            'data': function (data) {
            }
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'ministry_name'
            },
            {
                data: 'layer_name'
            },
            {
                data: 'parent_office_name'
            },
            {
                data: 'office_name_bng'
            },
            {
                data: 'office_name_eng'
            },
            {
                data: 'office_level'
            },
            {
                data: 'office_sequence'
            },
            {
                data: 'edit_button',
            },
        ],
        "columnDefs": [
            {className: "text-center", "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8]}
        ],
        drawCallback: function(settings) {
            let info = $("#office_origin_info").text();
            $("#office_origin_info").text(enTobn(info));

            $("#office_origin_paginate .pagination .page-item").each(function() {
                let text = $(this).find('a').text();
                $(this).find('a').text(enTobn(text));
            });
        }

    });
</script>
