<?php

namespace a2i\organogram\database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeFrontDesk extends Model
{
    use HasFactory;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'modified';
    protected $table = 'office_front_desk';
	protected $fillable = [
		'office_id',
		'office_name',
		'office_address',
		'office_unit_id',
		'office_unit_name',
		'office_unit_organogram_id',
		'designation_label',
		'officer_id',
		'officer_name',
		'created_by',
	];

	public function user()
    {
        return $this->hasOne(User::class, 'employee_record_id', 'officer_id');
    }
}
