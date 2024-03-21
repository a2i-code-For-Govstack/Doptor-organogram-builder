<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminResponsibilityLog extends Model
{
    use HasFactory;

    public function employee_record()
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_id','id');
    }

    public function office_info(){
        return $this->belongsTo(Office::class, 'office_id','id');
    }

    public function office_unit()
    {
        return $this->belongsTo(OfficeUnit::class, 'office_unit_id','id');
    }

    public function office_unit_organogram()
    {
        return $this->belongsTo(OfficeUnitOrganogram::class, 'office_unit_organogram_id','id');
    }

}
