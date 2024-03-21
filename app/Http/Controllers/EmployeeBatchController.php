<?php

namespace App\Http\Controllers;

use App\Models\EmployeeBatch;
use App\Models\EmployeeRecord;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EmployeeBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('employee_management_batch');
    }


    public function getEmployeeBatchData()
    {
        $employee_batches = EmployeeBatch::get();
        return view('employeebatch.get_employee_batch', compact('employee_batches'));
    }

    public function generateEmployeeManagementBatchExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $employee_batches = EmployeeBatch::get();

        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'Batch List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Sl.');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Batch Number');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'Joining Year');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $count = 3;
        foreach ($employee_batches as $employee_batch) {
            $sheet->setCellValue('A' . $count, (enTobn($employee_batch->id)));
            $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('B' . $count, $employee_batch->batch_no);
            $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('C' . $count, $employee_batch->batch_year);
            $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $count++;
        }

        expand_spreadsheet($sheet, $spreadsheet);
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Batch List.xlsx');
        $file_name = 'Batch List.xlsx';
        $full_path = url('storage/Batch List.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }

    public function searchBatch(Request $request){

        $batch_no = $request->batch_name;
        $batch_year = $request->batch_date;

        $query = EmployeeBatch::query();
        $query->when($batch_no, function ($q, $batch_no) {
            return $q->where('batch_no', $batch_no);
        });

        $query->when($batch_year, function ($q, $batch_year) {
            return $q->where('batch_year', $batch_year);
        });

        $employee_batches = $query->paginate();
        $html =  view('employeebatch.get_employee_batch', compact('employee_batches'));
        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
//        dd($request->all());

        $validAttribute = request()->validate([
            'id' => 'nullable|numeric',
            'batch_no' => 'required|numeric|unique:App\Models\EmployeeBatch,batch_no,{$request->id}',
            'batch_year' => 'nullable',
            'created_by' => 'nullable',
            'modified_by' => 'nullable'
        ]);

        if ($request->id !== null) {
            $employee_batch = EmployeeBatch::find($request->id);
            $employee_batch->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            EmployeeBatch::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeBatch  $employeeBatch
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeBatch $employeeBatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeBatch  $employeeBatch
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeBatch $employeeBatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeBatch  $employeeBatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeBatch $employeeBatch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeBatch  $employeeBatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
//        dd($request->emp_batch_id);
        $exist_employee =  EmployeeRecord::whereIn('employee_batch_id',$request->emp_batch_id)->count();

        if($exist_employee > 0){
            return response(['status' => 'error', 'msg' => 'Used in batch officials.']);
        }else{
            EmployeeBatch::whereIn('id',$request->emp_batch_id)->delete();
            return response(['status' => 'success', 'msg' => 'Deleted successfully.']);
        }


    }
}
