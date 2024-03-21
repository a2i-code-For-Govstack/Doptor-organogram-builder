<?php

namespace App\Http\Controllers;

use App\Models\Zila;
use App\Models\Bivag;
use App\Models\Office;
use App\Models\Thana;
use App\Models\UpoZila;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use DB;

class ZilaController extends Controller
{
    public function index()
    {
        $bivags = Bivag::get();
        return view('zila', compact('bivags'));
    }


    public function getZilaData()
    {
        $zilas = Zila::orderBy('id', 'DESC')->with('bivag')->get();
        return view('zila.get_zila', compact('zilas'));
    }

    public function searchZila(Request $request)
    {
        $district_name_bng = $request->district_name_bng;
        $district_name_eng = $request->district_name_eng;
        $geo_division_id = $request->geo_division_id;
        $bbs_code = bnToen($request->bbs_code);
        $status = $request->zila_status;
        $query = Zila::query();

        $query->when($district_name_bng, function ($q, $district_name_bng) {
            return $q->where('district_name_bng', $district_name_bng);
        });

        $query->when($district_name_eng, function ($q, $district_name_eng) {
            return $q->where('district_name_eng', $district_name_eng);
        });

        $query->when($geo_division_id, function ($q, $geo_division_id) {
            return $q->where('geo_division_id', $geo_division_id);
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

        $zilas = $query->paginate(20);
        $html = view('zila.get_zila', compact('zilas'));
        return response($html);
    }

    public function generateZilaExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $zilas = Zila::all();

        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'জেলার তালিকা');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'প্রশাসনিক বিভাগ');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'জেলা কোড');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'জেলার নাম(বাংলা)');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'জেলার নাম(ইংরেজি)');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'অবস্থা');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($zilas as $zila) {
            $sheet->setCellValue('A' . $count, $zila->bivag->division_name_bng);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, $zila->bbs_code);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('C' . $count, $zila->district_name_bng);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('D' . $count, $zila->district_name_eng);
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            if ($zila->status == '1') {
                $sheet->setCellValue('E' . $count, 'সক্রিয়');
            } else {
                $sheet->setCellValue('E' . $count, 'নিষ্ক্রিয়');
            }
            $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/জেলা তালিকা.xlsx');
        $file_name = 'জেলা তালিকা.xlsx';
        $full_path = url('storage/জেলা তালিকা.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function store(Request $request)
    {

        $validAttribute = request()->validate([
            'bbs_code' => "required|unique:App\Models\Zila,bbs_code,{$request->id}",
            'division_bbs_code' => 'required',
            'district_name_bng' => 'string |required',
            'district_name_eng' => 'string |required',
            'status' => 'nullable|numeric',
            'id' => 'nullable|numeric',
            'geo_division_id' => 'numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);
        if (!isset($request->status)) {
            $validAttribute['status'] = 0;
        }
        if ($request->id !== null) {
            $zila = Zila::find($request->id);
            $old_zila = $zila->toArray();
            $zila->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\Zila',
                'geo_table_name' => 'geo_districts',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_zila, $zila, $log_options);

            return response(['status' => 'success', 'msg' => 'জেলা সফলভাবে হালনাগাদ হয়েছে।']);
        } else {
            Zila::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'জেলা সফল ভাবে সম্পন্ন হয়েছে।']);
        }
    }

    public function destroy(Request $request)
    {
        $zilaId = $request->zila_id;
        if (!empty($zilaId)) {
            DB::beginTransaction();

            try {
                $exist_upzila = UpoZila::whereIn('geo_district_id', $request->zila_id)->get();
                $exist_thana = Thana::whereIn('geo_district_id', $request->zila_id)->get();
                $exist_office = Office::whereIn('geo_district_id', $request->zila_id)->get();

                if (count($exist_upzila) > 0 || count($exist_office) > 0 || Count($exist_thana)) {
                    return response(['status' => 'error', 'msg' => 'এই জেলার অধীনে উপজেলা,থানা অথবা অফিস রয়েছে']);
                } else {
                    Zila::whereIn('id', $request->zila_id)->delete();
                }
                DB::commit();
                return response(['status' => 'success', 'msg' => 'সফলভাবে জেলা মুছে ফেলা হয়েছে।']);
            } catch (\Exception $e) {
                DB::rollback();
                return response(['status' => 'error', 'msg' => 'জেলা মুছে ফেলা সম্ভব হয়নি।', 'data' => $e]);
            }
        } else {
            return response(['status' => 'error', 'msg' => 'জেলা বাছাই করা হয়নি।']);
        }
    }

}
