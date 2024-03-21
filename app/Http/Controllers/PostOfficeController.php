<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\PostOffice;
use App\Models\UpoZila;
use App\Models\Union;
use App\Services\GeoLocationLogServices;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PostOfficeController extends Controller
{
    public function index()
    {
        $bivags = Bivag::select('division_name_bng', 'id', 'bbs_code')->get();
        return view('post_office', compact('bivags'));

    }

    public function getPostOfficeData()
    {
        $post_offices = PostOffice::orderBy('id', 'DESC')->paginate(20);
        return view('postoffice.get_post_office', compact('post_offices'));
    }

    public function searchPostOffice(Request $request)
    {

        $postoffice_name_bng = $request->name_bn;
        $postoffice_name_eng = $request->name_en;
        $geo_division_id = $request->division_id;
        $geo_district_id = $request->district_id;
        $geo_upazila_id = $request->upozila_id;
        $bbs_code = bnToen($request->post_office_code);
        $status = $request->post_office_status;
        $query = PostOffice::query();

        $query->when($postoffice_name_bng, function ($q, $postoffice_name_bng) {
            return $q->where('postoffice_name_bng', $postoffice_name_bng);
        });

        $query->when($postoffice_name_eng, function ($q, $postoffice_name_eng) {
            return $q->where('postoffice_name_eng', $postoffice_name_eng);
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
                return $q->where('status', $status);
            })->when($status == 0, function ($q) {
                return $q->orWhere('status', 0);
            });
        }

        $post_offices = $query->paginate(20);

        $html = view('postoffice.get_post_office', compact('post_offices'));
        return response($html);
    }


    public function loadUpozilaDistrictWise(Request $request)
    {
        $upozilas = UpoZila::where('geo_district_id', $request->district_id)->get();
        return view('postoffice.select_upozila', compact('upozilas'));
    }

    public function loadUnionUpozilaWise(Request $request)
    {

        $unions = Union::where('geo_upazila_id', $request->upozila_id)->get();
        return view('union.select_union', compact('unions'));
    }

    public function generatePostOfficeExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $post_offices = PostOffice::all();

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Post Office List');
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

        $sheet->setCellValue('D2', 'Post Office Code');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'Post Office Name');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'Post Office Name (English)');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('G2', 'Status');
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($post_offices as $post_office) {
            $sheet->setCellValue('A' . $count, $post_office->bivag->division_name_bng);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, @$post_office->zila->district_name_bng);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('C' . $count, $post_office->upozila->upazila_name_bng);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('D' . $count, $post_office->bbs_code);
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('E' . $count, $post_office->postoffice_name_bng);
            $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('F' . $count, $post_office->postoffice_name_eng);
            $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            if ($post_office->status == '1') {
                $sheet->setCellValue('G' . $count, 'Active');
            } else {
                $sheet->setCellValue('G' . $count, 'Inactive');
            }
            $sheet->getStyle('G' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Post Office List.xlsx');
        $file_name = 'Post Office List.xlsx';
        $full_path = url('storage/Post Office List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function store(Request $request)
    {
        $validAttribute = request()->validate([
            'geo_division_id' => 'numeric|required',
            'geo_district_id' => 'numeric|required',
            'geo_upazila_id' => 'numeric',
            'geo_post_office_id' => 'numeric',
            'postoffice_name_bng' => 'string|required',
            'postoffice_name_eng' => 'string|required',
            // 'bbs_code' => "required|unique:App\Models\PostOffice,bbs_code,{{$request->id}}",
            'bbs_code' => "required|unique:App\Models\PostOffice,bbs_code,{$request->id}",
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
        $validAttribute['geo_thana_id'] = 0;
        if ($request->id !== null) {
            $post_office = PostOffice::find($request->id);
            $old_post_office = $post_office->toArray();
            $post_office->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\PostOffice',
                'geo_table_name' => 'geo_post_offices',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_post_office, $post_office, $log_options);

            return response(['status' => 'success', 'msg' => 'Post Office has been updated successfully.']);
        } else {
            PostOffice::create($validAttribute);
            return response(['status' => 'success', 'msg' => '
            Post Office completed successfully.']);
        }
    }

    public function destroy(Request $request)
    {
        foreach ($request->post_office_id as $key => $value) {
            PostOffice::where('id', $value)->delete();
        }

        return response(['status' => 'success', 'msg' => 'The post office has been successfully deleted.']);
    }
}
