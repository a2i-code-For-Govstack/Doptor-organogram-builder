<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\CityCorporationWord;
use App\Models\PouroshovaWord;
use App\Models\Pouroshova;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PouroshovaWordController extends Controller
{
    public function index()
    {
        $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
        return view('pouroshova_word', compact('bivags'));
    }


    public function getPouroshovaWordData()
    {
        $pouroshova_words = PouroshovaWord::orderBy('id', 'DESC')->paginate(20);
        return view('pouroshovaword.get_pouroshovaword', compact('pouroshova_words'));
    }

    public function loadPouroshovaUpozilaWise(Request $request)
    {
        $pouroshovas = Pouroshova::where('geo_upazila_id', $request->upozila_id)->get();
        return view('pouroshovaword.select_pouroshova', compact('pouroshovas'));
    }

    public function searchPouroshovaWord(Request $request)
    {

        $ward_name_bng = $request->name_bn;
        $ward_name_eng = $request->name_en;
        $geo_division_id = $request->division_id;
        $geo_district_id = $request->district_id;
        $geo_upazila_id = $request->upozila_id;
        $geo_municipality_id = $request->pouroshova_id;
        $bbs_code = $request->pouroshova_word_code;
        $status = $request->pouroshova_word_status;

        $query = PouroshovaWord::query();

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

        $query->when($geo_upazila_id, function ($q, $geo_upazila_id) {
            return $q->where('geo_upazila_id', $geo_upazila_id);
        });

        $query->when($geo_municipality_id, function ($q, $geo_municipality_id) {
            return $q->where('geo_municipality_id', $geo_municipality_id);
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

        $pouroshova_words = $query->paginate(20);

        $html = view('pouroshovaword.get_pouroshovaword', compact('pouroshova_words'));
        return response($html);
    }

    public function generatePouroshovaWordExcelFile()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $pouroshova_words = PouroshovaWord::all();

        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'Municipal Ward List');
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

        $sheet->setCellValue('D2', 'Municipality Name');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'Ward Coode');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'Ward Name (Bangla)');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('G2', 'Ward Name (English)');
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('H2', 'Status');
        $sheet->getStyle('H2')->getFont()->setBold(true);
        $sheet->getStyle('H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        if (!empty($pouroshova_words)) {
            foreach ($pouroshova_words as $pouroshova_word) {
                $sheet->setCellValue('A' . $count, $pouroshova_word->bivag->division_name_bng);
                $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('B' . $count, $pouroshova_word->zila->district_name_bng);
                $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('C' . $count, $pouroshova_word->upozila->upazila_name_bng);
                $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                ($pouroshova_word->pouroshova) ? ($sheet->setCellValue('D' . $count, $pouroshova_word->pouroshova->municipality_name_bng)) : ('');
                $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('E' . $count, $pouroshova_word->bbs_code);
                $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('F' . $count, $pouroshova_word->ward_name_bng);
                $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->setCellValue('G' . $count, $pouroshova_word->ward_name_eng);
                $sheet->getStyle('G' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                if ($pouroshova_word->status == '1') {
                    $sheet->setCellValue('H' . $count, 'Active');
                } else {
                    $sheet->setCellValue('H' . $count, 'Inactive');
                }
                $sheet->getStyle('H' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $count++;
            }
        }

        expand_spreadsheet($sheet, $spreadsheet);
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Municipal Ward List.xlsx');
        $file_name = 'Municipal Ward List.xlsx';
        $full_path = url('storage/Municipal Ward List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function store(Request $request)
    {
        $validAttribute = request()->validate([
            'geo_division_id' => 'numeric',
            'geo_district_id' => 'numeric',
            'geo_upazila_id' => 'numeric',
            'geo_municipality_id' => 'numeric',
            'ward_name_bng' => 'string|required',
            'ward_name_eng' => 'string|required',
            'bbs_code' => "required|unique:App\Models\PouroshovaWord,bbs_code,{$request->id}",
            'division_bbs_code' => 'nullable|numeric',
            'district_bbs_code' => 'nullable|numeric',
            'upazila_bbs_code' => 'nullable|numeric',
            'municipality_bbs_code' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'id' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);
        if (!isset($request->status)) {
            $validAttribute['status'] = 0;
        }
        if ($request->id !== null) {
            $pouroshovaword = PouroshovaWord::find($request->id);
            $old_pouroshova_ward = $pouroshovaword->toArray();
            $pouroshovaword->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\PouroshovaWord',
                'geo_table_name' => 'geo_municipality_wards',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_pouroshova_ward, $pouroshovaword, $log_options);

            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {

            PouroshovaWord::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    public function destroy(Request $request)
    {
        foreach ($request->pouroshova_word_id as $key => $value) {
            PouroshovaWord::where('id', $value)->delete();
        }

        return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
    }
}
