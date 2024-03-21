<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeOriginUnitOrganogram extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'office_origin_unit_organograms';
    protected $appends = ['name_bng', 'name_eng'];
    protected $fillable = ['office_origin_unit_id', 'superior_unit_id', 'superior_designation_id', 'designation_eng', 'designation_bng', 'short_name_eng', 'short_name_bng', 'designation_level', 'designation_sequence', 'status', 'created_by', 'modified_by'];

    public function getNameBngAttribute()
    {
        return $this->designation_bng;
    }

    public function getNameEngAttribute()
    {
        return $this->designation_eng;
    }
    //
    //    public function child()
    //    {
    //        return $this->hasMany(OfficeLayer::class, 'parent_layer_id', 'id')->with('child');
    //    }

    public function originUnit() {
        return $this->belongsTo(OfficeOriginUnit::class, 'office_origin_unit_id');
    }

    public function getExistsInOfficeUnitOrganograms($office_id)
    {
        $organograms = OfficeUnitOrganogram::where('status', 1)
        ->where('ref_origin_unit_org_id', $this->id);
        if ($office_id) {
            $organograms = $organograms->where('office_id', $office_id);
        }
        return $organograms->exists();
    }
}
