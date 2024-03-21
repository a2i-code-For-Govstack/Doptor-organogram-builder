<?php

namespace App\Models;

use App\Traits\UserInfoCollector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UserInfoCollector;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'force_password_change',
        'last_password_change',
        'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $current_office_id;
    protected $current_office_unit_id;
    protected $current_designation_id;

    public function __construct()
    {
        parent::__construct();

        $this->current_office_id = Session::get("_office_id");
        $this->current_office_unit_id = Session::get("_office_unit_id");
        $this->current_designation_id = Session::get("_designation_id");
    }

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_record_id', 'id');
    }

    public function signature(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserSignature::class, 'username', 'username')->orderBy('id', 'desc');
    }

    public function current_office_id()
    {
        return $this->current_office_id ?: (($this->employee && count($this->employee->employee_office) > 0) ? $this->employee->employee_office[0]->office_id : null);
    }

    public function current_office_unit_id()
    {
        return $this->current_office_unit_id ?: (($this->employee && count($this->employee->employee_office) > 0) ? $this->employee->employee_office[0]->office_unit_id : null);
    }

    public function current_designation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EmployeeOffice::class, 'employee_record_id', 'employee_record_id')->where('office_unit_organogram_id', $this->current_designation_id())->where('status', 1);
    }

    public function current_designation_id()
    {
        return $this->current_designation_id ?: (($this->employee && count($this->employee->employee_office) > 0) ? $this->employee->employee_office[0]->office_unit_organogram_id : null);
    }

    public function current_organogram_role_id()
    {
        return $this->getUserOrganogramRole();
    }

}
