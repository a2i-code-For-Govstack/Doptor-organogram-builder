<?php

namespace App\Http\Controllers;

use App\Models\GeoLocationLog;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use App\Services\GeoLocationLogServices;
use DB;
use App\Models\Zila;
use App\Models\Bivag;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mikehaertl\wkhtmlto\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BivagController extends Controller
{
    public function index()
    {
        return view('bivag');
    }

    public function getBivagData()
    {
        $bivags = Bivag::orderBy('id', 'DESC')->paginate();
        return view('bivag.get_bivag', compact('bivags'));
    }

    public function searchDivision(Request $request)
    {

        $division_name_bng = $request->division_name_bng;
        $division_name_eng = $request->division_name_eng;
        $bbs_code = bnToen($request->bbs_code);
        $status = $request->division_status;
        $query = Bivag::query();

        $query->when($division_name_bng, function ($q, $division_name_bng) {
            return $q->where('division_name_bng', $division_name_bng);
        });

        $query->when($division_name_eng, function ($q, $division_name_eng) {
            return $q->where('division_name_eng', $division_name_eng);
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
        $bivags = $query->paginate();
        $html = view('bivag.get_bivag', compact('bivags'));
        return response($html);
    }


    public function generateBivagExcelFile(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $bivags = Bivag::all();

        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'Administrative Division List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Division Code');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Administrative Division Name (Other)');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'Administrative Division Name (English)');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'Status');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($bivags as $bivag) {
            $sheet->setCellValue('A' . $count, $bivag->bbs_code);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, $bivag->division_name_bng);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('C' . $count, $bivag->division_name_eng);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            if ($bivag->status == '1') {
                $sheet->setCellValue('D' . $count, 'Active');
            } else {
                $sheet->setCellValue('D' . $count, 'inactive');
            }
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Division List.xlsx');
        $file_name = 'Division List.xlsx';
        $full_path = url('storage/Division List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }


    public function generateBivagPdfFile(Request $request)
    {

        $html_file_url = public_path('pdf.html');
        $pdf_file_url = public_path('bivag.pdf');
        $cmd = "\"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe\"" . " " . "--enable-local-file-access" . " " . $html_file_url . " " . $pdf_file_url;
        exec($cmd);
        $file_name = 'bivag.pdf';
        $full_path = url('/bivag.pdf');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function store(Request $request)
    {
        $validAttribute = request()->validate([
            'bbs_code' => "required|unique:App\Models\Bivag,bbs_code,{$request->id}",
            'division_name_bng' => 'string',
            'division_name_eng' => 'string',
            'status' => 'nullable|numeric',
            'id' => 'nullable|numeric',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);

        if (!isset($request->status)) {
            $validAttribute['status'] = 0;
        }

        if ($request->id !== null) {
            $bivag = Bivag::find($request->id);
            $old_bivag = $bivag->toArray();
            $bivag->update($validAttribute);

            $log_options = [
                'geo_model_name' => 'App\Models\Bivag',
                'geo_table_name' => 'geo_divisions',
            ];

            (new GeoLocationLogServices())->saveGeloLocationLog($old_bivag, $bivag, $log_options);

            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            Bivag::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    public function destroy(Request $request)
    {
        $divisionId = $request->division_id;

        if (!empty($divisionId)) {
            DB::beginTransaction();
            try {
                $exist_zila = Zila::whereIn('geo_division_id', $divisionId)->get();
                $exist_office = Office::whereIn('geo_division_id', $divisionId)->get();
                if (count($exist_zila) > 0 || count($exist_office) > 0) {
                    return response(['status' => 'error', 'msg' => 'Districts or offices are under this division']);
                } else {
                    Bivag::whereIn('id', $divisionId)->delete();
                }
                DB::commit();
                return response(['status' => 'success', 'msg' => 'Division deleted successfully.']);
            } catch (\Exception $e) {
                DB::rollback();
                return response(['status' => 'error', 'msg' => 'Division could not be deleted.', 'data' => $e]);
            }
        } else {
            return response(['status' => 'error', 'msg' => 'Division not selected.']);
        }
    }
}

