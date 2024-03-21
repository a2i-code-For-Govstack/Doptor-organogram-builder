<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeUnitCategory extends Model
{
    use HasFactory;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table='office_unit_categories';
    protected $fillable=['id','category_name_bng','category_name_eng','created_by','modified_by'];
}
