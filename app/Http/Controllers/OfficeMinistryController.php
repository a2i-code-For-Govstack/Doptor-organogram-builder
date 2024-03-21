<?php

namespace App\Http\Controllers;

use App\Models\OfficeMinistry;
use App\Models\OfficeOrigin;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OfficeMinistryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('office_ministry');
    }

    public function getOfficeMinistryData()
    {
		$office_ministries = Cache::remember('office-ministry', 60*60*24, function() {
			return OfficeMinistry::get();
		});
        return view('officeministry.get_ministry', compact('office_ministries'));
    }

    public function generateOfficeMinistryExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $office_ministries = OfficeMinistry::all();

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Ministry / Department List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Sl.');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Type');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'Name (Other)');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'Name (English)');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'Short Name');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'Ministry / Department Code');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('G2', 'Present Status');
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($office_ministries as $office_ministry) {
            $sheet->setCellValue('A' . $count, (enTobn($office_ministry->id)));
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            if($office_ministry->office_type == 1) {
                $sheet->setCellValue('B' . $count, 'Ministry');
            } else {
                $sheet->setCellValue('B' . $count, 'Department');
            }
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('C' . $count, $office_ministry->name_bng);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('D' . $count, $office_ministry->name_eng);
            $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('E' . $count, $office_ministry->name_eng_short);
            $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('F' . $count, $office_ministry->reference_code);
            $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            
            $sheet->setCellValue('G' . $count, ($office_ministry->active_status == 1) ? 'Active' : 'Inactive');
            $sheet->getStyle('G' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Ministry, Department List.xlsx');
        $file_name = 'Ministry, Department List.xlsx';
        $full_path = url('storage/Ministry, Department List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function searchOfficeMinistry(Request $request)
    {

        $ministry_name = $request->ministry_name;
        $status = $request->status;

        $query = OfficeMinistry::query();

        $query->when($ministry_name, function ($q, $ministry_name) {

                return $q->where(function($r)use($ministry_name){
                    $r->where('name_bng', 'like', "%" . $ministry_name . "%")
                ->orWhere('name_eng', 'like', "%" . $ministry_name . "%")
                ->orWhere('name_eng_short', 'like', "%" . $ministry_name . "%");
                });
        });
        $query->when($status, function ($q, $status) {
            if ($status == 'active')
                return $q->where('active_status', 1);
            elseif ($status == 'inactive')
                return $q->where('active_status', 0);
        });

        $office_ministries = $query->get();
        // dd($office_ministries);
        $html = view('officeministry.get_ministry', compact('office_ministries'));
        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $validAttribute = request()->validate([
            'office_type' => 'required|numeric',
            'id' => 'nullable|numeric',
            'name_bng' => "string|required|unique:App\Models\OfficeMinistry,name_bng,{$request->id}",
            'name_eng' => "string|required|unique:App\Models\OfficeMinistry,name_eng,{$request->id}",
            'name_eng_short' => "string|unique:App\Models\OfficeMinistry,name_eng_short,{$request->id}",
            'active_status' => 'nullable|numeric',
            'reference_code' => "required|unique:App\Models\OfficeMinistry,reference_code,{$request->id}",
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ], [
            'name_bng.required' => 'Ministry/Department Bangla Name Required',
            'name_eng.required' => 'Ministry/Department English name is required',
            'office_type.required' => 'Ministry/Department type required',
            'name_bng.unique' => 'Ministry/Department Bengali name used',
            'name_eng.unique' => 'Ministry/Department English name used',
            'name_bng.string' => 'Ministry/Department Bengali name must be string',
            'name_eng.string' => 'Ministry/Department English name must be string',
            'name_eng_short.string' => 'Ministry/Department Short name must be string',
            'name_eng_short.unique' => 'Ministry/Department Short name used.',
            'reference_code.required' => 'Ministry/Department code is required.',
            'reference_code.unique' => 'Ministry/Department code used.',
        ]);

        // dd(digit_replace($request->reference_code));


        if (!isset($request->active_status)) {
            $validAttribute['active_status'] = 0;
        }
        // dd($validAttribute['status']);
        if ($request->id !== null) {
			Cache::forget('office-ministry');
            $city_corporation = OfficeMinistry::find($request->id);
            $city_corporation->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
			Cache::forget('office-ministry');
            OfficeMinistry::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $exist_office_origin = OfficeOrigin::whereIn('office_ministry_id', $request->ministry_id)->count();

        if ($exist_office_origin > 0) {
            return response(['status' => 'error', 'msg' => 'This ministry has offices.']);
        } else {
            OfficeMinistry::whereIn('id', $request->ministry_id)->delete();
            Cache::forget('office-ministry');
            return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
        }
    }

}
