<?php

namespace App\Http\Controllers;

use App\Models\CityCorporation;
use App\Models\CityCorporationWord;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use App\Models\Bivag;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CityCorporationWordController extends Controller
{
    public function index()
    {
        $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
        return view('city_corporation_word', compact('bivags'));
    }

    public function getCityCorporationWordData()
    {
        $citycorporationwords = CityCorporationWord::orderBy('id', 'DESC')->paginate(20);
        return view('citycorporationword.get_citycorporationword', compact('citycorporationwords'));
    }


    public function loadCityCorporationDistrictWise(Request $request)
    {
        $citycorporations = CityCorporation::where('geo_district_id', $request->district_id)->get();
        return view('citycorporationword.select_citycorporation', compact('citycorporations'));
    }


    public function generateCityCorporationWordExcelFile()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $city_corporation_words = CityCorporationWord::all();

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'City Corporation Ward List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Administrative department');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Zila');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'City Corporation Name');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'Ward Code');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'Ward Name (Bangla)');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'Ward Name (English)');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('G2', 'Status');
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $count = 3;
        if (!empty($city_corporation_words)) {
            foreach ($city_corporation_words as $city_corporation_word) {
                $sheet->setCellValue('A' . $count, $city_corporation_word->bivag->division_name_bng);
                $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('B' . $count, $city_corporation_word->zila->district_name_bng);
                $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                ($city_corporation_word->city_corporation) ? ($sheet->setCellValue('C' . $count, $city_corporation_word->city_corporation->city_corporation_name_bng)) : ('');
                $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('D' . $count, $city_corporation_word->bbs_code);
                $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('E' . $count, $city_corporation_word->ward_name_bng);
                $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->setCellValue('F' . $count, $city_corporation_word->ward_name_eng);
                $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                if ($city_corporation_word->status == '1') {
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
        $writer->save('storage/City Corporation List.xlsx');
        $file_name = 'City Corporation List.xlsx';
        $full_path = url('storage/City Corporation List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);

    }

    public function searchCityCorporationWord(Request $request)
    {

        $ward_name_bng = $request->name_bn;
        $ward_name_eng = $request->name_en;
        $geo_division_id = $request->division_id;
        $geo_district_id = $request->district_id;
        $geo_city_corporation_id = $request->city_corporation_id;

        $bbs_code = $request->word_code;
        $status = $request->city_corporation_word_status;

        $query = CityCorporationWord::query();

        $query->when($ward_name_bng, function ($q, $ward_name_bng) {
            return $q->where('ward_name_bng', $ward_name_bng);
        });

        $query->when($ward_name_eng, function ($q, $ward_name_eng) {
            return $q->where('ward_name_eng', $ward_name_eng);
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

        $citycorporationwords = $query->paginate(20);
        $html = view('citycorporationword.get_citycorporationword', compact('citycorporationwords'));
        return response($html);
    }

    public function store(Request $request)
    {

        $validAttribute = request()->validate([
            'geo_division_id' => 'numeric',
            'geo_district_id' => 'numeric',
            'geo_city_corporation_id' => 'numeric',
            'ward_name_bng' => 'string|required',
            'ward_name_eng' => 'string|required',
            'bbs_code' => "required|unique:App\Models\CityCorporationWord,bbs_code,{$request->id}",
            'division_bbs_code' => 'nullable|numeric',
            'district_bbs_code' => 'nullable|numeric',
            'city_corporation_bbs_code' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'id' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);
        if (!isset($request->status)) {
            $validAttribute['status'] = 0;
        }
        if ($request->id !== null) {
            $city_corporation_ward = CityCorporationWord::find($request->id);
            $old_city_corporation_ward = $city_corporation_ward->toArray();
            $city_corporation_ward->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\CityCorporationWord',
                'geo_table_name' => 'geo_city_corporation_wards',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_city_corporation_ward, $city_corporation_ward, $log_options);

            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            CityCorporationWord::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    public function destroy(Request $request)
    {
        foreach ($request->citycorporationword_id as $key => $value) {
            CityCorporationWord::where('id', $value)->delete();
        }

        return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
    }
}
