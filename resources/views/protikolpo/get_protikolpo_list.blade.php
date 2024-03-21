<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="30%">পদবি</th>
        <th width="30%">প্রথম প্রতিকল্প</th>
        <th width="30%">দ্বিতীয় প্রতিকল্প</th>
        <th class="no-sort" width="10%">কার্যক্রম</th>
    </tr>
    </thead>
    <tbody>
    @foreach($office_employees as $office_employee)
        <tr>
            <td>{{@$office_employee->employee_record->name_bng}},{{$office_employee->unit_name_bn}}
                ,{{$office_employee->designation}}
                {{Auth::user()->user_role_id == config('menu_role_map.user') ? '' : ',' . $office_employee->office_name_bn}}
                @if(!$office_employee->employee_record)
                    <span class="d-none">{{$office_employee->employee_record_id}}</span>
                @endif

            </td>
            <td>
                <div style="width: 80%" class="float-left">
                    @foreach($protikolpo as $protikolpo_item)
                        @if($protikolpo_item['designation_id'] == $office_employee->office_unit_organogram_id)
                            <input type="hidden" id="protikolpo_id{{$protikolpo_item['designation_id']}}"
                                   value="{{$protikolpo_item['protikolpo_id']}}">
                        @endif
                    @endforeach
                    <select class="form-control" name="protikolpo_1"
                            id="protikolpo1_{{$office_employee->office_unit_organogram_id}}">
                        @foreach($protikolpo as $protikolpo_item)
                            @if($protikolpo_item['designation_id'] == $office_employee->office_unit_organogram_id)

                                <option selected="" value="{{$protikolpo_item['protikolpo1_designation']}}">
                                    @if(isset($selected_protikolpo[$protikolpo_item['protikolpo1_designation']]))
                                        {{$selected_protikolpo[$protikolpo_item['protikolpo1_designation']]}}
                                    @endif
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div style="width: 20%" class="float-left">
                    <button
                        data-content="{{$office_employee->office_id}},{{$office_employee->office_unit_id}},{{$office_employee->office_unit_organogram_id}},{{$office_employee->employee_record_id}},{{@$office_employee->employee_record->name_bng}},1"
                        type="button" class="btn  btn-icon  btn-outline-brand view_modal_protikolpo float-left">
                        <i class="fas fa-pencil-alt"></i></button>
                </div>
            </td>
            <td>
                <div style="width: 80%" class="float-left">
                    <select class="form-control" name="protikolpo_2"
                            id="protikolpo2_{{$office_employee->office_unit_organogram_id}}">
                        @foreach($protikolpo as $protikolpo_item)
                            @if(isset($protikolpo_item['protikolpo2_designation']))
                                @if($protikolpo_item['designation_id'] == $office_employee->office_unit_organogram_id)

                                    <option selected="" value="{{$protikolpo_item['protikolpo2_designation']}}">
                                        @if(isset($selected_protikolpo[$protikolpo_item['protikolpo2_designation']]))
                                            {{$selected_protikolpo[$protikolpo_item['protikolpo2_designation']]}}
                                        @endif
                                    </option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
                <div style="width: 20%" class="float-left">
                    <button
                        data-content="{{$office_employee->office_id}},{{$office_employee->office_unit_id}},{{$office_employee->office_unit_organogram_id}},{{$office_employee->employee_record_id}},{{@$office_employee->employee_record->name_bng}},2"
                        type="button" class="btn  btn-icon  btn-outline-brand view_modal_protikolpo float-left">
                        <i class="fas fa-pencil-alt"></i></button>
                </div>
            </td>
            <td class="text-center">
                <button
                    data-content="{{$office_employee->office_unit_organogram_id}},{{$office_employee->employee_record_id}},{{@$office_employee->employee_record->name_bng}}"
                    type="button" class="btn  btn-icon  btn-outline-brand view_modal_protikolpo_assign" title="সংরক্ষণ করুন">
                    <i class="fas fa-save"></i>
                </button>
                <button type="button"
                        data-id="{{$office_employee->protikolpo?$office_employee->protikolpo->id:null}}"
                        title="প্রতিকল্প ইতিহাস"
                        class="btn  btn-icon  btn-outline-info protikolpo_log">
                    <i class="fas fa-history"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="modal fade bd-example-modal-xl" id="protikolpoHistoryModal" tabindex="-1" role="dialog"
     aria-labelledby="protikolpoHistoryTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="protikolpoHistoryTitle">প্রতিকল্প ইতিহাস</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="protikolpoHistoryModalBody" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        tapp_table_init();
    })
    $(".view_modal_protikolpo").click(function () {
        // var id = $(this).data("id");
        content = $(this).attr('data-content');
        content_value = content.split(',')
        office_id = content_value[0];
        office_unit_id = content_value[1];
        office_unit_organogram_id = content_value[2];
        employee_record_id = content_value[3];
        employee_name = content_value[4];
        protikolpo_no = content_value[5];

        $('#pro_office_id').val(office_id);
        $('#pro_office_unit_id').val(office_unit_id);
        $('#pro_office_unit_organogram_id').val(office_unit_organogram_id);
        $('#pro_employee_record_id').val(employee_record_id);
        $('#pro_employee_name').val(employee_name);
        $('#protikolpo_no').val(protikolpo_no);

        $("#protikolpo_modal").modal("show");

        if ($("select#office_id").length > 0) {
            $("select#office_id").trigger('change');
        }
    });

    $(".view_modal_protikolpo_assign").click(function () {
        // id = $(this).data("id");
        content = $(this).attr('data-content');
        content_value = content.split(',');

        office_unit_organogram_id = content_value[0];
        employee_record_id = content_value[1];
        employee_name = content_value[2];

        url = '{{url('employee_protikolpo_list')}}';
        data = {employee_record_id}
        datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'POST', function (response) {
            $('#employee_protikolpo_list').html(response);
        })

        $('#office_unit_organogram_id').val(office_unit_organogram_id);
        $('#employee_record_id').val(employee_record_id);
        $('#employee_name').val(employee_name);

        $("#protikolpo_assing_modal").modal("show");
    });
    $(".protikolpo_log").click(function () {
        var protikolpo_id = $(this).data('id');
        var data = {protikolpo_id: protikolpo_id};
        var datatype = 'html';
        var url = '{{url('get_protikolpo_log')}}'

        ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
            $('#protikolpoHistoryModalBody').html(responseData);
            $('#protikolpoHistoryModal').modal('show');
        });
    });
</script>
