<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeLayer extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'office_layers';
    protected $appends = ['name_bng', 'name_eng'];
    protected $fillable = ['office_ministry_id', 'custom_layer_id','parent_layer_id','layer_name_bng', 'layer_name_eng', 'layer_level', 'layer_sequence', 'active_status', 'layer_type', 'created_by', 'modified_by'];

    public function getNameBngAttribute()
    {
        return $this->layer_name_bng;
    }

    public function getNameEngAttribute()
    {
        return $this->layer_name_eng;
    }

    public function parent()
    {
        return $this->belongsTo(OfficeLayer::class, 'parent_layer_id', 'id')->with('parent');
    }

    public function child()
    {
        return $this->hasMany(OfficeLayer::class, 'parent_layer_id', 'id')->with('child');
    }

    public function custom_layer()
    {
       return $this->belongsTo(OfficeCustomLayer::class, 'custom_layer_id','id');
    }

    public function office_ministry()
    {
       return $this->belongsTo(OfficeMinistry::class, 'office_ministry_id','id');
    }
}
