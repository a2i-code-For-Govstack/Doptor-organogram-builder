<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtikolpoLog extends Model
{
    use HasFactory;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table ='protikolpo_log';

    protected $fillable = ['protikolpo_id','protikolpo_start_date','protikolpo_end_date','protikolpo_ended_by','employee_office_id_from_name','employee_office_id_to_name','protikolpo_status','id','created','modified'];
}
