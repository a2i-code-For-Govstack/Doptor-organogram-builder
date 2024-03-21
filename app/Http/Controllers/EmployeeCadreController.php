<?php

namespace App\Http\Controllers;

use App\Models\EmployeeCadre;
use App\Models\EmployeeRecord;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Auth;

class EmployeeCadreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employee_management_cadre');
    }

    public function getEmployeeCadreData()
    {
        $employee_cadres = EmployeeCadre::get();
        return view('employeecadre.get_employee_cadre', compact('employee_cadres'));
    }


    public function generateEmployeeManagementCadreExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $employee_cadres = EmployeeCadre::all();

        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'Cadre List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Sl.');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Cadre Name (Bangla)');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->setCellValue('C2', 'Cadre Name (English)');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $count = 3;
        foreach ($employee_cadres as $employee_cadre) {
            $sheet->setCellValue('A' . $count, $employee_cadre->id);
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, $employee_cadre->cadre_name_bng);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('C' . $count, $employee_cadre->cadre_name_eng);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $count++;
        }
        
        expand_spreadsheet($sheet, $spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Cadre List.xlsx');
        $file_name = 'Cadre List.xlsx';
        $full_path = url('storage/Cadre List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function searchCadre(Request $request){

        $cadre_name_bng = $request->name_bn;
        $cadre_name_eng = $request->name_en;

        $query = EmployeeCadre::query();
        $query->when($cadre_name_eng, function ($q, $cadre_name_eng) {
            return $q->where('cadre_name_eng', $cadre_name_eng);
        });

        $query->when($cadre_name_bng, function ($q, $cadre_name_bng) {
            return $q->where('cadre_name_bng', $cadre_name_bng);
        });

        $employee_cadres = $query->paginate();
        $html =  view('employeecadre.get_employee_cadre', compact('employee_cadres'));
        return response($html);
    }

    public function changeCadre(){

        return view('employeecadre.change_cadre');
    }

    public function getCadreInfo(Request $request){

        $user = User::where('username', $request->username)->select('employee_record_id')->first();
        // dd($user->employee_record_id);
        if ($user) {
            $employee_info = EmployeeRecord::where('id', $user->employee_record_id)->first();
        }else{
            $employee_info = '';
        }
        return view('employeecadre.get_employee_cadre_info', compact('employee_info'));

    }

    public function changeToCadre(Request $request){

         $id = $request->employee_record_id;
         $identity_no = $request->identity_no;

         $gen_11no = str_pad($identity_no, 11, '0', STR_PAD_LEFT);
         $username = '';
         $username_one = '1'.$gen_11no;
         $username_two = '3'.$gen_11no;
         $username_three = '5'.$gen_11no;


         $exist_one =  User::select('username')->where('username',$username_one)->exists();

         if ($exist_one > 0 ) {
             $exist_two =  User::select('username')->where('username',$username_two)->exists();

             if ($exist_two > 0) {
                 $exist_three =  User::select('username')->where('username',$username_three)->exists();

                 if ($exist_three > 0) {
                     return response(['status' => 'exist', 'msg' => 'Already exist']);

                 }else{
                    $username = $username_three;
                 }
             }else{
                $username = $username_two;
             }
         }else{
            $username = $username_one;
         }


         $employee = EmployeeRecord::find($id);
         $employee->is_cadre = 1;
         $employee->identity_no = $identity_no;
         $employee->save();


         $data['username'] = $username;
         // $data['user_alias'] = $username;
         User::where('employee_record_id',$request->employee_record_id)->update($data);

         // 200000002946
         return response(['status' => 'success', 'msg' => 'Successfully updated.','identity_no' => $identity_no,'username' => $username]);
    }

    public function changeToNonCadre(Request $request){

        $username_list = User::select('username')->where('username', 'like', '2%')->whereRaw('LENGTH(username) = 12')->max('username');
//        dd($username_list);
        $data['username'] = $username_list + 1;
         // dd($data['username']);
         // $data['user_alias'] = $username;
         $employee = EmployeeRecord::find($request->employee_record_id);
         $employee->is_cadre = 0;
         $employee->identity_no = 0;
         $employee->save();

         User::where('employee_record_id',$request->employee_record_id)->update($data);
         return response(['status' => 'success', 'msg' => 'Successfully updated.', 'username' => $data['username']]);

    }


    public function changeOneToOtherCadre(){
        return view('employeecadre.change_other_cadre');
    }

    public function getOnlyCadreInfo(Request $request){

        $user = User::where('username', $request->username)->select('employee_record_id')->first();
        // dd($user->employee_record_id);
        if ($user) {
            $employee_info = EmployeeRecord::where('id', $user->employee_record_id)->where('is_cadre', 1)->first();
        }else{
            $employee_info = [];
        }
        return view('employeecadre.get_only_employee_cadre_info', compact('employee_info'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validAttribute = request()->validate([
            'id' => 'nullable|numeric',
            'cadre_name_eng' => 'nullable|string',
            'cadre_name_bng' => 'string',
        ]);

        $validAttribute['created_by'] = Auth::user()->id;
        $validAttribute['modified_by'] = Auth::user()->id;

        if ($request->id !== null) {
            $employee_cadre = EmployeeCadre::find($request->id);
            $employee_cadre->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            EmployeeCadre::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeCadre  $employeeCadre
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeCadre $employeeCadre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeCadre  $employeeCadre
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeCadre $employeeCadre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeCadre  $employeeCadre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeCadre $employeeCadre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeCadre  $employeeCadre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $exist_employee =  EmployeeRecord::whereIn('employee_cadre_id',$request->emp_cadre_id)->count();

        if($exist_employee > 0){
            return response(['status' => 'error', 'msg' => 'Used in cadre officers.']);
        }else{
            EmployeeCadre::whereIn('id',$request->emp_cadre_id)->delete();
        }

        return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
    }
}
