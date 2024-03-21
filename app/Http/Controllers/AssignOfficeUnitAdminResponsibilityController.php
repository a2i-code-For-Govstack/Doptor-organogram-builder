<?php

namespace App\Http\Controllers;

use App\Models\AdminResponsibilityLog;
use App\Models\EmployeeOffice;
use App\Models\OfficeMinistry;
use App\Models\OfficeUnitOrganogram;
use Illuminate\Http\Request;

class AssignOfficeUnitAdminResponsibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $ministries = OfficeMinistry::get();
        return view('assign_office_unit_admin_responsibility', compact('ministries'));
    }


    public function loadOfficeWiseUsers(Request $request)
    {
        $employee_offices = EmployeeOffice::where('office_id', $request->office_id)->get();

        return view('assignofficeunitadminresponsibility.get_employee_info', compact('employee_offices'));
    }

    public function loadOfficeUnitWiseOrganogram(Request $request)
    {
        $organograms = OfficeUnitOrganogram::where('office_unit_id', $request->office_unit_id)
            ->where('status', 1)
            ->orderBy('is_unit_admin', 'DESC')
            ->orderBy('designation_level', 'ASC')
            ->orderBy('designation_sequence', 'ASC')
            ->get();

        $current_responsible = $organograms->where('is_unit_admin', 1)->first();
        $assigned_users = $organograms->whereNotNull('assigned_user')->where('is_unit_admin', 0);
        $unassigned_users = $organograms->whereNull('assigned_user')->where('is_unit_admin', 0);


        return view('assignofficeunitadminresponsibility.get_employee_info', compact('current_responsible', 'assigned_users', 'unassigned_users'));;
    }


    public function assignOfficeUnitAdmin(Request $request)
    {
        $office_unit_organogram = OfficeUnitOrganogram::find($request->office_unit_organogram_id);
        if ($office_unit_organogram) {
            $existing_office_unit_admin = OfficeUnitOrganogram::where('office_unit_id', $office_unit_organogram->office_unit_id)->where('is_unit_admin', 1)->first();

            $assign_data = [
                'is_office_unit_admin' => 'Yes',
                'office_unit_organogram_id' => $request->office_unit_organogram_id,
                'office_id' => $office_unit_organogram->office_id,
                'office_unit_id' => $office_unit_organogram->office_unit_id,
            ];


            if ($existing_office_unit_admin) {
                $unassign_data = [
                    'is_office_unit_admin' => 'No',
                    'office_unit_organogram_id' => $existing_office_unit_admin->id,
                    'office_id' => $existing_office_unit_admin->office_id,
                    'office_unit_id' => $existing_office_unit_admin->office_unit_id,
                ];
                OfficeUnitOrganogram::where('office_unit_id', $office_unit_organogram->office_unit_id)->update(['is_unit_admin' => 0]);
            }

            $office_unit_organogram->update(['is_unit_admin' => 1]);


            if ($existing_office_unit_admin) {
                $existing_admin_log = AdminResponsibilityLog::where('office_unit_organogram_id', $existing_office_unit_admin->id)
                    ->latest()
                    ->first();

                if ($existing_admin_log) {
                    $existing_admin_log->assign_to = date('Y-m-d');
                    $existing_admin_log->save();
                }

                // for garbage data cleaning
                AdminResponsibilityLog::where('admin_type', 'office_head')
                    ->where('office_id', $existing_office_unit_admin->office_id)
                    ->whereNull('assign_to')
                    ->update(['assign_to' => date('Y-m-d')]);
            }
            $employee_offices = EmployeeOffice::where('office_unit_organogram_id', $office_unit_organogram->id)->where('status', 1)->first();

            $admin_log = new AdminResponsibilityLog();
            $admin_log->office_id = $office_unit_organogram->office_id;
            $admin_log->office_unit_id = $office_unit_organogram->office_unit_id;
            $admin_log->office_unit_organogram_id = $office_unit_organogram->id;
            $admin_log->admin_type = 'office_unit_admin';
            $admin_log->employee_id = $employee_offices ? $employee_offices->employee_record_id : 0;
            $admin_log->employee_name_en = $employee_offices ? $employee_offices->employee_record->name_eng : null;
            $admin_log->employee_name_bn = $employee_offices ? $employee_offices->employee_record->name_bng : null;
            $admin_log->assign_from = date('Y-m-d');
            $admin_log->created_at = date('Y-m-d h:i:s');
            $admin_log->save();

            return response(['status' => 'success', 'msg' => 'Successfully selected office unit admin.']);
        }
        return response(['status' => 'error', 'msg' => 'Please try again.']);
    }
}
