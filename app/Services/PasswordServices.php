<?php

namespace App\Services;

use App\Models\PasswordHistory;
use App\Models\XSetting;
use App\Traits\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordServices
{
    use SendNotification;

    public function checkPasswordOnHistory($user_id, $new_password): bool
    {
        $passwordHistories = PasswordHistory::where('user_id', $user_id)->get();
        if (!$passwordHistories) {
            return true;
        } else {
            foreach ($passwordHistories as $passwordHistoy) {
                if (Hash::check($new_password, $passwordHistoy->password_hash)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function verifyLastPassword($user_id, $new_password): bool
    {
        $hash_check = true;
        $hash_passwords = PasswordHistory::select('password_hash')->where('user_id', $user_id)->orderBy('id', 'DESC')->limit(2)->get();
        foreach ($hash_passwords as $hash_password) {
            if (Hash::check($new_password, $hash_password->password_hash)) {
                $hash_check = false;
                break;
            }
        }
        return $hash_check;
    }

    public function saveCurrentPasswordAsHistory($user, $current_password)
    {
        $passwordHistories = PasswordHistory::where('user_id', $user->id);

        $store_last_password = XSetting::where('param', 'store_last_password')->first();

        if ($passwordHistories->count() > $store_last_password->value) {
            $passwordHistories->first()->delete();
        }
        PasswordHistory::create([
            'user_id' => $user->id,
            'employee_record_id' => $user->employee_record_id,
            'password_hash' => Hash::make($current_password),
            'changed_date' => date('Y-m-d H:i:s'),
        ]);
    }

    public function changePassword($user, $password): array
    {
        if ((new PasswordServices())->verifyLastPassword($user->id, $password)) {
            $user->fill([
                'password' => Hash::make($password),
                'last_password_change' => date('Y-m-d H:i:s'),
            ])->save();

            (new PasswordServices())->saveCurrentPasswordAsHistory($user, $password);

            if ($user->force_password_change == 1) {
                $user->update(['force_password_change' => 0]);
            }

            if ($user->employee && $user->employee->personal_email) {
                $this->sendMailNotification(config('notifiable_constants.pass_change'), $user->employee->personal_email, 'পাসওয়ার্ড পরিবর্তন হয়েছে', []);
            }

            if ($user->employee && $user->employee->personal_mobile) {
                $this->sendSMSNotification(config('notifiable_constants.pass_change'), $user->employee->personal_mobile);
            }
            return ['status' => 'success', 'msg' => "পাসওয়ার্ড সফলভাবে সংরক্ষিতি হয়েছে।"];
        } else {
            return ['status' => 'error', 'msg' => "পাসওয়ার্ড পরিবর্তন করা সম্ভব হচ্ছে না। পূর্বের ব্যবহৃত পাওয়ার্ড গ্রহনযোগ্য নয়। নতুন পাসওয়ার্ড ব্যবহার করুন।"];
        }
    }
}
