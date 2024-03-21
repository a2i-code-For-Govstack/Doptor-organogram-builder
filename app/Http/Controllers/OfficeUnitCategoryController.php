<?php

namespace App\Http\Controllers;

use App\Models\OfficeUnitCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DB;

class OfficeUnitCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('office_unit_category');
    }
    public function generateOfficeUnitCategoryExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $office_unit_categories = OfficeUnitCategory::all();

        $sheet->setCellValue('A1', 'Type');
        $sheet->setCellValue('B1', 'Type (English)');

        $count = 2;
        foreach ($office_unit_categories as $office_unit_category) {
            $sheet->setCellValue('A' . $count, $office_unit_category->category_name_bng);
            $sheet->setCellValue('B' . $count, $office_unit_category->category_name_eng);
            $count++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('office_unit_category.xlsx');
        $file_name = 'office_unit_category.xlsx';
        $full_path = url('/office_unit_category.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function getOfficeUnitCategoryData()
    {
        $office_unit_categories = OfficeUnitCategory::get();
        return view('officeunitcategory.get_office_unit_category', compact('office_unit_categories'));
    }

    public function searchUnitCategory(Request $request){

        $category_name_bng = $request->name_bn;
        $category_name_eng = $request->name_en;
        $query = OfficeUnitCategory::query();

        $query->when($category_name_bng, function ($q, $category_name_bng) {
            return $q->where('category_name_bng', $category_name_bng);
        });

        $query->when($category_name_eng, function ($q, $category_name_eng) {
            return $q->where('category_name_eng', $category_name_eng);
        });

        $office_unit_categories = $query->paginate(20);
        // $bivags = Bivag::paginate();
        $html =  view('officeunitcategory.get_office_unit_category', compact('office_unit_categories'));
        return response($html);
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
            'id' => 'nullable|numeric',
            'category_name_bng' => 'required|string',
            'category_name_eng' => 'required|string',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);

        if ($request->id !== null) {
            $office_unit_category = OfficeUnitCategory::find($request->id);
            $office_unit_category->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully edited unit type.']);
        } else {
            OfficeUnitCategory::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Unit type added successfully.']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\OfficeUnitCategory $officeUnitCategory
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeUnitCategory $officeUnitCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\OfficeUnitCategory $officeUnitCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeUnitCategory $officeUnitCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OfficeUnitCategory $officeUnitCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeUnitCategory $officeUnitCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\OfficeUnitCategory $officeUnitCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        dd($request->all());
        OfficeUnitCategory::whereIn('id',$request->unit_category_id)->delete();
        return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
    }
}
