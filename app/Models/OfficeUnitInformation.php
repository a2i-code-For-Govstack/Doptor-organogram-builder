<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeUnitInformation extends Model
{
    protected $table = 'office_unit_informations';
    protected $fillable = [
        'office_id',
        'office_unit_id',
        'content',
        'type',
        'is_default',
        'status',
        'created_by',
        'created_at',
    ];
}
