<?php

namespace App\Http\Controllers;

use App\Models\AdminResponsibilityLog;
use App\Models\EmployeeOffice;
use App\Models\EmployeeRecord;
use App\Models\NotificationEvent;
use App\Models\NotificationSetting;
use App\Models\Office;
use App\Models\OfficeFrontDesk;
use App\Models\OfficeMinistry;
use App\Models\OfficeUnitOrganogram;
use Auth;
use DB;
use Illuminate\Http\Request;

class OfficeAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data['ministries'] = OfficeMinistry::all();
        return view('office.office_notification', $data);
    }

    public function get_office_notification_list(Request $request)
    {
        $id = $request->office_id;

        $data['office_notifications'] = NotificationEvent::get();

        $office_notifications_status = DB::table('notification_settings')->where('notification_settings.employee_id', 0)->where('notification_settings.office_id', $id)->get();
        $new_array = array();
        foreach ($office_notifications_status as $key => $value) {
            $new_array[$value->event_id] = $value;
        }
        $data['office_notifications_status'] = $new_array;
        // echo "<pre>";print_r($new_array);die();

        $html = view('office.office_notification_list', $data);
        return response($html);
    }

    public function section_designation_setting()
    {

        $data['ministries'] = OfficeMinistry::all();
        return view('office.section_designation_setting', $data);
    }

    public function get_office_by_ministry_and_layer(Request $request)
    {

        $office_ministry_id = $request->office_ministry_id;
        $office_layer_id = $request->office_layer_id;

        $data['office_list'] = Office::where('active_status', 1)->where('office_ministry_id', $office_ministry_id)->where('office_layer_id', $office_layer_id)->select('id', 'office_name_bng', 'unit_organogram_edit_option')->get();

        // dd($data['office_list']);
        $html = view('office.section_designation_setting_list', $data);
        return response($html);
    }

    public function section_designation_update(Request $request)
    {
        $office_id = $request->office_id;
        $data['unit_organogram_edit_option'] = $request->unit_organogram_edit_option;
        $office = Office::where('id', $office_id)->update($data);
        return response(['status' => 'success', 'msg' => 'Name has been modified successfully.']);
    }


    // office front desk

    public function office_front_desk()
    {
        $data['ministries'] = OfficeMinistry::all();
        return view('office.office_front_desk', $data);
    }

    public function get_office_front_desk_list(Request $request)
    {
        $organograms = OfficeUnitOrganogram::where('office_id', $request->office_id)
            ->where('status', 1)
            ->with('assigned_front_desk', 'assigned_user.employee_record.user', 'office_unit')
            ->orderBy('designation_level', 'ASC')
            ->orderBy('designation_sequence', 'ASC')
            ->get();
        return view('office.office_front_desk_list', compact('organograms'));
    }

    public function assign_front_desk(Request $request)
    {
        $office_unit_organogram = OfficeUnitOrganogram::find($request->office_unit_organogram_id);
        // unit_name_bng
        // dd($office_unit_organogram->office_info);
        // office_unit
        if ($office_unit_organogram && $office_unit_organogram->assigned_user) {

            $office_front_desk = OfficeFrontDesk::where('office_id', $office_unit_organogram->office_id)->first();

            $data['office_id'] = $office_unit_organogram->office_id;
            $data['office_name'] = $office_unit_organogram->assigned_user->office_name_bn;
            $data['office_address'] = !empty($office_unit_organogram->office_info->office_address) ? $office_unit_organogram->office_info->office_address : '';
            $data['office_unit_id'] = $office_unit_organogram->office_unit->id;
            $data['office_unit_name'] = $office_unit_organogram->office_unit->unit_name_bng;
            $data['office_unit_organogram_id'] = $office_unit_organogram->id;
            $data['designation_label'] = $office_unit_organogram->designation_bng;
            $data['officer_id'] = $office_unit_organogram->assigned_user->employee_record->id;
            $data['officer_name'] = $office_unit_organogram->assigned_user->employee_record->name_bng;

            if (is_null($office_front_desk)) {
                OfficeFrontDesk::insert($data);
            } else {
                OfficeFrontDesk::where('office_id', $office_unit_organogram->office_id)->update($data);
            }
            return response(['status' => 'success', 'msg' => 'Successfully selected Office Front Desk.']);
        }
        return response(['status' => 'error', 'msg' => 'Sorry! User is not assigned in designation.']);
    }


    // office head

    public function officeHead()
    {
        return view('office.office_head');
    }

    public function getOfficeHead(Request $request)
    {
        $office_id = $request->office_id ?: Auth::user()->current_office_id();
        $organograms = OfficeUnitOrganogram::where('office_id', $office_id)
            ->where('status', 1)
            ->with('assigned_user.employee_record.user', 'office_unit', 'office_info')
            ->orderBy('designation_level', 'ASC')
            ->orderBy('designation_sequence', 'ASC')->get();


        $current_responsible = $organograms->where('is_office_head', 1)->first();
        $assigned_users = $organograms->whereNotNull('assigned_user')->where('is_office_head', 0);
        $unassigned_users = $organograms->whereNull('assigned_user')->where('is_office_head', 0);

        return view('office.get_office_head', compact('current_responsible', 'assigned_users', 'unassigned_users'));
    }

    public function searchOfficeHead(Request $request)
    {
        $office_id = Auth::user()->current_office_id();
        $name_bng = $request->name_bng;
        $name_eng = $request->name_eng;
        $loginId = $request->loginId;
        $nid = $request->nid;

        $query = EmployeeRecord::query();

        if ($office_id) {
            $query->whereHas('employee_office', function ($q) use ($office_id) {
                return $q->where('office_id', $office_id);
            });
        }
        if ($loginId) {
            $query->whereHas('user', function ($q) use ($loginId) {
                return $q->where('username', $loginId);
            });
        }

        $query->when($name_bng, function ($q, $name_bng) {
            return $q->where('name_bng', $name_bng);
        });

        $query->when($name_eng, function ($q, $name_eng) {
            return $q->where('name_eng', $name_eng);
        });

        $query->when($nid, function ($q, $nid) {
            return $q->where('nid', $nid);
        });

        $employee_records = $query->get();

        return view('office.get_search_office_head', compact('employee_records'));
    }

    public function assignOfficeHead(Request $request)
    {
        $office_unit_organogram_id = $request->office_unit_organogram_id;
        $office_id = $request->office_id;

        $office_unit_organogram = OfficeUnitOrganogram::find($request->office_unit_organogram_id);
        if ($office_unit_organogram) {
            $existing_office_head = OfficeUnitOrganogram::where('office_id', $office_unit_organogram->office_id)->where('is_office_head', 1)->first();


            $sync_data = [
                'is_office_head' => 'Yes',
                'office_unit_organogram_id' => $request->office_unit_organogram_id,
                'office_id' => $office_unit_organogram->office_id,
                'office_unit_id' => $office_unit_organogram->office_unit_id,
            ];

            if ($existing_office_head) {
                $unassigned_data = [
                    'is_office_head' => 'No',
                    'office_unit_organogram_id' => $existing_office_head->id,
                    'office_id' => $existing_office_head->office_id,
                    'office_unit_id' => $existing_office_head->office_unit_id,
                ];

                OfficeUnitOrganogram::where('office_id', $office_id)->update(['is_office_head' => 0]);
            }

            $office_unit_organogram->update(['is_office_head' => 1]);


            if ($existing_office_head) {
                $existing_admin_log = AdminResponsibilityLog::where('office_unit_organogram_id', $existing_office_head->id)
                    ->latest()
                    ->first();

                if ($existing_admin_log) {
                    $existing_admin_log->assign_to = date('Y-m-d');
                    $existing_admin_log->save();
                }

                // for garbage data cleaning
                AdminResponsibilityLog::where('admin_type', 'office_head')
                    ->where('office_id', $existing_office_head->office_id)
                    ->whereNull('assign_to')
                    ->update(['assign_to' => date('Y-m-d')]);
            }
            $employee_offices = EmployeeOffice::where('office_unit_organogram_id', $office_unit_organogram->id)
                ->where('status', 1)
                ->first();

            $admin_log = new AdminResponsibilityLog();
            $admin_log->office_id = $office_unit_organogram->office_id;
            $admin_log->office_unit_id = $office_unit_organogram->office_unit_id;
            $admin_log->office_unit_organogram_id = $office_unit_organogram->id;
            $admin_log->admin_type = 'office_head';
            $admin_log->employee_id = $employee_offices ? $employee_offices->employee_record_id : 0;
            $admin_log->employee_name_en = $employee_offices ? $employee_offices->employee_record->name_eng : null;
            $admin_log->employee_name_bn = $employee_offices ? $employee_offices->employee_record->name_bng : null;
            $admin_log->assign_from = date('Y-m-d');
            $admin_log->created_at = date('Y-m-d h:i:s');
            $admin_log->save();

            return response(['status' => 'success', 'msg' => 'Successfully selected office head.']);
        }
        return response(['status' => 'error', 'msg' => 'Please try again.']);
        //
        //        $data['office_head'] = 0;
        //        EmployeeOffice::where('office_id',$office_id)->update($data);
        //
        //        $head['office_head'] = 1;
        //        EmployeeOffice::where('office_id',$office_id)->where('office_unit_organogram_id',$office_unit_organogram_id )->update($head);
        //
        //       // dd($designation_info);
        //       return response(['status' => 'success', 'msg' => 'সফলভাবে হালনাগাদ হয়েছে।']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sms = $request->sms;
        $email = $request->email;
        $mobile_app = $request->mobile_app;

        // dd($sms);
        $office_id = $request->office_id;

        foreach ($sms as $key => $value) {

            if ($value == null) {
                continue;
            }

            $data['sms'] = $value;
            $data['email'] = $email[$key];
            $data['mobile_app'] = $mobile_app[$key];

            // DB::enableQueryLog();
            $record = NotificationSetting::where('event_id', $key)->where('office_id', $office_id)->where('employee_id', 0)->first();
            // dd(DB::getQueryLog());

            // dd($record);
            if (is_null($record)) {

                if ($data['sms'] == 1 || $data['email'] == 1 || $data['mobile_app'] == 1) {
                    $data['employee_id'] = 0;
                    $data['office_id'] = $office_id;
                    $data['event_id'] = $key;
                    NotificationSetting::insert($data);
                }
            } else {
                $record->where('event_id', $key)->where('office_id', $office_id)->update($data);
            }
        }

        return response(['status' => 'success', 'msg' => 'Successfully updated.']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
