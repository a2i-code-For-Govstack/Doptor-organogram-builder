<?php

namespace App\Http\Controllers;

use App\Models\AdminResponsibilityLog;
use App\Models\EmployeeOffice;
use App\Models\Office;
use App\Models\OfficeCustomLayer;
use App\Models\OfficeLayer;
use App\Models\OfficeMinistry;
use App\Models\OfficeOrigin;
use App\Models\OfficeUnitOrganogram;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AssignOfficeAdminResponsibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user_roles = $this->getUserOfficeRoles();
        if (auth()->user()->user_role_id != config('menu_role_map.user') ||  (auth()->user()->user_role_id == config('menu_role_map.user') && $user_roles && $user_roles->is_admin == 1)) {
            $ministries = OfficeMinistry::get();
            return view('assign_office_admin_responsibility', compact('ministries'));
        } else {
            return redirect()->route('profile');
        }
    }


    public function loadOfficeWiseUsers(Request $request)
    {
        $employee_offices = EmployeeOffice::where('office_id', $request->office_id)->get();

        return view('assignofficeadminresponsibility.get_employee_info', compact('employee_offices'));
    }

    public function loadOfficeWiseOrganogram(Request $request)
    {
        $organograms = OfficeUnitOrganogram::where('office_id', $request->office_id)
            ->with('assigned_user', 'assigned_user.designation_user', 'office_unit_org')
            ->with('assigned_user.employee_record', 'office_info')
            ->orderBy('designation_level', 'ASC')
            ->orderBy('designation_sequence', 'ASC')
            ->where('status', 1)
            ->get();


        $current_responsible = $organograms->where('is_admin', 1)->first();
        $assigned_users = $organograms->whereNotNull('assigned_user')->where('is_admin', 0);
        $unassigned_users = $organograms->whereNull('assigned_user')->where('is_admin', 0);

        return view('assignofficeadminresponsibility.get_employee_info', compact('current_responsible', 'assigned_users', 'unassigned_users'));
    }

    public function assignOfficeAdmin(Request $request)
    {
        try {
            $office_unit_organogram = OfficeUnitOrganogram::find($request->office_unit_organogram_id);

            if ($office_unit_organogram) {
                $existing_office_admin = OfficeUnitOrganogram::where('office_id', $office_unit_organogram->office_id)->where('is_admin', 1)->first();

                $sync_data = [
                    'is_admin' => 'Yes',
                    'office_unit_organogram_id' => $request->office_unit_organogram_id,
                    'office_id' => $office_unit_organogram->office_id,
                    'office_unit_id' => $office_unit_organogram->office_unit_id,
                ];

                if ($existing_office_admin) {
                    $unassign_data = [
                        'is_admin' => 'No',
                        'office_unit_organogram_id' => $existing_office_admin->id,
                        'office_id' => $existing_office_admin->office_id,
                        'office_unit_id' => $existing_office_admin->office_unit_id,
                    ];

                    OfficeUnitOrganogram::where('office_id', $office_unit_organogram->office_id)->update(['is_admin' => 0]);

                    $existing_admin_log = AdminResponsibilityLog::where('office_unit_organogram_id', $existing_office_admin->id)
                        ->latest()
                        ->first();

                    if ($existing_admin_log) {
                        $existing_admin_log->assign_to = date('Y-m-d');
                        $existing_admin_log->save();
                    }

                    // for garbage data cleaning
                    AdminResponsibilityLog::where('admin_type', 'office_admin')
                        ->where('office_id', $existing_office_admin->office_id)
                        ->whereNull('assign_to')
                        ->update(['assign_to' => date('Y-m-d')]);
                }

                OfficeUnitOrganogram::find($request->office_unit_organogram_id)->update(['is_admin' => 1]);

                $employee_offices = EmployeeOffice::where('office_unit_organogram_id', $office_unit_organogram->id)
                    ->where('status', 1)
                    ->first();

                $admin_log = new AdminResponsibilityLog();
                $admin_log->office_id = $office_unit_organogram->office_id;
                $admin_log->office_unit_id = $office_unit_organogram->office_unit_id;
                $admin_log->office_unit_organogram_id = $office_unit_organogram->id;
                $admin_log->admin_type = 'office_admin';
                $admin_log->employee_id = $employee_offices ? $employee_offices->employee_record_id : 0;
                $admin_log->employee_name_en = $employee_offices ? $employee_offices->employee_record->name_eng : null;
                $admin_log->employee_name_bn = $employee_offices ? $employee_offices->employee_record->name_bng : null;
                $admin_log->assign_from = date('Y-m-d');
                $admin_log->created_at = date('Y-m-d h:i:s');
                $admin_log->save();

                return ['status' => 'success', 'msg' => 'Successfully updated.'];
            }
        } catch (\Exception $exception) {
            return response(['status' => 'error', 'msg' => $exception->getMessage()]);
        }
    }

    public function testComponent()
    {

        $layer_levels = OfficeCustomLayer::select('layer_level')->groupBy('layer_level')->get();

        $layers = OfficeCustomLayer::get();
        $custom_layers_temp = array();
        $custom_layers = array();

        foreach ($layer_levels as $key => $value) {
            $name = '';
            foreach ($layers as $key => $layer) {

                if ($value->layer_level == $layer->layer_level) {
                    if ($value->layer_level == 3) {
                        $name = 'Other Doptor/Organization';
                    } else {
                        $name .= $layer->name . '/';
                    }
                }
            }

            $custom_layers_temp['id'] = $value->layer_level;
            $custom_layers_temp['name'] = trim($name, '/');
            $custom_layers[] = $custom_layers_temp;
        }

        return view('test_component', compact('custom_layers'));
    }

    public function loadOfficeLayerWise(Request $request)
    {
        $custom_layers = OfficeCustomLayer::where('layer_level', $request->office_layer_id)->pluck('id');

        $layer_ids = OfficeLayer::whereIn('custom_layer_id', $custom_layers)->where('active_status', 1)->pluck('id');

        $offices = Office::where('active_status', 1)->select('id', 'office_name_bng', 'office_name_eng')->whereIn('office_layer_id', $layer_ids)->get();

        return view('employeofficemanagement.select_office', compact('offices'));
    }

    public function loadOfficeOriginLayerLevelWise(Request $request)
    {
        $custom_layers = OfficeCustomLayer::where('layer_level', $request->office_layer_id)->pluck('id');
        $layer_ids = OfficeLayer::whereIn('custom_layer_id', $custom_layers)->where('active_status', 1)->pluck('id');
        $office_origins = OfficeOrigin::where('active_status', 1)->whereIn('office_layer_id', $layer_ids)->select('id', 'office_name_bng')->get();
        return view('employeerecord.select_office_origin', compact('office_origins'));
    }

    public function loadCustomLevelWise(Request $request)
    {
        $custom_layers = OfficeCustomLayer::select('id', 'name')->where('layer_level', $request->office_layer_id)->get();
        return view('officecustomlayer.select_office_custom_layer', compact('custom_layers'));
    }

    public function loadOfficeCustomLayerWise(Request $request)
    {
        $offices = Office::where('active_status', 1)->select('id', 'office_name_bng', 'office_name_eng')->where('custom_layer_id', $request->custom_layer_id)->get();
        return view('employeofficemanagement.select_office', compact('offices'));
    }
}
