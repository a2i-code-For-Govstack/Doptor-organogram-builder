<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUpdateHistory extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'unit_update_history';

    protected $fillable = [
        'office_id',
        'office_unit_id',
        'office_origin_unit_id',
        'parent_unit_id',
        'old_unit_eng',
        'old_unit_bng',
        'unit_eng',
        'unit_bng',
        'employee_office_id',
        'employee_unit_id',
        'employee_designation_id',
        'created_by',
        'modified_by'
    ];
}
