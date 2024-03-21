<table id="user_list" class="table table-striped- table-bordered table-hover table-checkable  custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th>Sl.</th>
        <th>Username</th>
        <th>Name (Others)</th>
        <th>Name (English)</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Role</th>
        <th>Signature</th>
        <th class="text-center">Activity</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>
<script type="text/javascript">
    $('#user_list').DataTable({
        processing: true,
        language: {
            processing: "Please Wait...",
            lengthMenu: '<select class="custom-select custom-select-sm form-control form-control-sm">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">All</option>' +
                '</select> Data',
            zeroRecords: "Sorry! No Information Found!",
            info: "Showing _START_ to _END_ of _TOTAL_.",
            infoEmpty: "No Information Found!",
            paginate: {
                previous: "Previous",
                next: "Next",
            },
            sSearch: "",
            searchPlaceholder: "Search"
        },
        serverSide: true,
        // Initial no order.
        order: [],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url("user/user_list_server_side")}}",
            type: 'GET',
            data: function (data) {
            }
        },
        columns: [
            {data: 'id'},
            {data: 'username'},
            {data: 'name_en'},
            {data: 'name_bn'},
            {data: 'personal_email'},
            {data: 'personal_mobile'},
            {data: 'role'},
            {data: 'user_signature'},
            {data: 'action'},
        ],
        columnDefs: [
            {className: "text-center", "targets": [0, 1, 2, 3, 4]}
        ],
        drawCallback: function (settings) {
            let info = $("#user_list_info").text();
            // $("#user_list_info").text(enTobn(info));
            $("#user_list_info").text(info);

            $("#user_list_paginate .pagination .page-item").each(function () {
                let text = $(this).find('a').text();
                // $(this).find('a').text(enTobn(text));
                $(this).find('a').text(text);
            });
        }

    });

    $(".table tbody").on('change', '.change_active_status', function () {

        id = $(this).attr('data-id');

        swal.fire({
            title: 'Do you want to change the status?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('user.delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {id: id}, // pass in json format
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
</script>
