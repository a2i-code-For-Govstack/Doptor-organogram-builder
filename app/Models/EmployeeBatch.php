<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBatch extends Model
{
    use HasFactory;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table='employee_batches';
    protected $fillable=['batch_no','batch_year','created_by','modified_by'];

}
