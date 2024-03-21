<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRecord;
use App\Models\OfficeUnit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SelfRegistration;
use App\Models\EmployeeCadre;
use App\Models\EmployeeBatch;
use App\Models\Office;
use App\Models\EmployeeOffice;
use App\Models\OfficeInchargeType;
use App\Models\OfficeUnitOrganogram;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SelfRegistrationController extends Controller
{
    public function index()
    {
        $cadres = EmployeeCadre::all();
        $batches = EmployeeBatch::all();
        $office_incharges = OfficeInchargeType::all();

        return view('user_self_registration.signup', compact('cadres', 'batches', 'office_incharges'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $validAttributeUpdate = request()->validate([
            'id' => 'nullable|numeric',
            'prefix_name_bng' => 'nullable|string',
            'prefix_name_eng' => 'nullable|string',
            'name_bng' => 'required|string',
            'name_eng' => 'required|string',
            'surname_bng' => 'nullable|string',
            'surname_eng' => 'nullable|string',
            'identification_number' => 'nullable |string',
            'personal_email' => 'required |unique:App\Models\EmployeeRecord,personal_email',
            'personal_mobile' => 'required |unique:App\Models\EmployeeRecord,personal_mobile',
            'father_name_bng' => 'nullable |string',
            'father_name_eng' => 'nullable |string',
            'mother_name_bng' => 'nullable |string',
            'mother_name_eng' => 'nullable |string',
            'date_of_birth' => 'nullable ',
            'nid' => 'required |unique :App\Models\EmployeeRecord,nid',
            'bcn' => 'nullable |numeric',
            'ppn' => 'nullable |numeric',
            'gender' => 'required',
            'religion' => 'nullable |string',
            'blood_group' => 'nullable |string',
            'marital_status' => 'nullable |string',
            'alternative_mobile' => 'nullable |string',
            'is_cadre' => 'required|in:1,2,3',
            'joining_date' => 'nullable',
            'employee_batch_id' => 'nullable |string',
            'employee_cadre_id' => 'nullable |string',
            'employee_grade' => 'nullable |numeric',
            'identity_no' => 'nullable |string',
            'appointment_memo_no' => 'nullable |string',
            'office_id' => 'required |numeric',
            'office_unit_id' => 'required |numeric',
            'designation_id' => 'required |numeric',
            // 'status' => 'nullable |numeric',
            'designation_joining_date' => 'nullable |string',
            'created_by' => 'nullable |numeric',
            'modified_by' => 'nullable |numeric',
        ], [
            'name_bng.required' => 'Name is required.',
            'name_eng.required' => 'Name English is required.',
            'personal_email.required' => 'Personal email is required.',
            'personal_email.unique' => 'Personal email is used.',
            'personal_mobile.required' => 'Personal mobile is required.',
            'personal_mobile.min' => 'Personal mobile minimum 11.',
            'personal_mobile.max' => 'Personal mobile maximum 14.',
            'personal_mobile.unique' => 'Personal mobile used.',
            'nid.required' => '
            National ID number is required.',
            'nid.unique' => 'National Identity Card Number is used.',
            'is_cadre.required' => 'Cadre is required',
            'gender.required' => '
            Gender is required',
            'designation_id.required' => 'Office Layer Required',
        ]);
        // dd($validAttributeUpdate);

        $dob = date('Y-m-d', strtotime($request->date_of_birth));
        $today = date('Y-m-d');
        $personal_mobile = bnToen($request->personal_mobile);
        $datetime1 = date_create($dob);
        $datetime2 = date_create($today);
        $interval = date_diff($datetime1, $datetime2);
        $year = $interval->format('%y');

        if ($year < 18) {
            return response()->json(['status' => 'error', 'msg' => 'Minimum age should be 18 years']);
        }

        $joining_date = $request->joining_date ? date('Y-m-d', strtotime($request->joining_date)) : now()->format('Y-m-d');
        $designation_joining_date = $request->designation_joining_date ? date('Y-m-d', strtotime($request->designation_joining_date)) : now()->format('Y-m-d');

        $validAttributeUpdate['date_of_birth'] = $dob;
        $validAttributeUpdate['joining_date'] = $joining_date;
        $validAttributeUpdate['designation_joining_date'] = $designation_joining_date;
        $validAttributeUpdate['personal_mobile'] = $personal_mobile;
        $validAttributeUpdate['status'] = 1;

        SelfRegistration::create($validAttributeUpdate);
        DB::commit();
        return response()->json(['status' => 'success', 'msg' => 'Completed successfully.']);
    }

    public function registrationRequestList()
    {
        return view('user_self_registration.registration_request_list');
    }

    public function getRegistrationRequestList()
    {
        $reg_list = SelfRegistration::orderBy('id', 'DESC')->with('office', 'office_unit', 'office_designation')->paginate();

        return view('user_self_registration.get_registration_request_list', compact('reg_list'));
    }

    public function searchRegistrations(Request $request)
    {
        $name_bng = $request->name_bng;
        $nid = $request->nid;
        $personal_mobile = bnToen($request->personal_mobile);
        $personal_email = $request->personal_email;
        $query = SelfRegistration::query();

        $query->when($name_bng, function ($q, $name_bng) {
            return $q->where('name_bng', $name_bng);
        });

        $query->when($nid, function ($q, $nid) {
            return $q->where('nid', $nid);
        });

        $query->when($personal_mobile, function ($q, $personal_mobile) {
            return $q->where('personal_mobile', $personal_mobile);
        });

        $query->when($personal_email, function ($q, $personal_email) {
            return $q->where('personal_email', $personal_email);
        });

        $reg_list = $query->paginate();
        $html = view('user_self_registration.get_registration_request_list', compact('reg_list'));

        return response($html);
    }

    public function approveRegRequest(Request $request)
    {
        $registration = SelfRegistration::find($request->registration_id);

        DB::beginTransaction();
        try {

            $dob = $request->date_of_birth ? date('Y-m-d', strtotime($request->date_of_birth)) : null;
            $joining_date = $request->joining_date ? date('Y-m-d', strtotime($request->joining_date)) : null;

            $emp_record_data['prefix_name_bng'] = $registration->prefix_name_bng;
            $emp_record_data['prefix_name_eng'] = $registration->prefix_name_eng;
            $emp_record_data['name_bng'] = $registration->name_bng;
            $emp_record_data['name_eng'] = $registration->name_eng;
            $emp_record_data['surname_bng'] = $registration->surname_bng;
            $emp_record_data['surname_eng'] = $registration->surname_eng;
            $emp_record_data['identification_number'] = $registration->identification_number;
            $emp_record_data['personal_email'] = $registration->personal_email;
            $emp_record_data['personal_mobile'] = $registration->personal_mobile;
            $emp_record_data['father_name_bng'] = $registration->father_name_bng;
            $emp_record_data['father_name_eng'] = $registration->father_name_eng;
            $emp_record_data['mother_name_bng'] = $registration->mother_name_bng;
            $emp_record_data['mother_name_eng'] = $registration->mother_name_eng;
            $emp_record_data['nid'] = $registration->nid;
            $emp_record_data['gender'] = $registration->gender;
            $emp_record_data['religion'] = $registration->religion;
            $emp_record_data['blood_group'] = $registration->blood_group;
            $emp_record_data['marital_status'] = $registration->marital_status;
            $emp_record_data['alternative_mobile'] = $registration->alternative_mobile;
            $emp_record_data['is_cadre'] = $registration->is_cadre;
            $emp_record_data['employee_grade'] = $registration->employee_grade;
            $emp_record_data['employee_batch_id'] = $registration->employee_batch_id;
            $emp_record_data['employee_cadre_id'] = $registration->employee_cadre_id;
            $emp_record_data['identity_no'] = $registration->identity_no;
            $emp_record_data['appointment_memo_no'] = $registration->appointment_memo_no;
            $emp_record_data['date_of_birth'] = $dob;
            $emp_record_data['joining_date'] = $joining_date;
            $emp_record_data['status'] = 1;
            $emp_record_data['created_by'] = Auth::user()->id;
            $emp_record_data['modified_by'] = Auth::user()->id;

            $employee_id = EmployeeRecord::create($emp_record_data);

            $identity_no = bnToen($registration->identity_no);

            if ($registration->is_cadre == 1) {
                if ($identity_no == "") {
                    $username_list = User::select('username')->where('username', 'like', '3%')->whereRaw('LENGTH(username) = 12')->max('username');
                    $username = $username_list + 1;
                } else {
                    $gen_11no = str_pad($identity_no, 11, '0', STR_PAD_LEFT);
                    $username = '';
                    $username_one = '1' . $gen_11no;
                    $username_two = '5' . $gen_11no;
                    $username_three = '3' . $gen_11no;

                    $exist_one = User::select('username')->where('username', $username_one)->exists();
                    if ($exist_one) {
                        $exist_two = User::select('username')->where('username', $username_two)->exists();
                        if ($exist_two) {
                            return response()->json(['status' => 'exist', 'msg' => 'Already exist']);
                        } else {
                            $username = $username_two;
                        }
                    } else {
                        $username = $username_one;
                    }
                }
            } else if ($registration->is_cadre == 2) {

                $username_list = User::select('username')->where('username', 'like', '2%')->whereRaw('LENGTH(username) = 12')->max('username');
                $username = $username_list + 1;
            } else if ($registration->is_cadre == 3) {
                $username_list = User::select('username')->where('username', 'like', '7%')->whereRaw('LENGTH(username) = 12')->max('username');
                $username = $username_list + 1;
            }

            $user = new User;
            $user->username = $username;
            $user->password = Hash::make('02522016');
            $user->user_alias = $username;
            $user->active = 1;
            $user->user_role_id = 3;
            $user->user_status = 1;
            $user->modified_by = Auth::user()->id;
            $user->is_email_verified = 0;
            $user->created_by = auth()->id();
            $user->employee_record_id = $employee_id->id;
            $user->save();

            if ($registration->designation_id) {
                $office_id = $registration->office_id; //change
                $office_info = Office::find($office_id);
                $designation_info = OfficeUnitOrganogram::find($registration->designation_id);
                $office_unit_info = OfficeUnit::find($registration->office_unit_id);
                $exist_employee = EmployeeOffice::where('office_id', $office_id)->where('office_unit_id', $registration->office_unit_id)->where('status', 1)->first();

                $employee_office = new EmployeeOffice();
                $employee_office->office_unit_organogram_id = $registration->designation_id;
                $employee_office->office_unit_id = $registration->office_unit_id;
                $employee_office->office_id = $office_id;
                $employee_office->designation = $designation_info->designation_bng;
                $employee_office->designation_en = $designation_info->designation_eng;
                $employee_office->designation_level = $designation_info->designation_level;
                $employee_office->joining_date = $registration->designation_joining_date;
                $employee_office->unit_name_bn = $office_unit_info->unit_name_bng;
                $employee_office->unit_name_en = $office_unit_info->unit_name_eng;
                $employee_office->office_name_bn = $office_info->office_name_bng;
                $employee_office->office_name_en = $office_info->office_name_eng;
                $employee_office->employee_record_id = $employee_id->id;

                if ($identity_no) {
                    $identity_no = $identity_no;
                } else {
                    $identity_no = 0;
                }
                $employee_office->identification_number = $identity_no;
                $employee_office->is_default_role = 0;

                if ($registration->incharge_label) {
                    $employee_office->incharge_label = $registration->incharge_label;
                } else {
                    $employee_office->incharge_label = '';
                }
                $employee_office->status = 1;
                $employee_office->joining_date = date('Y-m-d', strtotime($registration->joining_date));
                $employee_office->save();

                if (is_null($exist_employee)) {
                    $data['is_unit_admin'] = 1;
                    OfficeUnitOrganogram::where('id', $registration->designation_id)->update($data);
                }

                $registration->modified_by = Auth::user()->id;
                $registration->modified_at = date('Y-m-d H:i:s');
                $registration->status = 1;
                $registration->save();
            }
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception->errors(),
                'statusCode' => '422',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => '
            Update failed.', 'data' => $e]);
        }
        DB::commit();

        return response()->json(['status' => 'success', 'msg' => 'Completed successfully.', 'userid' => $username, 'name' => $employee_id->full_name_bng]);
    }

    public function rejectRegRequest(Request $request)
    {
        try {
            $registration_id = $request->registration_id;

            $registration = SelfRegistration::find($registration_id);
            $registration->status = 0;
            $registration->modified_by = Auth::user()->id;
            $registration->modified_at = date('Y-m-d H:i:s');
            return response()->json(['status' => 'success', 'msg' => 'Completed successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'Update failed.', 'data' => $e]);
        }
    }
}
