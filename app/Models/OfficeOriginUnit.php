<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeOriginUnit extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'office_origin_units';
    protected $appends = ['name_bng', 'name_eng'];
    protected $all_parent_ids = [];

    protected $fillable = ['id', 'office_ministry_id', 'office_layer_id', 'office_origin_id', 'unit_name_bng', 'unit_name_eng', 'office_unit_category', 'parent_unit_id', 'unit_level', 'unit_sequence', 'active_status', 'created_by', 'modified_by'];

    public function getNameBngAttribute()
    {
        return $this->unit_name_bng;
    }

    public function getNameEngAttribute()
    {
        return $this->unit_name_eng;
    }

    public function child(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OfficeOriginUnit::class, 'parent_unit_id', 'id')->where('active_status', 1)->with('child')->orderBy('unit_level', 'asc')->orderBy('unit_sequence', 'asc')->withCount('office_units');
    }

    public function originOrganograms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OfficeOriginUnitOrganogram::class, 'office_origin_unit_id', 'id')->where('status', 1)->orderBy('designation_level', 'asc')->orderBy('designation_sequence', 'asc');
    }

    public function originOffice(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OfficeOrigin::class, 'office_origin_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OfficeOriginUnit::class, 'parent_unit_id', 'id')->where('active_status', 1)->with('parent');
    }

    public function getAllParentId()
    {
        $this->getAllParentIdRequcrring($this);
        return $this->all_parent_ids;
    }

    public function getAllParentIdRequcrring($origin_unit)
    {
        array_push($this->all_parent_ids, $origin_unit->id);
        if ($origin_unit->parent) {
            return self::getAllParentIdRequcrring($origin_unit->parent);
        }
    }

    public function office_units()
    {
        return $this->hasMany(OfficeUnit::class, 'office_origin_unit_id', 'id')->where('active_status', 1);
    }

    public function getExistsInOfficeUnit($office_id)
    {
        return OfficeUnit::where('active_status', 1)->orderBy('unit_level')->where('office_origin_unit_id', $this->id)->where('office_id', $office_id)->exists();
    }
}
