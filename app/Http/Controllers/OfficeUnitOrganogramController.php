<?php

namespace App\Http\Controllers;

use App\Models\DesignationUpdateHistory;
use App\Models\EmployeeOffice;
use App\Models\OfficeMinistry;
use App\Models\OfficeOriginUnitOrganogram;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use App\Services\CoreTransferServices;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OfficeUnitOrganogramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $ministries = Cache::remember('office-ministry', 60 * 60 * 24, function () {
            return OfficeMinistry::get();
        });
        return view('office_unit_organogram', compact('ministries'));
    }


    public function loadOriginUnitOrganogramTree(Request $request)
    {
        $results = [];
        $opeded_origin_node = [];
        if ($request->opeded_origin_node) {
            $opeded_origin_node = $request->opeded_origin_node;
        }
        //$results = OfficeOriginUnit::where('office_origin_id',$request->office_origin_id)
        $results = OfficeUnit::with(['child'])->where('office_id', $request->office_id)
            ->where('parent_unit_id', 0)
            ->where('active_status', 1)
            ->orderBy('unit_level')
            ->get();

        return view('officeunitorganogram.get_office_origin_unit_organogram_tree', compact('results', 'opeded_origin_node'));
    }

    public function loadUnitOrganogramTree(Request $request)
    {
        $results = [];
        $opeded_unit_node = [];
        if ($request->opeded_unit_node) {
            $opeded_unit_node = $request->opeded_unit_node;
        }

        $results = OfficeUnit::with(['child.active_organograms', 'active_organograms'])->where('office_id', $request->office_id)
            ->where('parent_unit_id', 0)
            ->where('active_status', 1)
            ->orderBy('unit_level')
            ->get();

        return view('officeunitorganogram.get_office_unit_organogram_tree', compact('results', 'opeded_unit_node'));
    }

    public function load_unit_organogram_tree_view(Request $request)
    {
        $office_id = $request->office_id;
        $results = [];
        try {
            if (!empty($office_id)) {
                $results = OfficeUnit::where('office_id', $request->office_id)
                    ->where('parent_unit_id', 0)
                    ->where('active_status', 1)
                    ->get();
            }
        } catch (\Throwable $th) {
            return response("There has been a mechanical error! Please contact the support team.");
        }

        return view('officeunitorganogram.get_office_unit_organogram_tree_view', compact('results'));
    }

    public function generateOriginOrganogramTreeData(Request $request)
    {
        \Validator::make($request->all(), [
            'office_id' => 'required|integer',
        ])->validate();

        if (empty($request->checked_id)) {
            return response(['status' => 'error', 'msg' => 'The designations already exist in the office branch.']);
        }

        $response = array('status' => 'error', 'msg' => 'A mechanical error has occurred.');
        $org_ids = $request->checked_id;
        $office_id = $request->office_id;

        $final_data = array();
        $err_msg = '';
        foreach ($org_ids as $row) {
            $row_arr = explode("|", $row);
            $office_origin_unit_id = $row_arr[1];
            $org_id = $row_arr[0];
            // dd($row_arr[1]);
            $existInactiveOrg = OfficeUnitOrganogram::where('office_id', $office_id)
                ->where('ref_origin_unit_org_id', $org_id)
                ->where('status', 0)->first();
            if ($existInactiveOrg) {
                $existInactiveOrg->status = 1;
                $existInactiveOrg->update();
                continue;
            }
            $origin_unit_org = OfficeOriginUnitOrganogram::find($org_id);

            $office_unit = OfficeUnit::where('office_origin_unit_id', $origin_unit_org['office_origin_unit_id'])->where('active_status', 1)
                ->where('office_id', $office_id)->first();
            $office_unit_id = $office_unit->id;
            $previous_org_id_exists = OfficeUnitOrganogram::select('id', 'ref_origin_unit_org_id', 'designation_bng', 'status')
                ->where('office_unit_id', $office_unit_id)
                ->where('ref_origin_unit_org_id', $org_id)
                ->first();
            if (empty($previous_org_id_exists)) {
                $office_org['office_id'] = $office_id;
                $office_org['office_unit_id'] = $office_unit_id;
                $office_org['superior_unit_id'] = 0;
                $office_org['superior_designation_id'] = 0;
                $office_org['ref_sup_origin_unit_id'] = $origin_unit_org['office_origin_unit_id'];
                $office_org['ref_sup_origin_unit_desig_id'] = $origin_unit_org['superior_designation_id'];
                $office_org['ref_origin_unit_org_id'] = $org_id;
                $office_org['designation_bng'] = $origin_unit_org['designation_bng'];
                $office_org['designation_eng'] = $origin_unit_org['designation_eng'];
                $office_org['designation_level'] = $origin_unit_org['designation_level'];
                $office_org['designation_sequence'] = $origin_unit_org['designation_sequence'];
                $office_org['status'] = 1;
                $office_org['short_name_eng'] = $origin_unit_org['designation_eng'];
                $office_org['short_name_bng'] = $origin_unit_org['designation_bng'];
                $office_org['created_by'] = auth()->id();
                $office_org['modified_by'] = auth()->id();

                $final_data[] = OfficeUnitOrganogram::create($office_org);
            } else {
                if ($previous_org_id_exists->status == 0) {
                    $office_org = $previous_org_id_exists->toArray();

                    $office_org['office_id'] = $office_id;
                    $office_org['office_unit_id'] = $office_unit_id;
                    $office_org['superior_unit_id'] = 0;
                    $office_org['superior_designation_id'] = 0;
                    $office_org['ref_sup_origin_unit_id'] = $origin_unit_org['office_origin_unit_id'];
                    $office_org['ref_sup_origin_unit_desig_id'] = $origin_unit_org['superior_designation_id'];
                    $office_org['ref_origin_unit_org_id'] = $org_id;
                    $office_org['designation_bng'] = $origin_unit_org['designation_bng'];
                    $office_org['designation_eng'] = $origin_unit_org['designation_eng'];
                    $office_org['designation_level'] = $origin_unit_org['designation_level'];
                    $office_org['designation_sequence'] = $origin_unit_org['designation_sequence'];
                    $office_org['status'] = 1;
                    $office_org['short_name_eng'] = $origin_unit_org['designation_eng'];
                    $office_org['short_name_bng'] = $origin_unit_org['designation_bng'];
                    $office_org['created_by'] = auth()->id();
                    $office_org['modified_by'] = auth()->id();

                    $final_data[] = OfficeUnitOrganogram::create($office_org);
                } else {
                    $err_msg = $err_msg . $previous_org_id_exists['designation_bng'] . ', ';
                    $response = array('status' => 'error', 'msg' => $err_msg . ' The designation has previously been used in the same branch.');
                }
            }
        }

        foreach ($final_data as $office_designation) {
            $superior_data = OfficeUnitOrganogram::getSuperiorDesignationId($final_data, $office_designation['ref_sup_origin_unit_desig_id']);
            $designation = OfficeUnitOrganogram::find($office_designation['id']);
            $designation->superior_unit_id = $superior_data['unit'];
            $designation->superior_designation_id = $superior_data['designation'];
            $designation->save();
        }
        if (empty($err_msg)) {
            $response = array('status' => 'success', 'msg' => 'Completed successfully.');
        }
        return response($response);
    }

    public function generateOfficeOrganogramTreeData(Request $request)
    {
        // keu assign ase kina bortomane {1} employee_office  status  1
        // keu ageee assign silo kina -> employee_office  status  0
        // if -> status 0 -> office_unit_organogram will be updated with status 0
        // if not assigned -> office_unit_organogram will be deleted

        DB::beginTransaction();
        try {
            $org_ids = $request->checked_id;
            $office_id = $request->office_id;
            $exist_array = array();
            $not_exist_array = array();
            foreach ($org_ids as $org_id) {
                $assing_employee = EmployeeOffice::where('office_unit_organogram_id', $org_id)->where('status', 1)->first();
                if ($assing_employee) {
                    $exist_array[] = $assing_employee->designation;
                } else {
                    $not_exist_array[] = $org_id;
                }
            }

            $delete_orgs = array();
            foreach ($not_exist_array as $not_exist) {
                $inactive_employee = EmployeeOffice::where('office_unit_organogram_id', $not_exist)->where('status', 0)->first();
                if ($inactive_employee) {
                    $org = OfficeUnitOrganogram::find($not_exist);
                    $org->status = 0;
                    $org->update();
                    $delete_orgs[] = $org->designation_bng;
                } else {
                    $org = OfficeUnitOrganogram::find($not_exist);
                    $organogram = $org->toArray();
                    $organogram['status'] = 0;
                    $org->delete();
                    $delete_orgs[] = $org->designation_bng;
                }


            }

            DB::commit();
            return response(['status' => 'success', 'delete' => implode(', ', $delete_orgs), 'not_delete' => implode(', ', $exist_array)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => '
            Update failed.', 'data' => $e]);
        }
    }

    public function renameOfficeDesignation()
    {
        // $office_designations = OfficeUnitOrganogram::where('office_id',53)->get();
        return view('officeunitorganogram.rename_office_designation');
    }

    public function renameOfficeDesignationTracking()
    {

        return view('officeunitorganogram.rename_office_designation_tracking');
    }

    public function getOfficeDesignationList(Request $request)
    {
        $office_unit_id = $request->office_unit_id;
        $office_designations = OfficeUnitOrganogram::where('office_unit_id', $office_unit_id)->where('status', 1)->with('assigned_user.employee_record')->orderBy('designation_level', 'ASC')->orderBy('designation_sequence', 'ASC')->get();
        return view('officeunitorganogram.get_office_designation_list', compact('office_designations'));
    }

    public function getOfficeDesignationTrackList(Request $request)
    {
        $office_unit_id = $request->office_unit_id;
        $office_designations = OfficeUnitOrganogram::where('office_unit_id', $office_unit_id)
            ->orderBy('designation_level', 'ASC')->orderBy('designation_sequence', 'ASC')->get();
        //        dd($office_designations);
        return view('officeunitorganogram.get_office_designation_track_list', compact('office_designations'));
    }

    public function getOfficeDesignation($id)
    {
        $designation_info = OfficeUnitOrganogram::select('designation_eng', 'designation_bng', 'id')->find($id);
        return view('officeunitorganogram.get_office_designation', compact('designation_info'));
    }

    public function getOfficeDesignationHistory($designation_id)
    {

        $designation_history = DesignationUpdateHistory::where('designation_id', $designation_id)->get();
        //        dd($designation_history);
        return view('officeunitorganogram.get_office_designation_history', compact('designation_history'));
    }

    public function officeDesignationUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $designation_id = $request->id;
            $designation_bng = $request->designation_bng;
            $designation_eng = $request->designation_eng;

            $organogram_info = OfficeUnitOrganogram::find($request->id);
            $old_designation_info = json_encode($organogram_info);

            $designation_update_history = new DesignationUpdateHistory();
            $designation_update_history->designation_id = $designation_id;
            $designation_update_history->office_id = $organogram_info->office_id;
            $designation_update_history->office_unit_id = $organogram_info->office_unit_id;
            $designation_update_history->superior_unit_id = $organogram_info->superior_unit_id;
            $designation_update_history->superior_designation_id = $organogram_info->superior_designation_id;
            $designation_update_history->ref_origin_unit_org_id = $organogram_info->ref_origin_unit_org_id;
            $designation_update_history->old_designation_eng = $organogram_info->designation_eng;
            $designation_update_history->old_designation_bng = $organogram_info->designation_bng;

            $designation_update_history->designation_eng = $designation_eng;
            $designation_update_history->designation_bng = $designation_bng;
            $designation_update_history->old_designation_info = $old_designation_info;

            $designation_update_history->employee_office_id = $organogram_info->office_id;
            $designation_update_history->employee_unit_id = $organogram_info->office_unit_id;
            $designation_update_history->employee_designation_id = $organogram_info->id;
            $designation_update_history->created_by = Auth::id();
            $designation_update_history->modified_by = Auth::id();

            $organogram_info->designation_eng = $request->designation_eng;
            $organogram_info->designation_bng = $request->designation_bng;
            $organogram_info->save();
            $designation_update_history->save();

            $assigned_employee = EmployeeOffice::where('office_unit_organogram_id', $designation_id)->where('status', 1)->first();
            if ($assigned_employee) {
                EmployeeOffice::unAssignDesignation($assigned_employee->id, [], 'Edit Designation');
                EmployeeOffice::assignDesignation($assigned_employee->toArray(), [], 'Edit Designation');
            }


            DB::commit();
            return response(['status' => 'success', 'msg' => '
            Successfully updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => '
            Update failed.', 'data' => $e]);
        }
    }

    public function searchofficeDesignation(Request $request)
    {
        $bangla = $request->bangla;
        $english = $request->english;

        $office_designations = OfficeUnitOrganogram::where('designation_bng', $bangla)->orWhere('designation_eng', $english)->get();
        return view('officeunitorganogram.get_office_designation_list', compact('office_designations'));
    }

    public function loadDesignationOfficeUnitWise(Request $request)
    {
        $office_id = $request->office_id;
        $office_unit_id = $request->office_unit_id;

        $office_designations = OfficeUnitOrganogram::select('id', 'designation_bng', 'designation_eng')
            ->where('office_id', $office_id)
            ->where('office_unit_id', $office_unit_id)->get();
        return view('officeunitorganogram.select_organogram', compact('office_designations'));
    }

    public function loadDesignationForAssignEmployee(Request $request)
    {
        $office_id = $request->office_id;
        $office_unit_id = $request->office_unit_id;

        $office_units = OfficeUnit::where('id', $office_unit_id)->where('office_id', $office_id)->get();

        return view('officeunitorganogram.select_organogram_assign_employee', compact('office_units'));
    }


    public function generateRenameOfficeDesignationExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $office_id = Auth::user()->current_office_id();
        $office_designations = OfficeUnitOrganogram::where('office_id', $office_id)->paginate();

        $sheet->setCellValue('A1', 'Designation Name (Bangla)');
        $sheet->setCellValue('B1', 'Designation Name (English)');
        $sheet->setCellValue('C1', 'Unit');
        $sheet->setCellValue('D1', 'Office');

        $count = 2;
        foreach ($office_designations as $key => $desigantion) {
            $sheet->setCellValue('A' . $count, $desigantion->designation_bng);
            $sheet->setCellValue('B' . $count, $desigantion->designation_eng);
            $sheet->setCellValue('C' . $count, $desigantion->office_unit->unit_name_bng);
            $sheet->setCellValue('D' . $count, $desigantion->office_info->office_name_bng);

            $count++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Designation Name Correction List.xlsx');
        $file_name = 'Designation Name Correction List.xlsx';
        $full_path = url('storage/Designation Name Correction List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function designationTreeView(Request $request)
    {
        return view('officeunitorganogram.designation_tree_view');
    }

    public function designationLebel()
    {
        return view('officeunitorganogram.designation_label');
    }

    public function designationLabelList(Request $request)
    {
        $officeId = Auth::user()->current_office_id();
        $unitId = Auth::user()->current_office_unit_id();
        $organogramId = Auth::user()->current_designation_id();
        $currentOfficeOrganogram = OfficeUnitOrganogram::where('id', $organogramId)->first();

        if (Auth::user()->user_role_id == config('menu_role_map.super_admin') || Auth::user()->user_role_id == config('menu_role_map.admin')) {
            $ownOfficeOrgLebel = OfficeUnitOrganogram::with('assigned_user', 'assigned_user.employee_record')
                ->with('assigned_user_level', 'assigned_user_level.designation_user')
                ->with('office_unit_org')
                ->where('office_unit_id', $request->unit_id)
                ->where('status', 1)
                ->orderBy('designation_level')
                ->orderBy('designation_sequence')
                ->get();
        } else {
            if ($currentOfficeOrganogram->is_admin == 1) {
                $ownOfficeOrgLebel = OfficeUnitOrganogram::with('assigned_user', 'assigned_user.employee_record')
                    ->with('assigned_user_level', 'assigned_user_level.designation_user')
                    ->with('office_unit_org')
                    ->where('office_id', $officeId)
                    ->where('status', 1)
                    ->orderBy('designation_level')
                    ->orderBy('designation_sequence')
                    ->get();
            } else {
                $ownOfficeOrgLebel = OfficeUnitOrganogram::with('assigned_user', 'assigned_user.employee_record')
                    ->with('assigned_user_level', 'assigned_user_level.designation_user')
                    ->with('office_unit_org')
                    ->where('office_unit_id', $unitId)
                    ->where('status', 1)
                    ->orderBy('designation_level')
                    ->orderBy('designation_sequence')
                    ->get();
            }
        }
        return view('officeunitorganogram.designation_label_list', compact('ownOfficeOrgLebel'));
    }

    public function saveDesignationLabel(Request $request)
    {
        $validAttribute = request()->validate([
            'designation_level' => 'required|string',
            'designation_sequence' => 'required|string'
        ], [
            'designation_level.required' => 'Designation Layer cannot be left blank.',
            'designation_sequence.required' => 'Designation Sequence cannot be left blank.'
        ]);

        if ($request->id !== null) {
            $org_lebel = OfficeUnitOrganogram::find($request->id);
            $org_lebel->update($validAttribute);
            EmployeeOffice::where('office_unit_organogram_id', $request->id)->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            return response(['status' => 'error', 'msg' => 'Sorry! Save was not possible.']);
        }
    }

    public function loadOrgWiseData(Request $request)
    {
        $office_organograms = OfficeUnitOrganogram::where('office_unit_id', $request->unit_id)
            ->where('status', 1)->get();
        return view('officelayer.select_office_organogram', compact('office_organograms'));
    }

    public function transferDesignation(Request $request)
    {
        return view('officeunitorganogram.transfer_designation');
    }

    public function loadOfficeWiseUnitWithOrganogramTree(Request $request)
    {
        $results = OfficeUnit::query();

        if ($request->office_unit_id) {
            $type = 'office_unit';
            $results = $results->where('id', $request->office_unit_id);
        }

        if ($request->office_id) {
            $type = '';
            $results = $results->where('office_id', $request->office_id);
        }
        $results = $results->where('active_status', 1)
            ->with('active_organograms')
            ->get();
        return view('officeunitorganogram.load_office_wise_unit_with_organogram_tree', compact('results', 'type'));
    }

    public function fireTransferDesignationAction(Request $request)
    {
        try {
            $validAttribute = request()->validate([
                'designation_ids' => 'array|required',
                'office_unit_id' => 'int|required',
                'office_id' => 'int|required'
            ]);
            $designation_transfer = (new CoreTransferServices())->transferDesignations($request->designation_ids, $request->office_unit_id, $request->office_id);

            return response(['status' => 'success', 'msg' => 'completed successfully.']);
        } catch (\Exception $exception) {
            return response(['status' => 'error', 'msg' => '
            There has been a mechanical error!', 'data' => $exception->getMessage()]);
        }
    }
}
