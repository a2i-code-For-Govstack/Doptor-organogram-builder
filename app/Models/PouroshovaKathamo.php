<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PouroshovaKathamo extends Model
{
    use HasFactory;
    protected $table ='geo_municipalities';
    protected $appends = ['name_bng', 'name_eng'];

    public static function get_pouroshova_upozila_wise($id)
    {

        return PouroshovaKathamo::where('geo_upazila_id',$id)->get();
    }

    public function pouroshova_word_kathamo()
    {
        return $this->hasMany(PouroshovaWordKathamo::class,'geo_municipality_id','id');
    }

    public function getNameBngAttribute() {
        return $this->municipality_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->municipality_name_eng;
    }
}
