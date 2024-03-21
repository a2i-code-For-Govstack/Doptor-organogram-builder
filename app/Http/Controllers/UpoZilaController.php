<?php

namespace App\Http\Controllers;

use App\Models\Zila;
use App\Models\Bivag;
use App\Models\Office;
use App\Models\Union;
use App\Models\UpoZila;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use DB;

class UpoZilaController extends Controller
{
    public function index()
    {
        $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
        foreach ($bivags as $bivag) {
            $bivag->bbs_code = bnToen($bivag->bbs_code);
        }
        return view('upozila', compact('bivags'));
    }


    public function getUpoZilaData()
    {
        $upozilas = UpoZila::orderBy('id', 'DESC')->with('bivag', 'zila')->get();
        return view('upozila.get_upozila', compact('upozilas'));
    }

    public function searchUpoZila(Request $request)
    {
        $upazila_name_bng = $request->name_bn;
        $upazila_name_eng = $request->name_en;
        $geo_division_id = $request->division_id;
        $geo_district_id = $request->district_id;
        $bbs_code = bnToen($request->bbs_code);
        $status = $request->status;

        $query = UpoZila::query();

        $query->when($upazila_name_bng, function ($q, $upazila_name_bng) {
            return $q->where('upazila_name_bng', $upazila_name_bng);
        });

        $query->when($upazila_name_eng, function ($q, $upazila_name_eng) {
            return $q->where('upazila_name_eng', $upazila_name_eng);
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

        $upozilas = $query->paginate(100);
        $html = view('upozila.get_upozila', compact('upozilas'));
        return response($html);
    }

    public function loadZilaDivisionWise(Request $request)
    {
        $zilas = Zila::where('geo_division_id', $request->division_id)->get();
        return view('upozila.select_zila', compact('zilas'));
    }


    public function generateUpozilaExcelFile()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $upozilas = UpoZila::all();

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'উপজেলার তালিকা');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'প্রশাসনিক বিভাগ');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'জেলা');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'উপজেলা কোড');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'উপজেলা নাম (বাংলা)');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'উপজেলা নাম (ইংরেজি)');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'অবস্থা');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($upozilas as $upozila) {
            $sheet->setCellValue('A' . $count, $upozila->bivag->division_name_bng);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, @$upozila->zila->district_name_bng);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('C' . $count, $upozila->bbs_code);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('D' . $count, $upozila->upazila_name_bng);
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('E' . $count, $upozila->upazila_name_eng);
            $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            if ($upozila->status == '1') {
                $sheet->setCellValue('F' . $count, 'সক্রিয়');
            } else {
                $sheet->setCellValue('F' . $count, 'নিষ্ক্রিয়');
            }

            $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/উপজেলা তালিকা.xlsx');
        $file_name = 'উপজেলা তালিকা.xlsx';
        $full_path = url('storage/উপজেলা তালিকা.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function store(Request $request)
    {

        $validAttribute = request()->validate([
            'geo_division_id' => 'numeric',
            'geo_district_id' => 'numeric',
            'upazila_name_bng' => 'string|required',
            'upazila_name_eng' => 'string|required',
            'bbs_code' => "required|unique:App\Models\UpoZila,bbs_code,{$request->id}",
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
            $upozila = UpoZila::find($request->id);
            $old_upazila = $upozila->toArray();
            $upozila->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\UpoZila',
                'geo_table_name' => 'geo_upazilas',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_upazila, $upozila, $log_options);

            return response(['status' => 'success', 'msg' => 'উপজেলা সফলভাবে হালনাগাদ হয়েছে।']);
        } else {
            UpoZila::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'উপজেলা সফল ভাবে সম্পন্ন হয়েছে।']);
        }
    }

    public function destroy(Request $request)
    {
        $upozilaId = $request->upozila_id;

        if (!empty($upozilaId)) {
            DB::beginTransaction();
            try {
                $exist_union = Union::whereIn('geo_upazila_id', $upozilaId)->get();
                $exist_office = Office::whereIn('geo_upazila_id', $upozilaId)->get();

                if (count($exist_union) > 0 || count($exist_office) > 0) {
                    return response(['status' => 'error', 'msg' => 'এই উপজেলার অধীনে ইউনিয়ন অথবা অফিস রয়েছে']);
                } else {
                    UpoZila::whereIn('id', $upozilaId)->delete();
                }
                DB::commit();
                return response(['status' => 'success', 'msg' => 'সফলভাবে উপজেলা মুছে ফেলা হয়েছে।']);
            } catch (\Exception $e) {
                DB::rollback();
                return response(['status' => 'error', 'msg' => 'উপজেলা মুছে ফেলা সম্ভব হয়নি।', 'data' => $e]);
            }
        } else {
            return response(['status' => 'error', 'msg' => 'উপজেলা বাছাই করা হয়নি।']);
        }
    }
}
