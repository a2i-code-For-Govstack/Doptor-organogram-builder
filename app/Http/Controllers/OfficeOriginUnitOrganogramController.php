<?php

namespace App\Http\Controllers;

use App\Models\OfficeMinistry;
use App\Models\OfficeOriginUnit;
use App\Models\OfficeOriginUnitOrganogram;
use App\Models\OfficeUnitOrganogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeOriginUnitOrganogramController extends Controller
{
    public function index()
    {
        $ministries = OfficeMinistry::where('active_status', 1)->select('id', 'name_bng', 'name_eng')->get();
        return view('office_origin_unit_organogram', compact('ministries'));
    }


    public function loadOfficeOriginUnitOrganogramTree(Request $request)
    {
        $data = 'office_origin_unit_organograms';
        $office_ministry_id = $request->office_ministry_id;
        $office_origin_id = $request->office_origin_id;
        $results = OfficeOriginUnit::where('office_ministry_id', $office_ministry_id)->where('active_status', 1)->where('office_origin_id', $office_origin_id)->where('parent_unit_id', 0)->select('id', 'unit_name_bng', 'unit_name_eng')->get();
        return view('officeoriginunitorganogram.get_origin_unit_organogram_tree', compact('results', 'data'));
    }


    public function loadUnitWiseOrganogram(Request $request)
    {
        $id = $request->id;
        $unit_organograms = OfficeOriginUnitOrganogram::where('office_origin_unit_id', $request->office_origin_unit_id)->where('id', '!=', $id)->get();
        return view('officeoriginunitorganogram.select_superior_designation', compact('unit_organograms'));
    }

    public function loadOriginWiseUnits(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $unit_organograms = OfficeOriginUnitOrganogram::where('office_origin_unit_id', $request->office_origin_unit_id)->where('id', $id)->get();
        } else {
            $unit_organograms = OfficeOriginUnit::where('id', $request->office_origin_unit_id)->get();
        }
        return view('officeoriginunitorganogram.select_superior_unit', compact('unit_organograms'));
    }

    public function store(Request $request)
    {
        $validAttribute = request()->validate([
            'office_origin_unit_id' => 'nullable|numeric',
            'superior_unit_id' => 'nullable|numeric',
            'superior_designation_id' => 'nullable|numeric',
            'designation_eng' => 'required|string',
            'designation_bng' => 'required|string',
            'short_name_eng' => 'nullable|string',
            'short_name_bng' => 'nullable|string',
            'designation_level' => 'required',
            'designation_sequence' => 'required',
            'status' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ], [
            'designation_bng.required' => 'Designation Name Required',
            'designation_eng.required' => 'Designation English Name Required',
            'designation_level.required' => 'Designation layer Required',
            'designation_sequence.required' => 'Designation Sequence Required',
        ]);

        $validAttribute['designation_level'] = $request->designation_level ? bnToen($request->designation_level) : 999;
        $validAttribute['designation_sequence'] = $request->designation_sequence ? bnToen($request->designation_sequence) : 999;
        $totalInsert = bnToen($request->total_insert);

        $office_unit_org = OfficeUnitOrganogram::where('ref_origin_unit_org_id', $request->id)->count();
        if ($office_unit_org == 0 || $validAttribute['superior_unit_id'] == $validAttribute['office_origin_unit_id']) {
            if ($request->id !== null) {
                $office_origin_unit_organogram = OfficeOriginUnitOrganogram::find($request->id);
                $office_origin_unit_organogram->update($validAttribute);
                return response(['status' => 'success', 'msg' => 'The basic branch organizational structure has been edited successfully.']);
            } else {

                // $request->total_insert = 2;

                for ($i = 0; $i < $totalInsert; $i++) {
                    OfficeOriginUnitOrganogram::create($validAttribute);
                }


                return response(['status' => 'success', 'msg' => '
                The organizational structure of the basic branch has been successfully completed.']);
            }
        } else {
            return response(['status' => 'error', 'msg' => 'As the designation is transferred to the office unit, it is not possible to change the unit!']);
        }
    }


    public function editOfficeOriginUnitOrganogram(Request $request)
    {
        return OfficeOriginUnitOrganogram::where('id', $request->id)->first();
    }


    public function deleteOfficeOriginUnitOrganogram(Request $request)
    {
        $originUnitOrganogramId = $request->office_origin_organogram_id;

        $isUsedInUnit = OfficeUnitOrganogram::where('ref_origin_unit_org_id', $originUnitOrganogramId)->first();
        $hasChild = OfficeOriginUnitOrganogram::where('superior_designation_id', $originUnitOrganogramId)->first();

        if ($isUsedInUnit || $hasChild) {
            return response(['status' => 'error', 'msg' => 'The designation is used or has a subordinate designation.']);
        } else {
            DB::beginTransaction();
            try {
                OfficeOriginUnitOrganogram::find($originUnitOrganogramId)->delete();
                DB::commit();
                return response(['status' => 'success', 'msg' => 'Delete Successfully.']);
            } catch (\Exception $e) {
                DB::rollback();
                return response(['status' => 'error', 'msg' => 'Delete failed.', 'data' => $e]);
            }

        }
    }
}
