
@if($unit_admin && $unit_admin->is_unit_admin == 1)
    <div class="text-center text-dark">
        <p style="font-size: 18px"><b>Unit:</b> {{$unit_admin->office_unit->unit_name_bng}}</p>
    </div>
@endif

<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th class="d-none">Sl.</th>
        <th>Id</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Designation (English)</th>
        @if(!$unit_admin->is_unit_admin)
            <th >Unit</th>
        @endif
        <th class="no-sort">Activity</th>
    </tr>
    </thead>
    <tbody>
    @foreach($organograms as $organogram)
        <tr>
            <td class="d-none">{{$loop->iteration}}</td>
            <td>{{($organogram->assigned_user && $organogram->assigned_user->employee_record && $organogram->assigned_user->employee_record->user) ? $organogram->assigned_user->employee_record->user->username : ''}}</td>
            <td>{{$organogram->assigned_user ? $organogram->assigned_user->employee_record->full_name_bng : ''}}</td>
            <td>{{$organogram->designation_bng}}</td>
            <td>{{$organogram->designation_eng}}</td>
            @if(!$unit_admin->is_unit_admin)
                <td>{{($organogram->office_unit) ? $organogram->office_unit->unit_name_bng : ''}}</td>
            @endif
            <td class="text-center">
                <button style="height: 30px;width: 30px"
                        data-designation_id="{{$organogram->id}}"
                        data-employee_office_id="{{$organogram->assigned_user ? $organogram->assigned_user->id : ''}}"
                        type="button" class="btn btn-icon btn-outline-brand view_modal"><i
                        class="fas fa-pencil-alt"></i>
                </button>
                <button style="height: 30px;width: 30px" data-id="{{$organogram->id}}"
                    type="button" class="btn btn-icon btn-outline-brand view-history"><i class="fas fa-eye"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

    <div class="modal fade bd-example-modal-lg" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">Designation change history</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="history_modal_body" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary edit_button">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    tapp_table_init();
    $(".table tbody").on('click','.view_modal',function () {
        var designation_id = $(this).data("designation_id");
        var employee_office_id = $(this).data("employee_office_id");
        var url = "{{url('get_office_employee_designation')}}";
        var data = {designation_id, employee_office_id};
        ajaxCallAsyncCallback(url, data, 'html', 'POST', function (data, textStatus, jqXHR) {
            $("#modal_body").html(data);
            $("#editModal").modal("show");
        });
    });

    $(".table tbody").on('click','.view-history',function () {
        // $("#historyModal").modal("show");
        var designation_id = $(this).data("id");

        $.ajax({
            method: "GET",
            url: "get_office_designation_history/" + designation_id,
            data: designation_id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                $("#history_modal_body").html(data);
                $("#historyModal").modal("show");
            }
        });
    });
</script>
