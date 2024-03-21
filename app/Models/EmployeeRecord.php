<?php

namespace App\Models;

use App\Traits\UserInfoCollector;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmployeeRecord extends Model
{
    use UserInfoCollector;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'employee_records';
    protected $fillable = [
        'id',
        'prefix_name_eng',
        'name_eng',
        'surname_eng',
        'prefix_name_bng',
        'name_bng',
        'surname_bng',
        'father_name_bng',
        'father_name_eng',
        'mother_name_bng',
        'mother_name_eng',
        'date_of_birth',
        'nid',
        'bcn',
        'ppn',
        'gender',
        'religion',
        'blood_group',
        'marital_status',
        'personal_mobile',
        'alternative_mobile',
        'is_cadre',
        'employee_grade',
        'personal_email',
        'employee_batch_id',
        'employee_cadre_id',
        'appointment_memo_no',
        'identity_no',
        'joining_date',
        'status',
        'image_file_name',
        'd_sign',
        'created_by',
        'modified_by'
    ];

    protected $appends = ['full_name_bng', 'full_name_eng'];

    public function getFullNameBngAttribute()
    {
        $prefix_name_bng = $this->prefix_name_bng ? $this->prefix_name_bng . ' ' : '';
        $surname_bng = $this->surname_bng ? ', ' . $this->surname_bng : '';
        $full_name_bng = $prefix_name_bng . $this->name_bng . $surname_bng;
        return $full_name_bng;
    }

    public function getFullNameEngAttribute()
    {
        $prefix_name_eng = $this->prefix_name_eng ? $this->prefix_name_eng . ' ' : '';
        $surname_eng = $this->surname_eng ? ', ' . $this->surname_eng : '';
        $full_name_eng = $prefix_name_eng . $this->name_eng . $surname_eng;
        return $full_name_eng;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'employee_record_id', 'id');
    }

    public function employee_office()
    {
        return $this->hasMany(EmployeeOffice::class, 'employee_record_id', 'id')->where('status', 1);
    }

    public function active_employee_office()
    {
        return $this->hasOne(EmployeeOffice::class, 'employee_record_id', 'id')->where('status', 1);
    }

    public function all_employee_office()
    {
        return $this->hasMany(EmployeeOffice::class, 'employee_record_id', 'id');
    }

    function profile_picture_old($is_thumbnail = false, $should_encoded = false): string
    {
        $pro_pic = $this->image_file_name ? asset($this->image_file_name) : asset('images/no.png');
        if ($is_thumbnail) {
            return $pro_pic;
        } elseif ($should_encoded) {
            $photo = file_get_contents($pro_pic);
            return "data:image/jpg;base64, " . base64_encode($photo);
        } else {
            return $pro_pic;
        }
    }

    function profile_picture()
    {
        if (!session()->has('_user_profile_image') || session('_user_profile_image') == null) {
            $this->get_profile_picture();
        }
        return session('_user_profile_image');
    }

    public function get_profile_picture()
    {
        return asset(auth()->user()->photo);
    }

    public function userProfileImage($username, $employee_record_id)
    {
        $user_photo = User::where('username')->select('photo')->first()->photo;
        return asset($user_photo);
    }
}
