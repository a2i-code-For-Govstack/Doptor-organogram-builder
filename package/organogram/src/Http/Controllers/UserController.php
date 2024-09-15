<?php

namespace a2i\organogram\Http\Controllers;

use App\Models\DigitalCaList;
use App\Models\EmployeeOffice;
use App\Models\EmployeeRecord;
use App\Models\NotificationEvent;
use App\Models\NotificationSetting;
use App\Models\OfficeInchargeType;
use App\Models\PasswordHistory;
use App\Models\User;
use App\Models\UserDigitalCertificate;
use App\Models\UserSignature;
use App\Models\XSetting;
use App\Services\PasswordServices;
use App\Traits\SendNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Image;

class UserController extends Controller
{
    use SendNotification;

    public function profile(Request $request)
    {
        $userHasRole = $this->isUserHasRole();
        $err_string = $request->_err;
        return view('user.settings.profile', compact('userHasRole', 'err_string'));
    }

    public function protikolpoInProfile(Request $request)
    {
        $office_incharges = OfficeInchargeType::all();
        return view('user.settings.partial.protikolpo', compact('office_incharges'));
    }

    public function workHistory(Request $request)
    {
        $designation_history = EmployeeOffice::where('employee_record_id', Auth::user()->employee_record_id)
            ->orderBy('id', 'desc')
            ->get();

        return view('user.settings.partial.workhistory', compact('designation_history'));
    }

    public function overview(Request $request)
    {
        return view('user.settings.partial.dataoverview');
    }

    public function infoChangeForm(Request $request)
    {
        return view('user.settings.partial.datachange');
    }

    public function add()
    {
        return view('user.settings.add_user_form');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'user_role_id' => 'required',
            'employee_record_id' => 'required',
            'password' => 'required|same:confirm_password|min:8|regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*\.]{8,}$/',
        ], [
            'username.required' => 'Username is required.',
            'user_role_id.required' => 'User role name is required.',
            'password.required' => 'New password required.',
            'employee_record_id.required' => 'Officer must be attached.',
            'password.min' => 'New password must be at least 8 characters long.',
            'password.same' => 'New password and confirm password do not match.',
            'password.regex' => 'The password format is not correct.',
        ]);


        if ($request->employee_record_id) {
            $userCount = User::where('employee_record_id', $request->employee_record_id)
                ->where('user_role_id', $request->user_role_id)->count();
            // dd($userCount);
            if ($userCount == 1) {
                return response()->json(['status' => 'error', 'msg' => "User already has this role"]);
            }

        }

        $user = new User();
        $user->username = $request->username;
        $user->user_alias = $request->username;
        $user->user_role_id = $request->user_role_id;
        $user->user_status = 'registered';
        $user->is_email_verified = 1;
        $user->created_by = Auth::user()->id;
        $user->modified_by = Auth::user()->id;
        $user->password = Hash::make($request->password);
        $user->employee_record_id = $request->employee_record_id ?? null;
        $user->save();

        return response()->json(['status' => 'success', 'msg' => "New user created"]);
    }

    public function edit(Request $request)
    {
        $this->validate(
            $request,
            [
                'gender' => 'required',
            ],
            [
                'gender.required' => 'Gender is required',
            ]
        );
        $current_user_alias = Auth::user()->user_alias;
        if ($request->user_alias != $current_user_alias) {
            $this->validate(
                $request,
                [
                    'user_alias' => 'required|min:1|regex:/^(?=.*[a-zA-Z]).+$/',
                ],
                [
                    'user_alias.required' => 'Sorry! Login name is required.',
                    'user_alias.regex' => 'Sorry! Login name must contain at least one (1) English character.',
                ]
            );
            $username = $request->user_alias;
            $users = User::where('user_alias', $username)->orWhere('username', $username)
                ->count();
            $current_username = Auth::user()->username;
            if ($users > 0 && $username != $current_username) {
                return back()->with('error', "Sorry! previously used.");
            } else {
                $data['user_alias'] = $request->user_alias;
            }
        }

        $data = $request->all();
        $data['personal_mobile'] = bnToen($request->personal_mobile);
        $data['alternative_mobile'] = bnToen($request->alternative_mobile);
        $user = User::findOrFail(Auth::user()->id);
        $record = EmployeeRecord::findOrFail($user->employee_record_id);
        $record->update($data);
        $user->user_alias = $request->user_alias;
        $user->save();
        return back()->with('success', "Information has been corrected");
    }

    public function password()
    {
        return view('user.settings.partial.password');
    }

    public function list()
    {
        return view('user.settings.user_list');
    }

    public function getUserList()
    {
        return view('user.settings.get_user_list_data');
    }

    public function userListServerSide(Request $request)
    {

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

        $total_data = User::when($sortBy, function ($query, $sortBy) use ($sortDirection) {
            return $query->orderBy($sortBy, $sortDirection);
        }, function ($query) {
            return $query->orderBy('id', 'desc');
        })
            ->when($search, function ($query) use ($search) {
                return $query->where('username', 'like', "%" . $search . "%")
                    ->orWhere('username', 'like', "%" . $search . "%");
            })
            ->count();

        $list = User::with('employee')->when($sortBy, function ($query, $sortBy) use ($sortDirection) {
            return $query->orderBy($sortBy, $sortDirection);
        }, function ($query) {
            return $query->orderBy('id', 'desc');
        })
            ->when($search, function ($query) use ($search) {
                return $query->where('username', 'like', "%" . $search . "%")
                    ->orWhere('username', 'like', "%" . $search . "%");
            })
            ->offset($start)
            ->limit($limit)
            ->get();

        $data = array();
        $i = 1;

        foreach ($list as $row) {
            $action = '';
            $user_array['id'] = enTobn($i);
            $user_array['username'] = $row->username;
            $user_array['name_bn'] = $row->employee ? $row->employee->full_name_eng : '';
            $user_array['name_en'] = $row->employee ? $row->employee->full_name_bng : '';
            $user_array['personal_email'] = $row->employee ? $row->employee->personal_email : '';
            $user_array['personal_mobile'] = $row->employee ? $row->employee->personal_mobile : '';
            $user_array['user_signature'] = $row->signature ? '<img width="100" src="' . $row->signature->encode_sign . '">' : 'Signature not found';

            if ($row->user_role_id == 1) {
                $role = 'SuperAdmin';
            } elseif ($row->user_role_id == 2) {
                $role = 'Admin';
            } elseif ($row->user_role_id == 3) {
                $role = 'User';
            }

            $user_array['role'] = $role;

            $checked = $row->active == 1 ? 'checked' : '';

            if ($row->user_role_id != 3) {
                $action .= '<span class="kt-switch kt-switch--icon"><label><input class="sms change_active_status" type="checkbox" data-id="' . $row->id . '" value="' . $row->active . '" ' . $checked . '  name="sms[]"><span></span></label></span>';
            }

            $user_array['action'] = $action;
            $data[] = $user_array;
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

    /**
     */
    public function changePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'required|same:confirm_password|min:8|regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*\.]{8,}$/',
            ], [
                'old_password.required' => 'Current password is required.',
                'password.required' => 'New password required.',
                'password.min' => 'New password must be at least 8 characters long.',
                'password.same' => 'New password and confirm password do not match.',
                'password.regex' => 'The password format is not correct.',
            ]);

            $user = User::find(Auth::user()->id);

            if (Hash::check($request->old_password, $user->password)) {
                $change_password = (new PasswordServices())->changePassword($user, $request->password);
                if ($change_password['status'] == 'error') {
                    return response()->json($change_password);
                }
            } else {
                return response()->json(['status' => 'error', 'msg' => "The old password did not match."]);
            }
        } catch (ValidationException $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => $exception->errors(),
                'statusCode' => '422',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'data' => $exception->getMessage(), 'msg' => 'Internal Server Error']);
        }
        DB::commit();
        return response()->json(['status' => 'success', 'msg' => "Password changed."]);
    }

    public function image()
    {
        return view('user.settings.partial.image');
    }

    public function changeImage(Request $request)
    {
        $this->validate($request, [
            'photo' => 'mimes:jpeg,jpg,png|required',
        ]);

        if ($request->hasFile('photo')) {
            $imageName = auth()->user()->username . '.' . $request->photo->extension();
            $imageNameWithPath = 'storage/content/profile/' . $imageName;

            $request->photo->move(public_path('storage/content/profile/'), $imageName);
            $record = User::findOrFail(Auth::user()->id);
            $record->photo = $imageNameWithPath;
            $record->save();

            $this->getUserProfileImage(\auth()->user()->username);

            if (isset(Auth::user()->employee->personal_email)) {
                $this->sendMailNotification(config('notifiable_constants.profile_pic_change'), Auth::user()->employee->personal_email, 'Change profile picture', []);
            }

            if (isset(Auth::user()->employee->personal_mobile)) {
                $this->sendSMSNotification(config('notifiable_constants.profile_pic_change'), Auth::user()->employee->personal_mobile);
            }
        }
        return response([
            'status' => 'success',
            'msg' => 'Profile picture changed',
            'response' => '200',
        ]);
    }

    public function signature()
    {
        return view('user.settings.partial.signature');
    }

    public function changeSigniture(Request $request)
    {
        try {
            $this->validate($request, [
                'photo' => 'mimes:jpeg,jpg,png|required|max:50',
            ]);

            if ($request->hasFile('photo')) {
                $imageName = time() . '.' . $request->photo->extension();
                $type = $request->photo->extension();
                $request->photo->move(public_path('images'), $imageName);

                $encode_signature = $type . ";" . base64_encode(file_get_contents(public_path('images/' . $imageName)));

                $record = UserSignature::where('username', Auth::user()->username)->latest('id')->first();
                $newRecord = new UserSignature;
                $previous_signature = $record ? $record->signature_file : null;
                $newRecord->previous_signature = $previous_signature;
                $newRecord->signature_file = $imageName;
                $newRecord->username = Auth::user()->username;
                $newRecord->encode_sign = $encode_signature;
                $newRecord->created_by = Auth::id();
                $newRecord->modified_by = Auth::id();
                $newRecord->save();

                if (Auth::user()->employee->personal_email) {
                    $this->sendMailNotification(config('notifiable_constants.sign_change'), Auth::user()->employee->personal_email, 'Change signature', []);
                }

                if (Auth::user()->employee->personal_mobile) {
                    $this->sendSMSNotification(config('notifiable_constants.sign_change'), Auth::user()->employee->personal_mobile);
                }
            }
            return response([
                'status' => 'success',
                'msg' => 'The signature image has changed.',
                'response' => '200',
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception->errors(),
                'statusCode' => '422',
            ]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception, 'msg' => 'Internal Server Error']);
        }
    }

    public function notification()
    {
        //        $settings = NotificationSetting::where('employee_id', Auth::user()->employee_record_id)->get();
        $events = NotificationEvent::all();
        return view('user.settings.partial.notification', compact('events'));
    }

    public function changeNotification(Request $request): \Illuminate\Http\RedirectResponse
    {
        foreach ($request->data as $data) {
            $setting = NotificationSetting::find($data['id']);
            $setting->email = isset($data['email']) ? 1 : 0;
            $setting->sms = isset($data['sms']) ? 1 : 0;
            $setting->save();
        }
        return back()->with('success', "Notification has changed.");
    }

    public function delete(Request $request)
    {

        $user = User::find($request->id);
        $user->active = $user->active == 1 ? 0 : 1;
        $user->save();

        return response(['status' => 'success', 'msg' => 'Canceled successfully.']);
    }

    public function checkUserAlias(Request $request)
    {
        $username = $request->user_alias;
        $users = User::where('user_alias', $username)->orWhere('username', $username)->count();
        $current_username = Auth::user()->username;
        if ($users > 0 && $username != $current_username) {
            return response()->json(['status' => 'success', 'msg' => 'previously used.']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'New login name.']);
        }
    }

    public function digitalCertificate(Request $request)
    {
        $ca_lists = DigitalCaList::where('status', 1)->with('user_digital_certificate', function ($q) {
            $q->where('user_id', Auth::id())->where('status', 1);
        })->orderBy('short_name')->get();

        return view('user.settings.partial.digital_signature', compact('ca_lists'));
    }
}
