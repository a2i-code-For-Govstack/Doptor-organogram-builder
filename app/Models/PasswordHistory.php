<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    use HasFactory;
	protected $fillable = [
		'user_id',
		'employee_record_id',
		'password_hash',
		'changed_date'
	];
}
