<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Office;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;

class SelfRegistration extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'user_self_registration';

    protected $fillable = [
        'personal_email', 'nid', 'created_by', 'modified_by', 'personal_mobile', 'date_of_birth', 'prefix_name_eng', 'name_eng',
        'surname_eng', 'prefix_name_bng', 'name_bng', 'surname_bng', 'father_name_eng', 'father_name_bng', 'mother_name_eng',
        'mother_name_bng', 'nid_valid', 'gender', 'religion', 'blood_group', 'marital_status', 'personal_email', 'personal_mobile',
        'alternative_mobile', 'is_cadre', 'employee_grade', 'employee_cadre_id', 'employee_batch_id', 'identity_no', 'joining_date',
        'service_rank_id', 'service_grade_id', 'service_ministry_id', 'service_office_id', 'appointment_memo_no', 'office_id',
        'office_unit_id', 'designation_id', 'designation_joining_date', 'created_by', 'modified_by', 'created', 'modified'
    ];

    public function office() {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }

    public function office_unit() {
        return $this->hasOne(OfficeUnit::class, 'id', 'office_unit_id');
    }

    public function office_designation() {
        return $this->hasOne(OfficeUnitOrganogram::class, 'id', 'designation_id');
    }

    public function modifier()
    {
        return $this->hasOne(User::class, 'id', 'modified_by');
    }
}
