<?php

namespace App\Services;

use App\Models\EmployeeOffice;
use App\Models\EmployeeRecord;
use App\Models\ProtikolpoLog;
use App\Models\ProtikolpoManagement;
use App\Models\User;

class ProtikolpoServices
{
    public function protikolpoTransferByStart()
    {
        $nonActiveProtikolpos = ProtikolpoManagement::select('id', 'employee_name', 'office_id', 'unit_id', 'designation_id', 'employee_record_id', 'protikolpos', 'selected_protikolpo', 'start_date', 'end_date', 'is_show_acting')
            ->where('active_status', 0)
            ->where('selected_protikolpo', '>', 0)
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->get();
        if ($nonActiveProtikolpos->isNotEmpty()) {
            foreach ($nonActiveProtikolpos as $value) {

                $isExists = EmployeeOffice::where('office_id', $value->office_id)
                    ->where('office_unit_id', $value->unit_id)
                    ->where('office_unit_organogram_id', $value->designation_id)
                    ->where('status', 1)
                    ->first();

                if (!empty($isExists)) {
                    $employeeInfo = json_decode($value->protikolpos, true);
                    $selectedInfo = !empty($employeeInfo['protikolpo_' . $value->selected_protikolpo]) ? $employeeInfo['protikolpo_' . $value->selected_protikolpo] : [];

                    if (!empty($selectedInfo)) {
                        if ($value->is_show_acting == 1) {
                            $isExists->incharge_label = $value->acting_level ?? '';
                        }

                        $isExistsNew = EmployeeOffice::where('office_id', $selectedInfo['office_id'])
                            ->where('office_unit_id', $selectedInfo['office_unit_id'])
                            ->where('office_unit_organogram_id', $selectedInfo['designation_id'])
                            ->where('status', 1)
                            ->first();

                        if (!$isExistsNew) {
                            continue;
                        }

                        $unassign = EmployeeOffice::unAssignDesignation($isExists->id, ['modified_by' => 1, 'released_by' => 1], 'প্রতিকল্প প্রয়োগ করা হয়েছে');
                        if ($unassign) {
                            $employeeAssignedInfo = EmployeeRecord::select('id', 'prefix_name_eng', 'name_eng', 'surname_eng', 'prefix_name_bng', 'name_bng', 'surname_bng')->where('id', $selectedInfo['employee_record_id'])->first();

                            $user = User::where('employee_record_id', $selectedInfo['employee_record_id'])->where('user_role_id', 3)->select('username')->first();

                            $new_assignee = $isExists->toArray();
                            $new_assignee['employee_record_id'] = $employeeAssignedInfo->id;
                            $new_assignee['identification_number'] = $user->username;
                            $new_assignee['office_id'] = $value->office_id;
                            $new_assignee['office_unit_id'] = $value->unit_id;
                            $new_assignee['office_unit_organogram_id'] = $value->designation_id;
                            $new_assignee['incharge_label'] = $isExists->incharge_label;
                            $new_assignee['joining_date'] = date("Y-m-d H:i:s");
                            $new_assignee['protikolpo_status'] = 1;

                            $assign = EmployeeOffice::assignDesignation($new_assignee, ['created_by' => 1], 'প্রতিকল্প প্রয়োগ করা হয়েছে');
                            if ($assign) {
                                ProtikolpoManagement::where('id', $value['id'])->update(['active_status' => 1]);
                                $logData = [
                                    'protikolpo_id' => $value->id,
                                    'protikolpo_start_date' => $value->start_date,
                                    'employee_office_id_from_name' => $value->employee_name,
                                    'employee_office_id_to_name' => $employeeAssignedInfo->full_name_bng,
                                    'protikolpo_status' => 1,
                                ];
                                ProtikolpoLog::create($logData);
                            }
                        }
                    }
                }
            }
        }
    }

    public function protikolpoTransferByEnd()
    {
        $activeProtikolpos = ProtikolpoManagement::select(
            'id',
            'office_id',
            'unit_id',
            'designation_id',
            'employee_record_id',
            'protikolpos',
            'selected_protikolpo',
            'start_date',
            'end_date',
            'is_show_acting'
        )->where('active_status', 1)
            ->where('selected_protikolpo', '>', 0)
            ->whereDate('end_date', date("Y-m-d", strtotime("-1 day")))
            ->get();
        if ($activeProtikolpos->isNotEmpty()) {
            foreach ($activeProtikolpos as $value) {
                $isExists = EmployeeOffice::where('office_id', $value->office_id)
                    ->where('office_unit_id', $value->unit_id)
                    ->where('office_unit_organogram_id', $value->designation_id)
                    ->where('status', 1)
                    ->first();
                if (!empty($isExists)) {
                    $employeeInfo = json_decode($value->protikolpos, true);
                    $selectedInfo = !empty($employeeInfo['protikolpo_' . $value->selected_protikolpo]) ? $employeeInfo['protikolpo_' . $value->selected_protikolpo] : [];

                    if (!empty($selectedInfo) && $selectedInfo['employee_record_id'] == $isExists->employee_record_id) {
                        $unassign = EmployeeOffice::unAssignDesignation($isExists->id, ['modified_by' => 1, 'released_by' => 1], 'প্রতিকল্প ফেরত করা হয়েছে');
                        if ($unassign) {
                            $employeeAssignedInfo = EmployeeRecord::where('id', $value->employee_record_id)->first();

                            $previous = EmployeeOffice::where([
                                'office_id' => $value->office_id,
                                'office_unit_organogram_id' => $value->designation_id,
                                'status' => 0,
                                'employee_record_id' => $employeeAssignedInfo->id
                            ])->orderBy('id', 'DESC')->first();

                            $newAssign = $previous->toArray();

                            $newAssign['employee_record_id'] = $employeeAssignedInfo->id;
                            $newAssign['identification_number'] = $employeeAssignedInfo->identity_no;
                            $newAssign['office_id'] = $value->office_id;
                            $newAssign['office_unit_id'] = $value->unit_id;
                            $newAssign['office_unit_organogram_id'] = $value->designation_id;
                            $newAssign['incharge_label'] = !empty($previous) ? $previous->incharge_label : ($value->is_show_acting == 1 ? $isExists->incharge_label : '');
                            $newAssign['joining_date'] = date("Y-m-d H:i:s");
                            $newAssign['protikolpo_status'] = 0;

                            $assign = EmployeeOffice::assignDesignation($newAssign, ['created_by' => 1], 'প্রতিকল্প ফেরত আনা হয়েছে');

                            if ($assign) {
                                ProtikolpoManagement::where('id', $value->id)->update([
                                    'active_status' => 0,
                                    'end_date' => null,
                                    'start_date' => null,
                                ]);

                                $protikolpoLogEntity = ProtikolpoLog::where('protikolpo_id', $value->id)->orderBy('id', 'desc')->first();
                                if (!empty($protikolpoLogEntity)) {
                                    ProtikolpoLog::where('id', $protikolpoLogEntity->id)->update([
                                        'protikolpo_end_date' => date("Y-m-d H:i:s"),
                                        'protikolpo_status' => 0,
                                        'protikolpo_ended_by' => 1,
                                    ]);
                                }
                            }
                        } else {
                            ProtikolpoManagement::where('id', $value->id)->update([
                                'active_status' => 0,
                                'employee_record_id' => 0,
                                'employee_name' => '',
                                'start_date' => null,
                                'end_date' => null,
                                'selected_protikolpo' => 0,
                            ]);
                        }
                    } else {
                        ProtikolpoManagement::where('id', $value->id)->update([
                            'active_status' => 0,
                            'employee_record_id' => 0,
                            'employee_name' => '',
                            'start_date' => null,
                            'end_date' => null,
                            'selected_protikolpo' => 0,
                        ]);
                    }

                    if (!empty($employeeAssignedInfo->name_bng)) {
                        //done
                    }
                } else {
                    ProtikolpoManagement::where('id', $value->id)->update([
                        'active_status' => 0,
                        'employee_record_id' => 0,
                        'employee_name' => '',
                        'start_date' => null,
                        'end_date' => null,
                        'selected_protikolpo' => 0,
                    ]);
                }
            }
        }

        $this->protikolpoTransferByStart();
    }
}
