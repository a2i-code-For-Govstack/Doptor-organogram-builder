<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
     <tr class="text-center">
            <th>নাম (বাংলা)</th>
            <th>নাম (ইংরেজি)</th>
            <th>মোবাইল</th>
            <th>পদবি</th>
            <th>শাখা</th>
            <th>অফিস</th>
            <th class="no-sort">অনুমোদন অবস্থা </th>
            <th class="no-sort" width="10%">
                <div class="btn-group">
                    <label style="padding-left: 0px" class="kt-checkbox kt-checkbox--success">
                        <input id="all" type="checkbox">
                        <span></span>
                    </label>
                    <button style="height: 18px;padding-left: 23px" type="button" id="delete_employee"
                    class="btn  btn-icon btn-square"><i style="margin-top: 9px;"
                    class="fas fa-trash-alt text-danger"></i></button>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($employee_records as $employee_record)
            @if($employee_record->employee_office)
                @foreach($employee_record->employee_office as $employee_office)
                    <tr class="text-center">
                        <td>{{$employee_record->name_bng}}</td>
                        <td>{{$employee_record->name_eng}}</td>
                        <td>{{$employee_record->personal_mobile}}</td>
                        <td>{{($employee_office) ? $employee_office->designation : ''}}</td>
                        <td>{{($employee_office) ? $employee_office->unit_name_bn : ''}}</td>
                        <td>{{($employee_office) ? $employee_office->office_name_bn : ''}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" data-dismiss="modal" class="btn btn-warning btn-icon btn-square"><i class="fa fa-check"></i></button>

                                <button type="button" class="btn btn-info btn-icon btn-danger"><i class="fas fa-ban"></i></button>
                            </div>
                        </td>
                        <td>
                            <label class="kt-checkbox kt-checkbox--success">
                                <input type="checkbox">
                                <span></span>
                            </label>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td>{{$employee_record->name_bng}}</td>
                    <td>{{$employee_record->name_eng}}</td>
                    <td>{{$employee_record->identity_no}}</td>
                    <td>{{$employee_record->personal_email}}</td>
                    <td>{{$employee_record->personal_mobile}}</td>
                    <td><?php echo ($employee_record->is_cadre == 1)?'হ্যা':'না'?></td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{@$employee_record->user->username}}</td>
                    <td>
                        <div class="btn-group">
                            <button
                                    data-content='<?php echo json_encode(['id'=>$employee_record->id,
                                        'name_bng'=>$employee_record->name_bng,
                                        'name_eng'=>$employee_record->name_eng,
                                        'identification_number'=>@$employee_record->identification_number,
                                        'personal_email'=>$employee_record->personal_email,
                                        'personal_mobile'=>$employee_record->personal_mobile,
                                        'is_cadre'=>$employee_record->is_cadre,
                                        'office_id'=>$employee_record->office_id,
                                        'office_unit_organogram_id'=>$employee_record->office_unit_organogram_id,
                                        'office_unit_id'=>$employee_record->office_unit_id,
                                        'designation'=>'',
                                        'designation_level'=>$employee_record->designation_level,
                                        'designation_sequence'=>$employee_record->designation_sequence,
                                        'office_head'=>$employee_record->office_head,
                                        'is_admin'=>$employee_record->is_admin,
                                        'summary_nothi_post_type'=>$employee_record->summary_nothi_post_type,
                                        'unit_name_bn'=>$employee_record->unit_name_bn,
                                        'office_name_bn'=>$employee_record->office_name_bn,
                                        'username'=>@$employee_record->user->username,
                                        'father_name_bng'=>$employee_record->father_name_bng,
                                        'father_name_eng'=>$employee_record->father_name_eng,
                                        'mother_name_bng'=>$employee_record->mother_name_bng,
                                        'mother_name_eng'=>$employee_record->mother_name_eng,
                                        'date_of_birth'=>date('Y-m-d', strtotime($employee_record->date_of_birth)),
                                        'nid'=>$employee_record->nid,
                                        'bcn'=>$employee_record->bcn,
                                        'ppn'=>$employee_record->ppn,
                                        'gender'=>$employee_record->gender,
                                        'religion'=>$employee_record->religion,
                                        'blood_group'=>$employee_record->blood_group,
                                        'marital_status'=>$employee_record->marital_status,
                                        'alternative_mobile'=>$employee_record->alternative_mobile]);?>'
                                    type="button" data-dismiss="modal"
                                    class="btn btn-warning btn-icon btn-square btntableDataEdit"><i
                                        class="fas fa-pencil-alt"></i></button>
                            <button type="button" class="btn btn-info btn-icon btn-square btntableDataEdit"><i class="fas fa-key"></i></button>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

<script type="text/javascript">
    tapp_table_init();
    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
</script>
