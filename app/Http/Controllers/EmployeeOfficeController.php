<?php

namespace App\Http\Controllers;

use App\Models\EmployeeOffice;
use App\Models\EmployeeRecord;
use Illuminate\Http\Request;

class EmployeeOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $this->validate($request, [
            'employee_record_id' => 'nullable | numeric',
            'office_id' => 'nullable | numeric',
            'office_unit_id' => 'nullable | numeric',
            'office_unit_organogram_id' => 'nullable | numeric',
            'designation' => 'nullable |string',
            'designation_level' => 'nullable |numeric',
            'designation_sequence' => 'nullable |numeric',
            'is_default_role' => 'nullable |numeric',
            'office_head' => 'nullable |numeric',
            'is_admin' => 'nullable |numeric',
            'summary_nothi_post_type' => 'nullable |numeric',
            'incharge_label' => 'nullable|string',
            'main_role_id' => 'nullable |numeric',
            'joining_date' => 'sometimes',
            'last_office_date' => 'sometimes',
            'status' => 'nullable |numeric',
            'status_change_date' => 'sometimes',
            'show_unit' => 'nullable |numeric',
            'designation_en' => 'nullable |string',
            'unit_name_bn' => 'nullable |string',
            'office_name_bn' => 'nullable |string',
            'unit_name_en' => 'nullable |string',
            'office_name_en' => 'nullable |string',

            'name_bng' => 'nullable |string',
            'name_eng' => 'nullable |string',
            'identification_number' => 'nullable |string',
            'personal_email' => 'nullable |string',
            'personal_mobile' => 'nullable |string',
            'is_cadre' => 'nullable |numeric',

            'username' => 'nullable |string',
        ]);

        if ($request->id !== null) {
            $employee_office = EmployeeOffice::findOrFail($request->id);
            $employee_office->identification_number=$request->identification_number;
            $employee_office->office_id=$request->office_id;
            $employee_office->office_unit_id=$request->office_unit_id;
            $employee_office->office_unit_organogram_id=$request->office_unit_organogram_id;
            $employee_office->designation=$request->designation;
            $employee_office->designation_level=$request->designation_level;
            $employee_office->designation_sequence=$request->designation_sequence;
            $employee_office->is_default_role=$request->is_default_role;
            $employee_office->office_head=$request->office_head;
            $employee_office->is_admin=$request->is_admin;
            $employee_office->summary_nothi_post_type=$request->summary_nothi_post_type;
            $employee_office->incharge_label=$request->incharge_label;
            $employee_office->main_role_id=$request->main_role_id;
            $employee_office->joining_date=$request->joining_date;
            $employee_office->last_office_date=$request->last_office_date;
            $employee_office->status=$request->status;
            $employee_office->status_change_date=$request->status_change_date;
            $employee_office->show_unit=$request->show_unit;
            $employee_office->designation_en=$request->designation_en;
            $employee_office->unit_name_bn=$request->unit_name_bn;
            $employee_office->office_name_bn=$request->office_name_bn;
            $employee_office->unit_name_en=$request->unit_name_en;
            $employee_office->office_name_en=$request->office_name_en;
            $employee_office->update();

            $employee_record = EmployeeRecord::findOrFail($employee_office->employee_record_id);
            $employee_record->name_bng = $request->name_bng;
            $employee_record->name_eng = $request->name_eng;
            $employee_record->identification_number = $request->identification_number;
            $employee_record->personal_email = $request->personal_email;
            $employee_record->personal_mobile = $request->personal_mobile;
            $employee_record->is_cadre = $request->is_cadre;
            $employee_record->update();

            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            EmployeeOffice::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeOffice  $employeeOffice
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeOffice $employeeOffice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeOffice  $employeeOffice
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeOffice $employeeOffice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeOffice  $employeeOffice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeOffice $employeeOffice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeOffice  $employeeOffice
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeOffice $employeeOffice)
    {
        //
    }
}
