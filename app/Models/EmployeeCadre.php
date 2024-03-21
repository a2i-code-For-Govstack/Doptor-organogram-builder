<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCadre extends Model
{
    use HasFactory;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table='employee_cadres';
    protected $fillable=['cadre_name_eng','cadre_name_bng','created_by','modified_by'];

}
