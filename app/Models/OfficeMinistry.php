<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeMinistry extends Model
{
    use HasFactory;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected  $table = 'office_ministries';
    protected $fillable=['id','office_type','name_bng','name_eng','name_eng_short','active_status','reference_code','created_by','modified_by'];


}
