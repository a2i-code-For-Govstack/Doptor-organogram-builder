<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\EmployeeOffice;
use App\Models\Office;
use App\Models\OfficeCustomLayer;
use App\Models\OfficeDomain;
use App\Models\OfficeLayer;
use App\Models\OfficeMinistry;
use App\Models\OfficeOrigin;
use App\Models\OfficeOriginUnit;
use App\Models\OfficeOriginUnitOrganogram;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use App\Models\Union;
use App\Models\UpoZila;
use App\Models\User;
use App\Models\Zila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $ministries = OfficeMinistry::get();
        $bivags = Bivag::select('id', 'division_name_bng')->get();
        return view('office', compact('ministries', 'bivags'));
    }

    public function loadOfficeOriginTree(Request $request)
    {
        $results = [];
        $results = OfficeOrigin::where('office_ministry_id', $request->ministry_id)->where('parent_office_id', 0)->get();
        return view('office.get_office_origin_tree', compact('results'));
    }

    public function getOfficeLayerId(Request $request)
    {
        return OfficeOrigin::where('id', $request->id)->select('office_layer_id')->first();
    }

    public function getCustomLayerId(Request $request)
    {
        return OfficeLayer::where('id', $request->office_layer_id)->select('custom_layer_id')->first();
    }


    public function OfficeOriginData(Request $request)
    {
        $this->validate(
            $request,
            [
                'table' => 'required',
                'id' => 'required'
            ]
        );

        if ($request->table == "office_origin_units") {
            return OfficeOriginUnit::find($request->id);
        }
    }

    public function loadParentOffice(Request $request)
    {
        $parent_office = Office::where('active_status', 1)->where('office_ministry_id', $request->ministry_id)->where('id', '!=', $request->office_id)->get();
        return view('office.select_parent_office', compact('parent_office'));
    }

    public function OfficeOriginRemove(Request $request)
    {
        $this->validate(
            $request,
            [
                'table' => 'required',
                'id' => 'required'
            ]
        );

        if ($request->table == "office_origin_units") {
            if (
                OfficeOriginUnitOrganogram::where('office_origin_unit_id', '=', $request->id)->exists() ||
                OfficeOriginUnit::where('parent_unit_id', '=', $request->id)->exists()
            ) {
                return response(['status' => 'failed', 'msg' => 'Unable to delete Office Basic unit.']);
            } else {
                OfficeOriginUnit::find($request->id)->delete();
                return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
            }
        }
    }


    public function loadOfficeTreeOriginWise(Request $request)
    {
//        dd($request->id);
        $results = [];
        $parent_office_id = Office::where('active_status', 1)->select('parent_office_id')->where('office_origin_id', $request->id)->groupBY('parent_office_id')->distinct()->pluck('parent_office_id');
        // $results = Office::where('active_status', 1)->whereIn('id', $parent_office_id)->get();
        $results = Office::where('active_status', 1)->where('office_origin_id', $request->id)->get();
        return view('office.get_office_tree', compact('results'));
    }


    public function getOfficeInfo(Request $request)
    {
        return Office::findOrFail($request->id);
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

    public function getMinistryAndLayerWiseOfficeSelect(Request $request)
    {
        $office_list = Office::where('active_status', 1)->select('id', 'office_name_bng', 'office_name_eng')->where('office_ministry_id', $request->ministry_id)
            ->where('office_layer_id', $request->office_layer_id)
            ->get();
        return view('office.select_office', compact('office_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validAttribute = request()->validate([
                'geo_division_id' => 'nullable|numeric',
                'geo_district_id' => 'nullable|numeric',
                'geo_upazila_id' => 'nullable|numeric',
                'office_ministry_id' => 'nullable|numeric',
                'office_layer_id' => 'nullable|numeric',
                'custom_layer_id' => 'nullable|numeric',
                'office_origin_id' => 'required|numeric',
                'geo_union_id' => 'nullable|numeric',
                'office_name_eng' => 'required|nullable|string',
                'office_name_bng' => 'required|nullable|string',
                'office_address' => 'required|string',
                'office_phone' => 'nullable|string',
                'office_mobile' => 'nullable|numeric',
                'office_fax' => 'nullable|numeric',
                'office_email' => 'nullable|string',
                'office_web' => "nullable|string|unique:App\Models\Office,office_web,{$request->id}",
                // 'digital_nothi_code' => 'nullable|numeric',
                // 'reference_code' => 'nullable|numeric',
                'parent_office_id' => 'nullable|numeric',
                'created_by' => 'nullable',
                'modified_by' => 'nullable'
            ], [
                'office_name_bng.required' => 'Office name must!',
                'office_name_eng.required' => 'Office name must be English!',
                'office_address.required' => 'Office address required!',
            ]);
            if ($request->id !== null) {
                $office = Office::find($request->id);
                if ($request->id == $request->parent_office_id) {
                    throw new \Exception('Office cannot select itself as a parent.');
                }
                $validAttribute['office_mobile'] = bnToen($request->office_mobile);
                $validAttribute['office_phone'] = bnToen($request->office_phone);
                $office->update($validAttribute);
                return response(['status' => 'success', 'msg' => 'Successfully updated.']);
            } else {
                $validAttribute['office_mobile'] = bnToen($request->office_mobile);
                $validAttribute['office_phone'] = bnToen($request->office_phone);
                $office = Office::create((array)$validAttribute);
                return response(['status' => 'success', 'msg' => 'Completed successfully.']);
            }
        } catch (\Exception $e) {
            return response(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Office $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Office $office
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function officeEdit()
    {
        $office_id = Auth::user()->current_office_id();
        $office_info = Office::find($office_id);
        if ($office_id) {
            $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
            $districts = Zila::select('district_name_bng', 'id', 'bbs_code')->where('geo_division_id', $office_info->geo_division_id)->get();
            $upzilas = UpoZila::select('upazila_name_bng', 'id', 'bbs_code')->where('geo_district_id', $office_info->geo_district_id)->get();
            $unions = Union::select('union_name_bng', 'id', 'bbs_code')->where('geo_upazila_id', $office_info->geo_upazila_id)->get();
        } else {
            $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
            $districts = Zila::select('district_name_bng', 'id', 'bbs_code')->get();
            $upzilas = UpoZila::select('upazila_name_bng', 'id', 'bbs_code')->get();
            $unions = Union::select('union_name_bng', 'id', 'bbs_code')->get();
        }
        $emptyInfo = $this->checkOfficeAdmin();
        return view('office.edit_office', compact('office_info', 'bivags', 'districts', 'upzilas', 'unions', 'emptyInfo'));
    }

    public function getOfficeWiseEditList(Request $request)
    {
        $office_id = $request->office_id;
        $office_info = [];
        $bivags = [];
        $districts = [];
        $upozilas = [];
        $unions = [];
        if (!empty($office_id)) {
            try {
                $office_info = Office::find($office_id);
                $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
                $districts = Zila::select('district_name_bng', 'id', 'bbs_code')->where('geo_division_id', $office_info->geo_division_id)->get();
                $upozilas = UpoZila::select('upazila_name_bng', 'id', 'bbs_code')->where('geo_district_id', $office_info->geo_district_id)->get();
                $unions = Union::select('union_name_bng', 'id', 'bbs_code')->where('geo_upazila_id', $office_info->geo_upazila_id)->get();
            } catch (\Throwable $th) {
                return response('There has been a mechanical error! Please contact the support team.');
            }
        }
        return view('office.get_office_wise_edit_list', compact('office_info', 'bivags', 'districts', 'upozilas', 'unions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Office $office
     * @return \Illuminate\Http\Response
     */
    public function officeUpdate(Request $request)
    {
        $validAttribute = request()->validate([
            'geo_division_id' => 'nullable',
            'geo_district_id' => 'nullable',
            'geo_upazila_id' => 'nullable',
            'geo_union_id' => 'nullable',
            'office_name_eng' => 'required|nullable|string',
            'office_name_bng' => 'required|nullable|string',
            'office_address' => 'nullable|string',
            'office_phone' => 'nullable|string',
            'office_mobile' => 'nullable|string',
            'office_fax' => 'nullable|string',
            'office_email' => 'nullable|string',
            'office_web' => 'nullable|string',
            'digital_nothi_code' => 'nullable',
            'reference_code' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);

        if (!empty($request->office_email)) {
            if (filter_var($request->office_email, FILTER_VALIDATE_EMAIL) !== false || '') {
                $this->officeInfoUpdate($validAttribute, $request);
                return response(['status' => 'success', 'msg' => 'Successfully updated.']);
            } else {
                return response(['status' => 'errors', 'msg' => 'Your e-mail is incorrect!']);
            }
        } else {
            $this->officeInfoUpdate($validAttribute, $request);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        }
    }

    private function officeInfoUpdate($validAttribute, $request)
    {
        $data = $validAttribute;
        $data['office_mobile'] = bnToen($request->office_mobile);
        $data['office_phone'] = bnToen($request->office_phone);
        $data['office_fax'] = bnToen($request->office_fax);
        $data['digital_nothi_code'] = bnToen($request->digital_nothi_code);
        $office = Office::find($request->id);
        $office->update($data);
        $this->nothiOfficeSync('UPDATE', $office->toArray());
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Office $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $office_info = Office::find($request->id);
            $employee_office = EmployeeOffice::where('office_id', $request->id)->first();
            if (count($office_info->child) > 0 || $employee_office) {
                return response(['status' => 'error', 'msg' => 'There are other offices or officers under this office']);
            } else {
                Office::find($request->id)->delete();
            }
            DB::commit();
            return response(['status' => 'success', 'msg' => 'Office has been canceled successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => 'It was not possible to cancel the office.', 'data' => $e]);
        }
    }

    public function officeList(Request $request)
    {
        $officeIds = $request->office_ids;
        $officeName = $request->office_name;
        $activeOffice = $request->office_search;
        $activeMapping = $request->custom_layer;
        $unitAndOrg = $request->unit_and_org;
        $ministry_id = $request->ministry_search;
        $orgin_id = $request->origin_search;

        $officeTable = Office::select('id', 'office_ministry_id', 'office_layer_id', 'custom_layer_id', 'office_origin_id', 'office_name_bng', 'active_status');
        $offices = [];
        if (!empty($officeIds)) {
            $office_ids = explode(",", $officeIds);
            $officeInformations = $officeTable->whereIn('id', $office_ids);
        }
        if (!empty($officeName)) {
            $officeInformations = $officeTable->where('office_name_bng', 'LIKE', '%' . $officeName . '%');
        } elseif ($activeOffice == 'active_office') {
            $officeInformations = $officeTable->where('active_status', 1);
        } elseif ($activeOffice == 'inactive_office') {
            $officeInformations = $officeTable->where('active_status', 0);
        } elseif ($activeMapping == 'active_custom_layer') {
            $officeInformations = $officeTable->with('custom_layer')->has('custom_layer');
        } elseif ($activeMapping == 'inactive_custom_layer') {
            $officeInformations = $officeTable->with('custom_layer')->doesnthave('custom_layer');
        } elseif ($unitAndOrg == 'unit_search') {
            $officeInformations = $officeTable->with('office_units')->doesnthave('office_units');
        } elseif ($unitAndOrg == 'org_search') {
            $officeInformations = $officeTable->with('office_unit_organograms')->doesnthave('office_unit_organograms');
        } elseif (!empty($ministry_id)) {
            $officeInformations = $officeTable->where('office_ministry_id', $ministry_id);
        } elseif (!empty($orgin_id)) {
            $officeInformations = $officeTable->where('office_origin_id', $orgin_id);
        } else {
            $officeInformations = $officeTable;
        }

        $officeInformations = $officeInformations->with('office_ministry', 'office_layer', 'custom_layer', 'office_origin_list', 'office_domain')
            ->withCount('office_units', 'office_unit_organograms', 'assigned_employees', 'office_domain')
            ->paginate(100);

        $customLayers = OfficeCustomLayer::get();
        $ministries = OfficeMinistry::where('active_status', 1)->get();
        $officeOrigins = OfficeOrigin::get();

        return view('officesetting.office_list', compact('officeInformations', 'customLayers', 'ministries', 'officeOrigins'));
    }

    public function getOfficeMappingInfo(Request $request)
    {
        $office_id = $request->office_id;
        $officeDomainTable = OfficeDomain::where('office_id', $office_id)->first();
        $officeTable = Office::find($office_id);
        $officeName = $officeTable->office_name_bng;
        return response(['status' => '200', 'office_name' => $officeName, 'data' => $officeDomainTable]);
    }

    public function loadOfficeStatistics()
    {
        $office_id = Auth::user()->current_office_id();

        if (Auth::user()->user_role_id == config('menu_role_map.user')) {
            $offices_table = new Office();
            $totalOffices = $offices_table->where('id', $office_id)
                ->count();
            $activeOffices = $offices_table->where('active_status', 1)
                ->where('id', $office_id)
                ->count();
            $inactiveOffices = $offices_table->where('active_status', 0)
                ->where('id', $office_id)
                ->count();
        } else {
            $offices_table = new Office();
            $totalOffices = $offices_table->count();
            $activeOffices = $offices_table->where('active_status', 1)->count();
            $inactiveOffices = $offices_table->where('active_status', 0)->count();
        }
        return response(['status' => '200', 'total_offices' => $totalOffices, 'active_offices' => $activeOffices, 'inactive_offices' => $inactiveOffices]);
    }

    public function loadUnitStatistics()
    {
        $office_id = Auth::user()->current_office_id();
        $unit_id = Auth::user()->current_office_unit_id();

        if (Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin')) {

            $units_table = new OfficeUnit();
            $toalUnits = $units_table->where('office_id', $office_id)
                ->count();
            $activeUnits = $units_table->where('active_status', 1)
                ->where('office_id', $office_id)
                ->count();
            $inactiveUnits = $units_table->where('active_status', 0)
                ->where('office_id', $office_id)
                ->count();

        } elseif (Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.unit_admin')) {

            $units_table = new OfficeUnit();
            $toalUnits = $units_table->where('id', $unit_id)
                ->count();
            $activeUnits = $units_table->where('active_status', 1)
                ->where('id', $unit_id)
                ->count();
            $inactiveUnits = $units_table->where('active_status', 0)
                ->where('id', $unit_id)
                ->count();
        } else {
            $units_table = new OfficeUnit();
            $toalUnits = $units_table->count();
            $activeUnits = $units_table->where('active_status', 1)->count();
            $inactiveUnits = $units_table->where('active_status', 0)->count();
        }
        return response(['status' => '200', 'total_units' => $toalUnits, 'active_units' => $activeUnits, 'inactive_units' => $inactiveUnits]);
    }

    public function loadOrganogramStatistics()
    {
        $office_id = Auth::user()->current_office_id();
        $unit_id = Auth::user()->current_office_unit_id();

        if (Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin')) {

            $office_unit_organogram_table = new OfficeUnitOrganogram();
            $totalOrganograms = $office_unit_organogram_table->where('office_id', $office_id)
                ->count();
            $activeOrganograms = $office_unit_organogram_table->where('status', 1)
                ->where('office_id', $office_id)
                ->count();
            $inactiveOrganograms = $office_unit_organogram_table->where('status', 0)
                ->where('office_id', $office_id)
                ->count();

            $assignOrganograms = EmployeeOffice::where('status', 1)
                ->where('office_id', $office_id)
                ->count();

        } elseif (Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.unit_admin')) {

            $office_unit_organogram_table = new OfficeUnitOrganogram();
            $totalOrganograms = $office_unit_organogram_table->where('office_unit_id', $unit_id)
                ->count();
            $activeOrganograms = $office_unit_organogram_table->where('status', 1)
                ->where('office_unit_id', $unit_id)
                ->count();
            $inactiveOrganograms = $office_unit_organogram_table->where('status', 0)
                ->where('office_unit_id', $unit_id)
                ->count();

            $assignOrganograms = EmployeeOffice::where('status', 1)
                ->where('office_unit_id', $unit_id)
                ->count();
        } else {
            $assignOrganograms = EmployeeOffice::where('status', 1)->count();
            $totalOrganogramsGroup = OfficeUnitOrganogram::select('status', DB::raw('count(1) as total'))->groupBy('status')->pluck('total', 'status');
            $activeOrganograms = isset($totalOrganogramsGroup[1]) ? $totalOrganogramsGroup[1] : 0;
            $inactiveOrganograms = isset($totalOrganogramsGroup[0]) ? $totalOrganogramsGroup[0] : 0;
            $totalOrganograms = $inactiveOrganograms + $activeOrganograms;
        }
        return response(['status' => '200', 'total_organograms' => $totalOrganograms, 'active_organograms' => $activeOrganograms, 'inactive_organograms' => $inactiveOrganograms, 'assign_organograms' => $assignOrganograms]);
    }

    public function loadAllUsers()
    {
        $users_table = User::select('active', DB::raw('count(1) as total'))->groupBy('active')->pluck('total', 'active');
        $active_users = isset($users_table[1]) ? $users_table[1] : 0;
        $inactive_users = isset($users_table[0]) ? $users_table[0] : 0;
        $total_users = $active_users + $inactive_users;
        return response(['status' => '200', 'total_users' => $total_users, 'active_users' => $active_users, 'inactive_users' => $inactive_users]);
    }
}
