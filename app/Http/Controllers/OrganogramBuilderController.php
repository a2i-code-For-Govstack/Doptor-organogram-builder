<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\OfficeMinistry;
use App\Models\OfficeOriginUnit;
use Illuminate\Http\Request;

class OrganogramBuilderController
{
    public function index()
    {
        $divisions = Bivag::all();
        $ministries = OfficeMinistry::all();
        return view('organogram-builder.index', compact('divisions', 'ministries'));
    }

    public function loadOfficeOriginUnitOrganogramTreeForOrganogramBuilder(Request $request)
    {
        $origin_id = $request->office_origin_id;
        $office_origin_units = OfficeOriginUnit::where('office_origin_id', $origin_id)->with('originOrganograms')->get();
        return view('organogram-builder.office-origin-unit-organogram-tree', compact('office_origin_units'));
    }

}
