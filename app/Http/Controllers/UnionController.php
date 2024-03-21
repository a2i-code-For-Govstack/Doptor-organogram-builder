<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\Union;
use App\Models\UpoZila;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

//ini_set('memory_limit', '250M');

class UnionController extends Controller
{
    public function index()
    {
        $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
        return view('union', compact('bivags'));
    }

    public function getUnionData()
    {
        $unions = Union::orderBy('id', 'DESC')->with('bivag', 'zila', 'upozila')->get();
        return view('union.get_union', compact('unions'));
    }

    public function getUpazilaWise(Request $request)
    {

        $upazilas = UpoZila::orderBy('id', 'DESC')->where('geo_district_id', $request->district_id)->get();
        return view('union.select_upazila', compact('upazilas'));
    }

    public function searchUnion(Request $request)
    {
        $union_name_bng = $request->name_bn;
        $union_name_eng = $request->name_en;
        $geo_division_id = $request->division_id;
        $geo_district_id = $request->district_id;
        $geo_upazila_id = $request->upazila_id;
        $bbs_code = $request->union_bbs_code;
        $status = $request->union_status;

        $query = Union::query();

        $query->when($union_name_bng, function ($q, $union_name_bng) {
            return $q->where('union_name_bng', $union_name_bng);
        });

        $query->when($union_name_eng, function ($q, $union_name_eng) {
            return $q->where('union_name_eng', $union_name_eng);
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

        $unions = $query->get();
        $html = view('union.get_union', compact('unions'));
        return response($html);
    }

    public function generateUnionExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $unions = Union::select('geo_upazila_id', 'geo_division_id', 'geo_district_id', 'bbs_code', 'union_name_bng', 'union_name_eng', 'status')->with('upozila:id,upazila_name_bng', 'zila:id,district_name_bng', 'bivag:id,division_name_bng')->get();

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Union ');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'প্রশাসনিক বিভাগ');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'জেলা');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'উপজেলা');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'ইউনিয়ন কোড');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'ইউনিয়ন নাম(বাংলা)');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'ইউনিয়ন নাম(ইংরেজি)');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('G2', 'অবস্থা');
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($unions as $union) {
            $sheet->setCellValue('A' . $count, @$union->bivag->division_name_bng);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, @$union->zila->district_name_bng);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('C' . $count, @$union->upozila->upazila_name_bng);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('D' . $count, $union->bbs_code);
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('E' . $count, $union->union_name_bng);
            $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('F' . $count, $union->union_name_eng);
            $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            if ($union->status == '1') {
                $sheet->setCellValue('G' . $count, 'সক্রিয়');
            } else {
                $sheet->setCellValue('G' . $count, 'নিষ্ক্রিয়');
            }
            $sheet->getStyle('G' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/ইউনিয়ন তালিকা.xlsx');
        $file_name = 'ইউনিয়ন তালিকা.xlsx';
        $full_path = url('storage/ইউনিয়ন তালিকা.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function store(Request $request)
    {
        $validAttribute = request()->validate([
            'geo_division_id' => 'numeric|required',
            'geo_district_id' => 'numeric|required',
            'geo_upazila_id' => 'numeric|required',
            'union_name_bng' => 'string|required',
            'union_name_eng' => 'string|required',
            'bbs_code' => "required|numeric|min:1|max:9999",
            'division_bbs_code' => 'nullable|numeric',
            'district_bbs_code' => 'nullable|numeric',
            'upazila_bbs_code' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'id' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ], ['union_name_bng.required' => 'ইউনিয়ন নাম(বাংলা) আবশ্যক!',
            'union_name_eng.required' => 'ইউনিয়ন নাম(ইংরেজি) আবশ্যক!',
            'bbs_code.required' => 'ইউনিয়ন কোড আবশ্যক!',
            'bbs_code.min' => 'ইউনিয়ন কোড ১ থেকে ছোট হতে পারবেনা!',
            'bbs_code.max' => 'ইউনিয়ন কোড ৪ ডিজিটের বেশি হতে পারবেনা!',
            'bbs_code.numeric' => 'ইউনিয়ন কোড অবশ্যই সংখ্যা হবে।',
        ]);
        if (!isset($request->status)) {
            $validAttribute['status'] = 0;
        }
        $validAttribute['bbs_code'] = bnToen($request->bbs_code);
        if ($request->id !== null) {
            $union = Union::find($request->id);
            $old_union = $union->toArray();
            $union->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\Union',
                'geo_table_name' => 'geo_unions',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_union, $union, $log_options);


            return response(['status' => 'success', 'msg' => 'ইউনিয়ন সফলভাবে হালনাগাদ হয়েছে।']);
        } else {
            Union::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'ইউনিয়ন সফল ভাবে সম্পন্ন হয়েছে।']);
        }
    }

    public function destroy(Request $request)
    {
        $unionId = $request->union_id;
        if (!empty($unionId)) {
            foreach ($unionId as $value) {
                Union::where('id', $value)->delete();
            }
            return response(['status' => 'success', 'msg' => 'ইউনিয়ন সফলভাবে মুছে ফেলা হয়েছে।']);
        } else {
            return response(['status' => 'error', 'msg' => 'ইউনিয়ন বাছাই করা হয়নি।']);
        }
    }
}
