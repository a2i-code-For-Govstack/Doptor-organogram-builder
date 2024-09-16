<?php

namespace a2i\organogram\database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeUnit extends Model
{
    protected $table = 'office_units';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable = [
        'office_ministry_id',
        'office_layer_id',
        'office_id',
        'office_origin_unit_id',
        'unit_name_bng',
        'unit_name_eng',
        'office_unit_category',
        'parent_unit_id',
        'parent_origin_unit_id',
        'unit_nothi_code',
        'unit_level',
        'sarok_no_start',
        'email',
        'phone',
        'mobile',
        'fax',
        'active_status',
        'created_by',
        'modified_by',
    ];

    protected $appends = ['name_bng', 'name_eng', 'origin_id'];

    public function getNameBngAttribute()
    {
        return $this->unit_name_bng;
    }

    public function getNameEngAttribute()
    {
        return $this->unit_name_eng;
    }

    public function getOriginIdAttribute()
    {
        return $this->office_origin_unit_id;
    }

    public function child(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OfficeUnit::class, 'parent_unit_id', 'id')->where('active_status', 1)->orderBy('unit_level', 'asc')->with('child');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OfficeUnit::class, 'parent_unit_id', 'id')->where('active_status', 1)->with('parent');
    }

    public function parentUnit()
    {
        return $this->belongsTo(OfficeUnit::class, 'parent_unit_id', 'id')->where('active_status', 1);
    }

    public function organograms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OfficeUnitOrganogram::class, 'office_unit_id', 'id')->orderBy('designation_level', 'asc')->orderBy('designation_sequence', 'asc');
    }

    public function active_organograms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OfficeUnitOrganogram::class, 'office_unit_id', 'id')->where('status', 1)->orderBy('designation_level', 'asc')->orderBy('designation_sequence', 'asc');
    }

    public function office_unit_origin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OfficeOriginUnit::class, 'office_origin_unit_id', 'id');
    }

    public function originOrganograms()
    {
        return $this->office_unit_origin->originOrganograms();
    }

    public function office_info(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function active_unit_informations()
    {
        return $this->hasMany(OfficeUnitInformation::class, 'office_unit_id', 'id')->where('status', 1);
    }

}
