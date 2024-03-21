<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bivag extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table ='geo_divisions';

    protected $fillable = ['bbs_code','division_name_bng','division_name_eng','status','id','created_by','modified_by'];
}
