<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'offices';
    protected $fillable = ['id', 'geo_division_id', 'geo_district_id', 'office_ministry_id', 'geo_upazila_id', 'geo_union_id', 'office_layer_id', 'custom_layer_id', 'office_origin_id', 'office_name_bng', 'office_name_eng', 'office_address', 'office_phone', 'office_mobile', 'office_fax', 'office_email', 'office_web', 'digital_nothi_code', 'reference_code', 'parent_office_id', 'created_by', 'modified_by'];

    protected $appends = ['name_bng', 'name_eng'];

    public function getNameBngAttribute()
    {
        return $this->office_name_bng;
    }

    public function getNameEngAttribute()
    {
        return $this->office_name_eng;
    }

    public function child()
    {
        return $this->hasMany(Office::class, 'parent_office_id', 'id')->where('active_status', 1)->with('child');
    }

    public function parent()
    {
        return $this->belongsTo(Office::class, 'parent_office_id', 'id')->where('active_status', 1)->with('parent');
    }

    public function office_origin()
    {
        return $this->belongsTo(OfficeOrigin::class, 'office_origin_id', 'id');
    }

    public function office_custom_layer()
    {
        return $this->belongsTo(OfficeCustomLayer::class, 'office_id', 'id');
    }

    public function office_ministry()
    {
        return $this->hasOne(OfficeMinistry::class, 'id', 'office_ministry_id');
    }

    public function office_layer()
    {
        return $this->hasOne(OfficeLayer::class, 'id', 'office_layer_id');
    }

    public function custom_layer()
    {
        return $this->hasOne(OfficeCustomLayer::class, 'id', 'custom_layer_id');
    }

    public function office_origin_list()
    {
        return $this->hasOne(OfficeOrigin::class, 'id', 'office_origin_id');
    }

    public function office_units()
    {
        return $this->hasMany(OfficeUnit::class, 'office_id', 'id')->where('active_status', 1);
    }

    public function office_unit_organograms()
    {
        return $this->hasMany(OfficeUnitOrganogram::class, 'office_id', 'id')->where('status', 1);
    }

    public function assigned_employees()
    {
        return $this->hasMany(EmployeeOffice::class, 'office_id', 'id')->where('status', 1);
    }

    public function office_domain()
    {
        return $this->hasOne(OfficeDomain::class, 'office_id', 'id');
    }

	public function office_front_desk() {
		return $this->hasOne(OfficeFrontDesk::class, 'office_id');
	}
}
