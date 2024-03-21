<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationUpdateHistory extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'designation_update_history';

    protected $fillable = [
        'designation_id',
        'office_id',
        'office_unit_id',
        'superior_unit_id',
        'superior_designation_id',
        'ref_origin_unit_org_id',
        'old_designation_eng',
        'old_designation_bng',
        'designation_eng',
        'designation_bng',
        'employee_office_id',
        'employee_unit_id',
        'employee_designation_id',
        'created_by',
        'modified_by'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
