<?php

namespace App\Traits;

use App\Models\Menu;
use App\Models\MenuRoleMap;
use App\Models\Office;
use App\Models\OfficeFrontDesk;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use App\Models\ProtikolpoManagement;
use App\Models\User;
use App\Models\XSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

trait UserInfoCollector
{
    use ApiHeart;

    public function getUserDetails()
    {
        return session('login') ? session('login')['user'] : Auth::user();
    }

    public function checkLogin(): bool
    {
        $has_sso_token = isset($_COOKIE['ntoken']) ?? null;
        if ($has_sso_token) {
            $sso_token = $_COOKIE['ntoken'];
            $sso_token = decrypt($sso_token);
            $username = $sso_token['username'];
            if (Auth::check()) {
                return true;
            }
            if (!Auth::check()) {
                $user = User::where('username', $username)->first();
                if ($user) {
                    Auth::login($user);
                    session()->put(['alert_notifications' => 'show']);
                    $this->checkPasswordValidity();
                    return true;
                }
                return false;
            }
        } else if (Auth::check() && app()->environment('local')) {
            return true;
        }
        session()->forget('ntoken');
        return false;
    }

    public function getUserOfficesByDesignation()
    {
        return (Auth::user()->employee) ? Auth::user()->employee->employee_office : [];
    }

    public function isUserHasRole(): bool
    {
        $role = $this->getAssignedMenus();
        return $role->count() > 0;
    }

    public function getAssignedMenus()
    {
        $isFrontDesk = $this->isUserInFrontDesk();
        $user_role_id = $this->getUserRoleId();
        $user_office_roles = $this->getUserOfficeRoles();
        $menus = collect();
        if ($user_role_id == config('menu_role_map.super_admin')) {
            $role_menu = $this->getUserRoleMenu($user_role_id);
            $menus = $menus->merge($role_menu);
        }
        if ($user_role_id == config('menu_role_map.admin')) {
            $role_menu = $this->getUserRoleMenu($user_role_id);
            $menus = $menus->merge($role_menu);

        }
        if ($user_role_id == config('menu_role_map.user')) {
            if ($user_office_roles) {
                if ($user_office_roles->is_unit_admin == 1 && $user_office_roles->is_admin == 0) {
                    $role_menu = $this->getUserRoleMenu(config('menu_role_map.unit_admin'));
                    $menus = $menus->merge($role_menu);
                }
                if ($user_office_roles->is_unit_head == 1) {
                    $role_menu = $this->getUserRoleMenu(config('menu_role_map.unit_head'));
                    $menus = $menus->merge($role_menu);
                }
                if ($user_office_roles->is_office_head == 1) {
                    $role_menu = $this->getUserRoleMenu(config('menu_role_map.office_head'));
                    $menus = $menus->merge($role_menu);
                }
                if ($user_office_roles->is_admin == 1) {
                    $role_menu = $this->getUserRoleMenu(config('menu_role_map.office_admin'));
                    $menus = $menus->merge($role_menu);
                }
                if ($isFrontDesk == 1) {
                    $role_menu = $this->getUserRoleMenu(config('menu_role_map.office_frontdesk'));
                    $menus = $menus->merge($role_menu);
                }
            }
        }

        return $menus->unique();
    }

    public function isUserInFrontDesk(): int
    {
        $frontDesk = OfficeFrontDesk::where('office_unit_organogram_id', Auth::user()->current_designation_id())->pluck('id');
        return $frontDesk->isEmpty() ? 0 : 1;
    }

    public function getUserRoleId()
    {
        if (Auth::check()) {
            return Auth::user()->user_role_id;
        }
        return "0";
    }

    public function getUserOfficeRoles()
    {
        if (Auth::user()->current_designation_id()) {
            return OfficeUnitOrganogram::find(Auth::user()->current_designation_id());
        }
    }

    public function getUserRoleMenu($role_id)
    {
        $roleMenuMapIds = MenuRoleMap::where('role_id', $role_id)->pluck('menu_id');
        return Cache::remember($role_id . '-user-wise-menu', 60 * 60 * 24, function () use ($roleMenuMapIds) {
            return Menu::whereIn('id', $roleMenuMapIds)->with([
                'children' => function ($query) use ($roleMenuMapIds) {
                    $query->whereIn('id', $roleMenuMapIds);
                }])->where('parent_menu_id', '0')->get();
        });
    }

    public function getUserOrganogramRoleName(): string
    {
        $role = $this->getUserOrganogramRole();
        if (Auth::user()->user_role_id == config('menu_role_map.super_admin')) {
            $role_name = 'Super Admin';
        } else if (Auth::user()->user_role_id == config('menu_role_map.admin')) {
            $role_name = 'Admin';
        } else if ($role == config('menu_role_map.office_admin')) {
            $role_name = 'Office Admin';
        } else if ($role == config('menu_role_map.office_head')) {
            $role_name = 'Office Head';
        } else if ($role == config('menu_role_map.unit_admin')) {
            $role_name = 'Unit Admin';
        } else if ($role == config('menu_role_map.unit_head')) {
            $role_name = 'Unit Head';
        } else if ($role == config('menu_role_map.office_frontdesk')) {
            $role_name = 'Office Front Desk';
        } else {
            $role_name = '';
        }

        return $role_name;
    }

    public function getUserOrganogramRole()
    {
        if ($this->getUserRoleId() == config('menu_role_map.user') && Auth::user()->current_designation_id()) {
            $designation_id = Auth::user()->current_designation_id();
            $unit_organogram = OfficeUnitOrganogram::where('id', $designation_id)->first();
            if ($unit_organogram && $unit_organogram->is_admin) {
                return config('menu_role_map.office_admin');
            } else if ($unit_organogram && $unit_organogram->is_unit_admin) {
                return config('menu_role_map.unit_admin');
            } else if ($unit_organogram && $unit_organogram->is_unit_head) {
                return config('menu_role_map.unit_head');
            } else if ($unit_organogram && $unit_organogram->is_office_head) {
                return config('menu_role_map.office_head');
            } else {
                return null;
            }
        }
        return null;
    }

    public function checkProtikolpo(): bool
    {
        if (Auth::user()->employee) {
            $employee_record_id = Auth::user()->employee->id;
            $protikolpo_count = ProtikolpoManagement::where('employee_record_id', $employee_record_id)->where('active_status', 1)->exists();
            if ($protikolpo_count) {
                return true;
            }
        }
        return false;
    }

    public function getUserProfileImage($username)
    {
        if (!session()->has('_user_profile_image') || session('_user_profile_image') == null) {
            $user_photo = User::where('username', $username)->select('photo')->first()->photo;
            session()->put('_user_profile_image', asset($user_photo));
            session()->save();
            return session('_user_profile_image');
        }
        return session('_user_profile_image');
    }

    public function checkPasswordValidity()
    {
        $last_password_change_date = Auth::user()->last_password_change;
        if ($last_password_change_date) {
            $password_validity_in_days = config('n_doptor_apps.password_validity_in_days');
            $password_change_reminder_in_day = config('n_doptor_apps.password_change_reminder_in_day');
            if (strtotime($last_password_change_date . '+' . ($password_validity_in_days - $password_change_reminder_in_day) . 'days') < time()) {
                Session::flash('password-reminder', 'Your password is expired soon, please change your password.');
            }
        }
    }

    public function checkOfficeAdmin()
    {
        $designationId = Auth::user()->current_designation_id();
        if (!empty($designationId)) {
            $officeId = Auth::user()->current_office_id();
            $officeUnitOrganogram = OfficeUnitOrganogram::find($designationId);
            if ($officeUnitOrganogram->is_admin == 1) {
                $officeTable = Office::find($officeId);
                $array = [
                    'digital_nothi_code' => $officeTable->digital_nothi_code,
                    'office_phone' => $officeTable->office_phone,
                    'office_mobile' => $officeTable->office_mobile,
                    'office_fax' => $officeTable->office_fax,
                    'office_email' => $officeTable->office_email,
                    'office_web' => $officeTable->office_web
                ];

                foreach ($array as $value) {
                    $value = trim($value);
                    if (empty($value)) {
                        return 'office_info';
                    }
                }
                $unitAdmin = $this->checkUnitAdmin($officeId);
                return $unitAdmin ? 'unit_info' : '';
            }
        }
    }

    private function checkUnitAdmin($officeId): bool
    {
        $officeUnitTables = OfficeUnit::where('office_id', $officeId)->where('active_status', 1)->where(function ($query) {
            return $query->where('unit_nothi_code', '')->orWhere('unit_nothi_code', '০০০')->orWhereNull('unit_nothi_code');
        })->first();
        return (bool)$officeUnitTables;
    }

    public function getAlertNotifications()
    {
        $notifications = [];
        $password_reminder = XSetting::where('param', 'reminder_for_change_password_in_days')->first();
        if (date('Y', strtotime(Auth::user()->last_password_change)) < 2017) {
            $notifications['reminder_for_change_password'] = "You did'nt change your password. Please change.";
        } else {
            $last_password_change = new Carbon(Auth::user()->last_password_change);
            $now = Carbon::now();
            $dayInDiff = $last_password_change->diffInDays($now);
            $years = ($dayInDiff / 365);
            $years = floor($years);
            $months = ($dayInDiff % 365) / 30.5;
            $months = floor($months);
            $days = ($dayInDiff % 365) % 30.5;
            $pass_difference = "";
            if ($years > 0) {
                $pass_difference .= enTobn($years) . " Year ";
            }
            if ($months > 0) {
                $pass_difference .= enTobn($months) . " Month ";
            }
            if ($days > 0) {
                $pass_difference .= enTobn($days) . " days ";
            }
            if ($password_reminder->value < $dayInDiff) {
                $notifications['reminder_for_change_password'] = 'Last Password Change At ' . $pass_difference . ' Before. Please Change Your Password.';
            }
        }
        return $notifications;
    }
}
