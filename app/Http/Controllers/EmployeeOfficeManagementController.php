<?php

namespace App\Http\Controllers;

use App\Models\EmployeeOffice;
use App\Models\EmployeeRecord;
use App\Models\Office;
use App\Models\OfficeInchargeType;
use App\Models\OfficeMinistry;
use App\Models\OfficeOrigin;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class EmployeeOfficeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $ministries = OfficeMinistry::where('active_status', 1)->select('id', 'name_bng', 'name_eng')->get();

        return view('employe_office_management', compact('ministries'));
    }

    public function nidTracking()
    {
        $ministries = OfficeMinistry::where('active_status', 1)->select('id', 'name_bng', 'name_eng')->get();

        return view('employe_office_management_nid_tracking', compact('ministries'));
    }

    public function getEmployeeInfo(Request $request)
    {
        $user = '';

        if ($request->username != '') {
            $username = $request->username;
            $username = substr($username, 0, 1) . str_pad(substr($username, 1), 11, 0, STR_PAD_LEFT);
            $user = User::where('username', $username)->select('employee_record_id')->first();
            if ($user) {
                $employee_info = EmployeeRecord::where('id', $user->employee_record_id)->first();
            } else {
                $employee_info = [];
            }
        } else {
            $employee_info = EmployeeRecord::query();
            if ($request->nid) {
                $employee_info = $employee_info->where('nid', $request->nid);
            } else if ($request->phone) {
                $employee_info = $employee_info->where('personal_mobile', $request->phone);
            } else if ($request->email) {
                $employee_info = $employee_info->where('personal_email', $request->email);
            }
            $employee_info = $employee_info->first();
        }
        $tracking = $request->tracking == 1;

        $userProfileImage = [];
        if ($employee_info) {
            if (!empty($employee_info->image_file_name)) {
                $userProfileImage = asset($employee_info->image_file_name);
            } else {
                $userProfileImage = (new EmployeeRecord())->userProfileImage($request->username, $employee_info->id);
            }
        }


        return view('employeofficemanagement.get_employee_info', compact('employee_info', 'tracking', 'userProfileImage'));
    }

    public function loadOfficeOriginWise(Request $request)
    {
        $offices = Office::where('active_status', 1)->where('office_origin_id', $request->office_origin_id)->select('id', 'office_name_bng', 'office_name_eng')->get();
        return view('employeofficemanagement.select_office', compact('offices'));
    }

    public function loadUnitOfficeWise(Request $request)
    {
        $units = OfficeUnit::where('active_status', 1)->orderBy('unit_level')->where('office_id', $request->office_id)->select('id', 'unit_name_bng', 'unit_name_eng', 'unit_level')->get();

        $zero_levels = $units->where('unit_level', 0);
        $non_zeo_levels = $units->where('unit_level', '!=', 0)->sortBy('unit_level');

        $units =$non_zeo_levels->merge($zero_levels);

        return view('employeofficemanagement.select_unit', compact('units'));
    }

    public function disableDesignation(Request $request)
    {
        $validAttribute = request()->validate([
            'date' => 'required',
        ], [
            'date.required' => 'Select the last working day date.',
        ]);

        $employee_office_id = $request->office_id;

        EmployeeOffice::unAssignDesignation($employee_office_id, ['last_office_date' => $request->date], 'Employee Unassigned');

        return response(['status' => 'success', 'msg' => 'Successfully updated.']);
    }

    public function loadOfficeWiseUnits(Request $request)
    {
        $office_units = [];
        if (!empty($request->office_id)) {
            $office_units = OfficeUnit::where('active_status', 1)->where('office_id', $request->office_id)
                ->with('office_info')
                ->with('active_organograms.assigned_user.employee_record.user')
                ->with('active_organograms.last_assigned_user.employee_record.user')
                ->orderBy('unit_level')
                ->get();

            $non_zero_levels = $office_units->where('unit_level', '!=', 0)->sortBy('unit_level');
            $zero_levels = $office_units->where('unit_level', 0);
            $office_units = $non_zero_levels->merge($zero_levels);
        }
        $office_incharges = OfficeInchargeType::all();
        return view('employeofficemanagement.load_office_units', compact('office_units', 'office_incharges'));
    }


    public function officeUnitWiseEmployee()
    {
        $office_unit_id = Auth::user()->current_office_unit_id();
        $office_id = Auth::user()->current_office_id();
        $designation_id = Auth::user()->current_designation_id();

        $office = Office::select('office_name_bng')->find($office_id);
        $office_name = $office->office_name_bng;

        $unit_admin = OfficeUnitOrganogram::select('is_unit_admin', 'is_admin')->where('id', $designation_id)->first();
        $office_admin = $unit_admin->is_admin;

        if ($unit_admin->is_unit_admin) {
            $office_units = OfficeUnit::where('id', $office_unit_id)->orderBy('unit_level')->get();
        } else {
            $office_units = OfficeUnit::where('office_id', $office_id)->orderBy('unit_level')->get();
        }

        return view('employeofficemanagement.office_unit_wise_employee', compact('office_id', 'office_admin', 'office_name'));
    }

    public function employeeManagement(Request $request)
    {

        $office_id = $request->office_id;
        $office_unit_id = Auth::user()->current_office_unit_id();
        $designation_id = Auth::user()->current_designation_id();

        $unit_admin = OfficeUnitOrganogram::where('id', $designation_id)->first();

        if ($unit_admin->is_admin) {
            $office_units = OfficeUnit::where('office_id', $office_id);
        } else if ($unit_admin->is_unit_admin) {
            $office_units = OfficeUnit::where('id', $office_unit_id);
        } else {
            $office_units = OfficeUnit::where('office_id', $office_id);
        }

        $office_units = $office_units->with('active_organograms.assigned_user.employee_record.user')
            ->with('active_organograms.last_assigned_user.employee_record.user')
            ->orderBy('unit_level')
            ->get();

        $office_incharges = OfficeInchargeType::all();
        return view('employeofficemanagement.employee_management', compact('office_units', 'office_incharges', 'office_id'));
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
        $validAttribute = request()->validate([
            'joining_date' => 'required',
        ], [
            'joining_date.required' => 'Select joining date',
        ]);


        $exist_employee = EmployeeOffice::where('office_id', $request->office_id)->where('office_unit_id', $request->office_unit_id)->first();

        $employee_office_data = [
            'office_unit_organogram_id' => $request->org_id,
            'office_unit_id' => $request->office_unit_id,
            'office_id' => $request->office_id,
            'designation' => $request->designation_bng,
            'designation_en' => $request->designation_eng,
            'designation_level' => $request->designation_level,
            'designation_sequence' => $request->designation_sequence,
            'unit_name_bn' => $request->unit_name_bn,
            'unit_name_en' => $request->unit_name_en,
            'office_name_bn' => $request->office_name_bng,
            'office_name_en' => $request->office_name_eng,
            'employee_record_id' => $request->employee_record_id,
            'identification_number' => $request->identification_number,
            'is_default_role' => 0,
            'incharge_label' => $request->incharge_label ?: '',
            'status' => 1,
            'joining_date' => date('Y-m-d', strtotime($request->joining_date))
        ];

        EmployeeOffice::assignDesignation($employee_office_data, ['exist_employee' => !is_null($exist_employee)], 'Employee Assign');
        return response(['status' => 'success', 'msg' => 'Successfully updated.']);
    }

    public function loadUnassignOfficeAdmin($org_id)
    {
        $employee_office_info = EmployeeOffice::where('office_unit_organogram_id', $org_id)
            ->where('status', 1)->first();
        return view('release_office_admin_by_own', compact('employee_office_info'));
    }

    public function unassignOfficeAdmin($org_id)
    {
        $employee_office_info = EmployeeOffice::where('office_unit_organogram_id', $org_id)
            ->where('status', 1)->first();
        return view('release_office_admin_own', compact('employee_office_info'));
    }

    public function officeAdminChecking($organogram_id)
    {
        $organogram = OfficeUnitOrganogram::where('id', $organogram_id)->where('is_admin', 1)->exists();
        if ($organogram) {
            return response(['status' => 'success']);
        } else {
            return response(['status' => 'error']);
        }
    }

    public function releaseAssignUser($office_id)
    {
        $organograms = OfficeUnitOrganogram::where('office_id', $office_id)
            ->with('assigned_user', 'assigned_user.designation_user', 'office_unit_org')
            ->with('assigned_user.employee_record', 'office_info')
            ->orderBy('is_admin', 'DESC')
            ->orderBy('designation_level', 'ASC')
            ->orderBy('designation_sequence', 'ASC')
            ->where('status', 1)
            ->get();

        return view('office_wise_user_list', compact('organograms'));
    }
}
