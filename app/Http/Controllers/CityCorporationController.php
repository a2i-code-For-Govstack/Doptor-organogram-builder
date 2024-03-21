<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\CityCorporation;
use App\Models\city_corporation;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CityCorporationController extends Controller
{
    public function index()
    {
        $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
        return view('city_corporation', compact('bivags'));
    }

    public function getCityCorporationData()
    {
        $citycorporations = CityCorporation::orderBy('id', 'DESC')->paginate();
        return view('citycorporation.get_citycorporation', compact('citycorporations'));
    }

    public function generateCityCorporationExcelFile()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $city_corporations = CityCorporation::all();

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'City Corporation List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Administrative department');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Zila');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'City Corporation Code');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'City Corporation Name (Other)');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'City Corporation Name (English)');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'Status');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($city_corporations as $city_corporation) {
            $sheet->setCellValue('A' . $count, $city_corporation->bivag->division_name_bng);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, $city_corporation->zila->district_name_bng);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('C' . $count, $city_corporation->bbs_code);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('D' . $count, $city_corporation->city_corporation_name_bng);
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('E' . $count, $city_corporation->city_corporation_name_eng);
            $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            if ($city_corporation->status == '1') {
                $sheet->setCellValue('F' . $count, 'Active');
            } else {
                $sheet->setCellValue('F' . $count, 'Inactive');
            }
            $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $count++;
        }
        
        expand_spreadsheet($sheet, $spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/City Corporation List.xlsx');
        $file_name = 'City Corporation List.xlsx';
        $full_path = url('storage/City Corporation List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);

    }

    public function searchCityCorporation(Request $request)
    {

        $city_corporation_name_bng = $request->name_bn;
        $city_corporation_name_eng = $request->name_en;
        $geo_division_id = $request->division_id;
        $geo_district_id = $request->district_id;
        $bbs_code = bnToen($request->city_corporation_code);
        $status = $request->city_corporation_status;
        $query = CityCorporation::query();

        $query->when($city_corporation_name_bng, function ($q, $city_corporation_name_bng) {
            return $q->where('city_corporation_name_bng', $city_corporation_name_bng);
        });

        $query->when($city_corporation_name_eng, function ($q, $city_corporation_name_eng) {
            return $q->where('city_corporation_name_eng', $city_corporation_name_eng);
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

        if ($status == '1') {
            $query->when($status, function ($q, $status) {
                return $q->where('status', $status);
            });
        } elseif ($status == '0') {
            $query->when($status !== null, function ($q) use ($status) {
                return $q->where('status', 0);
            });
        }

        $citycorporations = $query->paginate(20);
        $html = view('citycorporation.get_citycorporation', compact('citycorporations'));
        return response($html);
    }

    public function store(Request $request)
    {

        $validAttribute = request()->validate([
            'geo_division_id' => 'numeric|required',
            'geo_district_id' => 'numeric',
            'city_corporation_name_bng' => 'string|required',
            'city_corporation_name_eng' => 'string|required',
            'bbs_code' => "required|unique:App\Models\CityCorporation,bbs_code,{{$request->id}}",
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
            $city_corporation = CityCorporation::find($request->id);
            $old_city_corporation = $city_corporation->toArray();
            $city_corporation->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\CityCorporation',
                'geo_table_name' => 'geo_city_corporations',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_city_corporation, $city_corporation, $log_options);

            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            CityCorporation::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    public function destroy(Request $request)
    {
        foreach ($request->city_corporatoin_id as $value) {
            CityCorporation::where('id', $value)->delete();
        }

        return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
    }
}
