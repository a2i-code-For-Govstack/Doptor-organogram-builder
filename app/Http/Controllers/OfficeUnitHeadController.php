<?php

namespace App\Http\Controllers;

use App\Models\EmployeeOffice;
use App\Models\HonorBoard;
use App\Models\OfficeMinistry;
use App\Models\OfficeUnitOrganogram;
use DB;
use Illuminate\Http\Request;

class OfficeUnitHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $ministries = OfficeMinistry::get();
        return view('assign_office_unit_head_responsibility', compact('ministries'));
    }


    public function loadOfficeWiseUsers(Request $request)
    {
        $employee_offices = EmployeeOffice::where('office_id', $request->office_id)->get();

        return view('assignofficeunitheadresponsibility.get_employee_info', compact('employee_offices'));
    }

    public function loadOfficeUnitWiseOrganogram(Request $request)
    {
        $organograms = OfficeUnitOrganogram::where('office_unit_id', $request->office_unit_id)
            ->where('status', 1)
            ->orderBy('designation_level', 'ASC')
            ->orderBy('designation_sequence', 'ASC')
            ->get();

        $current_responsible = $organograms->where('is_unit_head', 1)->first();
        $assigned_users = $organograms->whereNotNull('assigned_user')->where('is_unit_head', 0);
        $unassigned_users = $organograms->whereNull('assigned_user')->where('is_unit_head', 0);


        return view('assignofficeunitheadresponsibility.get_employee_info', compact('current_responsible', 'assigned_users', 'unassigned_users'));
    }


    public function assignOfficeUnitHead(Request $request)
    {
        DB::beginTransaction();
        try {
            $office_unit_organogram = OfficeUnitOrganogram::find($request->office_unit_organogram_id);
            $prev_unit_admin = OfficeUnitOrganogram::where('office_unit_id', $office_unit_organogram->office_unit_id)->where('is_unit_head', 1)->first();
            if ($office_unit_organogram) {

                $sync_data = [
                    'is_office_unit_head' => 'Yes',
                    'office_unit_organogram_id' => $request->office_unit_organogram_id,
                    'office_id' => $office_unit_organogram->office_id,
                    'office_unit_id' => $office_unit_organogram->office_unit_id,
                ];

                if ($prev_unit_admin) {
                    $unassign_data = [
                        'is_office_unit_head' => 'No',
                        'office_unit_organogram_id' => $prev_unit_admin->id,
                        'office_id' => $prev_unit_admin->office_id,
                        'office_unit_id' => $prev_unit_admin->office_unit_id,
                    ];
                    OfficeUnitOrganogram::where('office_unit_id', $office_unit_organogram->office_unit_id)->update(['is_unit_head' => 0]);
                }


                $office_unit_organogram->update(['is_unit_head' => 1]);

                $honor_board = new HonorBoard;
                $honor_board->unit_id = $office_unit_organogram->office_unit_id;
                $honor_board->name = !empty($office_unit_organogram->assigned_user) ? $office_unit_organogram->assigned_user->employee_record->name_bng : '';
                $honor_board->organogram_name = $office_unit_organogram->designation_bng;
                $honor_board->incharge_label = !empty($office_unit_organogram->assigned_user) ? $office_unit_organogram->assigned_user->incharge_label : null;
                $honor_board->employee_record_id = !empty($office_unit_organogram->assigned_user) ? $office_unit_organogram->assigned_user->employee_record_id : null;
                $honor_board->organogram_id = $office_unit_organogram->id;
                $honor_board->join_date = date('Y-m-d');
                $honor_board->save();
                if ($prev_unit_admin && !empty($office_unit_organogram->assigned_user) && !empty($prev_unit_admin->assigned_user)) {
                    HonorBoard::where('unit_id', $prev_unit_admin->office_unit_id)->where('employee_record_id', $prev_unit_admin->assigned_user->employee_record_id)->update(['release_date' => date('Y-m-d')]);
                }
                DB::commit();
                return response(['status' => 'success', 'msg' => 'Successfully selected office unit head.']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => 'It was not possible to select the head of the office unit.', 'data' => $e]);
        }
    }

    public function searchOfficeUnitHead()
    {

    }
}
