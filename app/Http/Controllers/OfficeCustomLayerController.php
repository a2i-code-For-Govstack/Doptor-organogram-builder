<?php

namespace App\Http\Controllers;

use App\Models\OfficeCustomLayer;
use App\Models\OfficeLayer;
use App\Models\OfficeMinistry;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\Office;
use DB;
use Illuminate\Support\Facades\Cache;

class OfficeCustomLayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('office_custom_layer');
    }


    public function getOfficeCustomLayer()
    {
        // $layers = OfficeCustomLayer::orderBy('id', 'desc')->get();
		$layers = Cache::remember('office-custom-layers', 60*60*24, function() {
			return OfficeCustomLayer::orderBy('id', 'desc')->get();
		});
        return view('officecustomlayer.get_custom_layer',compact('layers'));
    }
    public function generateOfficeCustomLayerExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $layers = Cache::remember('office-custom-layers', 60*60*24, function() {
			return OfficeCustomLayer::get();
		});

        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'Office Custom Layer List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Name (Bangla)');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Name (English)');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'Layer Label');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($layers as $layer) {
            $sheet->setCellValue('A' . $count,  $layer->name);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('B' . $count,  $layer->name_eng);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('C' . $count,  $layer->layer_level);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $count++;
        }
        
        expand_spreadsheet($sheet, $spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Office Custom Layer List.xlsx');
        $file_name = 'Office Custom Layer List.xlsx';
        $full_path = url('storage/Office Custom Layer List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function customLayerOfficeMapping()
    {
        $custom_layers = Cache::remember('office-custom-layers', 60*60*24, function() {
			return OfficeCustomLayer::get();
		});
        return view('custom_layer_office_mapping',compact('custom_layers'));
    }


    public function loadCustomLayerWiseOffice(Request $request)
    {
       $offices =  Office::where('active_status', 1)->where('custom_layer_id',$request->custom_layer_id)->get();
        return view('officecustomlayer.get_office',compact('offices'));
    }

     public function searchCustomLayer(Request $request){

        $name = $request->name_bn;
        $name_eng = $request->name_en;
        $layer_level = $request->layer_level;
        $layer_level = bnToen($layer_level);

        $query = OfficeCustomLayer::query();

        $query->when($name, function ($q, $name) {
            return $q->where('name', $name);
        });

        $query->when($name_eng, function ($q, $name_eng) {
            return $q->where('name_eng', $name_eng);
        });

        $query->when($layer_level, function ($q, $layer_level) {
            return $q->where('layer_level', $layer_level);
        });

        $layers = $query->paginate(20);

        $html =  view('officecustomlayer.get_custom_layer',compact('layers'));

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validAttribute = request()->validate([
            'name' => 'required|string',
            'name_eng' => 'required|string',
            'layer_level' => 'nullable|string',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);

		Cache::forget('office-custom-layers');
        if ($request->id !== null) {
            $layer = OfficeCustomLayer::find($request->id);
            $layer->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            OfficeCustomLayer::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeCustomLayer  $officeCustomLayer
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeCustomLayer $officeCustomLayer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeCustomLayer  $officeCustomLayer
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeCustomLayer $officeCustomLayer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeCustomLayer  $officeCustomLayer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeCustomLayer $officeCustomLayer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeCustomLayer  $officeCustomLayer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
           $exist_office = Office::whereIn('custom_layer_id',$request->custom_layer_id)->get();
        if (count($exist_office) > 0) {
            return response(['status' => 'error', 'msg' => 'This custom layer contains offices.']);
        }else{
            OfficeCustomLayer::whereIn('id',$request->custom_layer_id)->delete();

        }
		Cache::forget('office-custom-layers');
        DB::commit();
        return response(['status' => 'success', 'msg' => 'Successfully deleted custom layer.']);
     } catch (\Exception $e) {
        DB::rollback();
        return response(['status' => 'error', 'msg' => 'Could not delete custom layer.', 'data' => $e]);
        }

    }
}
