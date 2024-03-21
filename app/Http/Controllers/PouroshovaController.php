<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\CityCorporationWord;
use App\Models\Pouroshova;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PouroshovaController extends Controller
{
    public function index()
    {
        $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
        return view('pouroshova', compact('bivags'));

    }

    public function getPouroshovaData()
    {
        $pouroshovas = Pouroshova::orderBy('id', 'DESC')->paginate(20);
        return view('pouroshova.get_pouroshova', compact('pouroshovas'));
    }

    public function generatePouroshovaExcelFile()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $pouroshovas = Pouroshova::all();

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Municipalities List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Administrative department');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Zila');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'Upazila');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'Municipality Code');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'Municipality Name (Bangla)');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'Municipality Name (English)');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('G2', 'Status');
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        if (!empty($pouroshovas)) {
            foreach ($pouroshovas as $pouroshova) {
                $sheet->setCellValue('A' . $count, $pouroshova->bivag->division_name_bng);
                $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('B' . $count, $pouroshova->zila->district_name_bng);
                $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('C' . $count, @$pouroshova->upozila->upazila_name_bng);
                $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('D' . $count, $pouroshova->bbs_code);
                $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('E' . $count, $pouroshova->municipality_name_bng);
                $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->setCellValue('F' . $count, $pouroshova->municipality_name_eng);
                $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                if ($pouroshova->status == '1') {
                    $sheet->setCellValue('G' . $count, 'Active');
                } else {
                    $sheet->setCellValue('G' . $count, 'Inactive');
                }
                $sheet->getStyle('G' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $count++;
            }
        }

        expand_spreadsheet($sheet, $spreadsheet);
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Municipalities List.xlsx');
        $file_name = 'Municipalities List.xlsx';
        $full_path = url('storage/Municipalities List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);

    }

    public function store(Request $request)
    {   
        $request->bbs_code = bnToen($request->bbs_code);
        $validAttribute = request()->validate([
            'geo_division_id' => 'numeric',
            'geo_district_id' => 'numeric',
            'geo_upazila_id' => 'numeric',
            'municipality_name_bng' => 'string|required',
            'municipality_name_eng' => 'string|required',
            'bbs_code' => "required|unique:App\Models\Pouroshova,bbs_code,{$request->id}",
            'division_bbs_code' => 'nullable|numeric',
            'district_bbs_code' => 'nullable|numeric',
            'upazila_bbs_code' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'id' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);
        if (!isset($request->status)) {
            $validAttribute['status'] = 0;
        }
        if ($request->id !== null) {
            $pouroshova = Pouroshova::find($request->id);
            $old_pouroshova = $pouroshova->toArray();
            $pouroshova->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\Pouroshova',
                'geo_table_name' => 'geo_municipalities',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_pouroshova, $pouroshova, $log_options);


            return response(['status' => 'success', 'msg' => 'Municipality updated successfully.']);
        } else {

            Pouroshova::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Municipalities have been completed successfully.']);
        }
    }

    public function searchPouroshova(Request $request)
    {
        $municipality_name_bng = $request->name_bn;
        $municipality_name_eng = $request->name_en;
        $geo_division_id = $request->division_id;
        $geo_district_id = $request->district_id;
        $geo_upazila_id = $request->upozila_id;
        $bbs_code = bnToen($request->pouroshova_code);
        $status = $request->pouroshova_status;
        $query = Pouroshova::query();

        $query->when($municipality_name_bng, function ($q, $municipality_name_bng) {
            return $q->where('municipality_name_bng', 'LIKE', "%$municipality_name_bng%");
        });

        $query->when($municipality_name_eng, function ($q, $municipality_name_eng) {
            return $q->where('municipality_name_eng', 'LIKE', "%$municipality_name_eng%");
        });

        $query->when($geo_division_id, function ($q, $geo_division_id) {
            return $q->where('geo_division_id', $geo_division_id);
        });

        $query->when($geo_district_id, function ($q, $geo_district_id) {
            return $q->where('geo_district_id', $geo_district_id);
        });

        $query->when($geo_upazila_id, function ($q, $geo_upazila_id) {
            return $q->where('geo_upazila_id', $geo_upazila_id);
        });

        $query->when($bbs_code, function ($q, $bbs_code) {
            return $q->where('bbs_code', $bbs_code);
        });

        if ($status == '1') {
            $query->when($status, function ($q, $status) {
                return $q->where('status', $status);
            });
        } elseif ($status == '0') {
            $query->when($status !== null, function ($q) use ($status) {
                return $q->where('status', 0);
            });
        }

        $pouroshovas = $query->get();

        return view('pouroshova.get_pouroshova', compact('pouroshovas'));
    }

    public function destroy(Request $request)
    {
        foreach ($request->pouroshova_id as $key => $value) {
            Pouroshova::where('id', $value)->delete();
        }

        return response(['status' => 'success', 'msg' => 'The municipality has been successfully deleted.']);
    }
}
