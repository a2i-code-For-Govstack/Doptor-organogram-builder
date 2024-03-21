<?php

namespace App\Http\Controllers;

use App\Models\EmployeeBatch;
use App\Models\EmployeeCadre;
use App\Models\EmployeeOffice;
use App\Models\EmployeeRecord;
use App\Models\Office;
use App\Models\OfficeCustomLayer;
use App\Models\OfficeInchargeType;
use App\Models\OfficeLayer;
use App\Models\OfficeMinistry;
use App\Models\OfficeOrigin;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EmployeeRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ministries = OfficeMinistry::select('name_bng', 'id')->get();
        return view('employee_record', compact('ministries'));
    }

    public function getEmployeeRecordData()
    {
        $employee_records = EmployeeRecord::whereHas('employee_office', function ($q) {
            return $q->orderBy('designation_sequence', 'ASC');
        })->limit(100)->get();
        //        dd($employee_records);
        return view('employeerecord.get_employee_record', compact('employee_records'));
    }

    public function generateOfficeWiseEmployeeExcelFile()
    {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $office_unit_id = Auth::user()->current_office_unit_id();
            $office_id = Auth::user()->current_office_id();
            $designation_id = Auth::user()->current_designation_id();

            $admin = OfficeUnitOrganogram::where('id', $designation_id)->first();

            if ($office_id) {
                if ($admin->is_admin) {
                    $organograms = EmployeeOffice::where('status', 1)->where('office_id', $office_id)->orderBy('id', 'desc')->get();
                } elseif ($admin->is_unit_admin) {
                    $organograms = EmployeeOffice::where('status', 1)->where('office_unit_id', $office_unit_id)->orderBy('id', 'desc')->get();
                }
            } else {
                $organograms = EmployeeRecord::with('user', 'active_employee_office')->orderBy('id', 'asc')->get();
            }


            $sheet->setCellValue('A1', 'Login Id');
            $sheet->setCellValue('B1', 'Name (Bangla)');
            $sheet->setCellValue('C1', 'Name (English)');
            $sheet->setCellValue('D1', 'Contact Number');
            $sheet->setCellValue('E1', 'Email');
            $sheet->setCellValue('F1', 'Mobile');
            $sheet->setCellValue('G1', 'Cadre');
            $sheet->setCellValue('H1', 'Designation');
            $sheet->setCellValue('I1', 'Unit');


            $count = 2;


            foreach ($organograms as $organogram) {
                if ($office_id) {
                    if (!empty($organogram)) {
                        $sheet->setCellValueExplicit('A' . $count, @$organogram->employee_record->user->username, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValue('B' . $count, $organogram->employee_record->name_bng);
                        $sheet->setCellValue('C' . $count, $organogram->employee_record->name_eng);
                        $sheet->setCellValue('D' . $count, $organogram->employee_record->identity_no);
                        $sheet->setCellValue('E' . $count, $organogram->employee_record->personal_email);
                        $sheet->setCellValueExplicit('F' . $count, $organogram->employee_record->personal_mobile, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValue('G' . $count, ($organogram->employee_record->is_cadre == 1) ? 'Yes' : 'No');
                        $sheet->setCellValue('H' . $count, $organogram->designation);
                        $sheet->setCellValue('I' . $count, $organogram->unit_name_bn);
                        $count++;
                    } else {
                        $sheet->setCellValue('A' . $count, '');
                        $sheet->setCellValue('B' . $count, '');
                        $sheet->setCellValue('C' . $count, '');
                        $sheet->setCellValue('D' . $count, '');
                        $sheet->setCellValue('E' . $count, '');
                        $sheet->setCellValue('F' . $count, '');
                        $sheet->setCellValue('G' . $count, '');
                        $sheet->setCellValue('H' . $count, $organogram->designation);
                        $sheet->setCellValue('I' . $count, $organogram->unit_name_bn);


                        $count++;
                    }
                } else {
                    if (!empty($organogram)) {
                        $sheet->setCellValueExplicit('A' . $count, !empty($organogram->user->username) ? $organogram->user->username : '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValue('B' . $count, $organogram->name_bng);
                        $sheet->setCellValue('C' . $count, $organogram->name_eng);
                        $sheet->setCellValue('D' . $count, $organogram->identity_no);
                        $sheet->setCellValue('E' . $count, $organogram->personal_email);
                        $sheet->setCellValueExplicit('F' . $count, $organogram->personal_mobile, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->setCellValue('G' . $count, ($organogram->is_cadre == 1) ? 'Yes' : 'No');
                        $sheet->setCellValue('H' . $count, !empty($organogram->active_employee_office) ? $organogram->active_employee_office->designation : '-');
                        $sheet->setCellValue('I' . $count, !empty($organogram->active_employee_office) ? $organogram->active_employee_office->unit_name_bn : '-');
                        $count++;
                    } else {
                        $sheet->setCellValue('A' . $count, '');
                        $sheet->setCellValue('B' . $count, '');
                        $sheet->setCellValue('C' . $count, '');
                        $sheet->setCellValue('D' . $count, '');
                        $sheet->setCellValue('E' . $count, '');
                        $sheet->setCellValue('F' . $count, '');
                        $sheet->setCellValue('G' . $count, '');
                        $sheet->setCellValue('H' . $count, !empty($organogram->active_employee_office) ? $organogram->active_employee_office->designation : '-');
                        $sheet->setCellValue('I' . $count, !empty($organogram->active_employee_office) ? $organogram->active_employee_office->unit_name_bn : '-');

                        $count++;
                    }
                }
            }
            $writer = new Xlsx($spreadsheet);
            if ($office_id) {
                if ($admin->is_admin) {
                    $file_name = 'OfficeWiseEmployee.xlsx';
                    $writer->save('storage/' . $file_name);
                    $full_path = url('/' . 'storage/' . $file_name);
                    return response()->json(['status' => 'success', 'file_name' => $file_name, 'full_path' => $full_path]);
                } elseif ($admin->is_unit_admin) {
                    $file_name = 'UnitWiseEmployee.xlsx';
                    $writer->save('storage/' . $file_name);
                    $full_path = url('/' . 'storage/' . $file_name);
                    return response()->json(['status' => 'success', 'file_name' => $file_name, 'full_path' => $full_path]);
                }
            } else {
                $file_name = 'AllEmployee.xlsx';
                $full_path = url('/' . 'storage/' . $file_name);
                return response()->json(['status' => 'success', 'file_name' => $file_name, 'full_path' => $full_path]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'data' => $e->getMessage()]);
        }
    }

    public function loadOfficeLayerMinistryWise(Request $request)
    {
        $office_layers = OfficeLayer::where('office_ministry_id', $request->ministry_id)->select('id', 'layer_name_bng')->get();
        return view('employeerecord.select_office_layer', compact('office_layers'));
    }

    public function loadOfficeOriginLayerWise(Request $request)
    {
        $office_origins = OfficeOrigin::where('office_layer_id', $request->office_layer_id)->select('id', 'office_name_bng')->get();
        return view('employeerecord.select_office_origin', compact('office_origins'));
    }

    public function searchEmployeeRecord(Request $request)
    {
        $office_ministry_id = $request->office_ministry_id;
        $office_layer_id = $request->office_layer_id;
        $office_origin_id = $request->office_origin_id;
        $office_id = $request->office_id;
        // $office_origin_id = $request->office_origin_id;
        $name_bng = $request->name_bn;
        $nid = $request->emp_nid;
        $personal_email = $request->emp_email;
        $personal_mobile = $request->emp_mobile;
        $loginId = $request->login_id;

        $query = EmployeeRecord::query();

        if ($office_id) {
            $query->whereHas('employee_office', function ($q) use ($office_id) {
                return $q->where('office_id', $office_id);
            });
        }
        if ($loginId) {
            $query->whereHas('user', function ($q) use ($loginId) {
                return $q->where('username', $loginId);
            });
        }

        $query->when($name_bng, function ($q, $name_bng) {
            return $q->where('name_bng', 'LIKE', '%{{$name_bng}}%');
        });

        $query->when($nid, function ($q, $nid) {
            return $q->where('nid', $nid);
        });

        $query->when($personal_email, function ($q, $personal_email) {
            return $q->where('personal_email', $personal_email);
        });

        $query->when($personal_mobile, function ($q, $personal_mobile) {
            return $q->where('personal_mobile', $personal_mobile);
        });

        // $query->with('user')->whereHas('user', function ($q) use ($loginId){
        //   return $q->where('username',$loginId);
        // });

        // $query->whereHas('user',function ($query) use ($loginId){
        //         return $query->where('username', $loginId);
        // });

        $employee_records = $query->get();
        return view('employeerecord.get_employee_record', compact('employee_records'));
        //        return response()->json($html);

    }


    public function employeeWorkHistory()
    {
        return view('employee_work_history');
    }

    public function employeeWorkHistoryInfo(Request $request)
    {
        $work_history_info = EmployeeOffice::find($request->employee_office_id);
        $office_ministry = OfficeMinistry::all();
        $custom_layers = OfficeCustomLayer::all();
        return view('employeeworkhistory.work_history_edit_form', compact('work_history_info', 'office_ministry', 'custom_layers'));
    }

    public function employeeWorkHistoryUpdate(Request $request)
    {
        //        dd($request->all());
        $validAttribute = request()->validate([
            'id' => 'required|numeric',
            'office_id' => 'required|numeric',
            'office_layer_id' => "required",
            'office_unit_id' => "required",
            'designation_id' => "required",
            'joining_date' => "required",
            'last_office_date' => "required",
        ], [
            'office_id.required' => 'Office required',
            'office_layer_id.required' => 'Odhidoptor type is required',
            'office_unit_id.required' => 'Office Unit is required',
            'designation_id.required' => 'Designation is required',
            'joining_date.required' => 'Start date required',
            'last_office_date.required' => 'End date required',
        ]);


        $work_history = EmployeeOffice::find($request->id);

        $work_history->office_id = $request->office_id;
        $work_history->office_name_bn = $request->office_name_bng;
        $work_history->office_name_en = $request->office_name_eng;

        $work_history->office_unit_id = $request->office_unit_id;
        $work_history->unit_name_en = $request->unit_name_bng;
        $work_history->unit_name_bn = $request->unit_name_eng;

        $work_history->office_unit_organogram_id = $request->designation_id;
        $work_history->designation = $request->designation_name_bng;

        $work_history->joining_date = date('y-m-d', strtotime($request->joining_date));
        $work_history->last_office_date = date('y-m-d', strtotime($request->last_office_date));
        $work_history->save();

        return ['status' => 'success', 'msg' => 'Action history has been modified.'];
    }

    public function searchEmployee(Request $request)
    {
        $user = User::where('username', $request->keyword)->select('employee_record_id')->first();
        $employee_id = [];
        if (!empty($user->employee_record_id)) {
            $employee_id = $user->employee_record_id;
        } else {
            // return response(['status' => 'error', 'msg' => 'কর্মকর্তা খুজে পাওয়া যায়নি।']);
            return;
        }

        if ($employee_id) {
            $employee_info = EmployeeRecord::where('id', $employee_id)->first();
        } else {
            $employee_info = EmployeeRecord::where('nid', $request->keyword)->first();
        }

        $work_history = EmployeeOffice::where('employee_record_id', $employee_info->id)->orderBy('last_office_date', 'DESC')->get();
        $current_history = $work_history->whereNull('last_office_date');
        $work_history = $work_history->sortByDesc('last_office_date')->whereNotNull('last_office_date');

        return view('employeeworkhistory.get_work_history', compact('employee_info', 'work_history', 'current_history'));
    }

    public function officeWiseEmployee()
    {
        $office_unit_id = Auth::user()->current_office_unit_id();
        $office_id = Auth::user()->current_office_id();
        $designation_id = Auth::user()->current_designation_id();

        $admin = OfficeUnitOrganogram::where('id', $designation_id)->first();

        return view('officeemployee.office_wise_employee', compact('admin'));
    }

    public function getOfficeWiseEmployeeRecordData(Request $request)
    {
        $data = $request->all();
        $designation_id = Auth::user()->current_designation_id();
        $data['admin'] = OfficeUnitOrganogram::where('id', $designation_id)->first();

        return view('officeemployee.get_office_wise_employee_record', $data);
    }

    public function getEmployeeRecordServerSide(Request $request)
    {

        //        dd($request->all());
        $designation_id = Auth::user()->current_designation_id();
        $admin = OfficeUnitOrganogram::where('id', $designation_id)->first();
        $office_unit_id = Auth::user()->current_office_unit_id();
        $office_id = Auth::user()->current_office_id();

        $searched_office_id = $request->office_id;
        $searched_office_unit_id = $request->office_unit_id;
        $name_bn = $request->name_bn;
        $name_en = $request->name_en;
        $login_id = $request->login_id;
        $emp_nid = $request->emp_nid;
        $emp_email = $request->emp_email;
        $emp_mobile = $request->emp_mobile;
        $identity_no = $request->identity_no;

        $draw = intval($request->draw);
        $start = intval($request->start);
        $limit = intval($request->length);
        $search = $request->search['value'];
        $sortBy = null;
        $sortDirection = '';

        if (isset($request->order[0]['column'])) {
            $sortBy = $request->columns[$request->order[0]['column']]['data'];
            $sortDirection = $request->order[0]['dir'];
        }

        $organogram_list = EmployeeRecord::when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name_bng', 'like', "%" . $search . "%")
                    ->orWhere('name_eng', 'like', "%" . $search . "%")
                    ->orWhere('personal_email', 'like', "%" . $search . "%")
                    ->orWhere('personal_mobile', 'like', "%" . $search . "%")
                    ->orWhere('nid', 'like', "%" . $search . "%")
                    ->orWhere('identity_no', 'like', "%" . $search . "%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('username', $search);
                    });
            });
        });

        if ($name_bn) {
            $organogram_list->where('name_bng', 'like', "%" . $name_bn . "%");
        }

        if ($name_en) {
            $organogram_list->where('name_eng', 'like', "%" . $name_en . "%");
        }

        if ($login_id) {
            $organogram_list->whereHas('user', function ($query) use ($login_id) {
                $query->where('username', $login_id);
            });
        }

        if ($emp_nid) {
            $organogram_list->where('nid', $emp_nid);
        }

        if ($emp_email) {
            $organogram_list->where('personal_email', $emp_email);
        }

        if ($emp_mobile) {
            $organogram_list->where('personal_mobile', $emp_mobile);
        }
        if ($identity_no) {
            $organogram_list->where('identity_no', $identity_no);
        }

        $organogram_search_list = [];
        if (Auth::user()->user_role_id == config('menu_role_map.user') && $office_id && $admin->is_admin) {
            $organogram_search_list = EmployeeOffice::where('status', 1)->where('office_id', $office_id);
        }
        if (Auth::user()->user_role_id != config('menu_role_map.user') && $searched_office_id) {
            $organogram_search_list = EmployeeOffice::where('status', 1)->where('office_id', $searched_office_id);
        }
        if (Auth::user()->user_role_id == config('menu_role_map.user') && $office_id && $admin->is_unit_admin == 1 && $admin->is_admin == 0) {
            $organogram_search_list = EmployeeOffice::where('status', 1)->where('office_unit_id', $office_unit_id);
        }
        if (Auth::user()->user_role_id != config('menu_role_map.user') && $searched_office_unit_id) {
            $organogram_search_list = EmployeeOffice::where('status', 1)->where('office_unit_id', $searched_office_unit_id);
        }
        if (!empty($organogram_search_list)) {
            $organogram_list = $organogram_search_list->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('employee_record_id', function ($query) use ($search) {
                        $query->where('name_bng', 'like', "%" . $search . "%");
                    })->orWhereHas('employee_record_id', function ($query) use ($search) {
                        $query->where('name_eng', 'like', "%" . $search . "%");
                    })->orWhereHas('employee_record_id', function ($query) use ($search) {
                        $query->where('personal_email', 'like', "%" . $search . "%");
                    })->orWhereHas('employee_record_id', function ($query) use ($search) {
                        $query->where('personal_mobile', 'like', "%" . $search . "%");
                    })->orWhereHas('employee_record_id', function ($query) use ($search) {
                        $query->where(
                            'nid',
                            'like',
                            "%" . $search . "%"
                        );
                    })->orWhereHas('employee_record_id', function ($query) use ($search) {
                        $query->where(
                            'identity_no',
                            'like',
                            "%" . $search . "%"
                        );
                    })->orWhereHas('user', function ($query) use ($search) {
                        $query->where('username', $search);
                    });
                });
            });

            if ($name_bn) {
                $organogram_list->whereHas('employee_record_id', function ($query) use ($name_bn) {
                    $query->where('name_bng', 'like', "%" . $name_bn . "%");
                });
            }
            if ($login_id) {
                $organogram_list->whereHas('user', function ($query) use ($login_id) {
                    $query->where('username', $login_id);
                });
            }
            if ($identity_no) {
                $organogram_list->whereHas('employee_record_id', function ($query) use ($identity_no) {
                    $query->where('identity_no', $identity_no);
                });
            }
            if ($emp_mobile) {
                $organogram_list->whereHas('employee_record_id', function ($query) use ($emp_mobile) {
                    $query->where('personal_mobile',
                        $emp_mobile
                    );
                });
            }
        }
        $total_data = $organogram_list->count();

        $organogram_list = $organogram_list->when($limit > 0, function ($query) use ($start, $limit) {
            $query->offset($start)->limit($limit);
        })->orderBy('id', 'asc')->when($sortBy, function ($query, $sortBy) use ($sortDirection) {
            $query->orderBy($sortBy, $sortDirection);
        })->get();
        $data = array();
        $i = 1;

        foreach ($organogram_list as $row) {
            $action = '';
            $employeeInfo = '';
            if (Auth::user()->user_role_id == config('menu_role_map.user') && ($office_id)) {
                $is_cadre = !empty($row->employee_record) ? $row->employee_record->is_cadre : 0;
                $organogram_array['username'] = !empty($row->employee_record->user) ? $row->employee_record->user->username : '-';
                $organogram_array['name_bng'] = !empty($row->employee_record) ? $row->employee_record->full_name_bng : '-';
                $organogram_array['name_eng'] = !empty($row->employee_record) ? $row->employee_record->full_name_eng : '-';
                $organogram_array['identity_no'] = !empty($row->employee_record) ? $row->employee_record->identity_no : '-';
                $organogram_array['personal_email'] = !empty($row->employee_record) ? $row->employee_record->personal_email : '-';
                $organogram_array['personal_mobile'] = !empty($row->employee_record) ? $row->employee_record->personal_mobile : '-';
                $organogram_array['is_cadre'] = ($is_cadre == 1) ? 'Yes' : 'No';
                $organogram_array['designation_bng'] = $row->designation;
                $organogram_array['unit'] = $row->office_unit ? $row->office_unit->unit_name_bng : '';
                $organogram_array['employee_info'] = '';
                $organogram_array['action'] = '';
                $data[] = $organogram_array;
            } else if (Auth::user()->user_role_id != config('menu_role_map.user') && ($searched_office_id || $searched_office_unit_id)) {
                $is_cadre = !empty($row->employee_record) ? $row->employee_record->is_cadre : 0;
                $organogram_array['username'] = !empty($row->employee_record->user) ? $row->employee_record->user->username : '-';
                $organogram_array['name_bng'] = !empty($row->employee_record) ? $row->employee_record->full_name_bng : '-';
                $organogram_array['name_eng'] = !empty($row->employee_record) ? $row->employee_record->full_name_eng : '-';
                $organogram_array['identity_no'] = !empty($row->employee_record) ? $row->employee_record->identity_no : '-';
                $organogram_array['personal_email'] = !empty($row->employee_record) ? $row->employee_record->personal_email : '-';
                $organogram_array['personal_mobile'] = !empty($row->employee_record) ? $row->employee_record->personal_mobile : '-';
                $organogram_array['is_cadre'] = ($is_cadre == 1) ? 'Yes' : 'No';
                $organogram_array['designation_bng'] = $row->designation;
                $organogram_array['unit'] = $row->office_unit ? $row->office_unit->unit_name_bng : '';


                $employee_id = !empty($row) ? $row->id : '';
                $edit_url = 'edit_employee/' . $employee_id;
                $employeeInfo .= '<button class="btn btn-icon btn-outline-brand btn-square" onclick="showEmployeeInfo(' . $employee_id . ')" data-toggle="modal"
                data-target="#employeeInfoModal" title="Current designations"> <i class="fa fa-eye" aria-hidden="true"></i></button>';
                $employeeInfo .= '<button class="btn btn-icon btn-outline-brand btn-square" onclick="showWorkHistoryInEmployeeList(' . $employee_id . ')" data-toggle="modal"
                data-target="#designationInfoModal" title="work history"> <i class="fa fa-history" aria-hidden="true"></i> </button>';
                $action .= '<a href="' . $edit_url . '" class="btn btn-icon btn-outline-brand btn-square"><i class="fas fa-pencil-alt"></i></a>';
                $action .= '<button data-id="' . $employee_id . '" type="button" class="btn btn-info btn-icon btn-square changePassword" onclick="changePasswordInEmployeeList(' . $employee_id . ')"><i class="fas fa-key"></i></button>';
                if (!empty($row->active_employee_office)) {
                    $organogram_array['employee_info'] = $employeeInfo;
                } else {
                    $organogram_array['employee_info'] = '<button class="btn btn-icon btn-outline-brand btn-square" onclick="showWorkHistoryInEmployeeList(' . $employee_id . ')" data-toggle="modal"
                data-target="#designationInfoModal" title="work history"> <i class="fa fa-history" aria-hidden="true"></i> </button>';
                }
                $organogram_array['action'] = $action;

                $data[] = $organogram_array;
            } else {
                $is_cadre = !empty($row) ? $row->is_cadre : 0;
                $organogram_array['username'] = !empty($row->user) ? $row->user->username : '-';
                $organogram_array['name_bng'] = !empty($row) ? $row->full_name_bng : '-';
                $organogram_array['name_eng'] = !empty($row) ? $row->full_name_eng : '-';
                $organogram_array['identity_no'] = !empty($row) ? $row->identity_no : '-';
                $organogram_array['personal_email'] = !empty($row) ? $row->personal_email : '-';
                $organogram_array['personal_mobile'] = !empty($row) ? $row->personal_mobile : '-';
                $organogram_array['is_cadre'] = ($is_cadre == 1) ? 'Yes' : 'No';
                $organogram_array['designation_bng'] = '';
                $organogram_array['unit'] = '';

                $employee_id = !empty($row) ? $row->id : '';
                $edit_url = 'edit_employee/' . $employee_id;
                $employeeInfo .= '<button class="btn btn-icon btn-outline-brand btn-square" onclick="showEmployeeInfo(' . $employee_id . ')" data-toggle="modal"
                data-target="#employeeInfoModal" title="Current designations"> <i class="fa fa-eye" aria-hidden="true"></i></button>';
                $employeeInfo .= '<button class="btn btn-icon btn-outline-brand btn-square" onclick="showWorkHistoryInEmployeeList(' . $employee_id . ')" data-toggle="modal"
                data-target="#designationInfoModal" title="work history"> <i class="fa fa-history" aria-hidden="true"></i> </button>';
                $action .= '<a href="' . $edit_url . '" class="btn btn-icon btn-outline-brand btn-square"><i class="fas fa-pencil-alt"></i></a>';
                $action .= '<button data-id="' . $employee_id . '" type="button" class="btn btn-info btn-icon btn-square changePassword" onclick="changePasswordInEmployeeList(' . $employee_id . ')"><i class="fas fa-key"></i></button>';
                if (!empty($row->active_employee_office)) {
                    $organogram_array['employee_info'] = $employeeInfo;
                } else {
                    $organogram_array['employee_info'] = '<button class="btn btn-icon btn-outline-brand btn-square" onclick="showWorkHistoryInEmployeeList(' . $employee_id . ')" data-toggle="modal"
                data-target="#designationInfoModal" title="work history"> <i class="fa fa-history" aria-hidden="true"></i> </button>';
                }
                $organogram_array['action'] = $action;
                $data[] = $organogram_array;
            }

            $i++;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_data,
            "recordsFiltered" => $total_data,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function getAssignEmployeeInfo(Request $request)
    {
        $employeeOffices = EmployeeOffice::where('employee_record_id', $request->employee_record_id)
            ->where('status', 1)->get();
        return response(['status' => '200', 'data' => $employeeOffices]);
    }

    public function createEmployeeByOfficeAdmin()
    {
        $office_id = Auth::user()->current_office_id();
        $office_units = OfficeUnit::where('office_id', $office_id)->orderBy('unit_level')->get();
        $cadres = EmployeeCadre::all();
        $batches = EmployeeBatch::all();
        $office_incharges = OfficeInchargeType::all();
        return view('employeofficemanagement.create_employee_by_office_admin', compact('cadres', 'batches', 'office_units', 'office_id', 'office_incharges'));
    }

    public function storeEmployeeByOfficeAdmin(Request $request)
    {

        if ($request->id !== null) {
            $validAttribute = request()->validate([
                'id' => 'nullable|numeric',
                'prefix_name_bng' => 'nullable|string',
                'prefix_name_eng' => 'nullable|string',
                'name_bng' => 'required|string',
                'name_eng' => 'required|string',
                'surname_bng' => 'nullable|string',
                'surname_eng' => 'nullable|string',
                'identification_number' => 'nullable |string',
                'personal_email' => 'required',
                'personal_mobile' => 'required|numeric|min:11|max:14',
                'father_name_bng' => 'nullable |string',
                'father_name_eng' => 'nullable |string',
                'mother_name_bng' => 'nullable |string',
                'mother_name_eng' => 'nullable |string',
                'date_of_birth' => 'nullable ',
                'nid' => 'required',
                'bcn' => 'nullable |numeric',
                'ppn' => 'nullable |numeric',
                'gender' => 'required',
                'religion' => 'nullable |string',
                'blood_group' => 'nullable |string',
                'marital_status' => 'nullable |string',
                'alternative_mobile' => 'nullable |string',
                'is_cadre' => 'required |numeric',
                'employee_grade' => 'nullable',
                'joining_date' => 'nullable',
                'employee_batch_id' => 'nullable |string',
                'employee_cadre_id' => 'nullable |string',
                'identity_no' => 'nullable |string',
                'appointment_memo_no' => 'nullable |string',
                'status' => 'nullable |numeric',
                'created_by' => 'nullable |numeric',
                'modified_by' => 'nullable |numeric',
            ]);

            $dob = date('Y-m-d', strtotime($request->date_of_birth));
            $joining_date = $request->joining_date ? date('Y-m-d', strtotime($request->joining_date)) : null;

            $validAttribute['date_of_birth'] = $dob;
            $validAttribute['joining_date'] = $joining_date;
            $validAttribute['identity_no'] = bnToen($request->identity_no);
            $validAttribute['status'] = 1;
            $validAttribute['created_by'] = Auth::user()->id;
            $validAttribute['modified_by'] = Auth::user()->id;

            $office_origin = EmployeeRecord::find($request->id);
            $office_origin->update($validAttribute);
            return response()->json(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            DB::beginTransaction();
            try {
                $validAttributeUpdate = $this->validate($request, [
                    'prefix_name_bng' => 'nullable|string',
                    'prefix_name_eng' => 'nullable|string',
                    'name_bng' => 'required|string',
                    'name_eng' => 'required|string',
                    'surname_bng' => 'nullable|string',
                    'surname_eng' => 'nullable|string',
                    'identification_number' => 'nullable |string',
                    'personal_email' => 'required |unique:App\Models\EmployeeRecord,personal_email',
                    'personal_mobile' => 'required |min:11|max:14 |unique:App\Models\EmployeeRecord,personal_mobile',
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
                    'employee_grade' => 'nullable',
                    'joining_date' => 'nullable',
                    'employee_batch_id' => 'nullable |string',
                    'employee_cadre_id' => 'nullable |string',
                    'identity_no' => 'nullable |string',
                    'appointment_memo_no' => 'nullable |string',
                    'status' => 'nullable |numeric',
                    'created_by' => 'nullable |numeric',
                    'modified_by' => 'nullable |numeric',
                ], [
                    'name_bng.required' => 'Name Other is required.',
                    'name_eng.required' => 'Name English is required.',
                    'personal_email.required' => 'Personal email is required.',
                    'personal_email.unique' => 'Personal email is used',
                    'personal_mobile.required' => 'Personal mobile is required',
                    'personal_mobile.min' => 'Personal mobile minimum 11',
                    'personal_mobile.max' => 'Personal mobile max 14',
                    'personal_mobile.unique' => 'Personal mobile used',
                    'nid.required' => 'National ID number is required',
                    'nid.unique' => 'National Identity Card Number is used',
                    'is_cadre.required' => 'Cadre is required',
                    'gender.required' => 'Gender is required',
                ]);
                //                dd($validAttributeUpdate);

                $dob = $request->date_of_birth ? date('Y-m-d', strtotime($request->date_of_birth)) : null;
                $joining_date = $request->joining_date ? date('Y-m-d', strtotime($request->joining_date)) : null;


                $validAttributeUpdate['date_of_birth'] = $dob;
                $validAttributeUpdate['joining_date'] = $joining_date;
                $validAttributeUpdate['status'] = 1;
                $validAttributeUpdate['created_by'] = Auth::user()->id;
                $validAttributeUpdate['modified_by'] = Auth::user()->id;

                $employee_id = EmployeeRecord::create($validAttributeUpdate);

                $identity_no = bnToen($request->identity_no);

                if ($request->is_cadre == 1) {
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
                } else if ($request->is_cadre == 2) {

                    $username_list = User::select('username')->where('username', 'like', '2%')->whereRaw('LENGTH(username) = 12')->max('username');
                    $username = $username_list + 1;
                } else if ($request->is_cadre == 3) {
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

                if ($request->designation_id) {
                    $office_id = $request->office_id; //change
                    $office_info = Office::find($office_id);
                    $designation_info = OfficeUnitOrganogram::find($request->designation_id);
                    $office_unit_info = OfficeUnit::find($request->office_unit_id);
                    $exist_employee = EmployeeOffice::where('office_id', $office_id)->where('office_unit_id', $request->office_unit_id)->where('status', 1)->first();

                    $employee_office = new EmployeeOffice();
                    $employee_office->office_unit_organogram_id = $request->designation_id;
                    $employee_office->office_unit_id = $request->office_unit_id;
                    $employee_office->office_id = $office_id;
                    $employee_office->designation = $designation_info->designation_bng;
                    $employee_office->designation_en = $designation_info->designation_eng;
                    $employee_office->designation_level = $designation_info->designation_level;
                    $employee_office->joining_date = $request->designation_joining_date;
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

                    if ($request->incharge_label) {
                        $employee_office->incharge_label = $request->incharge_label;
                    } else {
                        $employee_office->incharge_label = '';
                    }
                    $employee_office->status = 1;
                    $employee_office->joining_date = date('Y-m-d', strtotime($request->joining_date));
                    $employee_office->save();

                    if (is_null($exist_employee)) {
                        $data['is_unit_admin'] = 1;
                        OfficeUnitOrganogram::where('id', $request->designation_id)->update($data);
                    }
                }
            } catch (ValidationException $exception) {
                return response()->json([
                    'status' => 'error',
                    'msg' => $exception->errors(),
                    'statusCode' => '422',
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => 'error', 'msg' => 'Update failed.', 'data' => $e]);
            }
            DB::commit();

            return response()->json(['status' => 'success', 'msg' => 'Completed successfully.', 'userid' => $username, 'name' => $employee_id->full_name_bng]);
        }
    }

    public function searchOfficeWiseEmployeeRecordData(Request $request)
    {
        //        dd($request->all());
        $office_id = Auth::user()->current_office_id();
        $name_bn = $request->name;
        $login_id = $request->loginId;
        $identity_no = $request->identity_no;
        $emp_mobile = $request->phone;

        // $organograms = OfficeUnitOrganogram::whereHas('assigned_user.employee_record', function ($query) use ($office_id, $name, $identity_no, $phone, $loginId) {
        //     $query->when($office_id, function ($query) use ($office_id) {
        //         $query->where('office_id', $office_id);
        //     })->when($name, function ($query) use ($name) {
        //         return $query->where('name_bng', 'LIKE', '%' . $name . '%');
        //     })->when($identity_no, function ($query) use ($identity_no) {
        //         return $query->where('identity_no', $identity_no);
        //     })->when($phone, function ($query) use ($phone) {
        //         return $query->where('personal_mobile', $phone);
        //     })->when($loginId, function ($query) use ($loginId) {
        //         $query->whereHas('user', function ($query) use ($loginId) {
        //             return $query->where('username', $loginId);
        //         });
        //     });
        // })->paginate(20);

        return view('officeemployee.get_office_wise_employee_record', compact('office_id', 'name_bn', 'login_id', 'emp_mobile', 'identity_no'));
    }

    public function employeeWatingRecord()
    {
        $ministries = OfficeMinistry::select('name_bng', 'id')->get();
        return view('employeerecord.waitng_employee_record', compact('ministries'));
    }

    public function getWatingEmployeeRecordData()
    {
        $employee_records = EmployeeRecord::paginate(20);
        return view('employeerecord.get_waitng_employee_record', compact('employee_records'));
    }

    public function searchWatingEmployeeRecord(Request $request)
    {
        $office_ministry_id = $request->office_ministry_id;
        $office_layer_id = $request->office_layer_id;
        $office_origin_id = $request->office_origin_id;
        $office_id = $request->office_id;
        // $office_origin_id = $request->office_origin_id;
        $name_bng = $request->name_bn;
        $nid = $request->emp_nid;
        $personal_email = $request->emp_email;
        $personal_mobile = $request->emp_mobile;
        $loginId = $request->login_id;

        $query = EmployeeRecord::query();

        if ($office_id) {
            $query->whereHas('employee_office', function ($q) use ($office_id) {
                return $q->where('office_id', $office_id);
            });
        }
        if ($loginId) {
            $query->whereHas('user', function ($q) use ($loginId) {
                return $q->where('username', $loginId);
            });
        }

        $query->when($name_bng, function ($q, $name_bng) {
            return $q->where('name_bng', 'LIKE', '%{{$name_bng}}%');
        });

        $query->when($nid, function ($q, $nid) {
            return $q->where('nid', $nid);
        });

        $query->when($personal_email, function ($q, $personal_email) {
            return $q->where('personal_email', $personal_email);
        });

        $query->when($personal_mobile, function ($q, $personal_mobile) {
            return $q->where('personal_mobile', $personal_mobile);
        });

        $employee_records = $query->paginate(20);
        $html = view('employeerecord.get_waitng_employee_record', compact('employee_records'));
        return response()->json($html);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $cadres = EmployeeCadre::all();
        $batches = EmployeeBatch::all();
        $office_incharges = OfficeInchargeType::all();
        return view('employeofficemanagement.create_employee', compact('cadres', 'batches', 'office_incharges'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->id !== null) {
            $nid = bnToen($request->nid);
            $request->merge(['nid' => $nid]);

            $validAttribute = request()->validate([
                'id' => 'nullable|numeric',
                'prefix_name_bng' => 'nullable|string',
                'prefix_name_eng' => 'nullable|string',
                'name_bng' => 'required|string',
                'name_eng' => 'required|string',
                'surname_bng' => 'nullable|string',
                'surname_eng' => 'nullable|string',
                'identification_number' => 'nullable |string',
                'personal_email' => 'required',
                'personal_mobile' => 'required',
                'father_name_bng' => 'nullable |string',
                'father_name_eng' => 'nullable |string',
                'mother_name_bng' => 'nullable |string',
                'mother_name_eng' => 'nullable |string',
                'date_of_birth' => 'nullable ',
                'nid' => 'required',
                'bcn' => 'nullable |numeric',
                'ppn' => 'nullable |numeric',
                'gender' => 'nullable |string',
                'religion' => 'nullable |string',
                'blood_group' => 'nullable |string',
                'marital_status' => 'nullable |string',
                'alternative_mobile' => 'nullable |string',
                'is_cadre' => 'nullable |numeric',
                'joining_date' => 'nullable',
                'employee_batch_id' => 'nullable |string',
                'employee_cadre_id' => 'nullable |string',
                'identity_no' => 'nullable |string',
                'appointment_memo_no' => 'nullable |string',
                'status' => 'nullable |numeric',
                'created_by' => 'nullable |numeric',
                'modified_by' => 'nullable |numeric',
            ], [
                'personal_mobile.required' => 'Personal mobile is required.',
                'personal_mobile.min' => 'Personal mobile minimum 11.',
            ]);

            $nid_exist = EmployeeRecord::where('nid', $nid)->where('id', '!=', $request->id)->exists();

            if ($nid_exist) {
                throw ValidationException::withMessages([
                    'nid' => ['There are already records with this NID number.'],
                ]);
            }

            $dob = date('Y-m-d', strtotime($request->date_of_birth));
            $joining_date = date('Y-m-d', strtotime($request->joining_date));
            $personal_mobile = bnToen($request->personal_mobile);
            $identity_no = bnToen($request->identity_no);


            $validAttribute['date_of_birth'] = $dob;
            $validAttribute['nid'] = bnToen($request->nid);
            $validAttribute['joining_date'] = $joining_date;
            $validAttribute['personal_mobile'] = $personal_mobile;
            $validAttribute['identity_no'] = $identity_no;
            $validAttribute['status'] = 1;
            $validAttribute['created_by'] = Auth::user()->id;
            $validAttribute['modified_by'] = Auth::user()->id;

            $employee_record = EmployeeRecord::find($request->id);
            $employee_record->update($validAttribute);

            return response()->json(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {

            DB::beginTransaction();
            try {

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
                    'identity_no' => 'nullable |string',
                    'appointment_memo_no' => 'nullable |string',
                    'status' => 'nullable |numeric',
                    'created_by' => 'nullable |numeric',
                    'modified_by' => 'nullable |numeric',
                ], [
                    'name_bng.required' => 'Name Other is required.',
                    'name_eng.required' => 'Name English is required.',
                    'personal_email.required' => 'Personal email is required.',
                    'personal_email.unique' => 'Personal email is used',
                    'personal_mobile.required' => 'Personal mobile is required',
                    'personal_mobile.min' => 'Personal mobile minimum 11',
                    'personal_mobile.max' => 'Personal mobile max 14',
                    'personal_mobile.unique' => 'Personal mobile used',
                    'nid.required' => 'National ID number is required',
                    'nid.unique' => 'National Identity Card Number is used',
                    'is_cadre.required' => 'Cadre is required',
                    'gender.required' => 'Gender is required',
                ]);

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


                $validAttributeUpdate['date_of_birth'] = $dob;
                $validAttributeUpdate['joining_date'] = $joining_date;
                $validAttribute['personal_mobile'] = $personal_mobile;
                $validAttributeUpdate['status'] = 1;
                $validAttributeUpdate['created_by'] = Auth::user()->id;
                $validAttributeUpdate['modified_by'] = Auth::user()->id;

                $employee_id = EmployeeRecord::create($validAttributeUpdate);
                $identity_no = enTobn($request->identity_no);

                if ($request->is_cadre == 1) {

                    if (is_null($identity_no)) {

                        $username_list = User::select('username')->where('username', 'like', '3%')->whereRaw('LENGTH(username) = 12')->max('username');

                        $username = $username_list + 1;

                        // dd($username);
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
                } else if ($request->is_cadre == 2) {

                    $username_list = User::select('username')->where('username', 'like', '2%')->whereRaw('LENGTH(username) = 12')->max('username');
                    $username = $username_list + 1;
                } else if ($request->is_cadre == 3) {
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

                DB::commit();
                return response()->json(['status' => 'success', 'msg' => 'Completed successfully.', 'userid' => $username, 'name' => $employee_id->name_bng]);
            } catch (ValidationException $exception) {
                return response()->json([
                    'status' => 'error',
                    'msg' => $exception->errors(),
                    'statusCode' => '422',
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => 'error', 'msg' => 'Update failed.', 'data' => $e]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\EmployeeRecord $employeeRecord
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeRecord $employeeRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\EmployeeRecord $employeeRecord
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee_info = EmployeeRecord::find($id);
        $cadres = EmployeeCadre::all();
        $batches = EmployeeBatch::all();
        // dd($employee_info);
        return view('employeofficemanagement.edit_employee', compact('employee_info', 'cadres', 'batches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EmployeeRecord $employeeRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeRecord $employeeRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\EmployeeRecord $employeeRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $exist_employee_office = EmployeeOffice::whereIn('employee_record_id', $request->employee_record_id)->count();

        if ($exist_employee_office > 0) {
            return response()->json(['status' => 'error', 'msg' => 'The officer is in charge of the office']);
        } else {
            EmployeeRecord::whereIn('id', $request->employee_record_id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Deleted successfully.']);
        }
    }

    public function getAssignOrganogramInfo(Request $request)
    {
        $user = User::where('username', $request->keyword)->select('employee_record_id')->first();
        $employee_id = [];
        if (!empty($request->employee_record_id)) {
            $employee_id = $request->employee_record_id;
        } else {
            $employee_id = $user->employee_record_id;
        }

        if ($employee_id) {
            $work_history = EmployeeRecord::where('id', $employee_id)->first();
        } else {
            $work_history = EmployeeRecord::where('nid', $request->keyword)->first();
        }
        return view('employeeworkhistory.employee_work_history', compact('work_history'));
    }

    public function getEmployeeByUsernameOrAlias(Request $request)
    {
        $user = User::where('username', $request->keyword)->orWhere('username', $request->keyword)->select('employee_record_id')->first();

        if ($user) {
            $employee_id = $user->employee_record_id;
            $employee = EmployeeRecord::find($employee_id);
            if ($employee) {
                return response()->json(['status' => 'success', 'data' => $employee]);
            } else {
                return response()->json(['status' => 'error', 'msg' => '
                The officer could not be found.']);
            }
        } else {
            return response()->json(['status' => 'error', 'msg' => '
            User not found.']);
        }
    }
}
