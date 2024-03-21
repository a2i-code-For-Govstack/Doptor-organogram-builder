<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\Thana;
use App\Models\UpoZila;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ThanaController extends Controller
{
    public function index()
    {
        $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
        return view('thana', compact('bivags'));
    }


    public function getThanaData()
    {
        $thanas = Thana::orderBy('id', 'DESC')->with('bivag')->get();
        return view('thana.get_thana', compact('thanas'));
    }

    public function searchThana(Request $request)
    {

        $thana_name_bng = $request->name_bn;
        $thana_name_eng = $request->name_en;
        $geo_division_id = $request->division_id;
        $geo_district_id = $request->district_id;
        $bbs_code = $request->thana_bbs_code;
        $query = Thana::query();

        $query->when($thana_name_bng, function ($q, $thana_name_bng) {
            return $q->where('thana_name_bng', $thana_name_bng);
        });

        $query->when($thana_name_eng, function ($q, $thana_name_eng) {
            return $q->where('thana_name_eng', $thana_name_eng);
        });

        $query->when($geo_division_id, function ($q, $geo_division_id) {
            return $q->where('geo_division_id', $geo_division_id);
        });

        $query->when($geo_district_id, function ($q, $geo_district_id) {
            return $q->where('geo_district_id', $geo_district_id);
        });
        $query->when($bbs_code, function ($q, $bbs_code) {
            return $q->where('bbs_code', $bbs_code);
        });
        $thanas = $query->paginate(20);
        $html = view('thana.get_thana', compact('thanas'));
        return response($html);
    }

    public function loadThanaUpozilaWise(Request $request)
    {
        $upozilas = UpoZila::where('geo_district_id', $request->district_id)->get();
        return view('postoffice.select_upozila', compact('upozilas'));
    }


    public function generateThanaExcelFile()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $thanas = Thana::all();

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'Thana List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', '
        Administrative department');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Zila');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'Thana Code');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'Thana Name');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'Thana Name (English)');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'Status');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($thanas as $thana) {
            $sheet->setCellValue('A' . $count, $thana->bivag->division_name_bng);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, @$thana->zila->district_name_bng);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('C' . $count, $thana->bbs_code);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('D' . $count, $thana->thana_name_bng);
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('E' . $count, $thana->thana_name_eng);
            $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            if ($thana->status == '1') {
                $sheet->setCellValue('F' . $count, 'Active');
            } else {
                $sheet->setCellValue('F' . $count, 'Inactive');
            }
            $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Thana List.xlsx');
        $file_name = 'Thana List.xlsx';
        $full_path = url('storage/Thana List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function store(Request $request)
    {

        $validAttribute = request()->validate([
            'geo_division_id' => 'numeric|required',
            'geo_district_id' => 'numeric|required',
            'thana_name_bng' => 'string|required',
            'thana_name_eng' => 'string|required',
            'bbs_code' => "required|unique:App\Models\Thana,bbs_code,{$request->id}",
            'division_bbs_code' => 'nullable|numeric',
            'district_bbs_code' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'id' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);
        if (!isset($request->status)) {
            $validAttribute['status'] = 0;
        }
        if ($request->id !== null) {
            $thana = Thana::find($request->id);
            $old_thana = $thana->toArray();
            $thana->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\Thana',
                'geo_table_name' => 'geo_thanas',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_thana, $thana, $log_options);


            return response(['status' => 'success', 'msg' => 'Thana has been updated successfully.']);
        } else {
            Thana::create($validAttribute);
            return response(['status' => 'success', 'msg' => '
            Thana has been completed successfully.']);
        }
    }

    public function destroy(Request $request)
    {
        $thanaId = $request->thana_id;
        if (!empty($thanaId)) {
            foreach ($thanaId as $value) {
                Thana::where('id', $value)->delete();
            }
            return response(['status' => 'success', 'msg' => 'Thana has been deleted successfully.']);
        } else {
            return response(['status' => 'error', 'msg' => '
            Thana has not been selected.']);
        }
    }
}
