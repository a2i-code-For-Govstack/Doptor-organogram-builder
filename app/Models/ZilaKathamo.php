<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZilaKathamo extends Model
{
    use HasFactory;

    protected $table='geo_districts';
    protected $appends = ['name_bng', 'name_eng'];

    public function bivag_kathamo()
    {
        return $this->belongsTo(BivagKathamo::class,'geo_division_id','id');
    }

    public function get_all_zilas()
    {
        return ZilaKathamo::get();
    }

    public static function get_zila_bivag_wise($id)
    {

        return ZilaKathamo::where('geo_division_id',$id)->get();
    }

    public function upozila_kathamo()
    {
        return $this->hasMany(UpoZilaKathamo::class,'geo_district_id','id');
    }
    public function thana_kathamo()
    {
        return $this->hasMany(ThanaKathamo::class,'geo_district_id','id');
    }
    public function city_corporations_kathamo()
    {
        return $this->hasMany(CityCorporationKathamo::class,'geo_district_id','id');
    }

    public function getNameBngAttribute() {
        return $this->district_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->district_name_eng;
    }
}
