<?php

namespace App\Http\Controllers;

use App\Models\HonorBoard;
use App\Models\OfficeUnit;
use App\Models\EmployeeRecord;
use App\Models\OfficeUnitOrganogram;
use Illuminate\Http\Request;
use Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HonorBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $office_id = Auth::user()->current_office_id();
        $office_units = OfficeUnit::where('office_id',$office_id)->orderBy('unit_level')->get();
        // $honor_board_list =  HonorBoard::all();
        return view('office.office_honor_board',compact('office_units'));
    }

    public function getHonorBoard(Request $request){
        $office_id = Auth::user()->current_office_id();
        $office_unit_id = Auth::user()->current_office_unit_id();
        $designation_id = Auth::user()->current_designation_id();
        $admin = OfficeUnitOrganogram::where('id', $designation_id)->first();
        if ($office_id) {
            if ($admin->is_unit_admin) {
                $honor_board_list = HonorBoard::where('unit_id',$office_unit_id)->get();
            } elseif ($admin->is_admin) {
                $honor_board_list = HonorBoard::where('unit_id',$request->office_unit_id)->get();
            }
        }
        if (Auth::user()->user_role_id == config('menu_role_map.super_admin') || Auth::user()->user_role_id == config('menu_role_map.admin')) {
            $honor_board_list = HonorBoard::where('unit_id',$request->office_unit_id)->get();
        }

        return view('office.get_office_honor_board',compact('honor_board_list'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function GenerateHonorBoardExcelFile()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $office_unit_id = Auth::user()->current_office_unit_id();

        $honor_board_list = HonorBoard::where('unit_id',$office_unit_id)->paginate();

        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Designation');
        $sheet->setCellValue('C1', 'From');
        $sheet->setCellValue('D1', 'To');
        $sheet->setCellValue('E1', 'Label');

        $count = 2;
        foreach ($honor_board_list as $key => $value) {
            $sheet->setCellValue('A' . $count, $value->name);
            $sheet->setCellValue('B' . $count, $value->organogram_name);
            $sheet->setCellValue('C' . $count, (enTobn(date('d-m-Y',strtotime($value->join_date)))));
            $sheet->setCellValue('D' . $count, (enTobn(date('d-m-Y',strtotime($value->release_date)))));
            $sheet->setCellValue('E' . $count, $value->incharge_label);
            $count++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('Honor_Board.xlsx');
        $file_name = 'Honor_Board.xlsx';
        $full_path = url('/Honor_Board.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validAttribute = request()->validate([
            'unit_id' => 'required',
            'name' => 'required|string',
            'organogram_name' => 'string',
            'incharge_label' => 'required',
            'organogram_id' => 'required',
            'employee_record_id' => 'required',
            'join_date' => 'string',
            'release_date' => 'nullable',
            'id' => 'nullable|numeric',
            'created' => 'nullable',
            'modified' => 'nullable'
        ]);

        $validAttribute['join_date'] = date('Y-m-d',strtotime($request->join_date));
        $validAttribute['release_date'] = date('Y-m-d',strtotime($request->release_date));
        // if (!isset($request->status)) {
        //     $validAttribute['status'] = 0;
        // }

        // dd($validAttribute['organogram_id']);
        if ($request->id !== null) {
            $bivag = HonorBoard::find($request->id);
            $bivag->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            HonorBoard::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }

    }

    public function searchEmployeeOfficeWise(Request $request){
        $search = $request->search;
        $unit_id = $request->unit_id;
        $office_id = Auth::user()->current_office_id();

        if ($search == '') {
            $get_emp_info = EmployeeRecord::whereHas('employee_office',function
            ($query) use ($office_id,$unit_id){
              $query->where('office_id',$office_id)->where('office_unit_id',$unit_id);
            })->orderby('id', 'asc')->limit(5)->get();
        } else {
            $get_emp_info = EmployeeRecord::whereHas('employee_office',function
            ($query) use ($office_id,$unit_id){
              $query->where('office_id',$office_id)->where('office_unit_id',$unit_id);
            })->orderby('id', 'asc')->where('name_bng', 'like', '%' . $search . '%')->limit(15)->get();
        }

        // dd($get_emp_info);

        $response = array();
        foreach ($get_emp_info as $emp) {
            // dd($emp->employee_office);
            foreach ($emp->employee_office as $key => $value) {
                if ($value->office_unit_organogram_id) {
                    $organogram_id = $value->office_unit_organogram_id;
                    $organogram_name = $value->designation;
                    $unit_id = $value->office_unit_id;
                }else{
                    $organogram_id = '';
                    $organogram_name = '';
                    $unit_id = '';
                }
                $response[] = array("value" => $emp->id, "label" => $emp->name_bng.'('.$organogram_name.')',"organogram_id" => $organogram_id,"organogram_name" => $organogram_name,"name_bng" => $emp->name_bng,'unit_id' => $unit_id);
            }

        }

        // dd($response);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(HonorBoard $honor_board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function officeEdit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function officeUpdate(Request $request)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        foreach ($request->honor_id as $key => $value) {
            HonorBoard::where('id',$value)->delete();
        }

        return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
    }
}
