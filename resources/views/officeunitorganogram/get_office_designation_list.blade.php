<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th class="" width="10%">ইউজারের নাম</th>
        <th class="" width="10%">পদবি নাম ( বাংলা )</th>
        <th class="" width="10%">পদবি নাম ( ইংরেজি )</th>
        <th class="" width="10%">শাখা</th>
        <th class="" width="10%">অফিস</th>
        <th class="no-sort" width="10%">কার্যক্রম</th>
    </tr>
    </thead>
    <tbody>
    @foreach($office_designations as $key => $desigantion)
        <tr class="text-center">
            <td id="employee_bng{{$desigantion->id}}">
                {{$desigantion->assigned_user && $desigantion->assigned_user->employee_record ? $desigantion->assigned_user->employee_record->name_bng : '' }}
            </td>
            <td id="designation_bng{{$desigantion->id}}">{{$desigantion->designation_bng}}</td>
            <td id="designation_eng{{$desigantion->id}}">{{$desigantion->designation_eng}}</td>
            <td> @if($desigantion->office_unit)
                    {{$desigantion->office_unit->unit_name_bng}}
                @endif</td>
            <td>{{$desigantion->office_info->office_name_bng}}</td>
            <td class="text-center">
                <button style="height: 30px;width: 30px" data-id="{{$desigantion->id}}"
                        class="btn btn-icon btn-outline-brand view_modal"><i class="fas fa-pencil-alt"></i></button>
                <button style="height: 30px;width: 30px" data-id="{{$desigantion->id}}"
                        class="btn btn-icon btn-outline-brand view-history"><i class="fas fa-eye"></i></button>
            </td>

        </tr>
    @endforeach
    </tbody>
</table>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTable">পদবি পরিবর্তন করুন</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="edit_form">
                <div id="modal_body" class="modal-body">

                </div>
                @method('POST')
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary edit_button">সংরক্ষণ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="historyModal" tabindex="-1" role="dialog"
     aria-labelledby="editModalTable" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTable">পদবি পরিবর্তন ইতিহাস</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="history_modal_body" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    tapp_table_init();

    $(".table tbody").on('click', '.view_modal', function () {
        id = $(this).data("id");
        url = "get_office_designation/" + id;

        ajaxCallUnsyncCallback(url, {}, 'html', 'get', function (response) {
            $("#modal_body").html(response);
            $("#editModal").modal("show");
        });
    });

    $(".edit_button").click(function () {
        blockUi();
        url = '{{url('office_designation_update')}}';
        id = $('[name=id]').val();

        data = {
            id,
            designation_bng: $('[name=designation_bng]').val(),
            designation_eng: $('[name=designation_eng]').val(),
        }

        ajaxCallUnsyncCallback(url, data, 'json', 'post', function (response) {
            if (response.status == 'success') {
                var name_bng = $('#designation_bng').val();
                var name_eng = $('#designation_eng').val();
                $('#designation_bng' + id).text(name_bng);
                $('#designation_eng' + id).text(name_eng);
                $("#editModal").modal("hide");
                toastr.success(response.msg);
            } else {
                toastr.error(response.msg);
            }
        });
        unblockUi()
    });

    $(".table tbody").on('click', '.view-history', function () {
        designation_id = $(this).data("id");
        url = "get_office_designation_history/" + designation_id;

        ajaxCallUnsyncCallback(url, {}, 'html', 'get', function (response) {
            $("#history_modal_body").html(response);
            $("#historyModal").modal("show");
        });
    });
</script>
