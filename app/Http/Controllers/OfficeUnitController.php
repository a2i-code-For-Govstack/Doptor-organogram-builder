<?php

namespace App\Http\Controllers;

use App\Models\EmployeeOffice;
use App\Models\Office;
use App\Models\OfficeMinistry;
use App\Models\OfficeOriginUnit;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitInformation;
use App\Models\OfficeUnitOrganogram;
use App\Models\UnitUpdateHistory;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OfficeUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $ministries = OfficeMinistry::get();
        return view('office_unit', compact('ministries'));
    }

    public function loadOfficeOriginByCurrentOffice(Request $request): \Illuminate\Http\JsonResponse
    {
        $office_id = $request->office_id ?: Auth::user()->current_office_id();
        $office_origin_id = Office::where('id', $office_id)->pluck('office_origin_id');
        return response()->json(['status' => 'success', 'msg' => 'office origin found', 'data' => $office_origin_id]);
    }

    public function loadOfficeOriginUnitTree(Request $request)
    {
        $data = 'office_origin_units';
        $office_id = $request->office_id;
        $results = OfficeOriginUnit::with('child')->where('office_origin_id', $request->office_origin_id)
            ->where('parent_unit_id', 0)
            ->where('active_status', 1)
            ->orderBy('unit_level', 'asc')
            ->orderBy('unit_sequence', 'asc')
            ->get();
        return view('officeunit.get_office_origin_unit_tree', compact('results', 'data', 'office_id'));
    }

    public function loadOfficeUnitTree(Request $request)
    {
        $results = OfficeUnit::where('office_id', $request->office_id)
            ->where('parent_unit_id', 0)
            ->where('active_status', 1)
            ->orderBy('unit_level', 'asc')
            ->get();

        return view('officeunit.get_office_unit_tree', compact('results'));
    }

    public function generateOriginTreeData(Request $request)
    {
        $office_id = $request->office_id;
        $origin_unit_ids = $request->checked_id;

        $office = Office::find($office_id);
        $ministry_id = $office->office_ministry_id;
        $office_layer_id = $office->office_layer_id;

        $exist = [];
        $notExist = [];
        foreach ($origin_unit_ids as $id) {
            $isExisting = OfficeUnit::where('office_origin_unit_id', $id)
                ->where('office_id', $office_id)
                ->where('active_status', 1)
                ->orderBy('unit_level')
                ->first();

            $origin_unit = OfficeOriginUnit::find($id);

            if ($id !== 0 && !empty($isExisting)) {
                $exist[] = $isExisting->name_bng;
                continue;
            } else {
                $notExist[] = $origin_unit->unit_name_bng;
            }

            $isExistingActiveUnit = OfficeUnit::where('office_origin_unit_id', $id)
                ->where('office_id', $office_id)
                ->where('active_status', 0)
                ->first();
            if ($isExistingActiveUnit) {
                $isExistingActiveUnit->active_status = 1;
                $isExistingActiveUnit->update();
                $notExist[] = $isExistingActiveUnit->name_bng;
                continue;
            }

            if (empty($origin_unit)) continue;

            $parents = $origin_unit->getAllParentId();
            asort($parents);

            if (!$this->checkParentUnit($parents, $office_id, $ministry_id, $office_layer_id)) {
                return response(['status' => 'error', 'msg' => 'Parent problem, check again']);
            }

            if (!$this->saveUnit($id, $office_id, $ministry_id, $office_layer_id)) {
                return response(['status' => 'error', 'msg' => 'Unit problem, check again']);
            }
        }

        return response(['status' => 'success', 'send' => implode(', ', $notExist), 'not_send' => implode(', ', $exist)]);
    }

    private function checkParentUnit($parents, $office_id, $ministry_id, $office_layer_id)
    {
        if (!empty($parents)) {
            foreach ($parents as $key => $value) {
                if ($value == 0) continue;
                $isExisting = OfficeUnit::where('office_origin_unit_id', $value)
                    ->where('office_id', $office_id)
                    ->where('active_status', 1)
                    ->first();
                if (!empty($isExisting)) {
                    continue;
                }
                if (!$this->saveUnit($value, $office_id, $ministry_id, $office_layer_id)) {
                    return false;
                }
            }
        }
        return true;
    }

    private function saveUnit($originId, $office_id, $ministry_id, $office_layer_id)
    {
        try {
            if (!empty($originId)) {
                $office_unit_data = OfficeOriginUnit::find($originId);

                $isExisting = OfficeUnit::where('office_origin_unit_id', $originId)
                    ->where('office_id', $office_id)
                    ->where('active_status', 1)
                    ->first();

                if (!empty($isExisting)) {
                    return true;
                }

                $parentUnit = OfficeUnit::where('office_origin_unit_id', $office_unit_data['parent_unit_id'])
                    ->where('office_id', $office_id)
                    ->where('active_status', 1)
                    ->first();

                $office_unit['office_id'] = $office_id;
                $office_unit['office_origin_unit_id'] = $originId;
                $office_unit['office_ministry_id'] = $ministry_id;
                $office_unit['office_layer_id'] = $office_layer_id;
                $office_unit['unit_name_bng'] = $office_unit_data['unit_name_bng'];
                $office_unit['unit_name_eng'] = $office_unit_data['unit_name_eng'];
                $office_unit['office_unit_category'] = $office_unit_data['office_unit_category'];
                $office_unit['parent_origin_unit_id'] = $office_unit_data['parent_unit_id'];
                $office_unit['unit_level'] = $office_unit_data['unit_level'];
                $office_unit['parent_unit_id'] = empty($parentUnit) ? 0 : $parentUnit['id'];
                $office_unit['created_by'] = auth()->id();
                $office_unit['modified_by'] = auth()->id();

                $created_office_unit = OfficeUnit::create($office_unit);
                $created_office_unit['email'] = '';
                $created_office_unit['fax'] = '';
                $created_office_unit['phone'] = '';
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return false;
        }

        return true;
    }

    public function generateOfficeTreeData(Request $request)
    {
        // keu assign ase kina bortomane {1} employee_office  status  1
        // keu ageee assign silo kina -> employee_office  status  0
        // if -> status 0 -> office_unit_organogram will be updated with status 0
        // if not assigned -> office_unit_organogram will be deleted

        //        dd($request->checked_id);

        DB::beginTransaction();
        try {
            $org_ids = $request->checked_id;
            $office_id = $request->office_id;
            $exist_array = array();
            $not_exist_array = array();
            foreach (array_filter($org_ids) as $org_id) {
                $assing_employee = EmployeeOffice::where('office_unit_id', $org_id)->where('status', 1)->first();
                if ($assing_employee) {
                    $exist_array[] = $assing_employee->unit_name_bn;
                } else {
                    $not_exist_array[] = $org_id;
                }
            }

            $delete_orgs = array();
            foreach ($not_exist_array as $not_exist) {
                $inActive = $this->inactiveCheck($not_exist);
                if ($inActive) {
                    $unit = OfficeUnit::find($not_exist);
                    $unit->active_status = 0;
                    $unit->update();
                    $delete_orgs[] = $unit->unit_name_bng;
                }
                $notExist = $this->notExistCheck($not_exist);
                if ($notExist) {
                    $unit = OfficeUnit::find($not_exist);
                    $unit->delete();
                    $delete_orgs[] = $unit->unit_name_bng;
                }
            }
            DB::commit();
            return response(['status' => 'success', 'delete' => implode(', ', $delete_orgs), 'not_delete' => implode(', ', $exist_array)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => 'Update failed.', 'data' => $e]);
        }
    }

    public function inactiveCheck($unit_id)
    {
        $isNotExistEmployees = EmployeeOffice::where('office_unit_id', $unit_id)->where('status', 1)->doesntExist();
        $isNotExistOrgs = OfficeUnitOrganogram::where('office_unit_id', $unit_id)->where('status', 1)->doesntExist();
        $isExistParent = OfficeUnit::where('parent_unit_id', $unit_id)->doesntExist();
        if ($isNotExistEmployees && $isNotExistOrgs && $isExistParent) {
            return true;
        }
        return false;
    }

    public function notExistCheck($unit_id)
    {
        $isNotExistEmployees = EmployeeOffice::where('office_unit_id', $unit_id)->doesntExist();
        $isNotExistOrgs = OfficeUnitOrganogram::where('office_unit_id', $unit_id)->doesntExist();
        $isExistParent = OfficeUnit::where('parent_unit_id', $unit_id)->doesntExist();
        if ($isNotExistEmployees && $isNotExistOrgs && $isExistParent) {
            return true;
        }
        return false;
    }

    public function renameUnit()
    {
        return view('officeunit.rename_unit');
    }

    public function renameUnitTracking()
    {
        return view('officeunit.rename_unit_tracking');
    }

    public function generateRenameUnitEexcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $office_id = Auth::user()->current_office_id();
        $office_units = OfficeUnit::where('office_id', $office_id)->orderBy('unit_level')->get();

        $sheet->setCellValue('A1', 'Higher Unit');
        $sheet->setCellValue('B1', 'Unit Name (Bangla)');
        $sheet->setCellValue('C1', 'Unit Name (English)');

        $count = 2;
        foreach ($office_units as $key => $unit) {
            // $sheet->setCellValue('A' . $count, @$unit->parent_unit_id->unit_id->unit_name_bng);
            if ($unit->parent_unit_id)
                $sheet->setCellValue('A' . $count, $unit->unit_name_bng);
            else
                $sheet->setCellValue('A' . $count, '');

            $sheet->setCellValue('B' . $count, $unit->unit_name_bng);
            $sheet->setCellValue('C' . $count, $unit->unit_name_eng);
            $count++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Unit Name Edit List.xlsx');
        $file_name = 'Unit Name Edit List.xlsx';
        $full_path = url('storage/Unit Name Edit List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function getUnitNameList(Request $request)
    {
        $office_id = $request->office_id ?: Auth::user()->current_office_id();
        $user_organograam_role = $this->getUserOrganogramRole();
        $office_units = OfficeUnit::where('office_id', $office_id)->orderBy('unit_level')->with('parentUnit');
        if ($user_organograam_role == config('menu_role_map.unit_admin')) {
            $office_units = $office_units->where('id', auth()->user()->current_office_unit_id());
        }
        $office_units = $office_units->get();

        $zero_levels = $office_units->where('unit_level', 0);
        $non_zero_levels = $office_units->where('unit_level', '!=', 0);
        $office_units = $non_zero_levels->merge($zero_levels);

        $emptyInfo = $this->checkOfficeAdmin();
        return view('officeunit.get_unit_list', compact('office_units', 'emptyInfo'));
    }

    public function getUnitNameTrackingList(Request $request)
    {
        $office_id = $request->office_id ?: Auth::user()->current_office_id();
        $office_units = OfficeUnit::where('office_id', $office_id)->orderBy('unit_level')->paginate();
        return view('officeunit.get_unit_tracking_list', compact('office_units'));
    }

    public function getOfficeUnit($id)
    {
        $unit_info = OfficeUnit::where('id', $id)->with('active_unit_informations')->first();

        $phones = [];
        $mobiles = [];
        if ($unit_info->active_unit_informations) {
            foreach ($unit_info->active_unit_informations as $key => $value) {
                if ($value->type == 'phone') {
                    $phones[] = $value;
                }
                if ($value->type == 'mobile') {
                    $mobiles[] = $value;
                }
            }
        };

        $info = array('office_id' => $unit_info->office_id, 'unit_id' => $id);
        $unit_list = $this->parentUnitList($info);
        return view('officeunit.get_office_unit', compact('unit_info', 'unit_list', 'phones', 'mobiles'));
    }

    private function parentUnitList($info)
    {
        $unit_list = OfficeUnit::where('office_id', $info['office_id'])->where('id', '!=', $info['unit_id'])->orderBy('unit_level')->get();
        return $unit_list;
    }

    public function officeUnitUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'unit_nothi_code' => 'required|max:3|min:3'
            ], [
                'unit_nothi_code.required' => 'Unit code not given.'
            ]);

            $unit_employee = EmployeeOffice::where('office_unit_id', $request->id)->get();
            $data['status'] = 0;
            EmployeeOffice::where('office_unit_id', $request->id)->update($data);

            $new_employee_offices = [];
            foreach ($unit_employee as $employee) {
                $joining_date = ($employee->joining_date == '0000-00-00 00:00:00' || $employee->joining_date == '0000-00-00') ? null : $employee->joining_date;
                $status_change_date = ($employee->status_change_date == '0000-00-00 00:00:00') ? null : $employee->status_change_date;

                $new_employee_offices[] = [
                    'employee_record_id' => $employee->employee_record_id,
                    'identification_number' => $employee->identification_number,
                    'office_id' => $employee->office_id,
                    'office_unit_id' => $employee->office_unit_id,
                    'office_unit_organogram_id' => $employee->office_unit_organogram_id,
                    'designation' => $employee->designation,
                    'designation_level' => $employee->designation_level,
                    'designation_sequence' => $employee->designation_sequence,
                    'is_default_role' => $employee->is_default_role,
                    'office_head' => $employee->office_head,
                    'summary_nothi_post_type' => $employee->summary_nothi_post_type,
                    'incharge_label' => $employee->incharge_label,
                    'main_role_id' => $employee->main_role_id,
                    'joining_date' => $joining_date,
                    'status' => $employee->status,
                    'status_change_date' => $status_change_date,
                    'show_unit' => $employee->show_unit,
                    'designation_en' => $employee->designation_en,
                    'unit_name_bn' => $request->unit_name_bng,
                    'unit_name_en' => $request->unit_name_eng,
                    'office_name_bn' => $employee->office_name_bn,
                    'office_name_en' => $employee->office_name_en,
                    'protikolpo_status' => $employee->protikolpo_status,
                ];
            }

            $chunks = array_chunk($new_employee_offices, 5);

            foreach ($chunks as $chunk) {
                EmployeeOffice::insert($chunk);
            }

            $unit_info = OfficeUnit::find($request->id);

            $unit_update = new UnitUpdateHistory;
            $unit_update->office_id = $unit_info->office_id;
            $unit_update->office_unit_id = $unit_info->id;
            $unit_update->office_origin_unit_id = $unit_info->office_origin_unit_id;
            $unit_update->parent_unit_id = $unit_info->parent_unit_id;
            $unit_update->old_unit_eng = $unit_info->unit_name_eng;
            $unit_update->old_unit_bng = $unit_info->unit_name_bng;
            $unit_update->unit_bng = $request->unit_name_bng;
            $unit_update->unit_eng = $request->unit_name_eng;
            $unit_update->employee_office_id = 0;
            $unit_update->employee_unit_id = 0;
            $unit_update->employee_designation_id = 0;
            $unit_update->created_by = auth()->id();
            $unit_update->modified_by = auth()->id();
            $unit_update->save();

            $unit_info->unit_name_bng = $request->unit_name_bng;
            $unit_info->unit_name_eng = $request->unit_name_eng;
            $unit_info->email = $request->email;
            $unit_info->phone = bnToen($request->phone);
            $unit_info->fax = bnToen($request->fax);
            $unit_info->mobile = bnToen($request->mobile);
            $unit_info->parent_unit_id = $request->parent_unit_id;
            $unit_info->unit_nothi_code = bnToen($request->unit_nothi_code);
            $unit_info->unit_level = bnToen($request->unit_level);
            $unit_info->save();

            $r_phones = json_decode($request->phones, true);
            $r_mobiles = json_decode($request->mobiles, true);

            $office_unit_infos = [];

            OfficeUnitInformation::where('office_unit_id', $request->id)->update(['status' => 0]);

            foreach ($r_phones as $phone) {
                foreach ($phone as $is_default => $item) {
                    $office_unit_infos[] = [
                        'office_id' => $unit_info->office_id,
                        'office_unit_id' => $request->id,
                        'content' => bnToen($item),
                        'type' => 'phone',
                        'is_default' => $is_default,
                        'status' => 1,
                        'created_by' => auth()->id(),
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                    ];

                }
            }

            foreach ($r_mobiles as $mobile) {
                foreach ($mobile as $is_default => $item) {
                    $office_unit_infos[] = [
                        'office_id' => $unit_info->office_id,
                        'office_unit_id' => $request->id,
                        'content' => bnToen($item),
                        'type' => 'mobile',
                        'is_default' => $is_default,
                        'status' => 1,
                        'created_by' => auth()->id(),
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                    ];
                }
            }

            OfficeUnitInformation::insert($office_unit_infos);

            DB::commit();

            return response(['status' => 'success', 'msg' => '
            Successfully modified unit name.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => '
            It is not possible to correct the name of the unit.', 'data' => $e->getMessage()]);
        }
    }

    public function getOfficeUnitHistory($unit_id)
    {

        $unit_history = UnitUpdateHistory::where('office_unit_id', $unit_id)->get();
        return view('officeunit.get_office_unit_history', compact('unit_history'));
    }

    public function searchUnitByName(Request $request)
    {
        $bangla = $request->bangla;
        $english = $request->english;

        $office_units = OfficeUnit::where('office_id', 53)
            ->where('unit_name_bng', $bangla)
            ->orWhere('unit_name_eng', $english)->get();
        // dd($english);
        return view('officeunit.get_unit_list', compact('office_units'));
    }

    public function officeUnitTransfer()
    {
        $ministries = OfficeMinistry::get();
        return view('officeunit.office_unit_transfer', compact('ministries'));
    }

    public function loadOfficeUnitOfficeWise(Request $request)
    {
        $office_units = OfficeUnit::where('active_status', 1)->orderBy('unit_level')->select('id', 'unit_name_bng')->where('office_id', $request->office_id);

        if ($request->is_unit_admin && $request->unit_id && $request->is_office_admin == 0) {
            $office_units = $office_units->where('id', $request->unit_id);
        }

        $office_units = $office_units->get();

        return view('officeunit.select_office_units', compact('office_units'));
    }
}
