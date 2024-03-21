<?php

namespace App\Http\Controllers;

use App\Models\DesignationUpdateHistory;
use App\Models\EmployeeOffice;
use App\Models\OfficeUnitOrganogram;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EmployeeSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function officeEmployeeDesignation()
    {
        return view('officeemployee.office_employee_designation_update');
    }

    public function officeEmployeeDesignationUpdateList()
    {
        $office_unit_id = Auth::user()->current_office_unit_id();
        $office_id = Auth::user()->current_office_id();
        $designation_id = Auth::user()->current_designation_id();

        $unit_admin = OfficeUnitOrganogram::where('id', $designation_id)->first();

        if ($unit_admin->is_admin) {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->orderBy('designation_sequence')
                ->orderBy('designation_level')
                ->get();
        } else if ($unit_admin->is_unit_admin) {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->where('office_unit_id',
                $office_unit_id)->orderBy('designation_sequence')->get();
        } else {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->orderBy('designation_sequence')->get();
        }

        return view('officeemployee.office_employee_designation_updatelist', compact('organograms','unit_admin'));
    }
    public function generateEmployeeDesignationExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('595d6e');
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true)->setSize('15')->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $sheet = $spreadsheet->getActiveSheet();
        $office_unit_id = Auth::user()->current_office_unit_id();
        $office_id = Auth::user()->current_office_id();
        $designation_id = Auth::user()->current_designation_id();

        $unit_admin = OfficeUnitOrganogram::where('id', $designation_id)->first();

        if ($unit_admin->is_admin) {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->orderBy('designation_sequence')
                ->orderBy('designation_level')
                ->get();
        } else if ($unit_admin->is_unit_admin) {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->where('office_unit_id',
                $office_unit_id)->orderBy('designation_sequence')->get();
        } else {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->orderBy('designation_sequence')->get();
        }

        $sheet->setCellValue('A1', 'Sl.');
        $sheet->setCellValue('B1', 'Id');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Designation');
        $sheet->setCellValue('E1', 'Designation (English)');

        $count = 2;
        foreach ($organograms as $key =>$organogram) {
            $sheet->setCellValue('A' . $count, (enTobn($key+1)));
            $sheet->setCellValueExplicit('B' . $count, ($organogram->assigned_user && $organogram->assigned_user->employee_record && $organogram->assigned_user->employee_record->user) ? $organogram->assigned_user->employee_record->user->username : '',\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $count, $organogram->assigned_user ? $organogram->assigned_user->employee_record->name_bng : '');
            $sheet->setCellValue('D' . $count, $organogram->designation_bng);
            $sheet->setCellValue('E' . $count, $organogram->designation_eng);


            $count++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('employee_designation.xlsx');
        $file_name = 'employee_designation.xlsx';
        $full_path = url('/employee_designation.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }
    public function getOfficeEmployeeDesignation(Request $request)
    {
        $designation_id = $request->designation_id;
        $employee_office_id = $request->employee_office_id;
        $designation_info = OfficeUnitOrganogram::select('designation_eng', 'designation_bng')->find($designation_id);
        return view('officeemployee.get_office_employee_designation', compact('designation_info', 'designation_id', 'employee_office_id'));
    }

    //designation changer
    // office_unit_organogram e update hobe
    // -> update desingatoon_en,bn

    // employee_offices er update hobe
    // -> search by organogram_id and status(1)
    // -> if no -> return
    // -> if yes -> cloning the e_office row -> making the parent to status 0 -> new row will be updated by new
    // designation_en,bn

    // designation_update_history te insert

    public function OfficeEmployeeDesignationUpdate(Request $request)
    {
        $designation_id = $request->designation_id;
        $designation_eng = $request->designation_eng;
        $designation_bng = $request->designation_bng;
        $employee_office_id = $request->employee_office_id;

        $designation_info = OfficeUnitOrganogram::find($designation_id);
        if ($employee_office_id) {
            $needToDeactiveEmployee = EmployeeOffice::where('office_unit_organogram_id', $designation_id)
                ->whereStatus(1)
                ->first();
            if ($needToDeactiveEmployee) {
                $newEmployeeOffice = $needToDeactiveEmployee->replicate();
                $newEmployeeOffice->designation = $designation_bng;
                $newEmployeeOffice->designation_en = $designation_eng;
                $newEmployeeOffice->joining_date = date('Y-m-d');
                $newEmployeeOffice->created_by = Auth::id();
                $newEmployeeOffice->modified_by = Auth::id();
                $needToDeactiveEmployee->last_office_date = date('Y-m-d');
                $needToDeactiveEmployee->status = 0;
            }
        }

        $designation_update_history = new DesignationUpdateHistory();
        $designation_update_history->designation_id = $designation_id;
        $designation_update_history->office_id = $designation_info->office_id;
        $designation_update_history->office_unit_id = $designation_info->office_unit_id;
        $designation_update_history->superior_unit_id = $designation_info->superior_unit_id;
        $designation_update_history->superior_designation_id = $designation_info->superior_designation_id;
        $designation_update_history->ref_origin_unit_org_id = $designation_info->ref_origin_unit_org_id;
        $designation_update_history->old_designation_eng = $designation_info->designation_eng;
        $designation_update_history->old_designation_bng = $designation_info->designation_bng;

        $designation_update_history->designation_eng = $designation_eng;
        $designation_update_history->designation_bng = $designation_bng;

        $designation_update_history->employee_office_id = $designation_info->office_id;
        $designation_update_history->employee_unit_id = $designation_info->office_unit_id;
        $designation_update_history->employee_designation_id = $designation_info->id;
        $designation_update_history->created_by = Auth::id();
        $designation_update_history->modified_by = Auth::id();

        $designation_info->designation_bng = $designation_bng;
        $designation_info->designation_eng = $designation_eng;


        DB::beginTransaction();
        try {
            $designation_info->save();
            if ($employee_office_id) {
                $needToDeactiveEmployee->save();
                $newEmployeeOffice->save();
            }
            $designation_update_history->save();
            DB::commit();
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => '
            Update failed.', 'data' => $e]);
        }
    }

    public function officeSectionVisibility()
    {

        $office_unit_id = Auth::user()->current_office_unit_id();
        $office_id = Auth::user()->current_office_id();
        $designation_id = Auth::user()->current_designation_id();

        $unit_admin = OfficeUnitOrganogram::where('id', $designation_id)->first();

        if ($unit_admin->is_admin) {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->orderBy('designation_sequence')->get();
        } else if ($unit_admin->is_unit_admin) {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->where('office_unit_id', $office_unit_id)->orderBy('designation_sequence')->get();
        } else {
            $organograms = OfficeUnitOrganogram::where('office_id', $office_id)->orderBy('designation_sequence')->get();
        }


        return view('officeemployee.office_section_visibility', compact('organograms'));
    }

    public function officeSectionVisibilityUpdate(Request $request)
    {
        $designation_info = EmployeeOffice::find($request->employee_office_id);
        $designation_info->show_unit = $request->show_unit;
        $designation_info->save();
        // dd($designation_info);
        return response(['status' => 'success', 'msg' => 'Successfully updated.']);
    }
}
