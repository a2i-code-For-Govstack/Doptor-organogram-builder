<?php

namespace App\Http\Controllers;

use App\Models\OfficeCustomLayer;
use App\Models\OfficeLayer;
use App\Models\Office;
use App\Models\OfficeMinistry;
use App\Models\OfficeOrigin;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use DB;
use Auth;

class OfficeLayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $results = [];
//        $results = OfficeLayer::where('parent_layer_id',0)->get();

        $ministries = OfficeMinistry::where('active_status', 1)->select('id', 'name_bng', 'name_eng')->get();
        $custom_layers = OfficeCustomLayer::select('id', 'name', 'name_eng', 'layer_level')->get();
        return view('office_layer', compact('ministries', 'custom_layers', 'results'));
    }

    public function loadLayerMinistryWise(Request $request)
    {
        $office_layers = OfficeLayer::where('office_ministry_id', $request->ministry_id)
        ->where('active_status', 1)->get();
        return view('officelayer.select_office_layer', compact('office_layers'));
    }


    public function loadMinistryWiseLayerList(Request $request)
    {
        $offices = Office::where('office_ministry_id', $request->ministry_id)->where('office_layer_id', $request->office_layer_id)
        ->where('active_status', 1)->get();
        return view('officelayer.load_office_layer', compact('offices'));
    }


    public function loadLayerTree(Request $request)
    {
        $results = [];
        $results = OfficeLayer::where('office_ministry_id', $request->ministry_id)->where('parent_layer_id', 0)->select('id', 'layer_name_eng', 'layer_name_bng')->where('active_status', 1)->get();
        return view('officelayer.get_layer_tree', compact('results'));
    }

    public function layerWiseOfficeList()
    {
        $ministries = OfficeMinistry::select('id', 'name_bng', 'name_eng')->where('active_status', 1)->get();
        return view('layer_wise_office_list', compact('ministries'));
    }


    public function ministryWiseLayerMapping()
    {
        $ministries = OfficeMinistry::where('active_status', 1)->get();
        $custom_layers = OfficeCustomLayer::get();
        return view('ministry_wise_layer_mapping', compact('ministries', 'custom_layers'));
    }

    public function loadLayerAndCustomLayerMinistryWise(Request $request)
    {
        $office_layers = OfficeLayer::where('office_ministry_id', $request->ministry_id)->where('active_status', 1)->get();
        return view('officelayer.get_office_layer_ministry_wise', compact('office_layers'));
    }

    public function officeLayerSearch()
    {
        return view('officelayer.get_office_layer_search');
    }

    public function getOfficeLayerData()
    {
        $office_layers = OfficeLayer::orderBy('layer_level')->where('active_status', 1)->get();
        return view('officelayer.get_office_layer_search_list', compact('office_layers'));
    }
    public function generateOfficeLayerSearchExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $office_layers = OfficeLayer::all();

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Office layer search list');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Ministry/Department');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->setCellValue('B2', 'immediate layer');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->setCellValue('C2', 'Custom layer');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->setCellValue('D2', 'Layer name (Bangla)');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->setCellValue('E2', 'Layer name (English)');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->setCellValue('F2', 'Layer');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->setCellValue('G2', 'Status');
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $count = 3;
        foreach ($office_layers as $layer) {
            $sheet->setCellValue('A' . $count, ($layer->office_ministry) ? $layer->office_ministry->name_bng : '');
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('B' . $count, $layer->custom_layer ? $layer->custom_layer->name : '');
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('C' . $count, $layer->layer_name_bng);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('D' . $count, $layer->layer_name_eng);
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('E' . $count,(enTobn( $layer->layer_level)));
            $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('F' . $count, (enTobn($layer->layer_sequence)));
            $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('G' . $count, ($layer->layer_sequence  == 1)?'Active':'Inactive');
            $sheet->getStyle('G' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Office Layer Search List.xlsx');
        $file_name = 'Office Layer Search List.xlsx';
        $full_path = url('storage/Office Layer Search List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function searchOfficeLayerByName(Request $request)
    {
        $layer_name_bng = $request->name_bng;
        $layer_name_eng = $request->name_eng;
        $layer_level = bnToen($request->layer);

        $query = OfficeLayer::query();

        $query->when($layer_name_bng, function ($q, $layer_name_bng) {
            return $q->where('layer_name_bng', $layer_name_bng);
        });

        $query->when($layer_name_eng, function ($q, $layer_name_eng) {
            return $q->where('layer_name_eng', $layer_name_eng);
        });

        $query->when($layer_level, function ($q, $layer_level) {
            return $q->where('layer_level', $layer_level);
        });

        $office_layers = $query->where('active_status', 1)->paginate();

        $html = view('officelayer.get_office_layer_search_list', compact('office_layers'));
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
    public function store(Request $request): \Illuminate\Http\Response
    {

        $validAttribute = request()->validate([
            'office_ministry_id' => 'required|numeric',
            'custom_layer_id' => 'nullable|numeric',
            'parent_layer_id' => 'nullable|numeric',
            'layer_level' => 'nullable|regex:/(^([0-9০-৯]+))/',
            'layer_sequence' => 'nullable|regex:/(^([0-9০-৯]+))/',
            'layer_name_bng' => 'nullable|string',
            'layer_name_eng' => 'nullable|string',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ], [
            'office_ministry_id.required' => 'Select Ministry/Department.',
            'layer_level.required' => 'Fill up layer level',
        ]);
//        dd($request);
        $validAttribute['created_by'] = Auth::user()->id;
        $validAttribute['modified_by'] = Auth::user()->id;
        $validAttribute['layer_level'] = bnToen($request->layer_level);
        $validAttribute['layer_sequence'] = bnToen($request->layer_sequence);
        if ($request->id !== null) {
            $office_layer = OfficeLayer::find($request->id);
            $office_layer->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            OfficeLayer::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    public function layerStore(Request $request)
    {
        $validAttribute = request()->validate([
            'custom_layer_id' => 'required|numeric',
            'layer_id' => 'required|numeric'
        ], [
            'custom_layer_id.required' => 'Select a custom layer.',
        ]);

        try {
            $customLayer['custom_layer_id'] = $request->custom_layer_id;
            $office = Office::where('office_layer_id', $request->layer_id);
            $office->update($customLayer);
            $office_layer = OfficeLayer::where('id', $request->layer_id);
            $office_layer->update($customLayer);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } catch (\Throwable $th) {
            return response(['error' => 'error', 'msg' => 'Saving was not possible!']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\OfficeLayer $officeLayer
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeLayer $officeLayer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\OfficeLayer $officeLayer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return OfficeLayer::where('id', $request->id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OfficeLayer $officeLayer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeLayer $officeLayer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\OfficeLayer $officeLayer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        DB::beginTransaction();
        try {
           $exist_office_origin = OfficeOrigin::whereIn('office_layer_id',$request->office_layer_id)->get();
        if (count($exist_office_origin) > 0) {
            return response(['status' => 'error', 'msg' => 'This layer has offices']);
        }else{
            OfficeLayer::whereIn('id',$request->office_layer_id)->delete();

        }
        DB::commit();
        return response(['status' => 'success', 'msg' => 'Layer deleted successfully.']);
     } catch (\Exception $e) {
        DB::rollback();
        return response(['status' => 'error', 'msg' => 'Unable to delete layer.', 'data' => $e]);
        }
    }
}
