<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanaKathamo extends Model
{
    use HasFactory;

    protected $table= 'geo_thanas';
    protected $appends = ['name_bng', 'name_eng'];
    public function zila_kathamo()
    {
        return $this->belongsTo(ZilaKathamo::class);
    }

    public function get_all_thanas()
    {
        return ThanaKathamo::get();
    }

    public static function get_thana_zila_wise($id)
    {
        return ThanaKathamo::where('geo_district_id',$id)->get();
    }

    public function getNameBngAttribute() {
        return $this->thana_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->thana_name_eng;
    }
}
