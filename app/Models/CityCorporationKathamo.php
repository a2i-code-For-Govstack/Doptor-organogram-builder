<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityCorporationKathamo extends Model
{
    use HasFactory;

    protected $table='geo_city_corporations';
    protected $appends = ['name_bng', 'name_eng'];

    public static function get_city_corporation_zila_wise($id)
    {

        return CityCorporationKathamo::where('geo_district_id',$id)->get();
    }
    public function getNameBngAttribute() {
        return $this->city_corporation_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->city_corporation_name_eng;
    }
}
