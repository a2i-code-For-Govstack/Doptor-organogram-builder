<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PouroshovaWordKathamo extends Model
{
    use HasFactory;

    protected $table = 'geo_municipality_wards';
    protected $appends = ['name_bng', 'name_eng'];

    public static function get_pouroshova_word_pouroshova_wise($id)
    {
        return PouroshovaWordKathamo::where('geo_municipality_id',$id)->get();
    }
    public function getNameBngAttribute() {
        return $this->ward_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->ward_name_eng;
    }
}
