<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\OfficeLayer;
use App\Models\OfficeMinistry;
use App\Models\OfficeOrigin;
use App\Models\OfficeOriginUnit;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OfficeOriginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $office_ministries = OfficeMinistry::get();
        return view('office_origin', compact('office_ministries'));
    }

    public function getOfficeOriginData()
    {
        return view('officeorigin.get_office_origin');
    }

    public function officeOriginServerSide(Request $request)
    {
        $draw = intval($request->draw);
        $start = intval($request->start);
        $limit = intval($request->length);
        $search = $request->search['value'];
        $sortBy = null;
        $sortDirection = '';

        if (isset($request->order[0]['column'])) {
            $sortBy = $request->columns[$request->order[0]['column']]['data'];
            $sortDirection = $request->order[0]['dir'];
        }

        $total_data = OfficeOrigin::when($sortBy, function ($query, $sortBy) use ($sortDirection) {
            return $query->orderBy($sortBy, $sortDirection);
        }, function ($query) {
            return $query->orderBy('id', 'desc');
        })
            ->when($search, function ($query) use ($search) {
                return $query->where('office_name_bng', 'like', "%" . $search . "%")->orWhere('office_name_eng', 'like', "%" . $search . "%");
            })
            ->count();

        $origin_list = OfficeOrigin::when($sortBy, function ($query, $sortBy) use ($sortDirection) {
            return $query->orderBy($sortBy, $sortDirection);
        }, function ($query) {
            return $query->orderBy('id', 'desc');
        })
//                            ->when($filterList, function ($query, $filterList) use ($columns) {
//                                foreach($filterList as $key => $val) {
//                                    return $query->where($columns[$key]['name'], 'like', "%".$val[0]."%");
//                                }
//                            })

            ->when($search, function ($query) use ($search) {
                return $query->where('office_name_bng', 'like', "%" . $search . "%")->orWhere('office_name_eng', 'like', "%" . $search . "%");
            })
            ->offset($start)
            ->limit($limit)
            ->get();

        $data = array();
        $i = 1;

        foreach ($origin_list as $row) {
            $edit_button = '';
            $delete_button = '';
            $origin_array['id'] = enTobn($i);
            $origin_array['ministry_name'] = $row->office_ministry->name_bng;
            $origin_array['layer_name'] = @$row->office_layer->layer_name_bng;
            $origin_array['parent_office_name'] = @$row->parent->office_name_bng;
            $origin_array['office_name_bng'] = $row->office_name_bng;
            $origin_array['office_name_eng'] = $row->office_name_eng;
            $origin_array['office_level'] = enTobn($row->office_level);
            $origin_array['office_sequence'] = enTobn($row->office_sequence);

            $edit_button .= '<button style="height: 30px;width: 30px;margin-right:2px"';
            $edit_button .= 'data-content="' . $row->id . ',' . $row->office_ministry->id . ',' . @$row->office_layer->id . ',' . @$row->parent->id . ',' . $row->office_level . ',' . $row->office_sequence . ',' . $row->active_status . ',' . $row->office_name_eng . ',' . $row->office_name_bng . '"';
            $edit_button .= 'id="origin_id' . $row->id . '" type="button" data-dismiss="modal" class="btn  btn-icon  btn-outline-brand btntableDataEdit">';
            $edit_button .= '<i class="fas fa-pencil-alt"></i></button>';
            $edit_button .= '<button style="height: 30px;width: 30px;"  type="button" data-id="' . $row->id . '"  class="btn btn-icon btn-outline-danger delete_office_origin"><i class="fas fa-trash-alt"></i></button>';
            $origin_array['edit_button'] = $edit_button;

//            $delete_button .= '<label class="kt-checkbox kt-checkbox--success">';
//            $delete_button .=  '<input class="office_origin_id" value="'.$row->id.'" type="checkbox"> <span></span></label>';
            $origin_array['delete_button'] = '';
            $data[] = $origin_array;
            $i++;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_data,
            "recordsFiltered" => $total_data,
            "data" => $data
        );
        echo json_encode($output);

    }

    public function get_origin_office_info(Request $request)
    {
        return OfficeOrigin::findOrFail($request->id);
    }


    public function loadOfficeLayerMinistryWise(Request $request)
    {

        $office_layers = OfficeLayer::where('office_ministry_id', $request->ministry_id)->select('id', 'layer_name_bng')->get();
        return view('officeorigin.select_office_layer', compact('office_layers'));
    }

    public function loadMinistryParentOrigin(Request $request)
    {

        $parent_origins = OfficeOrigin::where('office_ministry_id', $request->ministry_id)->select('id', 'office_name_bng')->where('id', '!=', $request->office_id)->get();
        return view('officeorigin.select_office_parent_origin', compact('parent_origins'));
    }


    public function generateOfficeOriginExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $office_origins = OfficeOrigin::all();

        $sheet->setCellValue('A1', 'Sl.');
        $sheet->setCellValue('B1', 'Office Ministry');
        $sheet->setCellValue('C1', 'Office Layer');
        $sheet->setCellValue('D1', 'Higher Office');
        $sheet->setCellValue('E1', 'Name (Other)');
        $sheet->setCellValue('F1', 'Name (English)');
        $sheet->setCellValue('G1', 'layer');
        $sheet->setCellValue('H1', 'Order');

        $count = 2;
        foreach ($office_origins as $key => $office_origin) {
            $sheet->setCellValue('A' . $count, $key + 1);
            $sheet->setCellValue('B' . $count, $office_origin->office_ministry->name_bng);
            $sheet->setCellValue('C' . $count, @$office_origin->office_layer->layer_name_bng);
            $sheet->setCellValue('D' . $count, @$office_origin->parent->office_name_bng);
            $sheet->setCellValue('E' . $count, $office_origin->office_name_bng);
            $sheet->setCellValue('F' . $count, $office_origin->office_name_eng);
            $sheet->setCellValue('G' . $count, (enTobn($office_origin->office_level)));
            $sheet->setCellValue('H' . $count, (enTobn($office_origin->office_sequence)));
            $sheet->setCellValue('I' . $count, $office_origin->office_name_bng);

            $count++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('office_origin.xlsx');
        $file_name = 'office_origin.xlsx';
        $full_path = url('/office_origin.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }


    public function searchOfficeOrigins(Request $request)
    {

        $office_name_bng = $request->name_bn;
        $office_name_eng = $request->name_en;
        $office_ministry_id = $request->ministry_id;
        $office_layer_id = $request->layer_id;
        // $bbs_code = $request->bbs_code;
        // $status = $request->status;
        // if (!isset($request->status)) {
        //     $status = 0;
        // }
        $query = OfficeOrigin::query();

        $query->when($office_name_bng, function ($q, $office_name_bng) {
            return $q->where('office_name_bng', $office_name_bng);
        });

        $query->when($office_name_eng, function ($q, $office_name_eng) {
            return $q->where('office_name_eng', $office_name_eng);
        });

        $query->when($office_ministry_id, function ($q, $office_ministry_id) {
            return $q->where('office_ministry_id', $office_ministry_id);
        });

        $query->when($office_layer_id, function ($q, $office_layer_id) {
            return $q->where('office_layer_id', $office_layer_id);
        });

        // $query->when($bbs_code, function ($q, $bbs_code) {
        //     return $q->where('bbs_code', $bbs_code);
        // });

        // $query->when($status, function ($q, $status) {
        //     return $q->where('status', $status);
        // });

        $office_origins = $query->paginate(20);

        // dd($geo_district_id);
        // dd($query);
        // $bivags = Bivag::paginate();
        $html = view('officeorigin.get_office_origin', compact('office_origins'));
        return response($html);
    }

    public function store(Request $request)
    {
        $validAttribute = request()->validate([
            'office_ministry_id' => 'nullable|numeric',
            'office_layer_id' => 'numeric|min:1',
            'parent_office_id' => 'nullable|numeric',
            'office_level' => 'required|numeric',
            'office_sequence' => 'required|numeric',
            'active_status' => 'nullable|numeric',
            'office_name_eng' => 'required|string',
            'office_name_bng' => 'required|string',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ], [
            'office_layer_id.min' => 'Select the office layer.',
            'office_name_eng.required' => 'Name (English) is required.',
            'office_name_bng.required' => 'Name (Other) is required.',
            'office_level.required' => 'Layer code is required.',
            'office_sequence.required' => 'Sequence code is required.'
        ]);

        if ($request->id !== null) {
            $office_origin = OfficeOrigin::find($request->id);
            $office_origin->update($validAttribute);
            $office_origin_data = $validAttribute;
            $office_origin_data['id'] = $request->id;
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            OfficeOrigin::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    public function loadOfficeOriginOfficeLayerWise(Request $request)
    {
        $office_layer_id = $request->office_layer_id;
        $office_origins = OfficeOrigin::where('office_layer_id', $office_layer_id)->get();
        return view('officeoriginunit.select_office_origin', compact('office_origins'));
    }


    public function destroy(Request $request)
    {
        $exist_office = Office::whereIn('office_origin_id', $request->office_origin_id)->count();

        $office_origin = OfficeOrigin::whereIn('id', $request->office_origin_id)->get();

        foreach ($office_origin as $origin) {
            if ($origin->child->count() > 0) {
                return response(['status' => 'error', 'msg' => 'There are basic offices under basic offices.']);
            }
        }

        if ($exist_office > 0) {
            return response(['status' => 'error', 'msg' => 'There are basic office offices.']);
        } else {
            OfficeOrigin::whereIn('id', $request->office_origin_id)->delete();
            return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
        }
    }
}
