<?php


namespace App\Http\Controllers;

use App\Jobs\SendPassResetEmail;
use App\Jobs\SendPassResetFromAdminEmail;
use App\Jobs\SendPassResetOTP;
use App\Models\EmployeeRecord;
use App\Models\User;
use App\Models\UserActivationEmail;
use App\Models\UserActivationSMS;
use App\Services\PasswordServices;
use App\Traits\SendNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordResetController
{
    use SendNotification;

    public function index(Request $request)
    {
        $return_login_url = $request->get('redirect');
        return view('user.password_reset.reset', compact('return_login_url'));
    }

    public function verificationCode(Request $request)
    {
        \Validator::make($request->all(), [
            'userinfo' => 'required|string',
            'verifyMedium' => 'required|string',
            'verifyData' => 'required|string',
        ], [
            'userinfo.required' => 'Please enter your username',
            'verifyMedium.required' => 'Please enter verification medium',
            'verifyData.required' => 'Please enter Email or phone number',
        ])->validate();

        $username = $request->input('userinfo');
        $verifyMedium = $request->input('verifyMedium');
        $verifyData = $request->input('verifyData');

        $user = User::where('username', $username)->orWhere('user_alias', $username)->first();

        if (!$user) {
            return response()->json(['msg' => 'User information is incorrect.', 'statusCode' => '404'], 200);
        }

        $employee = EmployeeRecord::where('id', $user->employee_record_id)->first();

        if (!$employee) {
            return response()->json(['msg' => 'User information is incorrect.', 'statusCode' => '404'], 200);
        }

        if ($verifyMedium == 'email' && bnToen($employee->personal_email) != bnToen($verifyData)) {
            return response()->json(['msg' => 'Email is not valid.', 'statusCode' => '404'], 200);
        }
        if ($verifyMedium == 'phone' && bnToen($employee->personal_mobile) != bnToen($verifyData)) {
            return response()->json(['msg' => 'Mobile number is not correct.', 'statusCode' => '404'], 200);
        }

        return response()->json(['msg' => 'User information is correct.', 'statusCode' => '200'], 200);
    }

    public function sendPassResetEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        $email = $request->input('email');
        $username = $request->input('userinfo');

        $code = generateRandomNum((int)config('password_reset.code.length'));

        $user = User::where('username', $username)->orWhere('user_alias', $username)->first();

        UserActivationEmail::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'user_id' => $user->id,
            'username' => $user->username,
            'activation_code' => \Hash::make($code),
            'is_activated' => 0,
            'expiry' => Carbon::now()->addMinutes((int)config('password_reset.code.expiry')),
            'created_by' => $user->id,
            'modified_by' => $user->id,
        ]);

        $details = [
            'email' => $email,
            'code' => $code,
        ];

        SendPassResetEmail::dispatch($details);

        return response()->json(['msg' => 'OTP has been sent to e-mail.', 'statusCode' => '200'], 200);
    }

    public function sendPassResetOTP(Request $request): \Illuminate\Http\JsonResponse
    {
        $phone = $request->input('phone');
        $username = $request->input('userinfo');

        $code = generateRandomNum((int)config('password_reset.code.length'));

        $user = User::where('username', $username)->orWhere('user_alias', $username)->first();

        UserActivationSMS::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'user_id' => $user->id,
            'username' => $user->username,
            'activation_code' => \Hash::make($code),
            'is_activated' => 0,
            'expiry' => Carbon::now()->addMinutes((int)config('password_reset.code.expiry')),
            'created_by' => $user->id,
            'modified_by' => $user->id,
        ]);

        $details = [
            'phone' => $phone,
            'code' => $code,
        ];
        SendPassResetOTP::dispatch($details);

        return response()->json(['msg' => 'OTP has been sent to mobile.', 'statusCode' => '200'], 200);
    }

    public function verifyPassReset($token)
    {
        $token = base64_decode($token);
        $msg = '';

        if (strpos($token, '_') !== false) {
            $userId = (int)filter_var(explode('_', $token)[0], FILTER_SANITIZE_NUMBER_INT);
            $code = (int)filter_var(explode('_', $token)[1], FILTER_SANITIZE_NUMBER_INT);
            $checkValidation = UserActivationEmail::where('user_id', $userId)->latest()->first();
            $expiry = $checkValidation->expiry;
            $isActivated = $checkValidation->is_activated;
            if ((Carbon::now()->lessThan($expiry)) && ($isActivated == 0)) {
                if (\Hash::check($code, $checkValidation->activation_code)) {
                    return view('user.password_reset.verification.mail.verified', compact('userId'));
                } else {
                    $msg = 'The verification code is incorrect.';
                    return view('user.password_reset.verification.mail.unverified', compact('msg'));
                }
            } else {
                $msg = 'The verification code has expired. Please request a new reset.';
                return view('user.password_reset.verification.mail.unverified', compact('msg'));
            }
        } else {
            $msg = 'The verification link is not valid.';
            return view('user.password_reset.verification.mail.unverified', compact('msg'));
        }
    }

    public function verifyPassResetPhone(Request $request)
    {
        $code = $request->input('code');
        $userId = $request->input('userId');

        $checkValidation = UserActivationSMS::where('user_id', $userId)->latest()->first();
        $expiry = $checkValidation->expiry;
        $isActivated = $checkValidation->is_activated;
        if ((Carbon::now()->lessThan($expiry)) && ($isActivated == 0)) {
            if (\Hash::check($code, $checkValidation->activation_code)) {
                return view('user.password_reset.verification.mail.verified', compact('userId'));
            } else {
                return response()->json(['status' => 'error', 'msg' => 'The verification code is not valid.', 'statusCode' => '404']);
            }
        } else {
            return response()->json(['status' => 'error', 'msg' => 'The verification code has expired. Please request a new reset.', 'statusCode' => '404']);
        }
    }

    public function verifyPassResetEmail(Request $request)
    {
        $code = $request->input('code');
        $userId = $request->input('userId');

        $checkValidation = UserActivationEmail::where('user_id', $userId)->latest()->first();
        $expiry = $checkValidation->expiry;
        $isActivated = $checkValidation->is_activated;
        if ((Carbon::now()->lessThan($expiry)) && ($isActivated == 0)) {
            if (\Hash::check($code, $checkValidation->activation_code)) {
                return view('user.password_reset.verification.mail.verified', compact('userId'));
            } else {
                return response()->json(['status' => 'error', 'msg' => 'The verification code is incorrect.', 'statusCode' => '404']);
            }
        } else {
            return response()->json(['status' => 'error', 'msg' => '
            The verification code has expired. Please request a new reset.', 'statusCode' => '404']);
        }
    }

    public function saveNewPassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->input('userId');
        $pass = $request->input('newPass');

        $user = User::find($userId);

        $change_password = (new PasswordServices())->changePassword($user, $pass);

        if ($change_password['status'] == 'error') {
            return response()->json($change_password);
        }

        $isActivated = UserActivationEmail::where('user_id', $userId);
        $isActivated->update(['is_activated' => 1]);

        return response()->json(['msg' => 'Password reset completed.', 'statusCode' => '200'], 200);
    }

    public function phoneCodeAre(Request $request): string
    {
        $username = $request->input('userinfo');
        $user = User::where('username', $username)->orWhere('user_alias', $username)->first();
        $userId = $user->id;
        return view('user.password_reset.verification.phone.verify_box', compact('userId'))->render();
    }

    public function emailCodeAre(Request $request): string
    {
        $username = $request->input('userinfo');
        $user = User::where('username', $username)->orWhere('user_alias', $username)->first();
        $userId = $user->id;
        return view('user.password_reset.verification.phone.email_verify_box', compact('userId'))->render();
    }

    public function changePasswordByAdmin(Request $request)
    {

        try {
            $random = substr(md5(mt_rand()), 0, 8);

            $user = User::where('employee_record_id', $request->employee_record_id)->first();
            $user->password = \Hash::make($random);
            $user->force_password_change = 1;
            $user->save();

            $employee_info = EmployeeRecord::select('personal_email')->find($request->employee_record_id);

            $details = [
                'email' => $employee_info->personal_email,
                'password' => $random,
            ];
            SendPassResetFromAdminEmail::dispatch($details);
            return response(['status' => 'success', 'msg' => 'Password changed successfully.', 'password' => $random]);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'msg' => 'Update failed.', 'data' => $e]);
        }
    }
}
