<?php

namespace App\Http\Controllers;

use App\Models\OfficeMinistry;
use App\Models\OfficeOriginUnit;
use App\Models\OfficeUnitCategory;
use Illuminate\Http\Request;

class OfficeOriginUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = [];
        $ministries =  OfficeMinistry::where('active_status', 1)->select('id', 'name_bng', 'name_eng')->get();
        $office_unit_category = OfficeUnitCategory::all();
        return view('office_origin_unit', compact('results', 'ministries','office_unit_category'));
    }

    public function loadOfficeOriginUnitTree(Request $request)
    {
        $data = 'office_origin_units';
        $office_ministry_id = $request->office_ministry_id;
        $office_layer_id = $request->office_layer_id;
        $office_origin_id = $request->office_origin_id;
        $results = [];
        $results = OfficeOriginUnit::where('office_ministry_id', $office_ministry_id)->where('office_origin_id', $office_origin_id)->where('parent_unit_id', 0)->where('active_status', 1)->select('id', 'unit_name_bng', 'unit_name_eng')->get();
//         dd($results);

        return view('officeoriginunit.get_origin_unit_tree', compact('results', 'data'));
    }

    public function editOfficeOriginUnit(Request $request)
    {
        return OfficeOriginUnit::where('id', $request->id)->first();
    }

    public function loadParentOfficeOriginUnit(Request $request)
    {
        $origin_units = OfficeOriginUnit::select('id', 'parent_unit_id', 'unit_name_bng', 'unit_name_eng')
            ->where('office_ministry_id', $request->office_ministry_id)
            ->where('office_layer_id', $request->office_layer_id)
            ->where('office_origin_id', $request->office_origin_id)
            ->get();
        return view('officeoriginunit.select_origin_unit', compact('origin_units'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validAttribute = request()->validate([
            'office_unit_category' => 'required|string',
            'unit_name_bng' => 'required|string',
            'unit_name_eng' => 'required|string',
            'unit_level' => 'nullable',
            'unit_sequence' => 'nullable',
            'office_ministry_id' => 'nullable|numeric',
            'office_origin_id' => 'nullable|numeric',
            'office_layer_id' => 'nullable|numeric',
            'parent_unit_id' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ],[
            'office_unit_category.required' => 'Branch Type Required!',
            'unit_name_bng.required' => 'Other name is required!',
            'unit_name_eng.required' => 'English name is required!',
        ]);

        $validAttribute['unit_level'] = $request->unit_level ? bnToen($request->unit_level) : 0;
        $validAttribute['unit_sequence'] = $request->unit_sequence ? bnToen($request->unit_sequence) : 0;

        if(isset($request->active_status)){
            $validAttribute['active_status'] = $request->active_status;
        }else{
            $validAttribute['active_status'] = 0;
        }

        if (!empty($request->input('id')) && $request->id != 0) {
            $office_origin_unit = OfficeOriginUnit::find($request->id);
            $office_origin_unit->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {

            // dd($request->total_insert);
            for ($i=0; $i < $request->total_insert; $i++) {
                OfficeOriginUnit::create($validAttribute);
            }
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeOriginUnit  $officeOriginUnit
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeOriginUnit $officeOriginUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeOriginUnit  $officeOriginUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeOriginUnit $officeOriginUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeOriginUnit  $officeOriginUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeOriginUnit $officeOriginUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeOriginUnit  $officeOriginUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeOriginUnit $officeOriginUnit)
    {
        //
    }
}
