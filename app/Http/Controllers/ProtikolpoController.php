<?php

namespace App\Http\Controllers;

use App\Models\EmployeeOffice;
use App\Models\EmployeeRecord;
use App\Models\Message;
use App\Models\Office;
use App\Models\OfficeFrontDesk;
use App\Models\OfficeInchargeType;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use App\Models\ProtikolpoLog;
use App\Models\ProtikolpoManagement;
use App\Traits\SendNotification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProtikolpoController extends Controller
{
    use SendNotification;

    public function index()
    {
        $office_unit_id = Auth::user()->current_office_unit_id();
        $office_id = Auth::user()->current_office_id();
        $designation_id = Auth::user()->current_designation_id();

        $unit_admin = OfficeUnitOrganogram::select('is_unit_admin', 'is_admin')->where('id', $designation_id)->first();
        $office = Office::where('id', $office_id)->first();
        $is_unit_admin = $unit_admin->is_unit_admin;
        $is_office_admin = $unit_admin->is_admin;
        $office_unit = OfficeUnit::where('id', $office_unit_id)->where('office_id', $office_id)->get();
        $office_incharges = OfficeInchargeType::all();
        return view('protikolpo.protikolpo_management', compact('office', 'office_incharges', 'is_unit_admin', 'is_office_admin', 'office_unit', 'office_unit_id'));
    }

    public function protikolpoStatus()
    {

        if (Auth::user()->current_office_id()) {
            $protikolpo_list = ProtikolpoManagement::where('office_id', Auth::user()->current_office_id())->get();
        } else {
            $protikolpo_list = ProtikolpoManagement::all();
        }

        $office_unit_organogram_id = array();

        $designation_id = [];
        foreach ($protikolpo_list as $key => $value) {

            $designation_id[] = $value['designation_id'];
            $protikolpo_itm = json_decode($value['protikolpos'], true);
            if ($value['selected_protikolpo'] > 0) {
                $protikolpo_no = 'protikolpo_' . $value['selected_protikolpo'];
                $office_unit_organogram_id[] = $protikolpo_itm[$protikolpo_no]['designation_id'];
            }
        }

        $selected_protikolpo_username = EmployeeOffice::whereIn('office_unit_organogram_id', $office_unit_organogram_id)->where('status', 1)->get();

        $selected_protikolpo_key_value = array();
        foreach ($selected_protikolpo_username as $key => $userinfo) {
            $selected_protikolpo_key_value[$userinfo->office_unit_organogram_id] = $userinfo->employee_record->user->username . ', ' . $userinfo->employee_record->name_bng . ', ' . $userinfo->designation . ', ' . $userinfo->unit_name_bn;
        }

        $employee_office_info = EmployeeOffice::whereIn("office_unit_organogram_id", $designation_id)->where('status', 1)->get();

        $protikolpo_obosta = array();
        foreach ($protikolpo_list as $key => $value) {
            foreach ($employee_office_info as $key => $employee_office) {
                if ($value->designation_id == $employee_office->office_unit_organogram_id) {

                    $protikolpo_itm = json_decode($value['protikolpos'], true);


                    $protikolpo_no = 'protikolpo_' . $value['selected_protikolpo'];
                    if ($value['selected_protikolpo'] > 0 && isset($selected_protikolpo_key_value[$protikolpo_itm[$protikolpo_no]['designation_id']]) && $value['selected_protikolpo'] > 0) {
                        $emp_info = $selected_protikolpo_key_value[$protikolpo_itm[$protikolpo_no]['designation_id']];
                        $emp_value = explode(', ', $emp_info);

                        $identification_number = $emp_value[0];
                        $name = $emp_value[1];
                        $protikolpo_name = $emp_value[2];
                        $protikolpo_office_unit = $emp_value[3];
                    } else {
                        $identification_number = '';
                        $name = '';
                        $protikolpo_name = '';
                        $protikolpo_office_unit = '';
                    }

                    $protikolpo_info['office_id'] = $employee_office->office_id;
                    $protikolpo_info['office_unit_id'] = $employee_office->office_unit_id;
                    $protikolpo_info['office_unit_organogram_id'] = $employee_office->office_unit_organogram_id;
                    $protikolpo_info['unit_name_bn'] = $employee_office->unit_name_bn;
                    $protikolpo_info['office_name_bn'] = $employee_office->office_name_bn;
                    $protikolpo_info['designation'] = $employee_office->designation;

                    $protikolpo_info['protikolpo_id'] = $value['id'];
                    $protikolpo_info['protikolpo_start_date'] = $value['start_date'];
                    $protikolpo_info['protikolpo_end_date'] = $value['end_date'];
                    $protikolpo_info['employee_office_id_from_name'] = $employee_office->employee_record->name_bng;
                    $protikolpo_info['officer_id_from'] = $employee_office->employee_record->id;
                    $protikolpo_info['employee_office_id_to_name'] = $name;
                    $protikolpo_info['protikolpo_name'] = $protikolpo_name;
                    $protikolpo_info['protikolpo_office_unit'] = $protikolpo_office_unit;
                    $protikolpo_info['active_status'] = $value['active_status'];
                    $protikolpo_obosta[] = $protikolpo_info;
                }
            }
        }
        return view('protikolpo.protikolpo_status', compact('protikolpo_obosta'));
    }

    public function getProtikolpoStatus()
    {
        //
    }

    public function getProtikolpoList()
    {

        $office_id = Auth::user()->current_office_id();
        $office_unit_id = Auth::user()->current_office_unit_id();
        $designation_id = Auth::user()->current_designation_id();

        $unit_admin = OfficeUnitOrganogram::find($designation_id);

        if ($unit_admin->is_admin) {
            $office_employees = EmployeeOffice::where('office_id', $office_id)->where('status', 1)->with('protikolpo')->get();
        } else {
            $office_employees = EmployeeOffice::where('office_unit_id', $office_unit_id)->where('status', 1)->with('protikolpo')->get();
        }

        $designation_list = array();

        foreach ($office_employees as $key => $value) {
            $designation_list[] = $value->office_unit_organogram_id;
        }

        $protikolpo_list = ProtikolpoManagement::whereIn('designation_id', $designation_list)->get();

        $protikolpo = array();
        $protikolpo1_designations = [];
        $protikolpo2_designations = [];

        foreach ($protikolpo_list as $key => $row) {
            $protikolpo_temp['protikolpo_id'] = $row['id'];
            $protikolpo_temp['designation_id'] = $row['designation_id'];
            $protikolpo_itm = json_decode($row['protikolpos'], true);

            $protikolpo_temp['protikolpo1_designation'] = isset($protikolpo_itm['protikolpo_1']) ? $protikolpo_itm['protikolpo_1']['designation_id'] : null;

            if (isset($protikolpo_itm['protikolpo_2'])) {
                $protikolpo_temp['protikolpo2_designation'] = isset($protikolpo_itm['protikolpo_2']) ? $protikolpo_itm['protikolpo_2']['designation_id'] : null;
            } else {
                $protikolpo_temp['protikolpo2_designation'] = '';
            }

            $protikolpo[] = $protikolpo_temp;
            $protikolpo1_designations[] = isset($protikolpo_itm['protikolpo_1']) ? $protikolpo_itm['protikolpo_1']['designation_id'] : null;

            if (isset($protikolpo_itm['protikolpo_2'])) {
                $protikolpo2_designations[] = $protikolpo_itm['protikolpo_2']['designation_id'];
            }
        }

        // dd($protikolpo);

        $protikolpos_designations = array_merge($protikolpo1_designations, $protikolpo2_designations);

        $protikolpo_names = EmployeeOffice::whereIn('office_unit_organogram_id', $protikolpos_designations)->where('status', 1)->get();

        $selected_protikolpo = array();
        foreach ($protikolpo_names as $key => $name) {
            $selected_protikolpo[$name->office_unit_organogram_id] = $name->employee_record->name_bng . ',' . $name->designation . ',' . $name->unit_name_bn;
        }

        return view('protikolpo.get_protikolpo_list', compact('office_employees', 'protikolpo', 'selected_protikolpo'));
    }

    public function getOfficerName(Request $request)
    {
        $designation_id = $request->designation_id;

        $employee_records = EmployeeRecord::select('id', 'name_bng')->whereHas('employee_office', function ($query) use ($designation_id) {
            $query->where('office_unit_organogram_id', $designation_id);
        })->first();
        return response()->json($employee_records);
    }

    public function store(Request $request)
    {

        if ($request->pro_office_unit_organogram_id == $request->designation_id) {
            return response()->json(['status' => 'error', 'msg' => 'The plan cannot be given to the same person.']);
        }

        $protikolpo_no = $request->protikolpo_no;

        $exist_protikolpo = ProtikolpoManagement::getProtikolpo($request->pro_office_unit_organogram_id);

        $exist = json_decode($exist_protikolpo, true);

        if (is_null($exist_protikolpo)) {

            if ($protikolpo_no == 2) {
                return response()->json(['status' => 'fail', 'msg' => 'Set the first strategy first']);
            }

            $protikolpos = array(
                'protikolpo_1' => array(
                    'office_id' => $request->office_id,
                    'employee_record_id' => $request->officer_id,
                    'office_unit_id' => $request->office_unit_id,
                    'designation_id' => $request->designation_id,
                    'other_officer_info' => "",
                )
            );

            if (isset($exist['protikolpo_2'])) {
                $protikolpos['protikolpo_2']['office_id'] = $exist['protikolpo_2']['office_id'];
                $protikolpos['protikolpo_2']['employee_record_id'] = $exist['protikolpo_2']['employee_record_id'];
                $protikolpos['protikolpo_2']['office_unit_id'] = $exist['protikolpo_2']['office_unit_id'];
                $protikolpos['protikolpo_2']['designation_id'] = $exist['protikolpo_2']['designation_id'];
                $protikolpos['protikolpo_2']['other_officer_info'] = "";
            }

            $protikolpo = ProtikolpoManagement::where("designation_id", $request->pro_office_unit_organogram_id)->exists() ? ProtikolpoManagement::where("designation_id", $request->pro_office_unit_organogram_id)->first() : new ProtikolpoManagement;
            $protikolpo->office_id = $request->pro_office_id;
            $protikolpo->unit_id = $request->pro_office_unit_id;
            $protikolpo->designation_id = $request->pro_office_unit_organogram_id;
            $protikolpo->employee_record_id = 0;
            $protikolpo->employee_name = null;
            $protikolpo->protikolpos = json_encode($protikolpos);
            $protikolpo->selected_protikolpo = 0;
            $protikolpo->created_by = Auth::user()->id;
            $protikolpo->modified_by = Auth::user()->id;
            $protikolpo->save();
            return response(['status' => 'success', 'msg' => 'The plan is set.']);
        } else {
            if ($protikolpo_no == 1) {
                $protikolpos['protikolpo_1']['office_id'] = $request->office_id;
                $protikolpos['protikolpo_1']['employee_record_id'] = $request->officer_id;
                $protikolpos['protikolpo_1']['office_unit_id'] = $request->office_unit_id;
                $protikolpos['protikolpo_1']['designation_id'] = $request->designation_id;
                $protikolpos['protikolpo_1']['other_officer_info'] = "";
                if (isset($exist['protikolpo_2'])) {
                    $protikolpos['protikolpo_2']['office_id'] = $exist['protikolpo_2']['office_id'];
                    $protikolpos['protikolpo_2']['employee_record_id'] = $exist['protikolpo_2']['employee_record_id'];
                    $protikolpos['protikolpo_2']['office_unit_id'] = $exist['protikolpo_2']['office_unit_id'];
                    $protikolpos['protikolpo_2']['designation_id'] = $exist['protikolpo_2']['designation_id'];
                    $protikolpos['protikolpo_2']['other_officer_info'] = "";
                }
            } else {
                $protikolpos['protikolpo_1']['office_id'] = $exist['protikolpo_1']['office_id'];
                $protikolpos['protikolpo_1']['employee_record_id'] = $exist['protikolpo_1']['employee_record_id'];
                $protikolpos['protikolpo_1']['office_unit_id'] = $exist['protikolpo_1']['office_unit_id'];
                $protikolpos['protikolpo_1']['designation_id'] = $exist['protikolpo_1']['designation_id'];
                $protikolpos['protikolpo_1']['other_officer_info'] = "";
                if (isset($exist['protikolpo_2'])) {
                    $protikolpos['protikolpo_2']['office_id'] = $exist['protikolpo_2']['office_id'];
                    $protikolpos['protikolpo_2']['employee_record_id'] = $exist['protikolpo_2']['employee_record_id'];
                    $protikolpos['protikolpo_2']['office_unit_id'] = $exist['protikolpo_2']['office_unit_id'];
                    $protikolpos['protikolpo_2']['designation_id'] = $exist['protikolpo_2']['designation_id'];
                    $protikolpos['protikolpo_2']['other_officer_info'] = "";
                }
            }

            if ($protikolpo_no == 2) {
                $protikolpos['protikolpo_2']['office_id'] = $request->office_id;
                $protikolpos['protikolpo_2']['employee_record_id'] = $request->officer_id;
                $protikolpos['protikolpo_2']['office_unit_id'] = $request->office_unit_id;
                $protikolpos['protikolpo_2']['designation_id'] = $request->designation_id;
                $protikolpos['protikolpo_2']['other_officer_info'] = "";
            }

            $data['office_id'] = $request->pro_office_id;
            $data['unit_id'] = $request->pro_office_unit_id;
            $data['designation_id'] = $request->pro_office_unit_organogram_id;
            $data['employee_record_id'] = 0;
            $data['employee_name'] = null;
            $data['protikolpos'] = json_encode($protikolpos);
            // dd(json_encode($protikolpo->protikolpos));
            $data['selected_protikolpo'] = 0;
            $data['created_by'] = Auth::user()->id;
            $data['modified_by'] = Auth::user()->id;

            // dd($protikolpos['protikolpo_1']['designation_id']);

            $isFirstSet = array_key_exists('protikolpo_1', $exist);
            $isSecondSet = array_key_exists('protikolpo_2', $exist);

            $hasTwoProtikolpo = $isFirstSet && $isSecondSet;

            $protikolpo2asProtikolpo1 = $hasTwoProtikolpo && ($exist['protikolpo_2']['designation_id'] ==
                    $exist['protikolpo_1']['designation_id']);
            $same = false;

            if ($protikolpo_no == 1 && $isSecondSet) {
                if ($request->designation_id == $exist['protikolpo_2']['designation_id']) {
                    $same = true;
                }
            } elseif ($protikolpo2asProtikolpo1) {
                $same = true;
            }

            if ($same) {
                return response()->json(['status' => 'error', 'msg' => 'Plan 1 and Plan 2 are the same.']);
            } else {
                $ret = ProtikolpoManagement::where("designation_id", $request->pro_office_unit_organogram_id)->update($data);
                return response()->json(['status' => 'success', 'msg' => '
                The project has been set successfully.']);
            }
        }
    }

    public function assignProtikolpo(Request $request)
    {
        $request->validate([
            'protikolpo_start_date' => 'required',
            'protikolpo_end_date' => 'required'
        ], [
            'protikolpo_start_date.required' => 'No start date given.',
            'protikolpo_end_date.required' => 'End date not given.'
        ]);

        $msg = [];
        $data['start_date'] = date('Y-m-d', strtotime($request->protikolpo_start_date));
        $data['end_date'] = date('Y-m-d', strtotime($request->protikolpo_end_date));
        if (is_null($request->is_show_acting)) {
            $data['is_show_acting'] = 0;
        } else {
            $data['is_show_acting'] = 1;
        }

        $data['acting_level'] = $request->acting_level;
        $data['employee_record_id'] = $request->employee_record_id;
        $data['employee_name'] = $request->employee_name;

        $designation_id = EmployeeOffice::where('employee_record_id', $request->employee_record_id)->where('status', 1)->pluck('office_unit_organogram_id');

        $protikolpo_lists = ProtikolpoManagement::whereIn('designation_id', $designation_id)->get()->unique('designation_id');

        if ($designation_id->count() != $protikolpo_lists->count()) {
            return response()->json(['status' => 'error', 'msg' => 'One or more positions were not found.']);
        }

        foreach ($protikolpo_lists as $protikolpo_list) {
            $protikolpos = json_decode($protikolpo_list['protikolpos'], true);
            $data['selected_protikolpo'] = 0;
            if (isset($protikolpos['protikolpo_1'])) {

                $isAssigned = EmployeeOffice::where('office_unit_organogram_id', $protikolpos['protikolpo_1']['designation_id'])->where('status', 1)->first();
                if ($isAssigned) {
                    $isInLeave = ProtikolpoManagement::where('designation_id', $protikolpos['protikolpo_1']['designation_id'])->where('active_status', 1)->whereRaw('(' . $data['start_date'] . ' BETWEEN ' . 'start_date AND end_date)')->first();
                    if (!$isInLeave) {
                        $data['selected_protikolpo'] = 1;
                    } else {
                        $msg[$protikolpo_list['designation_id']][] = 'Protikolpo 1 is in leave';
                    }
                } else {
                    $msg[$protikolpo_list['designation_id']][] = 'Protikolpo 1 is not assigned';
                }
            }

            if ($data['selected_protikolpo'] == 0) {
                if (isset($protikolpos['protikolpo_2'])) {
                    $isAssigned = EmployeeOffice::where('office_unit_organogram_id', $protikolpos['protikolpo_2']['designation_id'])->where('status', 1)->first();
                    if ($isAssigned) {
                        $isInLeave = ProtikolpoManagement::where('designation_id', $protikolpos['protikolpo_2']['designation_id'])->where('active_status', 1)->whereRaw('(' . $data['start_date'] . ' BETWEEN ' . 'start_date AND end_date)')->first();
                        if (!$isInLeave) {
                            $data['selected_protikolpo'] = 2;
                        } else {
                            $msg[$protikolpo_list['designation_id']][] = 'Protikolpo 2 is in leave';
                        }
                    } else {
                        $msg[$protikolpo_list['designation_id']][] = 'Protikolpo 2 is not assigned';
                    }
                }
            }

            if ($data['selected_protikolpo'] != 0) {
                $data['active_status'] = 0;
                // dd($data);
                $protikolpo_list->update($data);
                $msg[$protikolpo_list['designation_id']][] = "Successfully Assign done";
            }
        }
        $startDate = enTobn($request->protikolpo_start_date);
        $endDate = enTobn($request->protikolpo_end_date);
        $employeeOffices = EmployeeOffice::where('employee_record_id', $request->employee_record_id)->where('status', 1)->get();
        foreach ($employeeOffices as $employeeOffice) {
            $employee_name = EmployeeRecord::find($employeeOffice->employee_record_id);
            $protikolposSettings = ProtikolpoManagement::where('designation_id', $employeeOffice->office_unit_organogram_id)->get();
            foreach ($protikolposSettings as $protikolposSetting) {
                $protikolpos = json_decode($protikolposSetting->protikolpos, true);

                foreach ($protikolpos as $protikolpo) {
                    $protikolpoName = EmployeeRecord::find($protikolpo['employee_record_id']);
                    $protikolpoOrg = OfficeUnitOrganogram::find($protikolpo['designation_id']);

                    $messages[] = [
                        "title" => 'The plan has been implemented',
                        "message" => '' . $startDate . ' From ' . $endDate . ' To <b>' . $employee_name->full_name_bng . '</b>, ' . $employeeOffice->designation . ' As an alternative <b>' . $protikolpoName->full_name_bng . '</b>, ' . $protikolpoOrg->name_bng . ' Got the responsibility.',
                        "message_for" => 'organogram',
                        "related_id" => $protikolpo['designation_id'],
                        "message_by" => Auth::user()->id,
                        "is_deleted" => 0,
                        "created" => date('Y-m-d H:i:s'),
                        "modified" => date('Y-m-d H:i:s')
                    ];
                    $messages[] = [
                        "title" => 'The plan has been implemented',
                        "message" => '' . $startDate . ' From ' . $endDate . ' To <b>' . $employee_name->full_name_bng . '</b>, ' . $employeeOffice->designation . ' As an alternative <b>' . $protikolpoName->full_name_bng . '</b>, ' . $protikolpoOrg->name_bng . ' Got the responsibility.',
                        "message_for" => 'organogram',
                        "related_id" => $employeeOffice->office_unit_organogram_id,
                        "message_by" => Auth::user()->id,
                        "is_deleted" => 0,
                        "created" => date('Y-m-d H:i:s'),
                        "modified" => date('Y-m-d H:i:s')
                    ];
                }
            }
        }
        Message::insert($messages);
        return response()->json(['status' => 'success', 'msg' => $msg]);
    }


    public function validateProtikolpoAssign($req, $desingation_ids)
    {
        $p_start_date = $req->protikolpo_start_date;
        $p_end_date = $req->protikolpo_end_date;
        $p_designation_id = $req->office_unit_organogram_id;
        $p_employee_record_id = $req->employee_record_id;

        $protikolpo_lists = ProtikolpoManagement::whereIn('designation_id', $desingation_ids)->get();
        $protikolpos = [];
        $protikolpo_infos = [];
        foreach ($protikolpo_lists as $protikolpo_list) {
            $protikolpos[] = json_decode($protikolpo_list->protikolpos, true);
        }
        foreach ($protikolpos as $protikolpo) {
            $protikolpo_infos[] = $protikolpo['designation_id'];
        }

        return $protikolpos;
    }

    public function activeProtikolpo(Request $request)
    {
        $need_to_logout = false;
        DB::beginTransaction();
        try {
            if ($request->date) {
                $date = date('Y-m-d', strtotime($request->date));
            } else {
                $date = date('Y-m-d');
            }

            if ($request->protikolpo_id && $request->protikolpo_id > 0) {
                $protikolpo_list = ProtikolpoManagement::where('id', $request->protikolpo_id)->where('start_date', $date)
                    ->where('active_status', 0)->get();
            } else {
                $protikolpo_list = ProtikolpoManagement::where('start_date', $date)->where('active_status', 0)->get();
            }

            // dd($date);

            $office_unit_organogram_id = array();
            $selected_protikolpo = array();

            foreach ($protikolpo_list as $key => $value) {
                $protikolpo_itm = json_decode($value['protikolpos'], true);
                $protikolpo_no = 'protikolpo_' . $value['selected_protikolpo'];

                $selected_protikolpo['designation_id'] = $value['designation_id'];

                $selected_protikolpo['employee_record_id'] = $protikolpo_itm[$protikolpo_no]['employee_record_id'];
                $selected_protikolpo['office_unit_organogram_id'] = $protikolpo_itm[$protikolpo_no]['designation_id'];

                $office_unit_organogram_id[] = $protikolpo_itm[$protikolpo_no]['designation_id'];
            }


            $selected_protikolpo_username = EmployeeOffice::whereIn('office_unit_organogram_id', $office_unit_organogram_id)->where('status', 1)->get();


            $selected_protikolpo_key_value = array();
            foreach ($selected_protikolpo_username as $key => $userinfo) {
                $selected_protikolpo_key_value[$userinfo->office_unit_organogram_id] = $userinfo->employee_record->user->username . ',' . $userinfo->employee_record->name_bng;
            }

            // dd($protikolpo_list);


            $designation_id = ProtikolpoManagement::where('start_date', $date)->where('active_status', 0)->pluck('designation_id');

            $employee_office_info = EmployeeOffice::whereIn("office_unit_organogram_id", $designation_id)->where('status', 1)->get();

            $employee_office = array_column($employee_office_info->toArray(), null, 'office_unit_organogram_id');

            foreach ($protikolpo_list as $key => $value) {

                if (array_key_exists($value->designation_id, $employee_office)) {
                    $protikolpo_itm = json_decode($value['protikolpos'], true);

                    $protikolpo_no = 'protikolpo_' . $value['selected_protikolpo'];;
                    $emp_info = $selected_protikolpo_key_value[$protikolpo_itm[$protikolpo_no]['designation_id']];
                    $emp_value = explode(',', $emp_info);

                    $identification_number = $emp_value[0];
                    $name = $emp_value[1];

                    $info['employee_record_id'] = $protikolpo_itm[$protikolpo_no]['employee_record_id']; //change
                    $info['identification_number'] = $identification_number; //change

                    $info['office_id'] = $employee_office[$value->designation_id]['office_id'];
                    $info['office_unit_id'] = $employee_office[$value->designation_id]['office_unit_id'];
                    $info['office_unit_organogram_id'] = $employee_office[$value->designation_id]['office_unit_organogram_id'];
                    $info['designation'] = $employee_office[$value->designation_id]['designation'];
                    $info['designation_level'] = $employee_office[$value->designation_id]['designation_level'];
                    $info['designation_sequence'] = $employee_office[$value->designation_id]['designation_sequence'];
                    $info['is_default_role'] = $employee_office[$value->designation_id]['is_default_role'];
                    $info['summary_nothi_post_type'] = $employee_office[$value->designation_id]['summary_nothi_post_type'];

                    if ($value['is_show_acting'] == 1) {
                        $info['incharge_label'] = $value['acting_level'] ?? '';
                    } else {
                        $info['incharge_label'] = '';
                    }

                    $info['last_office_date'] = null;
                    $info['status'] = 1; //change
                    $info['status_change_date'] = null;
                    $info['designation_en'] = $employee_office[$value->designation_id]['designation_en'];
                    $info['unit_name_bn'] = $employee_office[$value->designation_id]['unit_name_bn'];
                    $info['unit_name_en'] = $employee_office[$value->designation_id]['unit_name_en'];
                    $info['office_name_en'] = $employee_office[$value->designation_id]['office_name_en'];
                    $info['office_name_bn'] = $employee_office[$value->designation_id]['office_name_bn'];
                    $info['protikolpo_status'] = $employee_office[$value->designation_id]['protikolpo_status'];

                    $protikolpo_log['protikolpo_id'] = $value['id'];
                    $protikolpo_log['protikolpo_start_date'] = $value['start_date'];
                    $protikolpo_log['employee_office_id_from_name'] = $value['employee_name'];
                    $protikolpo_log['employee_office_id_to_name'] = $name;
                    $protikolpo_log['protikolpo_status'] = 1;
                    // dd($protikolpo_log);
                    // dd($info);
                    $info['protikolpo_status'] = 1;
                    // dd($info);
                    EmployeeOffice::create($info);

                    EmployeeOffice::where("id", $employee_office[$value->designation_id]['id'])->update([
                        'status' => 0,
                        'last_office_date' => date('Y-m-d H:i:s'),
                        'status_change_date' => date('Y-m-d H:i:s'),
                    ]);

                    $protikolpo['active_status'] = 1;
                    ProtikolpoManagement::where("id", $value['id'])->update($protikolpo);

                    ProtikolpoLog::create($protikolpo_log);

                    $employee_to_sync = OfficeUnitOrganogram::where('id', $info['office_unit_organogram_id'])->where('status', 1)->first();
                    $is_front_desk = OfficeFrontDesk::where('office_unit_organogram_id', $info['office_unit_organogram_id'])->first();

                    $front_desk = is_null($is_front_desk) ? 'NO' : 'YES';

                    $sync_data = [
                        'officer_id' => $employee_to_sync->assigned_user->employee_record_id,
                        'office_id' => $employee_to_sync->office_id,
                        'office_unit_id' => $employee_to_sync->office_unit_id,
                        'office_unit_organogram_id' => $employee_to_sync->id,
                        'officer_bng' => $employee_to_sync->assigned_user->employee_record->name_bng,
                        'officer_eng' => $employee_to_sync->assigned_user->employee_record->name_eng,
                        'gender' => $employee_to_sync->assigned_user->employee_record->gender,
                        'personal_mobile' => $employee_to_sync->assigned_user->employee_record->personal_mobile,
                        'personal_email' => $employee_to_sync->assigned_user->employee_record->personal_email,
                        'is_cadre' => $employee_to_sync->assigned_user->employee_record->is_cadre,
                        'date_of_birth' => $employee_to_sync->assigned_user->employee_record->date_of_birth,
                        'employee_id' => $employee_to_sync->assigned_user->employee_record_id,
                        'is_front_desk' => $front_desk,
                        'is_office_admin' => $employee_to_sync->is_admin,
                        'is_office_head' => $employee_to_sync->is_office_head,
                    ];
                }
            }


            if ($request->protikolpo_id && $request->protikolpo_id > 0) {

                if (Auth::user()->employee_record_id == $protikolpo_list[0]->employee_record_id) {
                    $need_to_logout = true;
                    // Auth::logout();
                    // $request->session()->invalidate();
                    // $request->session()->regenerateToken();
                    // session(['login' => ['status' => 'logged_out', 'user' => []]]);

                    // return redirect(config('jisf.logout_sso_url') . '?referer=' . base64_encode(url('/login-response')));
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => 'Failed to apply.', 'data' => $e->getMessage()]);
        }
        DB::commit();

        return response(['status' => 'success', 'msg' => 'The plan has been successfully implemented.', 'need_to_logout' => $need_to_logout]);
    }

    public function updateProtikolpoByUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $employee_record_id = $request->employee_record_id;

        $protikolpo_lists = ProtikolpoManagement::where('employee_record_id', $employee_record_id)->where('active_status', 1)->get();

        foreach ($protikolpo_lists as $protikolpo_list) {
            $request->merge(['protikolpo_id' => $protikolpo_list->id]);
            $this->updateProtikolpo($request);
        }
        return response()->json(['status' => 'success', 'msg' => 'Project edited successfully.']);
    }

    public function updateProtikolpo(Request $request)
    {

        if ($request->start_date) {
            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
        }
        $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
        ProtikolpoManagement::where("id", $request->protikolpo_id)->update($data);
        return response(['status' => 'success', 'msg' => 'Project edited successfully.']);
    }

    public function cancelProtikolpoByUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $employee_record_id = $request->employee_record_id;

        $protikolpo_lists = ProtikolpoManagement::where('employee_record_id', $employee_record_id)->where('active_status', 1)->get();

        foreach ($protikolpo_lists as $protikolpo_list) {
            $request->merge(['protikolpo_id' => $protikolpo_list->id]);
            $this->cancelProtikolpo($request);
        }

        return response()->json(['status' => 'success', 'msg' => 'The proposal has been cancelled.']);
    }

    public function cancelProtikolpo(Request $request)
    {
        $protikolpo_id = $request->protikolpo_id;
        $protikolpo = ProtikolpoManagement::find($protikolpo_id);

        if ($protikolpo->active_status) {
            // dd($protikolpo);
            $protikolpo_itm = json_decode($protikolpo['protikolpos'], true);

            if ($protikolpo['selected_protikolpo'] > 0) {
                $protikolpo_no = 'protikolpo_' . $protikolpo['selected_protikolpo'];
                $protikolpo_designation_id = $protikolpo_itm[$protikolpo_no]['designation_id'];
                $protikolpo_record_id = $protikolpo_itm[$protikolpo_no]['employee_record_id'];

                $employee_office = EmployeeOffice::where('office_unit_organogram_id', $protikolpo['designation_id'])
                    ->where('status', 1)->first();

                // dd($employee_office->office_id);
                $main_designation['employee_record_id'] = $protikolpo->employee_record_id; //change
                $main_designation['identification_number'] = 123456; //change

                $main_designation['office_id'] = $employee_office->office_id;
                $main_designation['office_unit_id'] = $employee_office->office_unit_id;
                $main_designation['office_unit_organogram_id'] = $employee_office->office_unit_organogram_id;
                $main_designation['designation'] = $employee_office->designation;
                $main_designation['designation_level'] = $employee_office->designation_level;
                $main_designation['designation_sequence'] = $employee_office->designation_sequence;
                $main_designation['is_default_role'] = $employee_office->is_default_role;
                $main_designation['summary_nothi_post_type'] = $employee_office->summary_nothi_post_type;
                $main_designation['incharge_label'] = '';

                // if ($value['is_show_acting'] == 1) {
                //     $info['incharge_label'] = $value['acting_level'];
                // }

                $main_designation['last_office_date'] = null;
                $main_designation['status'] = 1; //change
                $main_designation['status_change_date'] = null;
                $main_designation['designation_en'] = $employee_office->designation_en;
                $main_designation['unit_name_bn'] = $employee_office->unit_name_bn;
                $main_designation['office_name_bn'] = $employee_office->office_name_bn;
                $main_designation['unit_name_en'] = $employee_office->unit_name_en;
                $main_designation['office_name_en'] = $employee_office->office_name_en;
                $main_designation['protikolpo_status'] = 0;

                EmployeeOffice::create($main_designation);

                $protikolpo_data['status'] = 0;
                $protikolpo_data['last_office_date'] = date('Y-m-d');
                EmployeeOffice::where('id', $employee_office->id)->update($protikolpo_data);

                $protikolpo->start_date = null;
                $protikolpo->end_date = date("Y-m-d H:i:s");
                $protikolpo->active_status = 0;
                $protikolpo->update();

                $log['protikolpo_end_date'] = date("Y-m-d H:i:s");
                $log['protikolpo_status'] = 0;
                $log['protikolpo_ended_by'] = Auth::user()->id;

                ProtikolpoLog::where('protikolpo_id', $protikolpo_id)->update($log);

                // PROTIKOLPO BACK SEND NOTIFICATION
                $employee_record_get = EmployeeRecord::where('id', $protikolpo->employee_record_id)->first();

                $employee_office_admin = OfficeUnitOrganogram::where('office_id', $protikolpo->office_id)->where('is_admin', 1)->first();
                $employee_office_admin_email = $employee_office_admin->assigned_user->employee_record->personal_email;
                $employee_office_admin_mobile = $employee_office_admin->assigned_user->employee_record->personal_mobile;

                $this->sendSMSNotification(config('notifiable_constants.protikolpo_revert'), $employee_office_admin_mobile);

                $this->sendMailNotification(config('notifiable_constants.protikolpo_revert'), $employee_office_admin_email, 'Plan rejected', ['protikolpo_name' => $employee_record_get->full_name_bng, 'username' => $employee_record_get->user->username]);
                // PROTIKOLPO BACK SEND NOTIFICATION END

                // NOTHI SYNC
                $sync_data = [
                    'officer_id' => $protikolpo->employee_record_id,
                    'office_id' => $protikolpo->office_id,
                    'office_unit_id' => $protikolpo->unit_id,
                    'office_unit_organogram_id' => $protikolpo->designation_id,
                    'employee_id' => $protikolpo->employee_record_id,
                ];

                return response(['status' => 'success', 'msg' => 'The proposal has been cancelled']);
            }

            // dd($protikolpo);
        } else {
            $protikolpo->employee_record_id = 0;
            $protikolpo->employee_name = null;
            $protikolpo->start_date = null;
            $protikolpo->end_date = null;
            $protikolpo->selected_protikolpo = 0;
            $protikolpo->update();
            return response(['status' => 'success', 'msg' => 'The proposal has been cancelled']);
        }
    }

    public function protikolpoRevert()
    {
        if (!$this->checkProtikolpo()) {
            return redirect('/');
        }

        $employee_record_id = \Auth::user()->employee->id;
        $protikolpo_settings = ProtikolpoManagement::where('employee_record_id', $employee_record_id)->where('active_status', 1)->get();
        $protikolpo_list = [];

        $other_designations_in_employee_office = EmployeeOffice::where('employee_record_id', $employee_record_id)
            ->whereStatus(1)
            ->exists();
        if ($other_designations_in_employee_office) {
            $msg = 'Cancel project management if you want to return to your position.';
            $is_logout_button = false;
        } else {
            $is_logout_button = true;
        }

        $employee_record_user = EmployeeRecord::find($employee_record_id);
        $protikolpo_list['user_name'] = $employee_record_user->name_bng;
        $protikolpo_list['employee_record_id'] = $employee_record_user->id;

        foreach ($protikolpo_settings as $key => $protikolpo_setting) {

            $protikolpos = json_decode($protikolpo_setting['protikolpos'], true);
            if ($protikolpo_setting['selected_protikolpo'] > 0) {
                $selected_protikolpo = $protikolpos['protikolpo_' . $protikolpo_setting['selected_protikolpo']];
            }
            //pr($selected_protikolpo);die;
            $protikolpo_list['data'][$key]['start_date'] = $protikolpo_setting['start_date'];
            $protikolpo_list['data'][$key]['end_date'] = $protikolpo_setting['end_date'];

            $office = Office::find($selected_protikolpo['office_id']);
            $office_unit = OfficeUnit::find($selected_protikolpo['office_unit_id']);
            $office_unit_ogranogram = OfficeUnitOrganogram::find($selected_protikolpo['designation_id']);
            $employee_record = EmployeeRecord::find($selected_protikolpo['employee_record_id']);
            $protikolpo_list['data'][$key]['protikolpo'] = [
                'office_id' => $selected_protikolpo['office_id'],
                'employee_record_id' => $selected_protikolpo['employee_record_id'],
                'office_unit_id' => $selected_protikolpo['office_unit_id'],
                'office_unit_organogram_id' => $selected_protikolpo['designation_id'],

                'employee_name' => $employee_record->name_bng,
                'office_unit_organogram_name' => $office_unit_ogranogram->designation_bng,
                'office_unit_name' => $office_unit->unit_name_bng,
                'office_name' => $office->office_name_bng,
            ];
        }

        return view('protikolpo.protikolpo_revert', compact('protikolpo_list', 'is_logout_button'));
    }

    public function emoployeeProtikolpoList(Request $request)
    {
        $emoployee_protikolpo_list = [];
        $employee_record_id = $request->employee_record_id;
        $designations = EmployeeOffice::where('employee_record_id', $employee_record_id)
            ->whereStatus(1)
            ->orderBy('incharge_label')
            ->orderBy('designation_level')
            ->orderBy('designation_sequence')
            ->get();
        foreach ($designations as $designation) {
            $protikolpo_setting = ProtikolpoManagement::where('designation_id', $designation['office_unit_organogram_id'])->where('active_status', 0)->first();
            if ($protikolpo_setting) {
                $protikolpos = json_decode($protikolpo_setting['protikolpos'], true);
                $designations1 = !empty($protikolpos['protikolpo_1']) ? $protikolpos['protikolpo_1']['designation_id'] : 0;
                $designations2 = !empty($protikolpos['protikolpo_2']) ? $protikolpos['protikolpo_2']['designation_id'] : 0;

                if ($protikolpo_setting['selected_protikolpo'] == 1) {
                    $protikolpo_info = EmployeeOffice::where('office_unit_organogram_id', $designations1)->where('status', 1)->first();
                } else if ($protikolpo_setting['selected_protikolpo'] == 2) {
                    $protikolpo_info = EmployeeOffice::where('office_unit_organogram_id', $designations2)->where('status', 1)->first();
                }
                if (isset($protikolpo_info)) {
                    $protikolpo_setting['protikolpo_info'] = $protikolpo_info->employee_record->name_bng . ', ' .
                        $protikolpo_info->designation_label;
                }
                if (!empty($designations1)) {
                    $designationArray[] = $designations1;
                }
                if (!empty($designations2)) {
                    $designationArray[] = $designations2;
                }
                $protikolpo_setting['protikolpo_1'] = !empty($protikolpos['protikolpo_1']) ? $protikolpos['protikolpo_1'] : [];
                $protikolpo_setting['protikolpo_2'] = !empty($protikolpos['protikolpo_2']) ? $protikolpos['protikolpo_2'] : [];
            } else {
                $protikolpo_setting['protikolpo_1'] = [];
                $protikolpo_setting['protikolpo_2'] = [];
            }
            $protikolpo_setting['designation_id'] = $designation['office_unit_organogram_id'];
            $protikolpo_setting['designation_name_bng'] = $designation['designation'];

            $emoployee_protikolpo_list[] = $protikolpo_setting;
        }

        return view('protikolpo.employee_protikolpo_list', compact('emoployee_protikolpo_list'))->render();
    }

    public function getProtikolpoLog(Request $request)
    {
        $protikolpo_id = $request->protikolpo_id;

        $protikolpo_logs = ProtikolpoLog::where('protikolpo_id', $protikolpo_id)->get();

        return view('protikolpo.protikolpo_log', compact('protikolpo_logs'))->render();
    }
}
